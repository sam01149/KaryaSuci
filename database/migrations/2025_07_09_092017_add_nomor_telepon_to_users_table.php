<?php

// database/migrations/xxxx_xx_xx_xxxxxx_add_nomor_telepon_to_users_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Menambahkan kolom nomor_telepon setelah kolom email
            $table->string('nomor_telepon')->nullable()->after('email');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('nomor_telepon');
        });
    }
};