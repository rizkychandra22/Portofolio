<?php

namespace App\Filament\Resources\Portofolios\Pages;

use App\Filament\Resources\Portofolios\PortofolioResource;
use App\Helpers\TranslateHelper;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Storage;

class CreatePortofolio extends CreateRecord
{
    protected static string $resource = PortofolioResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (!empty($data['name_project_id'])) {
            $data['name_project_en'] = TranslateHelper::toEnglish($data['name_project_id']) ?? $data['name_project_en'] ?? null;
        }
        return $data;
    }

    protected function afterCreate(): void
    {
        Storage::disk('local')->deleteDirectory('livewire-tmp');
    }
}
