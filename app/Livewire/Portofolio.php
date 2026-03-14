<?php

namespace App\Livewire;

use App\Models\CategoryProject;
use App\Models\Portofolio as ModelsPortofolio;
use Illuminate\Support\Facades\App;
use Livewire\Component;

class Portofolio extends Component
{
    public $title = 'Rizky Chandra';
    public $page_en = 'Project';   
    public $page_id = 'Proyek';   

    public function mount($locale = null)
    {
        if ($locale) {
            App::setLocale($locale);
        }
    }

    public function render()
    {
        $currentPage = (app()->getLocale() == 'id') ? $this->page_id : $this->page_en;
        $categories = CategoryProject::orderBy('name_category_' . app()->getLocale(), 'asc')->get();
        $portofolio = ModelsPortofolio::with('category')->orderBy('name_project_' . app()->getLocale(), 'asc')->latest()->get();

        return view('livewire.portofolio', [
            'categories' => $categories,
            'portofolio' => $portofolio
        ])->layout('layouts.blog', [
            'title' => $this->title,
            'page' => $currentPage,
        ]);
    }
}
