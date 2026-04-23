<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CurriculumVitae extends Model
{
    protected $fillable = [
        'name',
        'file_path',
        'is_active'
    ];
}
