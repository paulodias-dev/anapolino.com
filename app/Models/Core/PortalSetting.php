<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;

class PortalSetting extends Model
{
    protected $table = 'portal_settings';

    protected $fillable = [
        'site_title',
        'site_description',
        'domain',
        'default_language',
        'supported_languages',
        'contact_email',
        'contact_phone',
        'address',
        'city',
        'state',
        'zip_code',
        'social_links',
        'logo_path',
        'favicon_path',
        'seo_meta',
        'payment_methods'
    ];

    protected $casts = [
        'supported_languages' => 'array',
        'seo_meta' => 'array',
        'payment_methods' => 'array'
    ];

    /**
     * Retorna a instância única das configurações
     */
    public static function getSettings()
    {
        return static::firstOrCreate([], [
            'site_title' => config('app.name'),
            'domain' => config('app.url'),
            'contact_email' => config('mail.from.address'),
            'default_language' => config('app.locale')
        ]);
    }

    /**
     * URL completa do logo
     */
    public function getLogoUrlAttribute()
    {
        return $this->logo_path ? asset('storage/'.$this->logo_path) : asset('images/logo.png');
    }

    /**
     * URL completa do favicon
     */
    public function getFaviconUrlAttribute()
    {
        return $this->favicon_path ? asset('storage/'.$this->favicon_path) : asset('images/favicon.ico');
    }

    /**
     * Endereço completo formatado
     */
    public function getFullAddressAttribute()
    {
        return "{$this->address}, {$this->city} - {$this->state}, {$this->zip_code}";
    }
}
