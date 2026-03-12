<?php

namespace App\Filament\Resources\Portofolios;

use App\Filament\Resources\Portofolios\Pages\CreatePortofolio;
use App\Filament\Resources\Portofolios\Pages\EditPortofolio;
use App\Filament\Resources\Portofolios\Pages\ListPortofolios;
use App\Filament\Resources\Portofolios\RelationManagers\DescriptionsRelationManager;
use App\Filament\Resources\Portofolios\RelationManagers\ImagesRelationManager;
use App\Filament\Resources\Portofolios\Schemas\PortofolioForm;
use App\Filament\Resources\Portofolios\Tables\PortofoliosTable;
use App\Models\Portofolio;
use BackedEnum;
use Filament\Resources\RelationManagers\RelationGroup;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PortofolioResource extends Resource
{
    protected static ?string $model = Portofolio::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Group Content';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBriefcase;
    protected static ?string $pluralModelLabel = 'Overview Portofolio';
    protected static ?string $navigationLabel = 'Portofolio';
    protected static ?string $modelLabel = 'New Portofolio';
    protected static ?string $breadcrumb = 'Portofolio';

    protected static ?string $recordTitleAttribute = 'name_project_id';

    public static function form(Schema $schema, bool $isRelation = false): Schema
    {
        return PortofolioForm::configure($schema, $isRelation);
    }

    public static function table(Table $table): Table
    {
        return PortofoliosTable::configure($table);
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
            'index' => ListPortofolios::route('/'),
            'create' => CreatePortofolio::route('/create'),
            'edit' => EditPortofolio::route('/{record}/edit'),
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