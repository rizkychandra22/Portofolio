<?php

namespace App\Filament\Resources\PortofolioImages;

use App\Filament\Resources\PortofolioImages\Pages\CreatePortofolioImage;
use App\Filament\Resources\PortofolioImages\Pages\EditPortofolioImage;
use App\Filament\Resources\PortofolioImages\Pages\ListPortofolioImages;
use App\Filament\Resources\PortofolioImages\Schemas\PortofolioImageForm;
use App\Filament\Resources\PortofolioImages\Tables\PortofolioImagesTable;
use App\Models\PortofolioImage;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PortofolioImageResource extends Resource
{
    protected static ?string $model = PortofolioImage::class;

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
        $title = $record?->portofolio?->name_project_id;
        return $title ? 'Galery ' . $title : null;
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return $record->title;
    }

    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['portofolio.category']);
    }

    public static function form(Schema $schema, bool $isRelation = false): Schema
    {
        return PortofolioImageForm::configure($schema, $isRelation);
    }

    public static function table(Table $table): Table
    {
        return PortofolioImagesTable::configure($table);
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
            'index' => ListPortofolioImages::route('/'),
            'create' => CreatePortofolioImage::route('/create'),
            'edit' => EditPortofolioImage::route('/{record}/edit'),
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
            ->with(['portofolio'])
            ->whereIn('id', function ($query) {
                $query->selectRaw('MIN(id)')
                    ->from('portofolio_images')
                    ->whereNull('deleted_at')
                    ->groupBy('portofolio_id');
            })
            ->withoutGlobalScopes([
                SoftDeletingScope::class
            ]);
    }
}
