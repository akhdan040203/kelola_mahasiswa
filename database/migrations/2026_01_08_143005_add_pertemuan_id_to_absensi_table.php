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
            $table->foreignId('absensi_pertemuan_id')->after('mata_kuliah_id')->constrained('absensi_pertemuan')->onDelete('cascade');
            $table->string('status')->nullable()->change();
            
            // Remove redundant columns if they exist (they are now in absensi_pertemuan)
            // But let's keep them for now to avoid data loss during transition if needed, 
            // or drop them if we are sure.
            $table->dropColumn(['pertemuan_ke', 'tanggal']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('absensi', function (Blueprint $table) {
            $table->dropForeign(['absensi_pertemuan_id']);
            $table->dropColumn('absensi_pertemuan_id');
            $table->string('status')->nullable(false)->change();
            $table->integer('pertemuan_ke')->after('mahasiswa_id');
            $table->date('tanggal')->after('pertemuan_ke');
        });
    }
};
