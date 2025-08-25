<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateSuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if superadmin already exists
        $superadmin = User::where('email', 'superadmin@admin.com')->first();
        
        if (!$superadmin) {
            User::create([
                'name' => 'Super Admin',
                'email' => 'superadmin@admin.com',
                'password' => Hash::make('password123'),
                'role' => 'superadmin',
            ]);
            
            $this->command->info('Superadmin user created successfully!');
            $this->command->info('Email: superadmin@admin.com');
            $this->command->info('Password: password123');
        } else {
            $this->command->info('Superadmin user already exists.');
        }
        
        // Create a sample employee user
        $employee = User::where('email', 'employee@admin.com')->first();
        
        if (!$employee) {
            User::create([
                'name' => 'Employee User',
                'email' => 'employee@admin.com',
                'password' => Hash::make('password123'),
                'role' => 'pegawai',
            ]);
            
            $this->command->info('Employee user created successfully!');
            $this->command->info('Email: employee@admin.com');
            $this->command->info('Password: password123');
        }
    }
}
