<?php

namespace App\Filament\Resources\Portofolios\Pages;

use App\Filament\Resources\Portofolios\PortofolioResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditPortofolio extends EditRecord
{
    protected static string $resource = PortofolioResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->icon('heroicon-o-trash'),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }

    // Funsi ini di Commant Out karena sudah di Handle penuh oleh model
    // protected function mutateFormDataBeforeSave(array $data): array
    // {
    //     if ($this->record && isset($data['image_project']) && $data['image_project'] !== $this->record->image_project) {
    //         $oldFile = $this->record->image_project;
    //         if ($oldFile && Storage::disk('public')->exists($oldFile)) {
    //             Storage::disk('public')->delete($oldFile);
    //         }
    //     }

    //     return $data;
    // }

    // protected function beforeDelete(): void
    // {
    //     if ($this->record->image_project && Storage::disk('public')->exists($this->record->image_project)) {
    //         Storage::disk('public')->delete($this->record->image_project);
    //     }
    // }
}
