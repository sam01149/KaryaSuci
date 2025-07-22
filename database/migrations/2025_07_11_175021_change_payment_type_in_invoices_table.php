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
            // Ubah tipe kolom menjadi string (VARCHAR) yang lebih fleksibel
            $table->string('payment_type')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            // (Opsional) Kembalikan ke ENUM jika di-rollback
            $table->enum('payment_type', ['Umum', 'Paket'])->change();
        });
    }
};