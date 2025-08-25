<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Hanya tambahkan kolom jika belum ada
        if (!Schema::hasColumn('users', 'last_login_at')) {
            Schema::table('users', function (Blueprint $table) {
                $table->timestamp('last_login_at')->nullable()->after('role');
            });
        }
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('last_login_at');
        });
    }
};