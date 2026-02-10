<?php

namespace App\Filament\Resources\PortofolioDescriptions\Pages;

use App\Filament\Resources\PortofolioDescriptions\PortofolioDescriptionResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditPortofolioDescription extends EditRecord
{
    protected static string $resource = PortofolioDescriptionResource::class;

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
