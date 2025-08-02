<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'icon',
        'order',
        'active'
    ];

    /**
     * Relação com subcategorias
     */
    public function subcategories()
    {
        return $this->hasMany(Subcategory::class);
    }

    /**
     * Relação com anúncios (através de subcategorias)
     */
    public function listings()
    {
        return $this->hasManyThrough(Listing::class, Subcategory::class);
    }
}
