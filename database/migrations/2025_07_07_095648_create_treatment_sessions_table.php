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
        Schema::create('treatment_sessions', function (Blueprint $table) {
        $table->id();
        $table->foreignId('branch_id')->constrained('branches');
        $table->foreignId('patient_id')->constrained()->onDelete('cascade');
        $table->foreignId('therapist_id')->nullable()->constrained('users');
        $table->date('session_date');
        $table->enum('status', ['Menunggu', 'Dilayani', 'Selesai', 'Sudah Bayar'])->default('Menunggu');
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('treatment_sessions');
    }
};
