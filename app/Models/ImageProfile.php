<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImageProfile extends Model
{
    protected $fillable = [
        'foto_home', 
        'foto_about', 
        'foto_resume'
    ];
}
