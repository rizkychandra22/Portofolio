<?php

namespace App\Livewire\Content;

use App\Models\ImageProfile;
use App\Models\User;
use Illuminate\Support\Facades\App;
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
        $imageResume = ImageProfile::first();
        $sosialMedia = User::first();
        
        return view('livewire.content.resume', [
            'imageResume' => $imageResume,
            'sosialMedia' => $sosialMedia
        ])->layout('layouts.blog', [
            'title' => $this->title,
            'page' => $this->page,
        ]);
    }
}
