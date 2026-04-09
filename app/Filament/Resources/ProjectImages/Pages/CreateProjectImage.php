<?php

namespace App\Filament\Resources\ProjectImages\Pages;

use App\Filament\Resources\ProjectImages\ProjectImageResource;
use App\Models\ProjectImage;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class CreateProjectImage extends CreateRecord
{
    protected static string $resource = ProjectImageResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        set_time_limit(300);
        $images = array_filter((array) ($data['image_path'] ?? []));
        $firstRecord = null;

        foreach ($images as $path) {
            $record = ProjectImage::create([
                'project_id' => $data['project_id'],
                'image_path'    => $path,
            ]);

            if (! $firstRecord) {
                $firstRecord = $record;
            }
        }

        // Fallback: create a placeholder record if no images were uploaded
        // (prevents a TypeError from Filament expecting a Model return).
        return $firstRecord ?? ProjectImage::create([
            'project_id' => $data['project_id'],
            'image_path'    => '',
        ]);
    }

    protected function afterCreate(): void
    {
        Storage::disk('local')->deleteDirectory('livewire-tmp');
    }
}
