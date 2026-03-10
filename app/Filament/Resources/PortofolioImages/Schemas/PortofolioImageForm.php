<?php

namespace App\Filament\Resources\PortofolioImages\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class PortofolioImageForm
{
    public static function configure(Schema $schema, bool $isRelation = false): Schema
    {
        return $schema
            ->components([
                Section::make('Manage Galery')
                    ->description('Pilih project portofolio terlebih dahulu untuk input galery portofolio.')
                    ->schema([
                        Select::make('portofolio_id')->columnSpan(2)
                            ->label('Name Project')
                            ->relationship('portofolio', 'name_project_id')
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
                            ->saveUploadedFileUsing(function (TemporaryUploadedFile $file): string {
                                // Force Cloudinary Media Library folder placement, not only public_id prefix.
                                $uploaded = cloudinary()->uploadApi()->upload($file->getRealPath(), [
                                    'resource_type' => 'image',
                                    'asset_folder' => 'project-detail',
                                    'folder' => 'project-detail',
                                ]);

                                $publicId = $uploaded['public_id'] ?? pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                                $format = $uploaded['format'] ?? $file->getClientOriginalExtension();

                                return $format ? $publicId.'.'.$format : $publicId;
                            })
                            ->multiple() 
                            ->image()
                            ->nullable()
                            ->moveFiles()
                            ->openable()
                            ->previewable()
                            ->reorderable()
                            ->panelLayout('grid')
                            ->removeUploadedFileButtonPosition('right')
                            ->maxSize(2048)
                            ->imagePreviewHeight(250)
                            ->imageResizeTargetHeight(800)
                            ->imageResizeTargetWidth(1200)
                            ->imageResizeMode('cover'),
                    ])->columns(6)->columnSpanFull()
                
            ]);
    }
}
