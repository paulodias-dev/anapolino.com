<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'icon',
        'order',
        'active'
    ];

    /**
     * Relação com a categoria pai
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relação com anúncios
     */
    public function listings()
    {
        return $this->hasMany(Listing::class);
    }
}
