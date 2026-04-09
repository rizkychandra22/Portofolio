<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class ProjectImage extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'project_id', 
        'image_path', 
    ];
    
    public function getTitleAttribute(): string
    {
        return $this->project 
            ? "Galery " . $this->project->name_project_id 
            : "Galery Tanpa Judul";
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::updating(function ($model) {
            if ($model->isDirty('image_path')) {
                $oldFile = $model->getOriginal('image_path');
                $newFile = $model->image_path;

                if ($oldFile && $newFile && $oldFile !== $newFile) {
                    rescue(fn () => Storage::disk('cloudinary')->delete($oldFile), report: false);
                }
            }
        });

        static::forceDeleting(function ($model) {
            $file = $model->getRawOriginal('image_path'); 
            if ($file) {
                rescue(fn () => Storage::disk('cloudinary')->delete($file), report: false);
            }
        });
    }
}