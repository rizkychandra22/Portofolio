<?php

namespace App\Filament\Resources\PortofolioDescriptions;

use App\Filament\Resources\PortofolioDescriptions\Pages\CreatePortofolioDescription;
use App\Filament\Resources\PortofolioDescriptions\Pages\EditPortofolioDescription;
use App\Filament\Resources\PortofolioDescriptions\Pages\ListPortofolioDescriptions;
use App\Filament\Resources\PortofolioDescriptions\Schemas\PortofolioDescriptionForm;
use App\Filament\Resources\PortofolioDescriptions\Tables\PortofolioDescriptionsTable;
use App\Models\PortofolioDescription;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PortofolioDescriptionResource extends Resource
{
    protected static ?string $model = PortofolioDescription::class;

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
        $title = $record?->portofolio?->name_project_id;
        return $title ? 'Meta Content ' . $title : null;
    }

    public static function form(Schema $schema, bool $isRelation = false): Schema
    {
        return PortofolioDescriptionForm::configure($schema, $isRelation);
    }

    public static function table(Table $table): Table
    {
        return PortofolioDescriptionsTable::configure($table);
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
            'index' => ListPortofolioDescriptions::route('/'),
            'create' => CreatePortofolioDescription::route('/create'),
            'edit' => EditPortofolioDescription::route('/{record}/edit'),
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
