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
    // Kolom show_on_landing sudah ada di migrasi awal, jadi kita cek dulu
    if (!Schema::hasColumn('media', 'show_on_landing')) {
        Schema::table('media', function (Blueprint $table) {
            $table->boolean('show_on_landing')->default(false)->after('id');
        });
    }
}

public function down(): void
{
    // Tidak perlu drop kolom karena sudah ada di migrasi awal
}

};
