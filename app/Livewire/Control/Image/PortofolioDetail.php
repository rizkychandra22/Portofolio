<?php

namespace App\Livewire\Control\Image;

use App\Models\Portofolio;
use App\Models\PortofolioImage;
use App\Models\PortofolioDescription;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Stichoza\GoogleTranslate\GoogleTranslate;

class PortofolioDetail extends Component
{
    use WithFileUploads;

    public $title = 'Dashboard';
    public $page = 'Overview Detail Content';

    // State Control
    public $selectedProjectId;
    public $selectedProjectName;
    public $activeTab = 'tab-meta';

    // Properti Form Metadata & Overview
    public $date_project;
    public $link_project;
    public $description_overview;

    // Properti Form Galeri
    public $new_gallery_images = []; 

    // Properti Form Fitur
    public $f_title, $f_content, $f_icon;
    public $editingFeatureId = null;

    /**
     * Memastikan project telah dipilih sebelum melakukan aksi
     */
    protected function ensureProjectSelected()
    {
        if (!$this->selectedProjectId) {
            abort(403, 'Project belum dipilih');
        }
    }

    /**
     * Memuat data detail project ke dalam form modal
     */
    public function loadDetail($id)
    {
        $project = Portofolio::findOrFail($id);
        $this->selectedProjectId   = $id;
        
        // Sesuaikan dengan nama kolom project Anda (name_project_id)
        $this->selectedProjectName = $project->name_project_id; 
        $this->date_project         = $project->date_project;
        $this->link_project         = $project->link_project;

        // Ambil data deskripsi tipe overview
        $overview = PortofolioDescription::where([
            'portofolio_id' => $id,
            'type'          => 'overview'
        ])->first();

        // Tampilkan data ke textarea jika ada
        $this->description_overview = $overview ? $overview->content_id : '';
        
        // Reset form lain dan kembali ke tab pertama
        $this->resetFeatureForm();
        $this->reset('new_gallery_images');
        $this->activeTab = 'tab-meta';
    }

    /* ================= METADATA & OVERVIEW CRUD ================= */

    public function saveMetadata()
    {
        $this->ensureProjectSelected();
        $this->validate([
            'date_project'         => 'required|date',
            'link_project'         => 'nullable|url',
            'description_overview' => 'required|min:10'
        ]);

        try {
            DB::transaction(function () {
                // 1. Update Metadata Project Utama
                Portofolio::where('id', $this->selectedProjectId)->update([
                    'date_project' => $this->date_project,
                    'link_project' => $this->link_project ?: null,
                ]);
                
                // 2. Proses Terjemahan Overview
                $translate = new GoogleTranslate();
                $trnsDescription = $translate->setSource('id')->setTarget('en')->translate($this->description_overview);

                // 3. Simpan/Update Deskripsi Overview (PostgreSQL friendly)
                PortofolioDescription::updateOrCreate(
                    ['portofolio_id' => $this->selectedProjectId, 'type' => 'overview'],
                    [
                        'title_id'   => null, 
                        'title_en'   => null, 
                        'content_id' => $this->description_overview,
                        'content_en' => $trnsDescription, 
                        'icon'       => 'bi bi-info-circle', 
                    ]
                );
            });

            session()->flash('success_detail', 'Metadata & deskripsi berhasil diperbarui');
        } catch (\Exception $e) {
            Log::error('Save Metadata Error: ' . $e->getMessage());
            session()->flash('danger_detail', 'Gagal menyimpan data.');
        }
    }

    /* ================= GALLERY CRUD ================= */

    public function uploadGallery()
    {
        $this->ensureProjectSelected();
        $this->validate(['new_gallery_images.*' => 'image|max:2048']);

        try {
            foreach ($this->new_gallery_images as $image) {
                $path = $image->store('portofolio-detail', 'public');

                PortofolioImage::create([
                    'portofolio_id' => $this->selectedProjectId,
                    'image_path'    => Storage::url($path),
                ]);
            }

            $this->reset('new_gallery_images');
            session()->flash('success_detail', 'Gambar galeri berhasil diunggah');
        } catch (\Exception $e) {
            Log::error('Gallery Upload Error: ' . $e->getMessage());
            session()->flash('danger_detail', 'Gagal mengunggah gambar.');
        }
    }

    public function deleteImage($id)
    {
        $img = PortofolioImage::findOrFail($id);
        try {
            $path = str_replace('/storage/', '', $img->image_path);
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
            $img->delete();
            session()->flash('success_detail', 'Gambar berhasil dihapus');
        } catch (\Exception $e) {
            session()->flash('danger_detail', 'Gagal menghapus gambar');
        }
    }

    /* ================= FEATURE CRUD ================= */

    public function addFeature()
    {
        $this->ensureProjectSelected();
        $this->validate([
            'f_title'   => 'required|min:2',
            'f_content' => 'required|min:5',
            'f_icon'    => 'required'
        ]);

        try {
            $translate = new GoogleTranslate();
            $trnsTitle   = $translate->setSource('id')->setTarget('en')->translate($this->f_title);
            $trnsContent = $translate->setSource('id')->setTarget('en')->translate($this->f_content);

            PortofolioDescription::create([
                'portofolio_id' => $this->selectedProjectId,
                'type'          => 'feature',
                'title_id'      => $this->f_title,
                'title_en'      => $trnsTitle,
                'content_id'    => $this->f_content,
                'content_en'    => $trnsContent, 
                'icon'          => $this->f_icon,
            ]);

            $this->resetFeatureForm();
            session()->flash('success_detail', 'Fitur baru berhasil ditambahkan');
        } catch (\Exception $e) {
            Log::error('Add Feature Error: ' . $e->getMessage());
            session()->flash('danger_detail', 'Gagal menambahkan fitur.');
        }
    }

    public function editFeature($id)
    {
        $f = PortofolioDescription::findOrFail($id);
        $this->editingFeatureId = $id;
        $this->f_title   = $f->title_id;   
        $this->f_content = $f->content_id; 
        $this->f_icon    = $f->icon;
    }

    public function updateFeature()
    {
        $this->validate([
            'f_title'   => 'required|min:2',
            'f_content' => 'required|min:5',
            'f_icon'    => 'required'
        ]);

        try {
            $translate = new GoogleTranslate();
            $trnsTitle   = $translate->setSource('id')->setTarget('en')->translate($this->f_title);
            $trnsContent = $translate->setSource('id')->setTarget('en')->translate($this->f_content);

            PortofolioDescription::where('id', $this->editingFeatureId)->update([
                'title_id'   => $this->f_title,
                'title_en'   => $trnsTitle,
                'content_id' => $this->f_content,
                'content_en' => $trnsContent,
                'icon'       => $this->f_icon,
            ]);

            $this->resetFeatureForm();
            session()->flash('success_detail', 'Fitur berhasil diperbarui');
        } catch (\Exception $e) {
            Log::error('Update Feature Error: ' . $e->getMessage());
            session()->flash('danger_detail', 'Gagal memperbarui fitur.');
        }
    }

    public function removeFeature($id)
    {
        PortofolioDescription::findOrFail($id)->delete();
        session()->flash('danger_detail', 'Fitur berhasil dihapus');
    }

    protected function resetFeatureForm()
    {
        $this->reset(['f_title', 'f_content', 'f_icon', 'editingFeatureId']);
    }

    public function render()
    {
        return view('livewire.control.image.portofolio-detail', [
            'portofolios'     => Portofolio::with(['category', 'images', 'descriptions'])->latest()->get(),
            'currentGallery'  => PortofolioImage::where('portofolio_id', $this->selectedProjectId)->get(),
            'currentFeatures' => PortofolioDescription::where([
                'portofolio_id' => $this->selectedProjectId, 
                'type'          => 'feature'
            ])->get(),
        ])->layout('layouts.app', [
            'title' => $this->title, 
            'page'  => $this->page
        ]);
    }
}