<?php

namespace App\Filament\Resources\PortofolioImages\Pages;

use App\Filament\Resources\PortofolioImages\PortofolioImageResource;
use App\Models\PortofolioImage;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditPortofolioImage extends EditRecord
{
    protected static string $resource = PortofolioImageResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['image_path'] = PortofolioImage::where('portofolio_id', $data['portofolio_id'])
            ->pluck('image_path')
            ->toArray();

        return $data;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
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
