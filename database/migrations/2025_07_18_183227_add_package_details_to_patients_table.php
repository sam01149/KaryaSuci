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
    Schema::table('patients', function (Blueprint $table) {
        // Tambahkan kolom ini terlebih dahulu
        $table->boolean('is_package_active')->default(false)->after('program_status');

        // Baru kemudian tambahkan kolom-kolom lainnya
        $table->integer('package_total_sessions')->default(0)->after('is_package_active');
        $table->integer('package_sessions_remaining')->default(0)->after('package_total_sessions');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
        $table->dropColumn(['package_total_sessions', 'package_sessions_remaining']);
    });
    }
};
