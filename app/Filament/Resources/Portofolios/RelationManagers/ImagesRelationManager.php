<?php

namespace App\Filament\Resources\Portofolios\RelationManagers;

use App\Filament\Resources\PortofolioImages\PortofolioImageResource;
use App\Models\PortofolioImage;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class ImagesRelationManager extends RelationManager
{
    protected static string $relationship = 'images';

    protected static ?string $relatedResource = PortofolioImageResource::class;

    public function form(Schema $schema, bool $isRelation = true): Schema
    {
        return PortofolioImageResource::form($schema, $isRelation);
    }

    public function table(Table $table): Table
    {
        return PortofolioImageResource::table($table)
            ->modifyQueryUsing(function (Builder $query) {
                // Samakan query agar hanya menampilkan 1 baris per portofolio (Grup)
                return $query->whereIn('id', function ($subQuery) {
                    $subQuery->selectRaw('MIN(id)')
                        ->from('portofolio_images')
                        ->whereNull('deleted_at')
                        ->groupBy('portofolio_id');
                });
            })
            ->headerActions([
                CreateAction::make()
                    ->modal()
                    ->label('Create New') 
                    ->icon('heroicon-o-plus-circle')
                    ->modalHeading('Upload Gallery Images')
                    ->using(function (array $data): Model {
                        $images = $data['image_path'] ?? [];
                        $firstRecord = null;

                        foreach ($images as $path) {
                            $record = PortofolioImage::create([
                                'portofolio_id' => $this->getOwnerRecord()->id, 
                                'image_path'    => $path,
                            ]);

                            if (!$firstRecord) $firstRecord = $record;
                        }

                        return $firstRecord;
                    }),
            ])
            ->actions([
                EditAction::make()
                    ->modal()
                    ->modalHeading('Edit Gallery')
                    // Mengisi data ke dalam Form Modal
                    ->fillForm(function (Model $record, array $data) {
                        $data['image_path'] = PortofolioImage::where('portofolio_id', $record->portofolio_id)
                            ->pluck('image_path')
                            ->toArray();

                        return $data;
                    }) 
                    // Menyimpan perubahan dari Form Modal
                    ->using(function (Model $record, array $data): Model {
                        $newImages = $data['image_path'] ?? [];
                        $existingImages = PortofolioImage::where('portofolio_id', $record->portofolio_id)
                            ->pluck('image_path')
                            ->toArray();

                        // 1. Hapus gambar yang di-unselect user dari Database
                        $deletedImages = array_diff($existingImages, $newImages);
                        foreach ($deletedImages as $path) {
                            PortofolioImage::where('portofolio_id', $record->portofolio_id)
                                ->where('image_path', $path)
                                ->forceDelete();
                        }

                        // 2. Tambah gambar yang baru diupload ke Database
                        $imagesToAdd = array_diff($newImages, $existingImages);
                        foreach ($imagesToAdd as $path) {
                            PortofolioImage::create([
                                'portofolio_id' => $record->portofolio_id,
                                'image_path'    => $path,
                            ]);
                        }

                        return $record;
                    }), 
                DeleteAction::make()
                    ->after(function (Model $record) {
                        // Hapus semua baris gambar terkait saat satu grup dihapus
                        PortofolioImage::where('portofolio_id', $record->portofolio_id)->forceDelete();
                    }),
            ]);
    }
}