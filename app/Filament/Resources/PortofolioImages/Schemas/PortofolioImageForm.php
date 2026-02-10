<?php

namespace App\Filament\Resources\PortofolioImages\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PortofolioImageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Manage Portofolio')
                    ->description('Pilih project portofolio terlebih dahulu untuk input galery portofolio.')
                    ->schema([
                        Select::make('portofolio_id')->columnSpan(2)
                            ->label('Project Portofolio')
                            ->relationship('portofolio', 'name_project_id')
                            ->preload()->live()
                            ->searchable()
                            ->required(),
                        FileUpload::make('image_path')->columnSpanFull()
                            ->label('Upload Gallery')
                            ->disk('public')
                            ->visibility('public')
                            ->directory('portofolio-galery')
                            ->reorderable()
                            ->panelLayout('grid')
                            ->removeUploadedFileButtonPosition('right')
                            ->multiple() 
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
                    ])->columns(6)->columnSpanFull()
                
            ]);
    }
}
