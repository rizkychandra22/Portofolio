<?php

namespace App\Filament\Resources\Portofolios\Pages;

use App\Filament\Resources\Portofolios\PortofolioResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPortofolios extends ListRecords
{
    protected static string $resource = PortofolioResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Create New') 
                ->icon('heroicon-o-plus-circle')
        ];
    }
}
