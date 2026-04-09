<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectDescription extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'project_id', 'type', 'title_id', 'title_en', 
        'content_id', 'content_en', 'icon',
    ];

    public function project(): BelongsTo 
    {
        return $this->belongsTo(Project::class);
    }
}