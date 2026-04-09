<?php

namespace App\Filament\Resources\ProjectImages\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProjectImageForm
{
    public static function configure(Schema $schema, bool $isRelation = false): Schema
    {
        return $schema
            ->components([
                Section::make('Manage Galery')
                    ->description('Pilih project terlebih dahulu untuk input galery portofolio.')
                    ->schema([
                        Select::make('project_id')->columnSpan(2)
                            ->label('Name Project')
                            ->relationship('project', 'name_project_id')
                            ->preload()->live()
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
                        FileUpload::make('image_path')->columnSpanFull()
                            ->label('Upload Image')
                            ->disk('cloudinary')
                            ->visibility('public')
                            ->directory('project-detail')
                            ->multiple() 
                            ->image()
                            ->nullable()
                            ->moveFiles()
                            ->fetchFileInformation(false)
                            ->openable()
                            ->previewable()
                            ->reorderable()
                            ->panelLayout('grid')
                            ->removeUploadedFileButtonPosition('right')
                            ->maxSize(2048)
                            ->imagePreviewHeight(140)
                            ->imageResizeTargetHeight(800)
                            ->imageResizeTargetWidth(1200)
                            ->imageResizeMode('cover'),
                    ])->columns(6)->columnSpanFull()
                
            ]);
    }
}
