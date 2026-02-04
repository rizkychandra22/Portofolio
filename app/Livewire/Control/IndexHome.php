<?php

namespace App\Livewire\Control;

use Livewire\Component;

class IndexHome extends Component
{
    public $title = 'Dashboard';
    public $page = 'Overview Home';

    public function render()
    {
        return view('livewire.control.index-home')->layout('layouts.app', [
            'title' => $this->title,
            'page' => $this->page,
        ]);
    }
}
