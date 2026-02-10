<?php

namespace App\Filament\Resources\CategoryProjects\Pages;

use App\Filament\Resources\CategoryProjects\CategoryProjectResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCategoryProjects extends ListRecords
{
    protected static string $resource = CategoryProjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Create New') 
                ->icon('heroicon-o-plus-circle')
        ];
    }
}
