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

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class, 'category_project_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($category) {
            foreach ($category->projects()->get() as $project) {
                $project->delete();
            }
        });

        static::restoring(function ($category) {
            foreach ($category->projects()->onlyTrashed()->get() as $project) {
                $project->restore();
            }
        });

        static::forceDeleting(function ($category) {
            foreach ($category->projects()->withTrashed()->get() as $project) {
                $project->forceDelete();
            }
        });
    }
}