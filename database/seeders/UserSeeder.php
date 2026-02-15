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
        User::create([
            'name' => 'Rizky Chandra Khusuma',
            'username' => 'username',
            'email' => 'rizkychandra2204@gmail.com',
            'password' => bcrypt('password'),
            'address_id' => 'Jalan Palasari no. 15, Sukakarya Warudoyong Kota Sukabumi',
            'address_en' => 'Palasari Street No. 15, Sukakarya Warudoyong, Sukabumi City',
            'phone' => '+6285860517808',
            'discord' => 'rizkychandra2204',
            'github' => 'rizkychandra22',
            'instagram' => '_chndr_22',
            'linkedin' => 'rizky-chandra-77b830389',
            'tiktok' => '@gagal_ganteng04',
        ]);
    }
}
