<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Roles;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\Krs;
use App\Models\KrsMataKuliah;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        $dosenRole = Roles::where('name', 'dosen')->first();
        $siswaRole = Roles::where('name', 'siswa')->first();

        if (!$dosenRole || !$siswaRole) {
            $this->command->error('Roles not found. Run SetupAuthSeeder first.');
            return;
        }

        // 1. Create 10 Lecturers
        $this->command->info('Creating 10 lecturers...');
        $dosens = User::factory()->count(10)->create([
            'role_id' => $dosenRole->id,
            'password' => Hash::make('password'),
        ]);

        // 2. Assign Lecturers to Mata Kuliah randomly
        $this->command->info('Assigning lecturers to courses...');
        $mataKuliahs = MataKuliah::all();
        foreach ($mataKuliahs as $mk) {
            $mk->update(['dosen_id' => $dosens->random()->id]);
        }

        // 3. Create 20 Students
        $this->command->info('Creating 20 students...');
        $students = Mahasiswa::factory()->count(20)->create();

        // 4. Create KRS for each student
        $this->command->info('Creating KRS submissions for each student...');
        foreach ($students as $student) {
            // Create a KRS for their current active semester
            $semester = $student->semester_aktif;
            $statusOptions = ['draft', 'submitted', 'approved'];
            $status = fake()->randomElement($statusOptions);
            
            $krs = Krs::create([
                'mahasiswa_id' => $student->id,
                'semester' => $semester,
                'tahun_ajaran' => '2024/2025',
                'status' => $status,
                'submitted_at' => in_array($status, ['submitted', 'approved']) ? now() : null,
                'approved_at' => $status === 'approved' ? now() : null,
                'approved_by' => $status === 'approved' ? User::whereHas('role', fn($q) => $q->where('name', 'admin'))->first()?->id : null,
            ]);

            // Pick 5-7 random courses from that semester
            $availableMK = MataKuliah::where('semester', $semester)->get();
            if ($availableMK->count() > 0) {
                $count = min($availableMK->count(), fake()->numberBetween(5, 7));
                $selectedMK = $availableMK->random($count);
                
                $krs->mataKuliah()->attach($selectedMK->pluck('id'));
            } else {
                // If no courses in that specific semester, pick any random ones
                $selectedMK = MataKuliah::inRandomOrder()->limit(5)->get();
                $krs->mataKuliah()->attach($selectedMK->pluck('id'));
            }
        }

        $this->command->info('✅ Dummy data successfully generated!');
    }
}
