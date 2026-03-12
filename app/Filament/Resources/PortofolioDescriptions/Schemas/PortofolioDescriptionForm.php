<?php

namespace App\Filament\Resources\PortofolioDescriptions\Schemas;

use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class PortofolioDescriptionForm
{
    public static function configure(Schema $schema, bool $isRelation = false): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Meta Content')
                    ->description('Translate otomatis ke bahasa Inggris saat Save.')
                    ->schema([
                        Select::make('portofolio_id')
                            ->relationship('portofolio', 'name_project_id')
                            ->label('Name Project')
                            ->preload()
                            ->searchable()
                            ->required()
                            ->dehydrated()
                            ->disabled($isRelation)
                            ->default(function ($livewire) {
                                if ($livewire instanceof RelationManager) {
                                    return $livewire->getOwnerRecord()->getKey();
                                }
                                return null;
                            }),
                        Select::make('type')
                            ->label('Type Meta Content')
                            ->options([
                                'overview' => 'General Description',
                                'feature' => 'Main Feature',
                            ])
                            ->required()
                            ->live() 
                            ->native(false),
                        TextInput::make('icon')
                            ->label('Icon Feature (Bootstrap Icon / Font Awesome)')
                            ->default('bi bi-check-circle / fa fa-check-circle')
                            ->visible(fn (Get $get) => $get('type') === 'feature'),
                        TextInput::make('title_id')
                            ->label('Name Feature')
                            ->required(fn (Get $get) => $get('type') === 'feature')
                            ->visible(fn (Get $get) => $get('type') === 'feature'),
                        Hidden::make('title_en')
                            ->dehydrated(),
                        RichEditor::make('content_id')
                            ->label(fn (Get $get) => $get('type') === 'feature' ? 'Detail Feature' : 'General Description')
                            ->required()
                            ->columnSpanFull(),
                        Hidden::make('content_en')
                            ->dehydrated(),
                    ])->columns()->columnSpanFull()
            ]);
    }
}
