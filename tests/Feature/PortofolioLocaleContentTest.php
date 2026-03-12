<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\CreatesDomainData;
use Tests\TestCase;

class PortofolioLocaleContentTest extends TestCase
{
    use CreatesDomainData;
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->createUser();
        $this->createImageProfile();
    }

    public function test_portofolio_detail_displays_indonesian_content_for_id_locale(): void
    {
        $category = $this->createCategory([
            'name_category_id' => 'Aplikasi Web',
            'name_category_en' => 'Web App',
        ]);

        $portofolio = $this->createPortofolio($category, [
            'name_project_id' => 'Sistem Inventori',
            'name_project_en' => 'Inventory System',
        ]);

        $this->createPortofolioDescription($portofolio, [
            'type' => 'overview',
            'content_id' => 'Deskripsi bahasa Indonesia.',
            'content_en' => 'English description.',
        ]);

        $response = $this->get(route('portofolio-detail', [
            'locale' => 'id',
            'id' => $portofolio->id,
        ]));

        $response->assertOk();
        $response->assertSee('Informasi Proyek');
        $response->assertSee('Sistem Inventori');
        $response->assertSee('Aplikasi Web');
        $response->assertSee('Deskripsi bahasa Indonesia.');
    }

    public function test_portofolio_detail_displays_english_content_for_en_locale(): void
    {
        $category = $this->createCategory([
            'name_category_id' => 'Aplikasi Web',
            'name_category_en' => 'Web App',
        ]);

        $portofolio = $this->createPortofolio($category, [
            'name_project_id' => 'Sistem Inventori',
            'name_project_en' => 'Inventory System',
        ]);

        $this->createPortofolioDescription($portofolio, [
            'type' => 'overview',
            'content_id' => 'Deskripsi bahasa Indonesia.',
            'content_en' => 'English description.',
        ]);

        $response = $this->get(route('portofolio-detail', [
            'locale' => 'en',
            'id' => $portofolio->id,
        ]));

        $response->assertOk();
        $response->assertSee('Project Information');
        $response->assertSee('Inventory System');
        $response->assertSee('Web App');
        $response->assertSee('English description.');
    }
}
