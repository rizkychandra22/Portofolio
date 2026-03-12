<?php

namespace App\Filament\Resources\CategoryProjects\RelationManagers;

use App\Filament\Resources\Portofolios\PortofolioResource;
use App\Helpers\TranslateHelper;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

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
                    ->icon('heroicon-o-plus-circle')
                    ->mutateFormDataUsing(function (array $data): array {
                        if (!empty($data['name_project_id'])) {
                            $data['name_project_en'] = TranslateHelper::toEnglish($data['name_project_id']) ?? $data['name_project_en'] ?? null;
                        }
                        return $data;
                    })
                    ->after(fn () => Storage::disk('local')->deleteDirectory('livewire-tmp')),
            ])
            ->actions([
                EditAction::make()->modal()
                    ->mutateFormDataUsing(function (array $data): array {
                        if (!empty($data['name_project_id'])) {
                            $data['name_project_en'] = TranslateHelper::toEnglish($data['name_project_id']) ?? $data['name_project_en'] ?? null;
                        }
                        return $data;
                    })
                    ->after(fn () => Storage::disk('local')->deleteDirectory('livewire-tmp')),
                DeleteAction::make(), 
            ]);
    }
}
