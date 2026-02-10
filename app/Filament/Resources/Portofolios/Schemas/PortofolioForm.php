<?php

namespace App\Filament\Resources\Portofolios\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Stichoza\GoogleTranslate\GoogleTranslate;

class PortofolioForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Manage Portofolio')
                    ->description('Input project portofolio beserta category.')
                    ->schema([
                        FileUpload::make('image_project')->columnSpanFull()
                            ->label('Image Project')
                            ->disk('public')
                            ->visibility('public')
                            ->directory('portofolio')
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
                            ->label('Category Project')
                            ->placeholder('Select Category Project')
                            ->relationship('category', 'name_category_id')
                            ->preload()
                            ->searchable()
                            ->required(),
                        DatePicker::make('date_project')
                            ->label('Date Project')
                            ->displayFormat('D, j F Y')
                            ->required(), 
                        TextInput::make('name_project_id')
                            ->label('Name Project (ID)')
                            ->placeholder('Contoh: Aplikasi Web E-Commerce')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (string $state, Set $set) {
                                if (blank($state)) return;
                                try {
                                    $tr = new GoogleTranslate();
                                    $translated = $tr->setSource('id')->setTarget('en')->translate($state);
                                    $set('name_project_en', $translated);
                                } catch (\Exception $e) {}
                            }),
                        TextInput::make('link_project')
                            ->label('Link Project')
                            ->placeholder('Contoh: https://...')
                            ->url() 
                            ->required(),
                        Hidden::make('name_project_en'),
                    ])->columns(2)->columnSpanFull()
            ]);
    }
}
