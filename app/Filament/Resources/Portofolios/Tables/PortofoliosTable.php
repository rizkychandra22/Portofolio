<?php

namespace App\Filament\Resources\Portofolios\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class PortofoliosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image_project')
                    ->label('Image')
                    ->disk('public')
                    ->visibility('public')
                    ->size(60)
                    ->square(),
                TextColumn::make('category.name_category_id')
                    ->label('Category')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('info'),
                TextColumn::make('name_project_id')
                    ->label('Name Project (ID)')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name_project_en')
                    ->label('Name Project (EN)')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault:true),
                TextColumn::make('date_project')
                    ->label('Date Project')
                    ->dateTime('D, d M Y')
                    ->sortable(),
                TextColumn::make('link_project')
                    ->label('Link Project')
                    ->icon('heroicon-o-eye')
                    ->iconColor('primary')
                    ->formatStateUsing(fn () => 'View Source Code') 
                    ->url(fn ($state) => $state, shouldOpenInNewTab: true)
                    ->description(fn ($state) => $state)
                    ->wrap()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('d-m-Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Updated')
                    ->dateTime('d-m-Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            
            ->filters([
                TrashedFilter::make(),
                Filter::make('date_project')
                    ->form([
                        DatePicker::make('dari_tanggal')->label('Project From Date'),
                        DatePicker::make('sampai_tanggal')->label('Project To Date'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['dari_tanggal'], fn ($q, $d) => $q->whereDate('date_project', '>=', $d))
                            ->when($data['sampai_tanggal'], fn ($q, $d) => $q->whereDate('date_project', '<=', $d));
                    }),
                Filter::make('created_at')
                    ->form([
                        DatePicker::make('dari_tanggal')->label('Created From Date'),
                        DatePicker::make('sampai_tanggal')->label('Created To Date'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['dari_tanggal'], fn ($q, $d) => $q->whereDate('created_at', '>=', $d))
                            ->when($data['sampai_tanggal'], fn ($q, $d) => $q->whereDate('created_at', '<=', $d));
                    })
            ])
            
            ->recordActions([
                EditAction::make(),
                RestoreAction::make(),
                DeleteAction::make(),
                ForceDeleteAction::make(),
            ])
            
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                ]),
            ]);
    }
}
