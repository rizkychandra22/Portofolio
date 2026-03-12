<?php

namespace App\Filament\Resources\CategoryProjects\Pages;

use App\Filament\Resources\CategoryProjects\CategoryProjectResource;
use App\Helpers\TranslateHelper;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditCategoryProject extends EditRecord
{
    protected static string $resource = CategoryProjectResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (!empty($data['name_category_id']) && $data['name_category_id'] !== $this->record->name_category_id) {
            $data['name_category_en'] = TranslateHelper::toEnglish($data['name_category_id']) ?? $data['name_category_en'] ?? $this->record->name_category_en;
        }
        return $data;
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
