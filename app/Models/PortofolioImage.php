<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
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

    public function portofolio(): BelongsTo
    {
        return $this->belongsTo(Portofolio::class, 'portofolio_id');
    }

    protected function title(): Attribute
    {
        return Attribute::make(
            get: fn () => "Galery Portofolio " . ($this->portofolio->name_project_id),
        );
    }

    protected static function boot()
    {
        parent::boot();

        static::updating(function ($model) {
            if ($model->isDirty('image_path')) {
                $oldFile = $model->getOriginal('image_path');
                if ($oldFile && Storage::disk('public')->exists($oldFile)) {
                    Storage::disk('public')->delete($oldFile);
                }
            }
        });

        static::forceDeleting(function ($model) {
            $file = $model->image_path;
            if ($file && Storage::disk('public')->exists($file)) {
                Storage::disk('public')->delete($file);
            }
        });
    }
}