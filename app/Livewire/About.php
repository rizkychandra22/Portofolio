<?php

namespace App\Livewire;

use App\Models\ImageProfile;
use App\Models\User;
use Illuminate\Support\Facades\App;
use Livewire\Component;

class About extends Component
{
    public $title = 'Rizky Chandra';
    public $page_en = 'About Portofolio';
    public $page_id = 'Tentang Portofolio';

    public function mount($locale = null)
    {
        if($locale) {
            App::setLocale($locale);
        }
    }

    public function render()
    {
        $currentPage = (app()->getLocale() == 'id') ? $this->page_id : $this->page_en;
        $imageAbout = ImageProfile::first();
        $sosialMedia = User::first();

        return view('livewire.about', [
            'imageAbout' => $imageAbout,
            'sosialMedia' => $sosialMedia
        ])->layout('layouts.blog', [
            'title' => $this->title,
            'page' => $currentPage,
        ]);
    }
}
