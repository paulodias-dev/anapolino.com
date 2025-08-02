<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BusinessHour extends Model
{
    protected $fillable = [
        'listing_id',
        'day',
        'open_time',
        'close_time',
        'closed',
        'special_note'
    ];

    protected $casts = [
        'closed' => 'boolean',
        'open_time' => 'datetime:H:i',
        'close_time' => 'datetime:H:i',
    ];

    /**
     * Relação com o anúncio
     */
    public function listing(): BelongsTo
    {
        return $this->belongsTo(Listing::class);
    }

    /**
     * Formata o horário para exibição
     */
    public function getFormattedHoursAttribute(): string
    {
        if ($this->closed) {
            return 'Fechado';
        }

        if (!$this->open_time || !$this->close_time) {
            return 'Horário não informado';
        }

        return $this->open_time->format('H:i') . ' - ' . $this->close_time->format('H:i');
    }

    /**
     * Verifica se está aberto no momento atual
     */
    public function getIsOpenNowAttribute(): bool
    {
        if ($this->closed) {
            return false;
        }

        $now = now()->format('H:i:s');
        return $now >= $this->open_time && $now <= $this->close_time;
    }
}
