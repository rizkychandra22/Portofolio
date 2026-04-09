<?php

namespace App\Filament\Resources\Projects\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProjectForm
{
    public static function configure(Schema $schema, bool $isRelation = false): Schema
    {
        return $schema
            ->components([
                Section::make('Manage Project')
                    ->description('Input project beserta category yang tersedia.')
                    ->schema([
                        TextInput::make('name_project_id')->columnSpanFull()
                            ->label('Name Project')
                            ->placeholder('Contoh: Aplikasi Web E-Commerce')
                            ->required(),
                        FileUpload::make('image_project')->columnSpanFull()
                            ->label('Image Cover')
                            ->disk('cloudinary')
                            ->visibility('public')
                            ->directory('project')
                            ->removeUploadedFileButtonPosition('right')
                            ->image()
                            ->nullable()
                            ->moveFiles()
                            ->openable()
                            ->previewable()
                            ->maxSize(2048)
                            ->imagePreviewHeight(250)
                            ->imageResizeTargetHeight(800)
                            ->imageResizeTargetWidth(1200)
                            ->imageResizeMode('cover'),
                        Select::make('category_project_id')
                            ->label('Category')
                            ->placeholder('Select Category Project')
                            ->relationship('category', 'name_category_id')
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
                        DatePicker::make('date_project')
                            ->label('Date Project')
                            ->displayFormat('D, j F Y')
                            ->required(), 
                        TextInput::make('link_project')
                            ->label('Link Project')
                            ->placeholder('Contoh: https://...')
                            ->url(),
                        TextInput::make('link_demo_project')
                            ->label('Link Demo')
                            ->placeholder('Contoh: https://...')
                            ->url(),
                        Hidden::make('name_project_en')
                            ->dehydrated(),
                    ])->columns(2)->columnSpanFull()
            ]);
    }
}
