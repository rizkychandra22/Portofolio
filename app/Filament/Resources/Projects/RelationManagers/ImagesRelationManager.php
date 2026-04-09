<?php

namespace App\Filament\Resources\Projects\RelationManagers;

use App\Filament\Resources\ProjectImages\ProjectImageResource;
use App\Models\ProjectImage;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;

class ImagesRelationManager extends RelationManager
{
    protected static string $relationship = 'images';

    protected static ?string $relatedResource = ProjectImageResource::class;

    public function form(Schema $schema, bool $isRelation = true): Schema
    {
        return ProjectImageResource::form($schema, $isRelation);
    }

    public function table(Table $table): Table
    {
        return ProjectImageResource::table($table)
            ->modifyQueryUsing(function (Builder $query) {
                // Samakan query agar hanya menampilkan 1 baris per Project (Grup)
                return $query->whereIn('id', function ($subQuery) {
                    $subQuery->selectRaw('MIN(id)')
                        ->from('project_images')
                        ->whereNull('deleted_at')
                        ->groupBy('project_id');
                });
            })
            ->headerActions([
                CreateAction::make()
                    ->modal()
                    ->label('Create New') 
                    ->icon('heroicon-o-plus-circle')
                    ->modalHeading('Upload Gallery Images')
                    ->using(function (array $data): Model {
                        set_time_limit(300);
                        $images = $data['image_path'] ?? [];
                        $firstRecord = null;

                        foreach ($images as $path) {
                            $record = ProjectImage::create([
                                'project_id' => $this->getOwnerRecord()->id, 
                                'image_path'    => $path,
                            ]);

                            if (!$firstRecord) $firstRecord = $record;
                        }

                        return $firstRecord;
                    })
                    ->after(fn () => Storage::disk('local')->deleteDirectory('livewire-tmp')),
            ])
            ->actions([
                EditAction::make()
                    ->modal()
                    ->modalHeading('Edit Gallery')
                    // Mengisi data ke dalam Form Modal
                    ->fillForm(function (Model $record, array $data) {
                        $data['image_path'] = ProjectImage::where('project_id', $record->project_id)
                            ->pluck('image_path')
                            ->toArray();

                        return $data;
                    }) 
                    // Menyimpan perubahan dari Form Modal
                    ->using(function (Model $record, array $data): Model {
                        set_time_limit(300);
                        $newImages = $data['image_path'] ?? [];
                        $existingImages = ProjectImage::where('project_id', $record->project_id)
                            ->pluck('image_path')
                            ->toArray();

                        // 1. Hapus gambar yang di-unselect user dari Cloudinary + Database
                        $deletedImages = array_diff($existingImages, $newImages);
                        if (!empty($deletedImages)) {
                            foreach ($deletedImages as $path) {
                                rescue(fn () => Storage::disk('cloudinary')->delete($path), report: false);
                            }
                            ProjectImage::where('project_id', $record->project_id)
                                ->whereIn('image_path', $deletedImages)
                                ->forceDelete();
                        }

                        // 2. Tambah gambar yang baru diupload ke Database (batch)
                        $imagesToAdd = array_diff($newImages, $existingImages);
                        if (!empty($imagesToAdd)) {
                            $insertData = array_map(fn ($path) => [
                                'project_id' => $record->project_id,
                                'image_path' => $path,
                                'created_at' => now(),
                                'updated_at' => now(),
                            ], $imagesToAdd);
                            ProjectImage::insert($insertData);
                        }

                        Storage::disk('local')->deleteDirectory('livewire-tmp');

                        return $record;
                    }), 
                DeleteAction::make()
                    ->after(function (Model $record) {
                        // Hapus file cloudinary + semua baris gambar terkait saat satu grup dihapus
                        $images = ProjectImage::where('project_id', $record->project_id)
                            ->pluck('image_path');
                        foreach ($images as $path) {
                            rescue(fn () => Storage::disk('cloudinary')->delete($path), report: false);
                        }
                        ProjectImage::where('project_id', $record->project_id)->forceDelete();
                    }),
            ]);
    }
}