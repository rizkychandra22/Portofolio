<?php

namespace Database\Seeders;

use App\Models\CategoryProject;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Hapus semua isi file di dalam folder
        Storage::disk('public')->deleteDirectory('livewire-tmp');
        Storage::disk('public')->deleteDirectory('portofolio');
        Storage::disk('public')->deleteDirectory('portofolio-galery');
        Storage::disk('public')->deleteDirectory('profile');

        // Buat kembali folder untuk simpan file upload
        Storage::disk('public')->makeDirectory('livewire-tmp');
        Storage::disk('public')->makeDirectory('portofolio');
        Storage::disk('public')->makeDirectory('portofolio-galery');
        Storage::disk('public')->makeDirectory('profile');

        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
        ]);
    }
}
