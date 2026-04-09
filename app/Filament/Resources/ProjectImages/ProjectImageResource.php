<?php

namespace App\Filament\Resources\ProjectImages;

use App\Filament\Resources\ProjectImages\Pages\CreateProjectImage;
use App\Filament\Resources\ProjectImages\Pages\EditProjectImage;
use App\Filament\Resources\ProjectImages\Pages\ListProjectImages;
use App\Filament\Resources\ProjectImages\Schemas\ProjectImageForm;
use App\Filament\Resources\ProjectImages\Tables\ProjectImagesTable;
use App\Models\ProjectImage;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProjectImageResource extends Resource
{
    protected static ?string $model = ProjectImage::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Group Content';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCamera;
    protected static ?string $pluralModelLabel = 'Overview Galery';
    protected static ?string $navigationLabel = 'Galery';
    protected static ?string $breadcrumb = 'Galery';
    protected static ?string $modelLabel = 'New Galery';
    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'image_path';

    public static function getRecordTitle(?Model $record): string|null
    {
        $title = $record?->project?->name_project_id;
        return $title ? 'Galery ' . $title : null;
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return $record->title;
    }

    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['project.category']);
    }

    public static function form(Schema $schema, bool $isRelation = false): Schema
    {
        return ProjectImageForm::configure($schema, $isRelation);
    }

    public static function table(Table $table): Table
    {
        return ProjectImagesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListProjectImages::route('/'),
            'create' => CreateProjectImage::route('/create'),
            'edit' => EditProjectImage::route('/{record}/edit'),
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
            ->with(['project.images'])
            ->whereIn('id', function ($query) {
                $query->selectRaw('MIN(id)')
                    ->from('project_images')
                    ->whereNull('deleted_at')
                    ->groupBy('project_id');
            })
            ->withoutGlobalScopes([
                SoftDeletingScope::class
            ]);
    }
}
