<?php

namespace App\Livewire\Content;

use App\Models\User;
use Illuminate\Support\Facades\App;
use Livewire\Component;

class Contact extends Component
{
    public $title = 'Rizky Chandra';
    public $page_en = 'Contact Portofolio';
    public $page_id = 'Kontak Portofolio';

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
