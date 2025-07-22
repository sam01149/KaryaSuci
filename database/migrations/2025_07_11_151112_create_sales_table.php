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
    Schema::create('sales', function (Blueprint $table) {
        $table->id();
        $table->foreignId('patient_id')->nullable()->constrained()->onDelete('set null');
        $table->foreignId('cashier_id')->constrained('users')->onDelete('cascade');
        $table->foreignId('invoice_id')->constrained()->onDelete('cascade');
        $table->decimal('total_amount', 15, 2);
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
