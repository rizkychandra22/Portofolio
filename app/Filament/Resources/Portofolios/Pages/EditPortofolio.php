<?php

namespace App\Filament\Resources\Portofolios\Pages;

use App\Filament\Resources\Portofolios\PortofolioResource;
use App\Helpers\TranslateHelper;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Storage;

class EditPortofolio extends EditRecord
{
    protected static string $resource = PortofolioResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (!empty($data['name_project_id']) && $data['name_project_id'] !== $this->record->name_project_id) {
            $data['name_project_en'] = TranslateHelper::toEnglish($data['name_project_id']) ?? $data['name_project_en'] ?? $this->record->name_project_en;
        }
        return $data;
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
