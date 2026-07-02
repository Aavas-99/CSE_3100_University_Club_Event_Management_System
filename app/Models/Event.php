<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    protected $fillable = [
        'club_id',
        'title',
        'description',
        'venue',
        'event_date',
        'start_time',
        'end_time',
        'registration_deadline',
        'seat_limit',
        'remaining_seats',
        'banner',
        'event_type',
        'status',
    ];

    protected $casts = [
        'event_date' => 'date',
        'registration_deadline' => 'date',
    ];

    public function club(): BelongsTo
    {
        return $this->belongsTo(Club::class);
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }
}
