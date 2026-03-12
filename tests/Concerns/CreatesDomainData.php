<?php

namespace Tests\Concerns;

use App\Models\CategoryProject;
use App\Models\ImageProfile;
use App\Models\Portofolio;
use App\Models\PortofolioDescription;
use App\Models\PortofolioImage;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

trait CreatesDomainData
{
    protected function createUser(array $overrides = []): User
    {
        return User::create(array_merge([
            'name' => 'Test User',
            'username' => 'test-user',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'address_id' => 'Jl. Test Indonesia',
            'address_en' => 'Test Street Indonesia',
            'phone' => '+620000000000',
            'discord' => 'test#0001',
            'github' => 'test-github',
            'instagram' => 'test-instagram',
            'linkedin' => 'test-linkedin',
            'tiktok' => '@test',
        ], $overrides));
    }

    protected function createImageProfile(array $overrides = []): ImageProfile
    {
        return ImageProfile::create(array_merge([
            'foto_home' => null,
            'foto_about' => null,
            'foto_resume' => null,
        ], $overrides));
    }

    protected function createCategory(array $overrides = []): CategoryProject
    {
        return CategoryProject::create(array_merge([
            'data_filter_category' => '.filter-web',
            'name_category_id' => 'Web',
            'name_category_en' => 'Web',
        ], $overrides));
    }

    protected function createPortofolio(CategoryProject $category, array $overrides = []): Portofolio
    {
        return Portofolio::create(array_merge([
            'category_project_id' => $category->id,
            'name_project_id' => 'Proyek Satu',
            'name_project_en' => 'Project One',
            'date_project' => now()->toDateString(),
            'link_project' => 'https://example.com',
            'image_project' => 'projects/sample-image',
        ], $overrides));
    }

    protected function createPortofolioImage(Portofolio $portofolio, array $overrides = []): PortofolioImage
    {
        return PortofolioImage::create(array_merge([
            'portofolio_id' => $portofolio->id,
            'image_path' => 'projects/gallery-image',
        ], $overrides));
    }

    protected function createPortofolioDescription(Portofolio $portofolio, array $overrides = []): PortofolioDescription
    {
        return PortofolioDescription::create(array_merge([
            'portofolio_id' => $portofolio->id,
            'type' => 'overview',
            'title_id' => 'Judul',
            'title_en' => 'Title',
            'content_id' => 'Konten deskripsi bahasa Indonesia.',
            'content_en' => 'Description content in English.',
            'icon' => 'bi bi-check',
        ], $overrides));
    }
}
