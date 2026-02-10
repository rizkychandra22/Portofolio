<?php

namespace App\Filament\Resources\PortofolioImages\Tables;

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

class PortofolioImagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('portofolio.name_project_id')
                    ->label('Name Project (ID)')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('portofolio.name_project_en')
                    ->label('Name Project (EN)')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault:true),
                ImageColumn::make('portofolio.images.image_path')
                    ->label('Galery Project')
                    ->disk('public')
                    ->visibility('public')
                    ->size(50)
                    ->circular()
                    ->stacked()
                    ->limit(5)
                    ->ring(3)
                    ->overlap(3)
                    ->limitedRemainingText(),
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
