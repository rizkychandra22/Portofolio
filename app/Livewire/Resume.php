<?php

namespace App\Livewire;

use App\Models\ImageProfile;
use App\Models\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class Resume extends Component
{
    public $title = 'Rizky Chandra';
    public $page = 'Resume Portofolio';

    public function mount($locale = null)
    {
        if($locale) {
            App::setLocale($locale);
        }
    }

    public function render()
    {
        $imageResume = Cache::remember('image_profile', 60 * 60, fn () => ImageProfile::first());
        $sosialMedia = Cache::remember('user_sosmed', 60 * 60, fn () => User::first());
        
        return view('livewire.resume', [
            'imageResume' => $imageResume,
            'sosialMedia' => $sosialMedia
        ])->layout('layouts.blog', [
            'title' => $this->title,
            'page' => $this->page,
        ]);
    }
}
