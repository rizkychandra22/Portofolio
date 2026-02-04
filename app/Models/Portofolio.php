<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Portofolio extends Model
{
    protected $fillable = ['category_project_id', 'name_project_id', 'name_project_en', 'image_project', 'date_project', 'link_project'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(CategoryProject::class, 'category_project_id');
    }

    // Relasi ke Galeri Gambar (Banyak)
    public function images(): HasMany
    {
        return $this->hasMany(PortofolioImage::class)->orderBy('sort_order', 'asc');
    }

    // Relasi ke Deskripsi & Fitur (Banyak)
    public function descriptions(): HasMany
    {
        return $this->hasMany(PortofolioDescription::class)->orderBy('sort_order', 'asc');
    }
}