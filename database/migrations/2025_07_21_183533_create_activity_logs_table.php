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
    Schema::create('activity_logs', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained('users'); // Pegawai yang melakukan aksi
        $table->foreignId('branch_id')->constrained('branches'); // Cabang tempat aktivitas terjadi
        $table->morphs('loggable'); // Untuk menghubungkan ke model lain (Pasien, Invoice, dll)
        $table->string('action'); // Deskripsi aksi, e.g., 'check_in_patient'
        $table->text('description'); // Deskripsi lengkap, e.g., "Resepsionis 1 melakukan absensi..."
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
