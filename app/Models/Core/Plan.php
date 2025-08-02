<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plan extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'price_monthly',
        'price_yearly',
        'listing_limit',
        'featured_listings',
        'featured_limit',
        'recommendations',
        'recommendation_limit',
        'photo_limit',
        'active',
        'order',
        'stripe_monthly_id',
        'stripe_yearly_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'price_monthly' => 'decimal:2',
        'price_yearly' => 'decimal:2',
        'listing_limit' => 'integer',
        'featured_listings' => 'boolean',
        'featured_limit' => 'integer',
        'recommendations' => 'boolean',
        'recommendation_limit' => 'integer',
        'photo_limit' => 'integer',
        'active' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($plan) {
            $plan->slug = \Illuminate\Support\Str::slug($plan->name);
        });

        static::updating(function ($plan) {
            if ($plan->isDirty('name')) {
                $plan->slug = \Illuminate\Support\Str::slug($plan->name);
            }
        });
    }

    /**
     * Get the subscriptions for the plan.
     */
    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    /**
     * Check if the plan is free.
     */
    public function isFree(): bool
    {
        return $this->price_monthly == 0 && $this->price_yearly == 0;
    }

    /**
     * Get the display name with price.
     */
    public function getDisplayNameAttribute(): string
    {
        if ($this->isFree()) {
            return $this->name . ' (Grátis)';
        }

        return $this->name . ' (R$ ' . number_format($this->price_monthly, 2, ',', '.') . '/mês)';
    }

    /**
     * Scope a query to only include active plans.
     */
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    /**
     * Scope a query to order by the order field.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}
