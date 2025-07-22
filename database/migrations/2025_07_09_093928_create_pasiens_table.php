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
    Schema::create('pasiens', function (Blueprint $table) {
        $table->id();
        $table->string('nama_pasien');
        $table->text('identitas_lainnya'); // alamat, no. KTP, dll.
        $table->date('tanggal_registrasi');
        $table->integer('jumlah_kunjungan')->default(0);
        $table->boolean('memiliki_paket')->default(false);
        $table->integer('sisa_sesi_paket')->default(0);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pasiens');
    }
};
