<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('media_id')->constrained()->onDelete('cascade');
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('day_of_week', ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu'])->nullable();
            $table->time('time')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('schedules');
    }
};