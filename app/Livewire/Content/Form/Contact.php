<?php

namespace App\Livewire\Content\Form;

use App\Services\GmailService;
use Livewire\Component;
use Illuminate\Support\Facades\Log;
use Throwable;

class Contact extends Component
{
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
        'subject' => 'required|min:3',
        'message' => 'required|min:7',
    ];

    public function updated($property): void
    {
        $this->validateOnly($property);
    }

    public function send(GmailService $gmail)
    {
        $this->resetState();
        $this->validate();

        try {
            $html = view('emails.contact', [
                'name' => $this->name,
                'email' => $this->email,
                'subject' => $this->subject,
                'messageContent' => $this->message,
            ])->render();

            $gmail->send(
                'rizkychandra2204@gmail.com',
                'Pesan baru: ' . $this->name,
                $html
            );

            $this->reset(['name', 'email', 'subject', 'message']);
            $this->sent = true;

        } catch (\Throwable $e) {
            Log::error('Gagal mengirim email kontak: ' . $e->getMessage());
            $this->error = true;
            $this->errorMessage = 'Gagal mengirim pesan. Pastikan autentikasi Gmail sudah benar.';
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
