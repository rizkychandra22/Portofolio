<?php

namespace App\Filament\Resources\Projects;

use App\Filament\Resources\Projects\Pages\CreateProject;
use App\Filament\Resources\Projects\Pages\EditProject;
use App\Filament\Resources\Projects\Pages\ListProjects;
use App\Filament\Resources\Projects\RelationManagers\DescriptionsRelationManager;
use App\Filament\Resources\Projects\RelationManagers\ImagesRelationManager;
use App\Filament\Resources\Projects\Schemas\ProjectForm;
use App\Filament\Resources\Projects\Tables\ProjectsTable;
use App\Models\Project;
use BackedEnum;
use Filament\Resources\RelationManagers\RelationGroup;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Group Content';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBriefcase;
    protected static ?string $pluralModelLabel = 'Overview Project';
    protected static ?string $navigationLabel = 'Project';
    protected static ?string $modelLabel = 'New Project';
    protected static ?string $breadcrumb = 'Project';

    protected static ?string $recordTitleAttribute = 'name_project_id';

    public static function form(Schema $schema, bool $isRelation = false): Schema
    {
        return ProjectForm::configure($schema, $isRelation);
    }

    public static function table(Table $table): Table
    {
        return ProjectsTable::configure($table);
    }

    public static function getRelations(): array
    {
       return [
            RelationGroup::make('Overview Galery', [
                ImagesRelationManager::class,
            ])->icon('heroicon-o-camera'), 
            RelationGroup::make('Overview Meta Content', [
                DescriptionsRelationManager::class,
            ])->icon('heroicon-o-chat-bubble-left-right'),
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListProjects::route('/'),
            'create' => CreateProject::route('/create'),
            'edit' => EditProject::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['category']);
    }
}