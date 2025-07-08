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
        Schema::table('invoices', function (Blueprint $table) {
            // Perintah yang benar untuk mengubah kolom yang sudah ada menjadi nullable
            $table->foreignId('treatment_session_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            // Mengembalikan kolom menjadi tidak nullable
            $table->foreignId('treatment_session_id')->nullable(false)->change();
        });
    }
};