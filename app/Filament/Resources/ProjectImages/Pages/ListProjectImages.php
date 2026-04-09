<?php

namespace App\Filament\Resources\ProjectImages\Pages;

use App\Filament\Resources\ProjectImages\ProjectImageResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListProjectImages extends ListRecords
{
    protected static string $resource = ProjectImageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Create New') 
                ->icon('heroicon-o-plus-circle')
        ];
    }
}
