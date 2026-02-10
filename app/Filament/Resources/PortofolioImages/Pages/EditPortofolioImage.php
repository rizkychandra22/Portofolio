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
        PortofolioImage::where('portofolio_id', $record->portofolio_id)->forceDelete();

        $images = $data['image_path'] ?? [];
        foreach ($images as $path) {
            PortofolioImage::create([
                'portofolio_id' => $data['portofolio_id'],
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
