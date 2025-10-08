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
        if (!Schema::hasTable('layout_templates')) {
            Schema::create('layout_templates', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->string('name');
                $table->text('description')->nullable();
                $table->json('template_data'); // Store layout positions and media IDs
                $table->unsignedBigInteger('background_image_id')->nullable();
                $table->boolean('is_public')->default(false);
                $table->timestamps();

                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('background_image_id')->references('id')->on('media')->onDelete('set null');
                
                $table->index(['user_id', 'is_public']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('layout_templates');
    }
};
