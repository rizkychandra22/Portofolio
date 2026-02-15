<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class PortofolioImage extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'portofolio_id', 
        'image_path', 
    ];
    
    public function getTitleAttribute(): string
    {
        return $this->portofolio 
            ? "Galery " . $this->portofolio->name_project_id 
            : "Galery Tanpa Judul";
    }

    public function portofolio(): BelongsTo
    {
        return $this->belongsTo(Portofolio::class, 'portofolio_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::updating(function ($model) {
            if ($model->isDirty('image_path')) {
                $oldFile = $model->getOriginal('image_path');
                $newFile = $model->image_path;

                if ($oldFile && $newFile && $oldFile !== $newFile) {
                    if (Storage::disk('public')->exists($oldFile)) {
                        Storage::disk('public')->delete($oldFile);
                    }
                }
            }
        });

        static::forceDeleting(function ($model) {
            $file = $model->getRawOriginal('image_path'); 
            if ($file && Storage::disk('public')->exists($file)) {
                Storage::disk('public')->delete($file);
            }
        });
    }
}