<?php

namespace App\Livewire\Content\Form;

use Livewire\Component;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class Contact extends Component
{
    // Form properties
    public string $name = '';
    public string $email = '';
    public string $subject = '';
    public string $message = '';

    public bool $sent = false;
    public bool $error = false;
    public string $errorMessage = '';

    protected array $rules = [
        'name'    => 'required|min:2',
        'email'   => 'required|email',
        'subject' => 'required|min:2',
        'message' => 'required|min:7',
    ];

    public function updated($property): void
    {
        $this->validateOnly($property);
    }

    public function sendMessage()
    {
        $this->resetState();
        $this->validate();

        try {
            $data = [
                'name' => $this->name,
                'email' => $this->email,
                'subject' => $this->subject,
                'messageContent' => $this->message,
            ];

            // Mail Laravel (SMTP Brevo)
            Mail::send('emails.contact', $data, function($message) use ($data) {
                $message->to('rizkychandra2204@gmail.com')
                        ->from(config('mail.from.address'), config('mail.from.name')) 
                        ->replyTo($data['email'], $data['name'])
                        ->subject('Pesan baru dari: ' . $data['name']);
            });

            $this->reset(['name', 'email', 'subject', 'message']);
            $this->sent = true;

        } catch (Throwable $e) {
            Log::error('Gagal mengirim email kontak via Brevo: ' . $e->getMessage());
            $this->error = true;
            $this->errorMessage = 'Gagal mengirim pesan. Silakan coba lagi nanti.';
        }
    }

    private function resetState(): void
    {
        $this->sent = false;
        $this->error = false;
        $this->errorMessage = '';
    }

    public function render()
    {
        return view('livewire.content.form.contact');
    }
}