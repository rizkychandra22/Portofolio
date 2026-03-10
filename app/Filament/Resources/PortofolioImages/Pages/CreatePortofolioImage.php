<?php

namespace App\Filament\Resources\PortofolioImages\Pages;

use App\Filament\Resources\PortofolioImages\PortofolioImageResource;
use App\Models\PortofolioImage;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreatePortofolioImage extends CreateRecord
{
    protected static string $resource = PortofolioImageResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $images = array_filter((array) ($data['image_path'] ?? []));
        $firstRecord = null;

        foreach ($images as $path) {
            $record = PortofolioImage::create([
                'portofolio_id' => $data['portofolio_id'],
                'image_path'    => $path,
            ]);

            if (! $firstRecord) {
                $firstRecord = $record;
            }
        }

        // Fallback: create a placeholder record if no images were uploaded
        // (prevents a TypeError from Filament expecting a Model return).
        return $firstRecord ?? PortofolioImage::create([
            'portofolio_id' => $data['portofolio_id'],
            'image_path'    => '',
        ]);
    }
}
