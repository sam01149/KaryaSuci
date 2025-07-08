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
            $table->foreignId('product_sale_id')
                  ->nullable()
                  ->constrained('product_sales') // Pastikan nama tabelnya 'product_sales'
                  ->onDelete('set null') // Jika penjualan dihapus, ID di invoice jadi null
                  ->after('treatment_session_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            // Hapus foreign key constraint sebelum menghapus kolom
            $table->dropForeign(['product_sale_id']);
            $table->dropColumn('product_sale_id');
        });
    }
};
