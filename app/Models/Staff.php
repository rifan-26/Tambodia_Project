<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;
    protected $table = 'staff';
    
    protected $fillable = [
        'name',
        'photo_path',
        'position',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'position' => 'integer'
    ];

    /**
     * Accessor untuk URL foto lengkap
     */
    public function getPhotoUrlAttribute()
    {
        return $this->photo_path 
            ? asset('storage/' . $this->photo_path)
            : asset('images/default-avatar.png');
    }
}
