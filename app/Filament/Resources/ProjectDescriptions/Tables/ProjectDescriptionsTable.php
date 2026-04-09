<?php

namespace App\Filament\Resources\ProjectDescriptions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\HtmlString;

class ProjectDescriptionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('project.name_project_id')
                    ->label('Name Project')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('info'),
                TextColumn::make('icon')
                    ->label('Icon')
                    ->color('success')
                    ->badge()
                    ->formatStateUsing(fn (string $state) => new HtmlString("
                        <span style='font-size: 1.0rem; display: inline-block; min-width: 20px; text-align: center;'>
                            <i class='{$state}'></i>
                        </span>
                    "))
                    ->visible(fn ($livewire) => $livewire->activeTab === 'feature'),
                TextColumn::make('title_id')
                    ->label('Name Feature')
                    ->searchable()
                    ->sortable()
                    ->visible(fn ($livewire) => $livewire->activeTab === 'feature'),
                TextColumn::make('title_en')
                    ->label('Name Feature (EN)')
                    ->searchable()
                    ->sortable()
                    ->visible(fn ($livewire) => $livewire->activeTab === 'feature')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('content_id')
                    ->label(fn ($livewire) => $livewire->activeTab === 'feature' ? 'Detail Feature' : 'General Description')
                    ->searchable()
                    ->sortable()
                    ->html()
                    ->wrap(),
                TextColumn::make('content_en')
                    ->label(fn ($livewire) => $livewire->activeTab === 'feature' ? 'Detail Feature (EN)' : 'General Description (EN)')
                    ->searchable()
                    ->sortable()
                    ->wrap()
                    ->html()
                    ->toggleable(isToggledHiddenByDefault: true),
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
                SelectFilter::make('project_id')
                    ->relationship('project', 'name_project_id')
                    ->label('Name Project')
                    ->preload()
                    ->searchable(),
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
