<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $table = 'mahasiswa';

    protected $fillable = [
        'user_id',
        'nim',
        'nama',
        'semester_aktif',
        'prodi',
        'angkatan',
        'status',
        'dosen_pembimbing_id',
    ];

    // Relationship: Mahasiswa belongs to User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relationship: Mahasiswa belongs to Dosen Pembimbing
    public function dosenPembimbing()
    {
        return $this->belongsTo(User::class, 'dosen_pembimbing_id');
    }

    // Relationship: Mahasiswa has many KRS
    public function krs()
    {
        return $this->hasMany(Krs::class, 'mahasiswa_id');
    }

    // Relationship: Mahasiswa has many Absensi
    public function absensi()
    {
        return $this->hasMany(Absensi::class, 'mahasiswa_id');
    }
}
