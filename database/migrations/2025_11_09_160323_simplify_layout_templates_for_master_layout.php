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
        Schema::table('layout_templates', function (Blueprint $table) {
            // Drop complex builder columns
            $table->dropColumn(['thumbnail_path', 'grid_type', 'grid_config', 'elements']);
            
            // Add simple master layout columns
            $table->unsignedBigInteger('background_media_id')->nullable()->after('description');
            $table->json('grid_positions')->nullable()->after('background_media_id'); // {1: media_id, 2: media_id, ...}
            $table->text('layout_description')->nullable()->after('grid_positions');
            
            // Add foreign key
            $table->foreign('background_media_id')->references('id')->on('media')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('layout_templates', function (Blueprint $table) {
            // Restore builder columns
            $table->string('thumbnail_path')->nullable();
            $table->string('grid_type');
            $table->json('grid_config');
            $table->json('elements');
            
            // Drop master layout columns
            $table->dropForeign(['background_media_id']);
            $table->dropColumn(['background_media_id', 'grid_positions', 'layout_description']);
        });
    }
};
