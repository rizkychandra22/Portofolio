<?php

namespace App\Filament\Resources\ProjectDescriptions\Pages;

use App\Filament\Resources\ProjectDescriptions\ProjectDescriptionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListProjectDescriptions extends ListRecords
{
    protected static string $resource = ProjectDescriptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Create New') 
                ->icon('heroicon-o-plus-circle')
        ];
    }

    public function getTabs(): array
    {
        return [
            'overview' => Tab::make('Description Only')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('type', 'overview'))
                ->icon('heroicon-m-document-text'),
                
            'feature' => Tab::make('Feature Only')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('type', 'feature'))
                ->icon('heroicon-m-star'),
        ];
    }

    public function getDefaultActiveTab(): string | int | null
    {
        return 'overview';
    }
}
