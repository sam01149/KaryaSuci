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
        Schema::create('medical_records', function (Blueprint $table) {
        $table->id();
        $table->foreignId('treatment_session_id')->constrained()->onDelete('cascade');
        $table->foreignId('patient_id')->constrained()->onDelete('cascade');
        $table->foreignId('therapist_id')->constrained('users');
        $table->text('assessment'); // Hasil asesmen/pemeriksaan
        $table->text('diagnosis');  // Diagnosis Fisioterapi
        $table->text('treatment_plan'); // Rencana latihan/terapi
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_records');
    }
};
