<?php

namespace App\Filament\Resources\Portofolios\RelationManagers;

use App\Filament\Resources\PortofolioDescriptions\PortofolioDescriptionResource;
use App\Models\PortofolioDescription;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class DescriptionsRelationManager extends RelationManager
{
    protected static string $relationship = 'descriptions';

    protected static ?string $relatedResource = PortofolioDescriptionResource::class;

    public function form(Schema $schema, bool $isRelation = true): Schema
    {
        return PortofolioDescriptionResource::form($schema, $isRelation);
    }

    public function table(Table $table): Table
    {
        return PortofolioDescriptionResource::table($table)
            ->headerActions([
                CreateAction::make()
                    ->modal()
                    ->label('Create New') 
                    ->icon('heroicon-o-plus-circle')
                    ->modalHeading('Create Meta Content'),
            ])
            
            ->actions([
                EditAction::make()
                    ->modal(),
                DeleteAction::make()
                    ->after(function (Model $record) {
                        // Hapus semua baris deskripsi dan fitur terkait saat satu grup dihapus
                        PortofolioDescription::where('portofolio_id', $record->portofolio_id)->forceDelete();
                    }),
            ]);
    }

    public function getTabs(): array
    {
        return [
            'overview' => Tab::make('Description Only')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('type', 'overview'))
                ->icon('heroicon-m-document-text'),
                
            'feature' => Tab::make('Feature Only')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('type', 'feature'))
                ->icon('heroicon-m-star'),
        ];
    }

    public function getDefaultActiveTab(): string | int | null
    {
        return 'overview';
    }
}
