<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'action',
        'description',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Static method untuk create log
    public static function createLog($userId, $action, $description = null)
    {
        return static::create([
            'user_id' => $userId,
            'action' => $action,
            'description' => $description,
        ]);
    }

    // Scope untuk recent logs
    public function scopeRecent($query, $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }
}