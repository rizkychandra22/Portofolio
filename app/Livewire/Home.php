<?php

namespace App\Livewire;

use App\Models\ImageProfile;
use App\Models\User;
use Illuminate\Support\Facades\App;
use Livewire\Component;

class Home extends Component
{
    public $title = 'Rizky Chandra';
    public $page_en = 'Home Portofolio';
    public $page_id = 'Beranda Portofolio';

    public function mount($locale = null)
    {
        if ($locale) {
            App::setLocale($locale);
        }
    }

    public function render()
    {
        $currentPage = (app()->getLocale() == 'id') ? $this->page_id : $this->page_en;
        $imageHome = ImageProfile::first();
        $sosialMedia = User::first();

        return view('livewire.home', [
            'imageHome' => $imageHome,
            'sosialMedia' => $sosialMedia
        ])->layout('layouts.blog', [
            'title' => $this->title,
            'page' => $currentPage,
        ]);
    }
}
