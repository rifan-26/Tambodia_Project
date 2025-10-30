<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('staff_names', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->boolean('is_default')->default(false);
            $table->timestamps();
        });
        
        // Insert default names
        $defaultNames = [
            'Ahmad Fauzi', 'Budi Santoso', 'Citra Dewi', 'Dian Pratama',
            'Eka Putri', 'Fajar Ramadhan', 'Gita Sari', 'Hendra Wijaya',
            'Indah Permata', 'Joko Susilo', 'Kartika Sari', 'Lestari Wulandari',
            'Muhammad Rizki', 'Nur Azizah', 'Oki Setiawan', 'Putri Ayu',
            'Qori Hidayat', 'Rina Marlina', 'Siti Nurhaliza', 'Taufik Hidayat'
        ];
        
        foreach ($defaultNames as $name) {
            DB::table('staff_names')->insert([
                'name' => $name,
                'is_default' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_names');
    }
};
