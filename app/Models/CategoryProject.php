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

    /**
     * Relasi ke Portofolio
     */
    public function portofolios(): HasMany
    {
        return $this->hasMany(Portofolio::class, 'category_project_id');
    }

    /**
     * Logika Otomatisasi (Boot)
     */
    protected static function boot()
    {
        parent::boot();

        /**
         * 1. EVENT: DELETING (Soft Delete)
         * Saat kategori di-soft delete, relasi project di dalamnya juga ikut di-soft delete.
         */
        static::deleting(function ($category) {
            $category->portofolios()->get()->each->delete();
        });

        /**
         * 2. EVENT: RESTORING (Mengembalikan Data)
         * Jika kategori dikembalikan dari Trash, relasi project di dalamnya juga ikut kembali.
         */
        static::restoring(function ($category) {
            $category->portofolios()->onlyTrashed()->get()->each->restore();
        });

        /**
         * 3. EVENT: FORCE DELETING (Hapus Permanen)
         * Saat kategori dihapus permanen, semua project & filenya bersih total.
         */
        static::forceDeleting(function ($category) {
            $category->portofolios()->withTrashed()->get()->each->forceDelete();
        });
    }
}