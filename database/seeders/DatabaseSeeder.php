<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create Super Admin
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@tambodia.com',
            'password' => Hash::make('superadmin123'),
            'role' => 'superadmin'
        ]);

        // Create Sample Pegawai
        User::create([
            'name' => 'Admin1',
            'email' => 'admin1@tambodia.com',
            'password' => Hash::make('admin1234'),
            'role' => 'pegawai'
        ]);

        User::create([
            'name' => 'Admin2', 
            'email' => 'admin2@tambodia.com',
            'password' => Hash::make('admin1234'),
            'role' => 'pegawai'
        ]);
    }
}