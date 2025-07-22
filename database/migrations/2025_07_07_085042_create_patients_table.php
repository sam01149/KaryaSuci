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
        Schema::create('patients', function (Blueprint $table) {
            $table->id(); // ID unik untuk setiap pasien
            $table->foreignId('branch_id')->constrained('branches');
            $table->string('name'); // Nama lengkap pasien
            $table->string('contact_number')->nullable(); // Nomor kontak
            $table->text('address')->nullable(); // Alamat
            $table->date('date_of_birth')->nullable(); // Tanggal lahir
            $table->enum('gender', ['Laki-laki', 'Perempuan'])->nullable(); // Jenis kelamin
            $table->text('medical_history_summary')->nullable(); // Ringkasan riwayat medis awal
            $table->timestamps(); // Kolom created_at dan updated_at otomatis
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
