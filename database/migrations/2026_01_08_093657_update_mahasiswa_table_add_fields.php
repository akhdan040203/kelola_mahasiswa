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
        Schema::table('mahasiswa', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('nim', 20)->unique()->nullable();
            $table->string('nama')->nullable();
            $table->integer('semester_aktif')->default(1); // 1-8
            $table->string('prodi')->nullable();
            $table->string('angkatan', 10)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mahasiswa', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn(['user_id', 'nim', 'nama', 'semester_aktif', 'prodi', 'angkatan']);
        });
    }
};
