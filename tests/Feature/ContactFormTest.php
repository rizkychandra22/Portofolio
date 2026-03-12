<?php

namespace Tests\Feature;

use App\Livewire\Form\Contact;
use Illuminate\Support\Facades\Http;
use Livewire\Livewire;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    public function test_contact_form_validates_required_fields(): void
    {
        Livewire::test(Contact::class)
            ->call('sendMessage')
            ->assertHasErrors(['name', 'email', 'subject', 'message']);
    }

    public function test_contact_form_sets_sent_true_when_resend_api_is_successful(): void
    {
        Http::fake([
            'https://api.resend.com/emails' => Http::response(['id' => 'msg_123'], 200),
        ]);

        Livewire::test(Contact::class)
            ->set('name', 'Rizky')
            ->set('email', 'rizky@example.com')
            ->set('subject', 'Testing')
            ->set('message', 'Ini pesan percobaan yang valid.')
            ->call('sendMessage')
            ->assertSet('sent', true)
            ->assertSet('error', false);
    }

    public function test_contact_form_shows_generic_error_message_when_resend_api_fails(): void
    {
        Http::fake([
            'https://api.resend.com/emails' => Http::response(['message' => 'error'], 500),
        ]);

        Livewire::test(Contact::class)
            ->set('name', 'Rizky')
            ->set('email', 'rizky@example.com')
            ->set('subject', 'Testing')
            ->set('message', 'This message is long enough.')
            ->call('sendMessage')
            ->assertSet('sent', false)
            ->assertSet('error', true)
            ->assertSet('errorMessage', 'Failed to send message, please try again.');
    }
}
