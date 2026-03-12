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
                'data_filter_category' => 'filter-business',
                'name_category_id' => 'Sistem Bisnis',
                'name_category_en' => 'Business System',
            ],
            [
                'data_filter_category' => 'filter-management',
                'name_category_id' => 'Sistem Manajemen',
                'name_category_en' => 'Management System',
            ],
            [
                'data_filter_category' => 'filter-monitoring',
                'name_category_id' => 'Sistem Monitoring',
                'name_category_en' => 'Monitoring System',
            ],
        ];

        foreach($categories as $item) {
            CategoryProject::create($item);
        }
    }
}
