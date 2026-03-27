<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminEmail = config('filament.admin_email') ?: 'rizkychandra2204@gmail.com';

        User::firstOrCreate(
            [
                'email' => $adminEmail,
            ],
            [
                'name' => 'Rizky Chandra Khusuma',
                'username' => 'username',
                'password' => bcrypt('password'),
                'address_id' => 'Jalan Palasari no. 15, Sukakarya Warudoyong Kota Sukabumi',
                'address_en' => 'Palasari Street No. 15, Sukakarya Warudoyong, Sukabumi City',
                'phone' => '+6285860517808',
                'discord' => 'rizkychandra2204',
                'github' => 'rizkychandra22',
                'instagram' => '_chndr_22',
                'linkedin' => 'rizky-chandra-86p22n04',
                'tiktok' => '@gagal_ganteng04',
            ]
        );
    }
}
