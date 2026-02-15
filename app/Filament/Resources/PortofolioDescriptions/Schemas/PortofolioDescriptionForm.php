<?php

namespace App\Filament\Resources\PortofolioDescriptions\Schemas;

use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Stichoza\GoogleTranslate\GoogleTranslate;

class PortofolioDescriptionForm
{
    public static function configure(Schema $schema, bool $isRelation = false): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Meta Content')
                    ->description('Pilih type untuk menyesuaikan input meta content.')
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
                            ->visible(fn (Get $get) => $get('type') === 'feature')
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (string $state, Set $set) {
                                if (blank($state)) return;
                                try {
                                    $tr = new GoogleTranslate();
                                    $translated = $tr->setSource('id')->setTarget('en')->translate($state);
                                    $set('title_en', $translated);
                                } catch (\Exception $e) {}
                            }),
                        Hidden::make('title_en'),
                        RichEditor::make('content_id')
                            ->label(fn (Get $get) => $get('type') === 'feature' ? 'Detail Feature' : 'General Description')
                            ->required()
                            ->columnSpanFull()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (string $state, Set $set) {
                                if (blank($state)) return;
                                try {
                                    $tr = new GoogleTranslate();
                                    $translated = $tr->setSource('id')->setTarget('en')->translate($state);
                                    $set('content_en', $translated);
                                } catch (\Exception $e) {}
                            }),
                        Hidden::make('content_en')
                            
                    ])->columns()->columnSpanFull()
            ]);
    }
}
