<?php

namespace Tests\Unit;

use App\Models\User;
use Filament\Panel;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    protected function tearDown(): void
    {
        putenv('ADMIN_EMAIL');
        unset($_ENV['ADMIN_EMAIL'], $_SERVER['ADMIN_EMAIL']);

        parent::tearDown();
    }

    public function test_user_can_access_admin_panel_when_email_matches_admin_email_env(): void
    {
        putenv('ADMIN_EMAIL=admin@example.com');
        $_ENV['ADMIN_EMAIL'] = 'admin@example.com';
        $_SERVER['ADMIN_EMAIL'] = 'admin@example.com';

        $user = new User(['email' => 'admin@example.com']);
        $panel = (new Panel())->id('admin');

        $this->assertTrue($user->canAccessPanel($panel));
    }

    public function test_user_cannot_access_admin_panel_when_admin_email_env_is_missing(): void
    {
        $user = new User(['email' => 'admin@example.com']);
        $panel = (new Panel())->id('admin');

        $this->assertFalse($user->canAccessPanel($panel));
    }

    public function test_user_cannot_access_non_admin_panel_even_if_email_matches(): void
    {
        putenv('ADMIN_EMAIL=admin@example.com');
        $_ENV['ADMIN_EMAIL'] = 'admin@example.com';
        $_SERVER['ADMIN_EMAIL'] = 'admin@example.com';

        $user = new User(['email' => 'admin@example.com']);
        $panel = (new Panel())->id('member');

        $this->assertFalse($user->canAccessPanel($panel));
    }
}
