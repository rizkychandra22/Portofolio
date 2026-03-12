<?php

namespace Database\Seeders;

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
        // Hapus livewire-tmp di local disk (sesuai config/livewire.php)
        Storage::disk('local')->deleteDirectory('livewire-tmp');

        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
        ]);
    }
}
