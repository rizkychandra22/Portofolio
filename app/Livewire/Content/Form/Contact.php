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
            $body = "Nama: {$this->name}\n" .
                    "Email: {$this->email}\n" .
                    "Subjek: {$this->subject}\n\n" .
                    "Pesan:\n{$this->message}";

            // Mail::raw HANYA butuh string $body dan function callback
            Mail::raw($body, function($message) {
                $message->to('rizkychandra2204@gmail.com')
                        ->from('rizkychandra2204@gmail.com', 'Web-Portofolio')
                        ->replyTo($this->email, $this->name) // Pakai $this langsung
                        ->subject('Pesan baru dari: ' . $this->name);
            });

            $this->reset(['name', 'email', 'subject', 'message']);
            $this->sent = true;

        } catch (Throwable $e) {
            Log::error('Gagal mengirim email kontak via Brevo: ' . $e->getMessage());
            $this->error = true;
            $this->errorMessage = 'Gagal mengirim pesan. Silakan coba lagi nanti.' . $e->getMessage();
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