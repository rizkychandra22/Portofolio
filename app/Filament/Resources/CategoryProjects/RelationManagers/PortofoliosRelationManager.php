<?php

namespace App\Filament\Resources\CategoryProjects\RelationManagers;

use App\Filament\Resources\Portofolios\PortofolioResource;
use App\Filament\Resources\Portofolios\Schemas\PortofolioForm;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class PortofoliosRelationManager extends RelationManager
{
    protected static string $relationship = 'portofolios';

    protected static ?string $relatedResource = PortofolioResource::class;

    public function form(Schema $schema): Schema
    {
        // Ambil schema asli dari PortofolioForm
        $schema = PortofolioForm::configure($schema);

        // Ambil array komponen yang sudah ada
        $components = $schema->getComponents();

        // Modifikasi isi komponen tersebut
        foreach ($components as $component) {
            if ($component instanceof Section) {
                foreach ($component->getChildComponents() as $child) {
                    if (method_exists($child, 'getName') && $child->getName() === 'category_project_id') {
                        $child->default($this->getOwnerRecord()->getKey())
                            ->disabled()
                            ->dehydrated();
                    }
                }
            }
        }

        return $schema->components($components);
    }

    public function table(Table $table): Table
    {
        return PortofolioResource::table($table)
            ->headerActions([
                CreateAction::make()->modal()
                    ->label('Create New') 
                    ->icon('heroicon-o-plus-circle') 
                    ->color('info'),
            ])
            ->actions([
                EditAction::make()->modal(), 
            ]);
    }
}
