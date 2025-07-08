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
    Schema::table('treatment_sessions', function (Blueprint $table) {
        $table->string('patient_photo_path')->nullable()->after('status');
        $table->integer('visit_number')->default(1)->after('patient_photo_path');
    });
    // Mengubah enum status
    \DB::statement("ALTER TABLE treatment_sessions CHANGE COLUMN status status ENUM('Sudah Check-in', 'Selesai', 'Sudah Bayar') NOT NULL DEFAULT 'Sudah Check-in'");
}
public function down(): void
{
    Schema::table('treatment_sessions', function (Blueprint $table) {
        $table->dropColumn(['patient_photo_path', 'visit_number']);
    });
    \DB::statement("ALTER TABLE treatment_sessions CHANGE COLUMN status status ENUM('Menunggu', 'Dilayani', 'Selesai', 'Sudah Bayar') NOT NULL DEFAULT 'Menunggu'");
}
};
