<?php

namespace App\Filament\Pages;

use App\Models\ImageProfile;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\ViewField;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class ProfileImages extends Page implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-user';
    // protected static ?string $navigationLabel = 'Foto Profile';
    // protected static ?string $pluralModelLabel = 'Foto Profile';

    protected string $view = 'filament.pages.profile-images';

    public array $data = [];
    public array $oldImage = [];

    public function mount(): void
    {
        $profile = ImageProfile::first();

        $this->oldImage = [
            'foto_home'   => $profile?->foto_home,
            'foto_about'  => $profile?->foto_about,
            'foto_resume' => $profile?->foto_resume,
        ];

        $this->form->fill([]);
    }

    public function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Section::make('Preview & Upload Foto')
                    ->description('Foto di atas adalah foto yang sedang aktif.')
                    ->schema([
                        Grid::make(3)->schema([

                            /** FOTO HOME */
                            Grid::make(1)->schema([
                                ViewField::make('preview_home')
                                    ->view('filament.components.image-preview')
                                    ->viewData(fn () => [
                                        'path' => $this->oldImage['foto_home'] ?? null,
                                    ]),

                                $this->fileUpload('foto_home', 'Foto Utama Home'),
                            ]),

                            /** FOTO ABOUT */
                            Grid::make(1)->schema([
                                ViewField::make('preview_about')
                                    ->view('filament.components.image-preview')
                                    ->viewData(fn () => [
                                        'path' => $this->oldImage['foto_about'] ?? null,
                                    ]),

                                $this->fileUpload('foto_about', 'Foto Utama About'),
                            ]),

                            /** FOTO RESUME */
                            Grid::make(1)->schema([
                                ViewField::make('preview_resume')
                                    ->view('filament.components.image-preview')
                                    ->viewData(fn () => [
                                        'path' => $this->oldImage['foto_resume'] ?? null,
                                    ]),

                                $this->fileUpload('foto_resume', 'Foto Utama Resume'),
                            ]),
                        ]),
                    ]),
            ])
            ->statePath('data');
    }

    /** FILE UPLOAD STANDARD */
    protected function fileUpload(string $name, string $label): FileUpload
    {
        return FileUpload::make($name)
            ->label($label)
            ->image()
            ->disk('cloudinary')
            ->directory('profile')
            ->saveUploadedFileUsing(function (TemporaryUploadedFile $file) use ($name): string {
                $errorKey = "data.{$name}";

                try {
                    if (! $file->exists()) {
                        throw ValidationException::withMessages([
                            $errorKey => 'Upload sementara tidak ditemukan. Di Laravel Cloud gunakan LIVEWIRE_TMP_DISK=cloudinary (atau storage bersama seperti S3), lalu jalankan optimize:clear.',
                        ]);
                    }

                    $realPath = $file->getRealPath();

                    if (! empty($realPath) && is_file($realPath)) {
                        $uploaded = cloudinary()->uploadApi()->upload($realPath, [
                            'resource_type' => 'image',
                            'asset_folder'  => 'profile',
                            'folder'        => 'profile',
                        ]);
                    } else {
                        // Fallback for cloud runtimes where temp upload path is not directly readable.
                        $ext = $file->getClientOriginalExtension() ?: 'jpg';
                        $tmpPath = tempnam(sys_get_temp_dir(), 'cld_') . '.' . $ext;
                        file_put_contents($tmpPath, $file->get());

                        try {
                            $uploaded = cloudinary()->uploadApi()->upload($tmpPath, [
                                'resource_type' => 'image',
                                'asset_folder'  => 'profile',
                                'folder'        => 'profile',
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

                    Log::error('Profile image upload failed', [
                        'field' => $name,
                        'message' => $exception->getMessage(),
                        'exception_class' => $exception::class,
                        'trace' => $exception->getTraceAsString(),
                    ]);

                    throw ValidationException::withMessages([
                        $errorKey => 'Gagal upload ke Cloudinary: ' . $exceptionSummary,
                    ]);
                }

                $publicId = $uploaded['public_id'] ?? pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $format   = $uploaded['format'] ?? $file->getClientOriginalExtension();

                return $format ? $publicId . '.' . $format : $publicId;
            })
            ->visibility('public')
            // ->preserveFilenames()
            ->moveFiles()
            ->maxSize(2048)
            ->imagePreviewHeight(250)
            ->storeFiles(true)
            ->dehydrateStateUsing(fn ($state) =>
                is_array($state) ? collect($state)->first() : $state
            );
    }

    public function save(): void
    {
        $profile = ImageProfile::firstOrCreate(['id' => 1]);

        $data = array_filter(
            $this->form->getState(),
            fn ($value) => ! is_null($value)
        );

        foreach ($data as $field => $newPath) {
            if (! empty($profile->$field) && $profile->$field !== $newPath &&
                Storage::disk('cloudinary')->exists($profile->$field)
            ) {
                Storage::disk('cloudinary')->delete($profile->$field);
            }
            $profile->$field = $newPath;
        }

        $profile->save();

        // Refresh preview
        $this->oldImage = [
            'foto_home'   => $profile->foto_home,
            'foto_about'  => $profile->foto_about,
            'foto_resume' => $profile->foto_resume,
        ];

        // Reset upload state untuk preview
        $this->form->fill([
            'data' => $this->oldImage,
        ]);

        Notification::make()
            ->title('Berhasil')
            ->body('Foto profile berhasil diperbarui')
            ->success()
            ->send();
    }
}
