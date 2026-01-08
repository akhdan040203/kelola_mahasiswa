<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataKuliah extends Model
{
    use HasFactory;

    protected $table = 'mata_kuliah';

    protected $fillable = [
        'kode_mk',
        'nama_mk',
        'sks',
        'semester',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'ruangan',
        'deskripsi',
        'dosen_id',
    ];

    // Relationship: Mata Kuliah belongs to a Dosen (User with role dosen)
    public function dosen()
    {
        return $this->belongsTo(User::class, 'dosen_id');
    }

    // Relationship: Mata Kuliah belongs to many KRS through krs_mata_kuliah
    public function krs()
    {
        return $this->belongsToMany(Krs::class, 'krs_mata_kuliah', 'mata_kuliah_id', 'krs_id')
            ->withTimestamps();
    }

    // Relationship: Mata Kuliah has many Absensi
    public function absensi()
    {
        return $this->hasMany(Absensi::class, 'mata_kuliah_id');
    }

    public function absensiPertemuan()
    {
        return $this->hasMany(AbsensiPertemuan::class, 'mata_kuliah_id');
    }

    // Relationship: Mata Kuliah has many Tugas
    public function tugas()
    {
        return $this->hasMany(Tugas::class, 'mata_kuliah_id');
    }

    // Relationship: Mata Kuliah has many KrsMataKuliah
    public function krsMataKuliah()
    {
        return $this->hasMany(KrsMataKuliah::class, 'mata_kuliah_id');
    }
}
