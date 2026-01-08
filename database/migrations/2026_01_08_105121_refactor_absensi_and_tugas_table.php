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
        Schema::table('absensi', function (Blueprint $table) {
            $table->dropForeign(['dosen_mata_kuliah_id']);
            $table->dropColumn('dosen_mata_kuliah_id');
            $table->foreignId('mata_kuliah_id')->after('id')->constrained('mata_kuliah')->onDelete('cascade');
        });

        Schema::table('tugas', function (Blueprint $table) {
            $table->dropForeign(['dosen_mata_kuliah_id']);
            $table->dropColumn('dosen_mata_kuliah_id');
            $table->foreignId('mata_kuliah_id')->after('id')->constrained('mata_kuliah')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('absensi', function (Blueprint $table) {
            $table->dropForeign(['mata_kuliah_id']);
            $table->dropColumn('mata_kuliah_id');
            $table->foreignId('dosen_mata_kuliah_id')->after('id')->constrained('dosen_mata_kuliah')->onDelete('cascade');
        });

        Schema::table('tugas', function (Blueprint $table) {
            $table->dropForeign(['mata_kuliah_id']);
            $table->dropColumn('mata_kuliah_id');
            $table->foreignId('dosen_mata_kuliah_id')->after('id')->constrained('dosen_mata_kuliah')->onDelete('cascade');
        });
    }
};
