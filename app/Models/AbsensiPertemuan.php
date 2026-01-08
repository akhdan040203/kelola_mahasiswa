<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbsensiPertemuan extends Model
{
    use HasFactory;

    protected $table = 'absensi_pertemuan';

    protected $fillable = [
        'mata_kuliah_id',
        'pertemuan_ke',
        'tanggal',
        'is_open',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'is_open' => 'boolean',
    ];

    public function mataKuliah()
    {
        return $this->belongsTo(MataKuliah::class, 'mata_kuliah_id');
    }

    public function absensi()
    {
        return $this->hasMany(Absensi::class, 'absensi_pertemuan_id');
    }
}
