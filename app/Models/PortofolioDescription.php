<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PortofolioDescription extends Model
{
    protected $fillable = ['portofolio_id', 'type', 'title_id', 'title_en', 'content_id', 'content_en', 'icon', 'sort_order'];

    public function portofolio(): BelongsTo
    {
        return $this->belongsTo(Portofolio::class);
    }
}
