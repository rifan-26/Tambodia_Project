<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminUser extends Model
{
    protected $table = 'admin_users';
    protected $fillable = ['username','status'];

    public function activities()
    {
        return $this->hasMany(AdminActivity::class, 'admin_id');
    }
}
