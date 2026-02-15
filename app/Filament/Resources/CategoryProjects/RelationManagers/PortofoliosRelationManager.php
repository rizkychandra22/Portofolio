<?php

namespace App\Filament\Resources\CategoryProjects\RelationManagers;

use App\Filament\Resources\Portofolios\PortofolioResource;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class PortofoliosRelationManager extends RelationManager
{
    protected static string $relationship = 'portofolios';

    protected static ?string $relatedResource = PortofolioResource::class;

    public function form(Schema $schema, bool $isRelation = true): Schema
    {
        return PortofolioResource::form($schema, $isRelation);
    }

    public function table(Table $table): Table
    {
        return PortofolioResource::table($table)
            ->headerActions([
                CreateAction::make()->modal()
                    ->label('Create New') 
                    ->icon('heroicon-o-plus-circle'),
            ])
            ->actions([
                EditAction::make()->modal(),
                DeleteAction::make(), 
            ]);
    }
}
