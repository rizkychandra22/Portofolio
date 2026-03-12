<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\CreatesDomainData;
use Tests\TestCase;

class AdminPanelAccessTest extends TestCase
{
    use CreatesDomainData;
    use RefreshDatabase;

    protected function tearDown(): void
    {
        putenv('ADMIN_EMAIL');
        unset($_ENV['ADMIN_EMAIL'], $_SERVER['ADMIN_EMAIL']);

        parent::tearDown();
    }

    public function test_guest_is_redirected_to_dashboard_login(): void
    {
        $response = $this->get('/dashboard');

        $response->assertRedirect('/dashboard/login');
    }

    public function test_non_admin_user_cannot_access_dashboard_panel(): void
    {
        putenv('ADMIN_EMAIL=admin@example.com');
        $_ENV['ADMIN_EMAIL'] = 'admin@example.com';
        $_SERVER['ADMIN_EMAIL'] = 'admin@example.com';

        $user = $this->createUser(['email' => 'member@example.com']);
        $this->actingAs($user);

        $response = $this->get('/dashboard');

        $response->assertForbidden();
    }

    public function test_admin_user_can_access_dashboard_panel(): void
    {
        putenv('ADMIN_EMAIL=admin@example.com');
        $_ENV['ADMIN_EMAIL'] = 'admin@example.com';
        $_SERVER['ADMIN_EMAIL'] = 'admin@example.com';

        $admin = $this->createUser(['email' => 'admin@example.com']);
        $this->actingAs($admin);

        $response = $this->get('/dashboard');

        $response->assertOk();
    }
}
