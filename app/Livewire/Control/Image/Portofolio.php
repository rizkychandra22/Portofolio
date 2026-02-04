<?php

namespace App\Livewire\Control\Image;

use App\Models\CategoryProject;
use App\Models\Portofolio as PortofolioModel; 
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Stichoza\GoogleTranslate\GoogleTranslate;

class Portofolio extends Component
{
    use WithFileUploads;

    public $title = 'Dashboard';
    public $page = 'Overview Portofolio';

    // Properti Form Portofolio
    public $portofolio_id, $category_project_id, $name_project_id, $image_project;
    public $date_project, $link_project;
    
    // Properti Form Category
    public $category_id, $name_category_id, $data_filter_category;
    
    public $old_image_url;

    // State Control 
    public $isEdit = false;
    public $isEditCategory = false;

    /**
     * CRUD Category 
     */
    public function storeCategory()
    {
        $this->validate([
            'name_category_id' => 'required|min:2',
            'data_filter_category' => 'required|alpha_dash'
        ]);

        try {
            $translate = new GoogleTranslate();
            $trnsNameCategory = $translate->setSource('id')->setTarget('en')->translate($this->name_category_id);

            CategoryProject::updateOrCreate(
                ['id' => $this->category_id],
                [
                    'name_category_id' => $this->name_category_id,
                    'name_category_en' => $trnsNameCategory, 
                    'data_filter_category' => strtolower($this->data_filter_category)
                ]
            );

            $status = $this->isEditCategory ? 'diperbarui' : 'disimpan';
            $this->resetCategoryForm();
            session()->flash('success_category', "Kategori berhasil $status!");
            
        } catch (\Exception $e) {
            Log::error('Translate Category Error: ' . $e->getMessage());
            session()->flash('danger_category', 'Gagal menyimpan: Terjadi kesalahan pada sistem terjemahan.');
        }
    }

    public function editCategory($id)
    {
        $category = CategoryProject::findOrFail($id);
        $this->category_id = $category->id;
        $this->name_category_id = $category->name_category_id; 
        $this->data_filter_category = $category->data_filter_category;
        $this->isEditCategory = true;
    }

    public function deleteCategory($id)
    {
        $category = CategoryProject::with('portofolios')->findOrFail($id);
        try {
            foreach ($category->portofolios as $project) {
                if ($project->image_project) {
                    $this->deleteFile($project->image_project);
                }
            }
            $category->delete();
            session()->flash('danger_category', 'Kategori dan data terkait berhasil dihapus!');
        } catch (\Exception $e) {
            Log::error('Delete Category Error: ' . $e->getMessage());
            session()->flash('danger_category', 'Gagal menghapus data.');
        }
    }

    public function resetCategoryForm()
    {
        $this->reset(['category_id', 'name_category_id', 'data_filter_category', 'isEditCategory']);
    }

    /**
     * CRUD Portofolio
     */
    public function editPortofolio($id)
    {
        $project = PortofolioModel::findOrFail($id);
        $this->portofolio_id = $project->id;
        $this->name_project_id = $project->name_project_id; 
        $this->category_project_id = $project->category_project_id;
        $this->date_project = $project->date_project;
        $this->link_project = $project->link_project;
        $this->old_image_url = $project->image_project;
        $this->isEdit = true;
        
        $this->page = 'Edit Portofolio: ' . $project->name_project_id;
    }

    public function savePortofolio()
    {
        $this->validate([
            'category_project_id' => 'required|exists:category_projects,id',
            'name_project_id' => 'required|min:2',
            'date_project' => 'required|date',
            'link_project' => 'nullable|url',
            'image_project' => $this->isEdit ? 'nullable|image|max:2048' : 'required|image|max:2048', 
        ]);

        try {
            $translate = new GoogleTranslate();
            $trnsNameProject = $translate->setSource('id')->setTarget('en')->translate($this->name_project_id);
            
            $data = [
                'category_project_id' => $this->category_project_id,
                'name_project_id' => $this->name_project_id,
                'name_project_en' => $trnsNameProject,
                'date_project' => $this->date_project,
                'link_project' => $this->link_project ?: null,
            ];

            if ($this->image_project) {
                if ($this->isEdit && $this->old_image_url) {
                    $this->deleteFile($this->old_image_url);
                }
                $path = $this->image_project->store('portofolio', 'public');
                $data['image_project'] = Storage::url($path);
            }

            PortofolioModel::updateOrCreate(['id' => $this->portofolio_id], $data);

            $msg = $this->isEdit ? 'diperbarui' : 'disimpan';
            session()->flash('success', "Project berhasil $msg!");
            $this->resetProjectForm();

        } catch (\Exception $e) {
            Log::error('Upload Portofolio Error: ' . $e->getMessage());
            session()->flash('danger', 'Gagal memproses data.');
        }
    }

    public function deletePortofolio($id)
    {
        $project = PortofolioModel::findOrFail($id);
        try {
            if ($project->image_project) {
                $this->deleteFile($project->image_project);
            }
            $project->delete();
            session()->flash('danger', 'Project berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Delete Portofolio Error: ' . $e->getMessage());
        }
    }

    private function deleteFile($url)
    {
        $path = str_replace('/storage/', '', $url);
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    public function resetProjectForm()
    {
        $this->reset(['portofolio_id', 'category_project_id', 'name_project_id', 'image_project', 'date_project', 'link_project', 'old_image_url', 'isEdit']);
        $this->page = 'Overview Portofolio';
    }

    public function render()
    {
        return view('livewire.control.image.portofolio', [
            'categories' => CategoryProject::latest()->get(),
            'portofolios' => PortofolioModel::with('category')->latest()->get()
        ])->layout('layouts.app', [
            'title' => $this->title,
            'page' => $this->page
        ]);
    }
}