<?php

namespace Tests\Feature;

use App\Livewire\Content\Form\Contact;
use App\Services\GmailService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Mock GmailService to avoid token issues in tests
        $this->mock(GmailService::class);
    }

    public function test_contact_form_can_be_rendered()
    {
        Livewire::test(Contact::class)
            ->assertOk();
    }

    public function test_contact_form_validation_works()
    {
        Livewire::test(Contact::class)
            ->set('name', '')
            ->set('email', 'invalid-email')
            ->set('subject', 'ab')
            ->set('message', 'short')
            ->call('send')
            ->assertHasErrors(['name', 'email', 'subject', 'message']);
    }

    public function test_contact_form_sends_email_successfully()
    {
        // Mock GmailService send method
        $this->mock(GmailService::class, function ($mock) {
            $mock->shouldReceive('send')
                ->once()
                ->with('rizkychandra2204@gmail.com', 'Pesan baru: John Doe', \Mockery::type('string'));
        });

        Livewire::test(Contact::class)
            ->set('name', 'John Doe')
            ->set('email', 'john@example.com')
            ->set('subject', 'Test Subject')
            ->set('message', 'This is a test message with enough length.')
            ->call('send')
            ->assertSet('sent', true)
            ->assertSet('error', false);
    }
}