<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PortofolioImage extends Model
{
    protected $fillable = ['portofolio_id', 'image_path', 'sort_order'];

    public function portofolio(): BelongsTo
    {
        return $this->belongsTo(Portofolio::class);
    }
}