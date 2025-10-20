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
        Schema::table('schedules', function (Blueprint $table) {
            $table->string('layout_type')->default('grid')->after('time'); // grid, carousel, fullscreen, mosaic
            $table->json('layout_positions')->nullable()->after('layout_type'); // positions for grid layout
            $table->integer('display_duration')->default(10)->after('layout_positions'); // seconds for each media
            $table->boolean('auto_rotate')->default(true)->after('display_duration'); // auto rotate media
            $table->json('layout_settings')->nullable()->after('auto_rotate'); // additional layout settings
            $table->boolean('is_active')->default(true)->after('layout_settings'); // schedule active status
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('schedules', function (Blueprint $table) {
            $table->dropColumn([
                'layout_type',
                'layout_positions', 
                'display_duration',
                'auto_rotate',
                'layout_settings',
                'is_active'
            ]);
        });
    }
};