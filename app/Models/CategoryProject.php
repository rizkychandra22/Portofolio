<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryProject extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'data_filter_category', 
        'name_category_id', 
        'name_category_en'
    ];

    public function portofolios(): HasMany
    {
        return $this->hasMany(Portofolio::class, 'category_project_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($category) {
            foreach ($category->portofolios()->get() as $portofolio) {
                $portofolio->delete();
            }
        });

        static::restoring(function ($category) {
            foreach ($category->portofolios()->onlyTrashed()->get() as $portofolio) {
                $portofolio->restore();
            }
        });

        static::forceDeleting(function ($category) {
            foreach ($category->portofolios()->withTrashed()->get() as $portofolio) {
                $portofolio->forceDelete();
            }
        });
    }
}