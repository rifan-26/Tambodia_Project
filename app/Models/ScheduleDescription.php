<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleDescription extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'is_active',
        'start_date',
        'end_date',
        'day_of_week',
        'time',
        'user_id'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'time' => 'datetime:H:i',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Helper methods
    public function isActive($date = null)
    {
        $checkDate = $date ?? now()->toDateString();
        
        if (!$this->is_active) {
            return false;
        }
        
        if ($checkDate < $this->start_date) {
            return false;
        }
        
        if ($this->end_date && $checkDate >= $this->end_date) {
            return false;
        }
        
        return true;
    }

    public function scopeActive($query, $date = null)
    {
        $checkDate = $date ?? now()->toDateString();
        
        return $query->where('is_active', true)
                    ->where('start_date', '<=', $checkDate)
                    ->where(function($q) use ($checkDate) {
                        $q->whereNull('end_date')
                          ->orWhere('end_date', '>', $checkDate);
                    });
    }
}
