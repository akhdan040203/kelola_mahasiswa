<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
    use HasFactory;

    protected $table = 'tugas';

    protected $fillable = [
        'mata_kuliah_id',
        'judul',
        'deskripsi',
        'deadline',
        'file_path',
    ];

    protected $casts = [
        'deadline' => 'datetime',
    ];

    // Relationship: Tugas belongs to Mata Kuliah
    public function mataKuliah()
    {
        return $this->belongsTo(MataKuliah::class, 'mata_kuliah_id');
    }
}
