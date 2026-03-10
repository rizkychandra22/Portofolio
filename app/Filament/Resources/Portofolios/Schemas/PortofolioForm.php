<?php

namespace App\Filament\Resources\Portofolios\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Stichoza\GoogleTranslate\GoogleTranslate;

class PortofolioForm
{
    public static function configure(Schema $schema, bool $isRelation = false): Schema
    {
        return $schema
            ->components([
                Section::make('Manage Portofolio')
                    ->description('Input project portofolio beserta category.')
                    ->schema([
                        FileUpload::make('image_project')->columnSpanFull()
                            ->label('Image Cover')
                            ->disk('cloudinary')
                            ->visibility('public')
                            ->directory('project')
                            ->saveUploadedFileUsing(function (TemporaryUploadedFile $file): string {
                                // Force Cloudinary Media Library folder placement, not only public_id prefix.
                                $uploaded = cloudinary()->uploadApi()->upload($file->getRealPath(), [
                                    'resource_type' => 'image',
                                    'asset_folder' => 'project',
                                    'folder' => 'project',
                                ]);

                                $publicId = $uploaded['public_id'] ?? pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                                $format = $uploaded['format'] ?? $file->getClientOriginalExtension();

                                return $format ? $publicId.'.'.$format : $publicId;
                            })
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
                        TextInput::make('name_project_id')
                            ->label('Name Project')
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
                            ->url(),
                        Hidden::make('name_project_en'),
                    ])->columns(2)->columnSpanFull()
            ]);
    }
}
