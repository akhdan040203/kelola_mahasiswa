<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DosenMataKuliah extends Model
{
    use HasFactory;

    protected $table = 'dosen_mata_kuliah';

    protected $fillable = [
        'krs_mata_kuliah_id',
        'dosen_id',
    ];

    // Relationship: DosenMataKuliah belongs to KrsMataKuliah
    public function krsMataKuliah()
    {
        return $this->belongsTo(KrsMataKuliah::class, 'krs_mata_kuliah_id');
    }

    // Relationship: DosenMataKuliah belongs to User (dosen)
    public function dosen()
    {
        return $this->belongsTo(User::class, 'dosen_id');
    }

    // Relationship: DosenMataKuliah has many Absensi
    public function absensi()
    {
        return $this->hasMany(Absensi::class, 'dosen_mata_kuliah_id');
    }

    // Relationship: DosenMataKuliah has many Tugas
    public function tugas()
    {
        return $this->hasMany(Tugas::class, 'dosen_mata_kuliah_id');
    }
}
