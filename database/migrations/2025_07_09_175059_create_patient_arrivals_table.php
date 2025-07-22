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
    Schema::create('patient_arrivals', function (Blueprint $table) {
        $table->id();
        $table->foreignId('patient_id')->constrained()->onDelete('cascade');
        $table->foreignId('receptionist_id')->constrained('users')->onDelete('cascade');
        $table->date('arrival_date');
        $table->time('check_in_time')->nullable();
        $table->string('check_in_photo_path')->nullable();
        $table->integer('visit_number');
        $table->enum('status', ['Menunggu', 'Sudah Check-in', 'Selesai Terapi', 'Sudah Bayar']);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_arrivals');
    }
};
