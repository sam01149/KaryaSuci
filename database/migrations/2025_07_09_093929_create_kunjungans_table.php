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
    Schema::create('kunjungans', function (Blueprint $table) {
        $table->id();
        $table->foreignId('pasien_id')->constrained()->onDelete('cascade');
        $table->date('tanggal_kunjungan');
        $table->string('bukti_foto_checkin');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kunjungans');
    }
};
