<?php

namespace App\Livewire;

use App\Models\Project;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class ProjectDetail extends Component
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
        $project = Project::with(['category', 'images', 'descriptions'])
            ->findOrFail($this->projectId);

        $currentCategoryName = (app()->getLocale() == 'id') 
            ? $project->category->name_category_id 
            : $project->category->name_category_en;

        $this->page = (app()->getLocale() == 'id') 
            ? 'Detail Proyek #' . $project->id . ' - ' . $currentCategoryName 
            : 'Project Details #' . $project->id . ' - ' . $currentCategoryName;
        
        return view('livewire.project-detail', [
            'project' => $project
        ])->layout('layouts.blog', [
            'title' => $this->title,
            'page' => $this->page,
            'metaImage' => $project->image_project
                ? Storage::disk('cloudinary')->url($project->image_project)
                : null,
        ]);
    }
}
