<?php

namespace Database\Seeders;

use App\Models\MataKuliah;
use Illuminate\Database\Seeder;

class MataKuliahSeeder extends Seeder
{
    public function run(): void
    {
        $mataKuliah = [
            // Semester 1
            ['kode_mk' => 'TIF101', 'nama_mk' => 'Pemrograman Dasar', 'sks' => 3, 'semester' => 1, 'deskripsi' => 'Mata kuliah dasar pemrograman menggunakan bahasa C'],
            ['kode_mk' => 'TIF102', 'nama_mk' => 'Matematika Diskrit', 'sks' => 3, 'semester' => 1, 'deskripsi' => 'Logika matematika dan teori himpunan'],
            ['kode_mk' => 'TIF103', 'nama_mk' => 'Algoritma dan Struktur Data', 'sks' => 4, 'semester' => 1, 'deskripsi' => 'Dasar-dasar algoritma dan struktur data'],
            ['kode_mk' => 'UNI101', 'nama_mk' => 'Bahasa Indonesia', 'sks' => 2, 'semester' => 1, 'deskripsi' => 'Mata kuliah umum bahasa Indonesia'],
            ['kode_mk' => 'UNI102', 'nama_mk' => 'Pancasila', 'sks' => 2, 'semester' => 1, 'deskripsi' => 'Pendidikan Pancasila'],
            
            // Semester 2
            ['kode_mk' => 'TIF201', 'nama_mk' => 'Pemrograman Berorientasi Objek', 'sks' => 3, 'semester' => 2, 'deskripsi' => 'OOP menggunakan Java'],
            ['kode_mk' => 'TIF202', 'nama_mk' => 'Basis Data', 'sks' => 3, 'semester' => 2, 'deskripsi' => 'Konsep dan implementasi database'],
            ['kode_mk' => 'TIF203', 'nama_mk' => 'Sistem Operasi', 'sks' => 3, 'semester' => 2, 'deskripsi' => 'Konsep sistem operasi modern'],
            ['kode_mk' => 'MAT201', 'nama_mk' => 'Kalkulus', 'sks' => 3, 'semester' => 2, 'deskripsi' => 'Kalkulus diferensial dan integral'],
            ['kode_mk' => 'UNI201', 'nama_mk' => 'Bahasa Inggris', 'sks' => 2, 'semester' => 2, 'deskripsi' => 'English for IT'],
            
            // Semester 3
            ['kode_mk' => 'TIF301', 'nama_mk' => 'Pemrograman Web', 'sks' => 3, 'semester' => 3, 'deskripsi' => 'HTML, CSS, JavaScript, dan PHP'],
            ['kode_mk' => 'TIF302', 'nama_mk' => 'Jaringan Komputer', 'sks' => 3, 'semester' => 3, 'deskripsi' => 'Konsep dan protokol jaringan'],
            ['kode_mk' => 'TIF303', 'nama_mk' => 'Rekayasa Perangkat Lunak', 'sks' => 3, 'semester' => 3, 'deskripsi' => 'Software engineering principles'],
            ['kode_mk' => 'TIF304', 'nama_mk' => 'Statistika', 'sks' => 3, 'semester' => 3, 'deskripsi' => 'Statistika untuk data science'],
            
            // Semester 4
            ['kode_mk' => 'TIF401', 'nama_mk' => 'Pemrograman Mobile', 'sks' => 3, 'semester' => 4, 'deskripsi' => 'Android dan iOS development'],
            ['kode_mk' => 'TIF402', 'nama_mk' => 'Keamanan Informasi', 'sks' => 3, 'semester' => 4, 'deskripsi' => 'Cybersecurity fundamentals'],
            ['kode_mk' => 'TIF403', 'nama_mk' => 'Kecerdasan Buatan', 'sks' => 3, 'semester' => 4, 'deskripsi' => 'AI dan machine learning dasar'],
            ['kode_mk' => 'TIF404', 'nama_mk' => 'Interaksi Manusia Komputer', 'sks' => 3, 'semester' => 4, 'deskripsi' => 'UI/UX design principles'],
            
            // Semester 5
            ['kode_mk' => 'TIF501', 'nama_mk' => 'Cloud Computing', 'sks' => 3, 'semester' => 5, 'deskripsi' => 'AWS, Azure, dan GCP'],
            ['kode_mk' => 'TIF502', 'nama_mk' => 'Big Data', 'sks' => 3, 'semester' => 5, 'deskripsi' => 'Hadoop dan Spark'],
            ['kode_mk' => 'TIF503', 'nama_mk' => 'Blockchain', 'sks' => 3, 'semester' => 5, 'deskripsi' => 'Teknologi blockchain dan cryptocurrency'],
            
            // Semester 6
            ['kode_mk' => 'TIF601', 'nama_mk' => 'DevOps', 'sks' => 3, 'semester' => 6, 'deskripsi' => 'CI/CD dan automation'],
            ['kode_mk' => 'TIF602', 'nama_mk' => 'Internet of Things', 'sks' => 3, 'semester' => 6, 'deskripsi' => 'IoT systems dan sensors'],
            ['kode_mk' => 'TIF603', 'nama_mk' => 'Etika Profesi', 'sks' => 2, 'semester' => 6, 'deskripsi' => 'Professional ethics in IT'],
            
            // Semester 7
            ['kode_mk' => 'TIF701', 'nama_mk' => 'Metodologi Penelitian', 'sks' => 2, 'semester' => 7, 'deskripsi' => 'Research methodology'],
            ['kode_mk' => 'TIF702', 'nama_mk' => 'Kerja Praktik', 'sks' => 4, 'semester' => 7, 'deskripsi' => 'Internship program'],
            
            // Semester 8
            ['kode_mk' => 'TIF801', 'nama_mk' => 'Skripsi', 'sks' => 6, 'semester' => 8, 'deskripsi' => 'Final project / thesis'],
        ];

        foreach ($mataKuliah as $mk) {
            MataKuliah::firstOrCreate(
                ['kode_mk' => $mk['kode_mk']],
                $mk
            );
        }

        $this->command->info('✅ Mata Kuliah berhasil dibuat!');
        $this->command->info('📚 Total: ' . count($mataKuliah) . ' mata kuliah');
    }
}
