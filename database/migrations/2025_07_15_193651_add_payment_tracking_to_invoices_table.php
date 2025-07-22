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
        // Mengganti nama kolom 'amount' menjadi 'total_due' agar lebih jelas
        $table->renameColumn('amount', 'total_due');

        // Kolom baru untuk melacak jumlah yang sudah dibayar
        $table->decimal('amount_paid', 15, 2)->default(0)->after('payment_type');

        // Kolom baru untuk status pembayaran
        $table->enum('payment_status', ['Lunas', 'Cicilan', 'Belum Lunas'])->default('Belum Lunas')->after('amount_paid');
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            //
        });
    }
};
