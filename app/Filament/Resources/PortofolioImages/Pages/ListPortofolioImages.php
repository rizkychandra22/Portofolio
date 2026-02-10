<?php

namespace App\Filament\Resources\PortofolioImages\Pages;

use App\Filament\Resources\PortofolioImages\PortofolioImageResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPortofolioImages extends ListRecords
{
    protected static string $resource = PortofolioImageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Create New') 
                ->icon('heroicon-o-plus-circle')
        ];
    }
}
