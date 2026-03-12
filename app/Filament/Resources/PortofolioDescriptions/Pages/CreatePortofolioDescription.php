<?php

namespace App\Filament\Resources\PortofolioDescriptions\Pages;

use App\Filament\Resources\PortofolioDescriptions\PortofolioDescriptionResource;
use App\Helpers\TranslateHelper;
use Filament\Resources\Pages\CreateRecord;

class CreatePortofolioDescription extends CreateRecord
{
    protected static string $resource = PortofolioDescriptionResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (!empty($data['title_id'])) {
            $data['title_en'] = TranslateHelper::toEnglish($data['title_id']) ?? $data['title_en'] ?? null;
        }
        if (!empty($data['content_id'])) {
            $data['content_en'] = TranslateHelper::toEnglish(strip_tags($data['content_id'])) ?? $data['content_en'] ?? null;
        }
        return $data;
    }
}
