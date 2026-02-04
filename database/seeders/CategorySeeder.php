<?php

namespace Database\Seeders;

use App\Models\CategoryProject;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'data_filter_category' => 'filter-web',
                'name_category_id' => 'Aplikasi Web',
                'name_category_en' => 'Web Aplication',
            ],
            [
                'data_filter_category' => 'filter-management',
                'name_category_id' => 'Manajemen Sistem',
                'name_category_en' => 'Management System',
            ]
        ];

        foreach($categories as $item) {
            CategoryProject::create($item);
        }
    }
}
