<?php

namespace App\Filament\Resources\CategoryProjects\Pages;

use App\Filament\Resources\CategoryProjects\CategoryProjectResource;
use App\Helpers\TranslateHelper;
use Filament\Resources\Pages\CreateRecord;

class CreateCategoryProject extends CreateRecord
{
    protected static string $resource = CategoryProjectResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (!empty($data['name_category_id'])) {
            $data['name_category_en'] = TranslateHelper::toEnglish($data['name_category_id']) ?? $data['name_category_en'] ?? null;
        }
        return $data;
    }
}
