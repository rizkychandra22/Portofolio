<?php

namespace App\Filament\Resources\PortofolioImages\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
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
                                try {
                                    if (! $file->exists()) {
                                        throw ValidationException::withMessages([
                                            'image_path' => 'Upload sementara tidak ditemukan. Di Laravel Cloud gunakan LIVEWIRE_TMP_DISK=cloudinary (atau storage bersama seperti S3), lalu jalankan optimize:clear.',
                                        ]);
                                    }

                                    $realPath = $file->getRealPath();

                                    if (! empty($realPath) && is_file($realPath)) {
                                        $uploaded = cloudinary()->uploadApi()->upload($realPath, [
                                            'resource_type' => 'image',
                                            'asset_folder'  => 'project-detail',
                                            'folder'        => 'project-detail',
                                        ]);
                                    } else {
                                        $ext = $file->getClientOriginalExtension() ?: 'jpg';
                                        $tmpPath = tempnam(sys_get_temp_dir(), 'cld_') . '.' . $ext;
                                        file_put_contents($tmpPath, $file->get());

                                        try {
                                            $uploaded = cloudinary()->uploadApi()->upload($tmpPath, [
                                                'resource_type' => 'image',
                                                'asset_folder'  => 'project-detail',
                                                'folder'        => 'project-detail',
                                            ]);
                                        } finally {
                                            @unlink($tmpPath);
                                        }
                                    }
                                } catch (ValidationException $exception) {
                                    throw $exception;
                                } catch (\Throwable $exception) {
                                    $exceptionSummary = trim($exception::class . ': ' . $exception->getMessage());
                                    $exceptionSummary = mb_substr($exceptionSummary, 0, 280);

                                    Log::error('Portfolio gallery upload failed', [
                                        'message' => $exception->getMessage(),
                                        'exception_class' => $exception::class,
                                        'trace' => $exception->getTraceAsString(),
                                    ]);

                                    throw ValidationException::withMessages([
                                        'image_path' => 'Gagal upload ke Cloudinary: ' . $exceptionSummary,
                                    ]);
                                }

                                $publicId = $uploaded['public_id'] ?? pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                                $format   = $uploaded['format'] ?? $file->getClientOriginalExtension();

                                return $format ? $publicId . '.' . $format : $publicId;
                            })
                            ->getUploadedFileUsing(function (string $file): ?array {
                                // Use delivery URL helper to avoid Admin API calls when rendering existing files.
                                return [
                                    'name' => basename($file),
                                    'size' => 0,
                                    'type' => 'image/jpeg',
                                    'url'  => \App\Support\CloudinaryUrl::fromPath($file),
                                ];
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
