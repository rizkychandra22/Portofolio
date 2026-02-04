<?php

namespace App\Livewire\Content;

use App\Mail\SendMailMessage;
use App\Models\User;
use App\Services\GmailService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Throwable;

class Contact extends Component
{
    public $title = 'Rizky Chandra';
    public $page_en = 'Contact Portofolio';
    public $page_id = 'Kontak Portofolio';

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
        'subject' => 'required|min:3',
        'message' => 'required|min:7',
    ];

    public function mount($locale = null)
    {
        if($locale) {
            App::setLocale($locale);
        }
    }

    public function updated($property): void
    {
        $this->validateOnly($property);
    }

    public function sendMessage(GmailService $gmail)
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

        } catch (Throwable $e) {
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
        $currentPage = (app()->getLocale() == 'id') ? $this->page_id : $this->page_en;
        $sosialMedia = User::first();

        return view('livewire.content.contact', [
            'sosialMedia' => $sosialMedia
        ])->layout('layouts.blog', [
            'title' => $this->title,
            'page' => $currentPage,
        ]);
    }
}
