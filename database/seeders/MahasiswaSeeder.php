<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use App\Models\User;
use App\Models\Roles;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MahasiswaSeeder extends Seeder
{
    public function run(): void
    {
        $siswaRole = Roles::where('name', 'siswa')->first();

        if (!$siswaRole) {
            $this->command->error('❌ Role siswa tidak ditemukan! Jalankan SetupAuthSeeder terlebih dahulu.');
            return;
        }

        // Create sample mahasiswa
        $mahasiswaData = [
            [
                'email' => 'siswa@universitas.test',
                'name' => 'Budi Santoso',
                'nim' => '2024010001',
                'prodi' => 'Teknik Informatika',
                'angkatan' => '2024',
                'semester_aktif' => 1,
            ],
            [
                'email' => 'andi@universitas.test',
                'name' => 'Andi Wijaya',
                'nim' => '2024010002',
                'prodi' => 'Teknik Informatika',
                'angkatan' => '2024',
                'semester_aktif' => 1,
            ],
            [
                'email' => 'siti@universitas.test',
                'name' => 'Siti Nurhaliza',
                'nim' => '2023010015',
                'prodi' => 'Teknik Informatika',
                'angkatan' => '2023',
                'semester_aktif' => 3,
            ],
            [
                'email' => 'rudi@universitas.test',
                'name' => 'Rudi Hermawan',
                'nim' => '2023010020',
                'prodi' => 'Teknik Informatika',
                'angkatan' => '2023',
                'semester_aktif' => 3,
            ],
            [
                'email' => 'dewi@universitas.test',
                'name' => 'Dewi Lestari',
                'nim' => '2022010030',
                'prodi' => 'Teknik Informatika',
                'angkatan' => '2022',
                'semester_aktif' => 5,
            ],
        ];

        foreach ($mahasiswaData as $data) {
            // Create or get user
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => Hash::make('password'),
                    'role_id' => $siswaRole->id,
                ]
            );

            // Create mahasiswa profile
            Mahasiswa::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'nim' => $data['nim'],
                    'nama' => $data['name'],
                    'prodi' => $data['prodi'],
                    'angkatan' => $data['angkatan'],
                    'semester_aktif' => $data['semester_aktif'],
                ]
            );
        }

        $this->command->info('✅ Mahasiswa berhasil dibuat!');
        $this->command->info('👨‍🎓 Total: ' . count($mahasiswaData) . ' mahasiswa');
        $this->command->info('📧 Password untuk semua mahasiswa: password');
    }
}
