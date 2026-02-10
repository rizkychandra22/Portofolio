<?php

namespace App\Filament\Resources\PortofolioDescriptions\Pages;

use App\Filament\Resources\PortofolioDescriptions\PortofolioDescriptionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPortofolioDescriptions extends ListRecords
{
    protected static string $resource = PortofolioDescriptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Create New') 
                ->icon('heroicon-o-plus-circle')
        ];
    }
}
