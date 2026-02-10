<?php

namespace App\Filament\Resources\CategoryProjects\Pages;

use App\Filament\Resources\CategoryProjects\CategoryProjectResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditCategoryProject extends EditRecord
{
    protected static string $resource = CategoryProjectResource::class;

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
