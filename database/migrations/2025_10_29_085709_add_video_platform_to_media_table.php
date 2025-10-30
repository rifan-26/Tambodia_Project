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
        Schema::table('media', function (Blueprint $table) {
            // Add video_platform column after file_path
            // Nullable string to store platform: 'youtube', 'tiktok', 'instagram', 'facebook', 'twitter'
            // NULL means it's an uploaded file, not an external link
            $table->string('video_platform', 50)->nullable()->after('file_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('media', function (Blueprint $table) {
            // Remove video_platform column
            $table->dropColumn('video_platform');
        });
    }
};
