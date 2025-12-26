<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Roles;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SetupAuthSeeder extends Seeder
{
    public function run(): void
    {
        // Create Roles
        $adminRole = Roles::firstOrCreate(['name' => 'admin']);
        $dosenRole = Roles::firstOrCreate(['name' => 'dosen']);
        $siswaRole = Roles::firstOrCreate(['name' => 'siswa']);

        // Create Permissions
        $kelolaNews = Permission::firstOrCreate(['name' => 'kelola_news']);
        $kelolaMahasiswa = Permission::firstOrCreate(['name' => 'kelola_mahasiswa']);
        $kelolaMataKuliah = Permission::firstOrCreate(['name' => 'kelola_mata_kuliah']);
        $kelolaNilai = Permission::firstOrCreate(['name' => 'kelola_nilai']);
        $kelolaUsers = Permission::firstOrCreate(['name' => 'kelola_users']);

        // Assign Permissions to Admin (semua akses)
        $adminRole->permissions()->syncWithoutDetaching([
            $kelolaNews->id,
            $kelolaMahasiswa->id,
            $kelolaMataKuliah->id,
            $kelolaNilai->id,
            $kelolaUsers->id,
        ]);

        // Assign Permissions to Dosen (hanya kelola nilai)
        $dosenRole->permissions()->syncWithoutDetaching([
            $kelolaNilai->id,
        ]);

        // Siswa tidak punya permission admin (bisa ditambahkan nanti untuk fitur siswa)
        // $siswaRole->permissions()->syncWithoutDetaching([]);

        // Create Demo Users
        User::firstOrCreate(
            ['email' => 'admin@universitas.test'],
            [
                'name' => 'Admin Kampus',
                'password' => Hash::make('password'),
                'role_id' => $adminRole->id,
            ]
        );

        User::firstOrCreate(
            ['email' => 'dosen@universitas.test'],
            [
                'name' => 'Dosen Demo',
                'password' => Hash::make('password'),
                'role_id' => $dosenRole->id,
            ]
        );

        User::firstOrCreate(
            ['email' => 'siswa@universitas.test'],
            [
                'name' => 'Siswa Demo',
                'password' => Hash::make('password'),
                'role_id' => $siswaRole->id,
            ]
        );

        $this->command->info('✅ Roles, Permissions, dan Demo Users berhasil dibuat!');
        $this->command->info('📧 Admin: admin@universitas.test / password');
        $this->command->info('📧 Dosen: dosen@universitas.test / password');
        $this->command->info('📧 Siswa: siswa@universitas.test / password');
    }
}
