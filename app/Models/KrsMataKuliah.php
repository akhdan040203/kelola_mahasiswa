<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KrsMataKuliah extends Model
{
    use HasFactory;

    protected $table = 'krs_mata_kuliah';

    protected $fillable = [
        'krs_id',
        'mata_kuliah_id',
    ];

    // Relationship: KrsMataKuliah belongs to KRS
    public function krs()
    {
        return $this->belongsTo(Krs::class, 'krs_id');
    }

    // Relationship: KrsMataKuliah belongs to MataKuliah
    public function mataKuliah()
    {
        return $this->belongsTo(MataKuliah::class, 'mata_kuliah_id');
    }

}
