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
        return $this->hasMany(PortofolioDescription::class, 'portofolio_id');
    }

    protected static function boot()
    {
        parent::boot();

        // 1. Update File Galeri (Hapus foto lama jika ada foto baru)
        static::updating(function ($model) {
            if ($model->isDirty('image_project')) {
                $oldFile = $model->getOriginal('image_project');
                if ($oldFile) {
                    rescue(fn () => Storage::disk('cloudinary')->delete($oldFile), report: false);
                }
            }
        });

        // 2. Cascade Soft Delete ke Gambar & Deskripsi
        static::deleting(function ($model) {
            $model->images()->delete();
            $model->descriptions()->delete();
        });

        // 3. Cascade Restore (Agar relasi database ikut aktif lagi)
        static::restoring(function ($model) {
            $model->images()->onlyTrashed()->restore();
            $model->descriptions()->onlyTrashed()->restore();
        });

        // 4. Cascade Force Delete (Hapus Permanen file gambar)
        static::forceDeleting(function ($model) {
            if ($model->image_project) {
                rescue(fn () => Storage::disk('cloudinary')->delete($model->image_project), report: false);
            }
            // Hapus file cloudinary untuk setiap gambar
            $model->images()->withTrashed()->get()->each(function ($image) {
                if ($image->image_path) {
                    rescue(fn () => Storage::disk('cloudinary')->delete($image->image_path), report: false);
                }
            });
            $model->images()->withTrashed()->forceDelete();
            $model->descriptions()->withTrashed()->forceDelete();
        });
    }
}