<?php

namespace App\Filament\Resources\PortofolioDescriptions\Pages;

use App\Filament\Resources\PortofolioDescriptions\PortofolioDescriptionResource;
use App\Helpers\TranslateHelper;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditPortofolioDescription extends EditRecord
{
    protected static string $resource = PortofolioDescriptionResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (!empty($data['title_id']) && $data['title_id'] !== $this->record->title_id) {
            $data['title_en'] = TranslateHelper::toEnglish($data['title_id']) ?? $data['title_en'] ?? $this->record->title_en;
        }
        if (!empty($data['content_id']) && $data['content_id'] !== $this->record->content_id) {
            $data['content_en'] = TranslateHelper::toEnglish(strip_tags($data['content_id'])) ?? $data['content_en'] ?? $this->record->content_en;
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
