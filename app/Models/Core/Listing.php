<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Listing extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'category_id',
        'subcategory_id',
        'title',
        'slug',
        'description',
        'phone',
        'whatsapp',
        'address',
        'city',
        'state',
        'zip_code',
        'latitude',
        'longitude',
        'delivery_available',
        'website',
        'active',
        'featured',
        'featured_until',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'whatsapp' => 'boolean',
        'delivery_available' => 'boolean',
        'active' => 'boolean',
        'featured' => 'boolean',
        'featured_until' => 'datetime',
    ];

    /**
     * Relação com o usuário dono do anúncio
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relação com a categoria principal
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relação com a subcategoria
     */
    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(Subcategory::class);
    }

    /**
     * Relação com os horários de funcionamento
     */
    public function businessHours(): HasMany
    {
        return $this->hasMany(BusinessHour::class);
    }

    /**
     * Obtém o horário para um dia específico
     */
    public function businessHourForDay(string $day): ?BusinessHour
    {
        return $this->businessHours()->where('day', strtolower($day))->first();
    }

    /**
     * Relação com as imagens do anúncio
     */
    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    /**
     * Relação com a imagem principal
     */
    public function mainImage(): HasOne
    {
        return $this->hasOne(Image::class, 'imageable_id')
            ->where('imageable_type', self::class)
            ->where('is_main', true);
    }

    /**
     * Scope para anúncios ativos
     */
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    /**
     * Scope para anúncios destacados
     */
    public function scopeFeatured($query)
    {
        return $query->where('featured', true)
            ->where('featured_until', '>=', now());
    }

    /**
     * Scope para busca por localização
     */
    public function scopeNearby($query, $latitude, $longitude, $radius = 10)
    {
        return $query->selectRaw(
            "*,
            (6371 * acos(cos(radians(?)) * cos(radians(latitude)) *
            cos(radians(longitude) - radians(?)) +
            sin(radians(?)) * sin(radians(latitude)))) AS distance",
            [$latitude, $longitude, $latitude]
        )
            ->having('distance', '<', $radius)
            ->orderBy('distance');
    }

    /**
     * Gera o slug automaticamente antes de salvar
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($listing) {
            $listing->slug = \Illuminate\Support\Str::slug($listing->title);
        });

        static::updating(function ($listing) {
            if ($listing->isDirty('title')) {
                $listing->slug = \Illuminate\Support\Str::slug($listing->title);
            }
        });
    }
}
