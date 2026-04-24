<?php

namespace App\Filament\Pages;

use App\Models\CurriculumVitae;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ViewField;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema; 
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class ManageCv extends Page implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-document-text';
    protected static ?int $navigationSort = 2;

    protected string $view = 'filament.pages.manage-cv';

    public array $data = [];
    public ?string $oldFilePath = null;

    public function mount(): void
    {
        $cv = CurriculumVitae::first();
        $this->oldFilePath = $cv?->file_path;

        $this->form->fill([
            'name' => $cv?->name,
        ]);
    }

    public function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Section::make('Manage CV')
                    ->description('File CV yang diupload akan menggantikan file sebelumnya di Cloudinary.')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Dokumen')
                            ->required(),

                        FileUpload::make('file_path')
                            ->label('Upload File CV (PDF)')
                            ->disk('cloudinary')
                            ->directory('cv')
                            ->acceptedFileTypes(['application/pdf'])
                            ->maxSize(4096) // 4MB
                            ->moveFiles()
                            ->storeFiles(true)
                            ->fetchFileInformation(false)
                            ->getUploadedFileNameForStorageUsing(fn (TemporaryUploadedFile $file): string => Str::ulid() . '.pdf')
                            ->dehydrateStateUsing(fn ($state) =>
                                is_array($state) ? collect($state)->first() : $state
                            ),

                        ViewField::make('preview_cv')->columnSpanFull()
                            ->view('filament.components.cv-preview')
                            ->viewData([
                                'path' => $this->oldFilePath,
                                'url' => $this->resolveCvUrl($this->oldFilePath),
                                'imageUrl' => $this->resolveCvUrl($this->oldFilePath, true),
                            ]),
                    ])->columns(2),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $state = $this->form->getState();

        $cv = CurriculumVitae::first() ?? new CurriculumVitae();
        $cv->name = $state['name'] ?? 'CV Rizky Chandra';

        // Validasi file wajib PDF
        if (!empty($state['file_path'])) {
            // Hapus file lama jika berbeda
            if ($cv->file_path && $cv->file_path !== $state['file_path']) {
                rescue(fn () => Storage::disk('cloudinary')->delete($cv->file_path), report: false);
            }
            $cv->file_path = $state['file_path'];
        }

        $cv->is_active = true;
        $cv->save();

        // Update preview
        $this->oldFilePath = $cv->file_path;
        $this->form->fill([
            'name' => $cv->name,
            'file_path' => null,
        ]);

        Notification::make()
            ->title('Berhasil')
            ->body('Data CV berhasil diperbarui')
            ->success()
            ->send();

        // Bersihkan file sementara
        Storage::disk('local')->deleteDirectory('livewire-tmp');
    }

    protected function resolveCvUrl(?string $path, bool $asImage = false): ?string
    {
        if (blank($path)) return null;
        $normalizedPath = ltrim(str_replace('\\', '/', $path), '/');

        return rescue(function () use ($normalizedPath, $asImage) {
            $url = Storage::disk('cloudinary')->url($normalizedPath);
            
            if ($asImage) {
                $baseUrl = str_replace('.pdf', '.jpg', $url);
                return str_replace('/upload/', '/upload/pg_1,f_jpg,w_1000/', $baseUrl);
            }

            return $url;
        }, report: false);
    }
}
