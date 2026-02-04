<?php

namespace App\Livewire\Control\Image;

use App\Models\ImageProfile;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class Profile extends Component
{
    use WithFileUploads;

    public $title = 'Dashboard';
    public $page = 'Overview Profile';

    public $imageHome;
    public $imageAbout;
    public $imageResume;

    public $existingHome;
    public $existingAbout;
    public $existingResume;

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $profile = ImageProfile::first();
        if ($profile) {
            $this->existingHome = $profile->foto_home;
            $this->existingAbout = $profile->foto_about;
            $this->existingResume = $profile->foto_resume;
        }
    }

    public function updateImages()
    {
        $this->validate([
            'imageHome' => 'nullable|image|max:2048',
            'imageAbout' => 'nullable|image|max:2048',
            'imageResume' => 'nullable|image|max:2048',
        ]);

        $profile = ImageProfile::firstOrCreate([]);

        try {
            $filesToUpload = [
                'imageHome'   => 'foto_home',
                'imageAbout'  => 'foto_about',
                'imageResume' => 'foto_resume'
            ];

            foreach ($filesToUpload as $property => $column) {
                if ($this->$property) {
                    
                    // 1. Hapus foto lama agar storage tidak penuh
                    if ($profile->$column) {
                        $oldPath = str_replace('/storage/', '', $profile->$column);
                        if (Storage::disk('public')->exists($oldPath)) {
                            Storage::disk('public')->delete($oldPath);
                        }
                    }

                    // 2. Simpan ke folder 'profile' di dalam disk 'public'
                    $path = $this->$property->store('profile', 'public');
                    
                    // 3. Simpan URL publik ke database
                    $profile->$column = Storage::url($path);
                }
            }

            if ($profile->isDirty()) {
                $profile->save();
                session()->flash('success', 'Foto profil utama berhasil diperbarui.');
            }

            $this->loadData();
            $this->reset(['imageHome', 'imageAbout', 'imageResume']);

        } catch (\Exception $e) {
            Log::error('Upload Profile Error: ' . $e->getMessage());
            session()->flash('danger', 'Gagal mengunggah: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.control.image.profile')->layout('layouts.app', [
            'title' => $this->title,
            'page' => $this->page
        ]);
    }
}