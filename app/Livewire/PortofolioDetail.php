<?php

namespace App\Livewire;

use App\Models\Portofolio;
use Illuminate\Support\Facades\App;
use Livewire\Component;

class PortofolioDetail extends Component
{
    public $title = 'Rizky Chandra';
    public $page; 
    public $projectId;

    public function mount($id, $locale = null)
    {
        $this->projectId = $id;

        if($locale) {
            App::setLocale($locale);
        }
    }

    public function render()
    {
        $portofolio = Portofolio::with(['category', 'images', 'descriptions'])
            ->findOrFail($this->projectId);

        $currentCategoryName = (app()->getLocale() == 'id') 
            ? $portofolio->category->name_category_id 
            : $portofolio->category->name_category_en;

        $this->page = (app()->getLocale() == 'id') 
            ? 'Detail Project #' . $portofolio->id . ' - ' . $currentCategoryName 
            : 'Project Detail #' . $portofolio->id . ' - ' . $currentCategoryName;
        
        return view('livewire.portofolio-detail', [
            'portofolio' => $portofolio
        ])->layout('layouts.blog', [
            'title' => $this->title,
            'page' => $this->page, 
        ]);
    }
}