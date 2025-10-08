<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ScheduledBackground extends Model
{
    protected $fillable = [
        'user_id',
        'media_id',
        'start_date',
        'day_of_week',
        'time',
    ];

    protected $casts = [
        'start_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function media(): BelongsTo
    {
        return $this->belongsTo(Media::class);
    }

    public function isActive(): bool
    {
        $now = now();
        
        // Check date range
        if ($this->start_date->isAfter($now)) {
            return false;
        }

        // Check day of week if specified
        if ($this->day_of_week) {
            $currentDay = strtolower($now->translatedFormat('l'));
            $dayMap = [
                'monday' => 'senin',
                'tuesday' => 'selasa',
                'wednesday' => 'rabu',
                'thursday' => 'kamis',
                'friday' => 'jumat',
                'saturday' => 'sabtu',
                'sunday' => 'minggu'
            ];
            
            if (($dayMap[$currentDay] ?? null) !== $this->day_of_week) {
                return false;
            }
        }

        // Check time if specified
        if ($this->time) {
            $currentTime = $now->format('H:i:s');
            if ($currentTime < $this->time) {
                return false;
            }
        }

        return true;
    }
}
