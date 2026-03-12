<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\CreatesDomainData;
use Tests\TestCase;

class PublicPagesFeatureTest extends TestCase
{
    use CreatesDomainData;
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->createUser();
        $this->createImageProfile();
    }

    public function test_home_about_resume_and_contact_routes_are_accessible_for_supported_locales(): void
    {
        $routes = ['home', 'about', 'resume', 'contact'];
        $locales = ['en', 'id'];

        foreach ($locales as $locale) {
            foreach ($routes as $routeName) {
                $response = $this->get(route($routeName, ['locale' => $locale]));
                $response->assertOk();
            }
        }
    }

    public function test_portofolio_list_and_detail_routes_are_accessible(): void
    {
        $category = $this->createCategory();
        $portofolio = $this->createPortofolio($category);
        $this->createPortofolioImage($portofolio);
        $this->createPortofolioDescription($portofolio);

        $listResponse = $this->get(route('portofolio', ['locale' => 'en']));
        $listResponse->assertOk();
        $listResponse->assertSee('Project One');

        $detailResponse = $this->get(route('portofolio-detail', [
            'locale' => 'en',
            'id' => $portofolio->id,
        ]));

        $detailResponse->assertOk();
        $detailResponse->assertSee('Project One');
    }

    public function test_portofolio_detail_returns_404_for_non_existing_project(): void
    {
        $response = $this->get(route('portofolio-detail', [
            'locale' => 'en',
            'id' => 999999,
        ]));

        $response->assertNotFound();
    }
}
