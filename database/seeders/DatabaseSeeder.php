<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create Pegawai Users
        User::create([
            'name' => 'Galuh',
            'email' => 'galuh@tambodia.com',
            'password' => Hash::make('password'),
            'role' => 'pegawai'
        ]);

        User::create([
            'name' => 'Nadiah',
            'email' => 'nadiah@tambodia.com',
            'password' => Hash::make('password'),
            'role' => 'pegawai'
        ]);

        User::create([
            'name' => 'Samuel',
            'email' => 'samuel@tambodia.com',
            'password' => Hash::make('password'),
            'role' => 'pegawai'
        ]);

        // Create Super Admin
        User::create([
            'name' => 'Rifan',
            'email' => 'rifan@tambodia.com',
            'password' => Hash::make('password'),
            'role' => 'superadmin'
        ]);
    }
}