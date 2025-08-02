<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = [
        'path',
        'thumbnail_path',
        'is_main',
        'order',
        'alt_text',
        'imageable_id',
        'imageable_type'
    ];

    protected $casts = [
        'is_main' => 'boolean'
    ];

    /**
     * Relação polimórfica com qualquer modelo que tenha imagens
     */
    public function imageable()
    {
        return $this->morphTo();
    }

    /**
     * URL completa da imagem
     */
    public function getUrlAttribute()
    {
        return asset('storage/' . $this->path);
    }

    /**
     * URL completa do thumbnail
     */
    public function getThumbnailUrlAttribute()
    {
        return $this->thumbnail_path ? asset('storage/' . $this->thumbnail_path) : $this->url;
    }

    /**
     * Scope para imagens principais
     */
    public function scopeMain($query)
    {
        return $query->where('is_main', true);
    }
}
