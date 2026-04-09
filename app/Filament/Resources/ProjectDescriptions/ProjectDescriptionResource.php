<?php

namespace App\Filament\Resources\ProjectDescriptions;

use App\Filament\Resources\ProjectDescriptions\Pages\CreateProjectDescription;
use App\Filament\Resources\ProjectDescriptions\Pages\EditProjectDescription;
use App\Filament\Resources\ProjectDescriptions\Pages\ListProjectDescriptions;
use App\Filament\Resources\ProjectDescriptions\Schemas\ProjectDescriptionForm;
use App\Filament\Resources\ProjectDescriptions\Tables\ProjectDescriptionsTable;
use App\Models\ProjectDescription;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProjectDescriptionResource extends Resource
{
    protected static ?string $model = ProjectDescription::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Group Content';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChatBubbleLeftRight;
    protected static ?string $pluralModelLabel = 'Overview Meta Content';
    protected static ?string $navigationLabel = 'Meta Content';
    protected static ?string $modelLabel = 'New Meta Content';
    protected static ?string $breadcrumb = 'Meta Content';
    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'id';

    public static function getRecordTitle(?Model $record): string|null
    {
        $title = $record?->project?->name_project_id;
        return $title ? 'Meta Content ' . $title : null;
    }

    public static function form(Schema $schema, bool $isRelation = false): Schema
    {
        return ProjectDescriptionForm::configure($schema, $isRelation);
    }

    public static function table(Table $table): Table
    {
        return ProjectDescriptionsTable::configure($table);
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
            'index' => ListProjectDescriptions::route('/'),
            'create' => CreateProjectDescription::route('/create'),
            'edit' => EditProjectDescription::route('/{record}/edit'),
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
            ->with(['project']);
    }
}
