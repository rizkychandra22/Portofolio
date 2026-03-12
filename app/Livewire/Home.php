<?php

namespace App\Livewire;

use App\Models\ImageProfile;
use App\Models\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
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
        $imageHome = Cache::remember('image_profile', 60 * 60, fn () => ImageProfile::first());
        $sosialMedia = Cache::remember('user_sosmed', 60 * 60, fn () => User::first());

        return view('livewire.home', [
            'imageHome' => $imageHome,
            'sosialMedia' => $sosialMedia
        ])->layout('layouts.blog', [
            'title' => $this->title,
            'page' => $currentPage,
        ]);
    }
}
