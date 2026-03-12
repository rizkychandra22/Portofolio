<?php

namespace App\Livewire\Form;

use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Illuminate\Support\Facades\Log;
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
            // View Pesan Email
            $data = [
                'name' => $this->name,
                'email' => $this->email,
                'subject' => $this->subject,
                'messageContent' => $this->message,
            ];

            // Render View HTML untuk pesan email
            $htmlContent = view('emails.contact', $data)->render();

            // Kirim via API Resend
            $response = Http::timeout(10)->withToken(config('services.resend.key'))
                ->post('https://api.resend.com/emails', [
                    'from'      => config('app.name') . " <" . config('mail.from.address') . ">",
                    'to'        => 'rizkychandra2204@gmail.com',
                    'reply_to'  => $this->email,
                    'subject'   => 'Pesan Baru: ' . $this->subject,
                    'html'      => $htmlContent, 
                ]);

            if ($response->successful()) {
                $this->reset(['name', 'email', 'subject', 'message']);
                $this->sent = true;
            } else {
                throw new \Exception('Resend Error: ' . $response->body());
            }

        } catch (\Throwable $e) {
            Log::error('Resend View Error: ' . $e->getMessage());
            $this->error = true;
            $this->errorMessage = 'Gagal mengirim: ' . $e->getMessage();
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
        return view('livewire.form.contact');
    }
}