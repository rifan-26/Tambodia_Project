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
        Schema::table('layout_settings', function (Blueprint $table) {
            $table->unsignedBigInteger('background_image_id')->nullable()->after('description');
            $table->foreign('background_image_id')->references('id')->on('media')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('layout_settings', function (Blueprint $table) {
            $table->dropForeign(['background_image_id']);
            $table->dropColumn('background_image_id');
        });
    }
};
