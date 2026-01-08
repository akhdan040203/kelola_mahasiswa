<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Krs extends Model
{
    use HasFactory;

    protected $table = 'krs';

    protected $fillable = [
        'mahasiswa_id',
        'semester',
        'tahun_ajaran',
        'status',
        'catatan_admin',
        'submitted_at',
        'approved_at',
        'approved_by',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'approved_at' => 'datetime',
    ];

    // Relationship: KRS belongs to Mahasiswa
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id');
    }

    // Relationship: KRS belongs to many MataKuliah through krs_mata_kuliah
    public function mataKuliah()
    {
        return $this->belongsToMany(MataKuliah::class, 'krs_mata_kuliah', 'krs_id', 'mata_kuliah_id')
            ->withTimestamps();
    }

    // Relationship: KRS has many KrsMataKuliah
    public function krsMataKuliah()
    {
        return $this->hasMany(KrsMataKuliah::class, 'krs_id');
    }

    // Relationship: KRS approved by User (admin)
    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // Helper method: Get total SKS
    public function getTotalSksAttribute()
    {
        return $this->mataKuliah()->sum('sks');
    }
}
