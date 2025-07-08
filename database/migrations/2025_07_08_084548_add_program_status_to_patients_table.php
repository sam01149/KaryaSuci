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
        $table->enum('program_status', ['Umum', 'Paket'])->default('Umum')->after('gender');
        $table->string('program_proof_photo_path')->nullable()->after('program_status');
    });
}
    public function down(): void
{
    Schema::table('patients', function (Blueprint $table) {
        $table->dropColumn(['program_status', 'program_proof_photo_path']);
    });
}
};
