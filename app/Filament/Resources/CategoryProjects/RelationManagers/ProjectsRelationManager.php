<?php

namespace App\Filament\Resources\CategoryProjects\RelationManagers;

use App\Filament\Resources\Projects\ProjectResource;
use App\Helpers\TranslateHelper;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

class ProjectsRelationManager extends RelationManager
{
    protected static string $relationship = 'projects';

    protected static ?string $relatedResource = ProjectResource::class;

    public function form(Schema $schema, bool $isRelation = true): Schema
    {
        return ProjectResource::form($schema, $isRelation);
    }

    public function table(Table $table): Table
    {
        return ProjectResource::table($table)
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
