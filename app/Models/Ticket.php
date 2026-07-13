<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ticket extends Model
{
    protected $fillable = [
        'registration_id',
        'qr_code',
        'qr_code_image',      // stores the generated QR image path
        'pdf_path',
        'issued_at',
    ];

    protected $casts = [
        'issued_at' => 'datetime',
    ];

    public function registration(): BelongsTo
    {
        return $this->belongsTo(Registration::class);
    }

    // get full ticket number via registration
    public function getTicketNumberAttribute(): ?string
    {
        return $this->registration?->ticket_number;
    }

    // get event via registration
    public function getEventAttribute(): ?Event
    {
        return $this->registration?->event;
    }

    // get user via registration
    public function getUserAttribute(): ?User
    {
        return $this->registration?->user;
    }
}