<?php

namespace App\Filament\Resources\CategoryProjects;

use App\Filament\Resources\CategoryProjects\Pages\CreateCategoryProject;
use App\Filament\Resources\CategoryProjects\Pages\EditCategoryProject;
use App\Filament\Resources\CategoryProjects\Pages\ListCategoryProjects;
use App\Filament\Resources\CategoryProjects\Schemas\CategoryProjectForm;
use App\Filament\Resources\CategoryProjects\Tables\CategoryProjectsTable;
use App\Filament\Resources\CategoryProjects\RelationManagers\PortofoliosRelationManager;
use App\Models\CategoryProject;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CategoryProjectResource extends Resource
{
    protected static ?string $model = CategoryProject::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Group Content';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSquares2x2;
    protected static ?string $pluralModelLabel = 'Overview Category';
    protected static ?string $navigationLabel = 'Category';
    protected static ?string $breadcrumb = 'Category';
    protected static ?string $modelLabel = 'New Category';

    protected static ?string $recordTitleAttribute = 'name_category_id';

    public static function form(Schema $schema): Schema
    {
        return CategoryProjectForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CategoryProjectsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            PortofoliosRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCategoryProjects::route('/'),
            'create' => CreateCategoryProject::route('/create'),
            'edit' => EditCategoryProject::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
