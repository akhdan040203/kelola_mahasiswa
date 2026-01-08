<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $table = 'absensi';

    protected $fillable = [
        'mata_kuliah_id',
        'absensi_pertemuan_id',
        'mahasiswa_id',
        'status',
        'keterangan',
        'tanggal_absen',
    ];

    protected $casts = [
        'tanggal_absen' => 'datetime',
    ];

    // Relationship: Absensi belongs to Pertemuan
    public function pertemuan()
    {
        return $this->belongsTo(AbsensiPertemuan::class, 'absensi_pertemuan_id');
    }

    // Relationship: Absensi belongs to Mata Kuliah
    public function mataKuliah()
    {
        return $this->belongsTo(MataKuliah::class, 'mata_kuliah_id');
    }

    // Relationship: Absensi belongs to Mahasiswa
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id');
    }
}
