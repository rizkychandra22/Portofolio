<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CategoryProject extends Model
{

    protected $fillable = ['data_filter_category', 'name_category_id', 'name_category_en'];

    public function portofolios(): HasMany
    {
        return $this->hasMany(Portofolio::class, 'category_project_id');
    }
}
