<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Portofolio extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'category_project_id', 'name_project_id', 'name_project_en',
        'image_project', 'date_project', 'link_project',
    ];

    public function category(): BelongsTo 
    {
        return $this->belongsTo(CategoryProject::class, 'category_project_id');
    }

    public function images(): HasMany 
    {
        return $this->hasMany(PortofolioImage::class, 'portofolio_id');
    }

    public function descriptions(): HasMany 
    {
        return $this->hasMany(PortofolioDescription::class);
    }

    protected static function boot()
    {
        parent::boot();

        // 1. Update File Cover
        static::updating(function ($model) {
            if ($model->isDirty('image_project')) {
                $oldFile = $model->getOriginal('image_project');
                if ($oldFile && Storage::disk('public')->exists($oldFile)) {
                    Storage::disk('public')->delete($oldFile);
                }
            }
        });

        // 2. Cascade Soft Delete ke Gambar & Deskripsi
        static::deleting(function ($model) {
            $model->images()->get()->each->delete();
            $model->descriptions()->get()->each->delete();
        });

        // 3. Cascade Restore (PENTING: Agar anak-anaknya ikut aktif lagi)
        static::restoring(function ($model) {
            $model->images()->onlyTrashed()->get()->each->restore();
            $model->descriptions()->onlyTrashed()->get()->each->restore();
        });

        // 4. Cascade Force Delete (Hapus Permanen & File fisik)
        static::forceDeleting(function ($model) {
            if ($model->image_project && Storage::disk('public')->exists($model->image_project)) {
                Storage::disk('public')->delete($model->image_project);
            }
            $model->images()->withTrashed()->get()->each->forceDelete();
            $model->descriptions()->withTrashed()->get()->each->forceDelete();
        });
    }
}