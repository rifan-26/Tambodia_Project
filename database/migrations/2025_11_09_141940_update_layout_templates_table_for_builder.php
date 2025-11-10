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
            // Drop old columns that will be replaced
            if (Schema::hasColumn('layout_templates', 'template_data')) {
                $table->dropColumn('template_data');
            }
            if (Schema::hasColumn('layout_templates', 'background_image_id')) {
                $table->dropForeign(['background_image_id']);
                $table->dropColumn('background_image_id');
            }
            if (Schema::hasColumn('layout_templates', 'is_public')) {
                $table->dropColumn('is_public');
            }
            if (Schema::hasColumn('layout_templates', 'user_id')) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            }
            
            // Add new columns for template builder
            $table->string('thumbnail_path')->nullable()->after('description');
            $table->string('grid_type')->after('thumbnail_path'); // '1-col', '2-col', '3-col', '2x2', '3x3', 'custom'
            $table->json('grid_config')->after('grid_type'); // Grid configuration
            $table->json('elements')->after('grid_config'); // Design elements (text, color, image)
            $table->boolean('is_active')->default(false)->after('elements');
            $table->unsignedBigInteger('created_by')->after('is_active');
            $table->softDeletes();
            
            // Add foreign key and indexes
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->index('is_active');
            $table->index('created_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('layout_templates', function (Blueprint $table) {
            // Drop new columns
            $table->dropSoftDeletes();
            $table->dropIndex(['is_active']);
            $table->dropIndex(['created_by']);
            $table->dropForeign(['created_by']);
            $table->dropColumn([
                'thumbnail_path',
                'grid_type',
                'grid_config',
                'elements',
                'is_active',
                'created_by'
            ]);
            
            // Restore old columns
            $table->unsignedBigInteger('user_id')->after('id');
            $table->json('template_data')->after('description');
            $table->unsignedBigInteger('background_image_id')->nullable()->after('template_data');
            $table->boolean('is_public')->default(false)->after('background_image_id');
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('background_image_id')->references('id')->on('media')->onDelete('set null');
            $table->index(['user_id', 'is_public']);
        });
    }
};
