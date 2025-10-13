<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('scheduled_backgrounds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('media_id')->nullable()->constrained('media')->onDelete('set null');
            $table->date('start_date');
            $table->string('day_of_week')->nullable();
            $table->time('time')->nullable();
            $table->timestamps();
            
            $table->index(['start_date', 'day_of_week', 'time']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('scheduled_backgrounds');
    }
};
