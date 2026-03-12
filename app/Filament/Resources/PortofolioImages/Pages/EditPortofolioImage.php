<?php

namespace App\Filament\Resources\PortofolioImages\Pages;

use App\Filament\Resources\PortofolioImages\PortofolioImageResource;
use App\Models\PortofolioImage;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class EditPortofolioImage extends EditRecord
{
    protected static string $resource = PortofolioImageResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        set_time_limit(300);

        $cacheKey = 'portofolio_images_paths_' . $data['portofolio_id'];

        $data['image_path'] = Cache::remember($cacheKey, 60, function () use ($data) {
            return PortofolioImage::where('portofolio_id', $data['portofolio_id'])
                ->pluck('image_path')
                ->toArray();
        });

        return $data;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        set_time_limit(300);
        $newImages = array_values(array_filter($data['image_path'] ?? []));
        $existingImages = PortofolioImage::where('portofolio_id', $record->portofolio_id)
            ->pluck('image_path')
            ->toArray();

        // 1. Hapus gambar yang di-unselect user dari Cloudinary + Database
        $deletedImages = array_values(array_diff($existingImages, $newImages));
        foreach ($deletedImages as $path) {
            rescue(fn () => Storage::disk('cloudinary')->delete($path), report: false);
        }
        if (! empty($deletedImages)) {
            PortofolioImage::where('portofolio_id', $record->portofolio_id)
                ->whereIn('image_path', $deletedImages)
                ->forceDelete();
        }

        // 2. Tambah gambar yang baru diupload ke Database
        $imagesToAdd = array_values(array_diff($newImages, $existingImages));
        if (! empty($imagesToAdd)) {
            $now = now();
            $insertData = array_map(fn ($path) => [
                'portofolio_id' => $record->portofolio_id,
                'image_path' => $path,
                'created_at' => $now,
                'updated_at' => $now,
            ], $imagesToAdd);

            PortofolioImage::insert($insertData);
        }

        Cache::forget('portofolio_images_paths_' . $record->portofolio_id);

        return $record;
    }

    protected function afterSave(): void
    {
        Storage::disk('local')->deleteDirectory('livewire-tmp');
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->icon('heroicon-o-trash'),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
