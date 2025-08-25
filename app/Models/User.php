<?php
// ===== 1. MODEL: User.php =====
namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'last_login_at' => 'datetime',
    ];

    // Relationships
    public function media()
    {
        return $this->hasMany(Media::class);
    }

    public function logs()
    {
        return $this->hasMany(Log::class);
    }

    // Helper methods
    public function isSuperAdmin()
    {
        return $this->role === 'superadmin';
    }

    public function isPegawai()
    {
        return $this->role === 'pegawai';
    }
    
    public function isOnline()
    {
        // Jika last_login_at ada dan kurang dari 24 jam yang lalu, anggap online
        return $this->last_login_at && $this->last_login_at->gt(now()->subHours(24));
    }
}