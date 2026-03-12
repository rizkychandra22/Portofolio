<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function test_root_redirects_to_english_home(): void
    {
        $response = $this->get('/');

        $response->assertRedirect(route('home', ['locale' => 'en']));
    }

    public function test_user_route_redirects_to_dashboard_login(): void
    {
        $response = $this->get('/user');

        $response->assertRedirect('/dashboard/login');
    }

    public function test_view_cv_route_returns_expected_status_based_on_file_presence(): void
    {
        $response = $this->get(route('view.cv'));
        $cvPath = storage_path('app/document/CV_RizkyChandraKhusuma.pdf');

        if (file_exists($cvPath)) {
            $response->assertOk();
            return;
        }

        $response->assertNotFound();
    }
}
