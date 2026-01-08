<?php

namespace Database\Factories;

use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MahasiswaFactory extends Factory
{
    protected $model = Mahasiswa::class;

    public function definition(): array
    {
        $nimPrefix = '20' . fake()->numberBetween(21, 24);
        return [
            'user_id' => User::factory(),
            'nim' => $nimPrefix . fake()->unique()->numberBetween(1000, 9999),
            'nama' => fake()->name(),
            'prodi' => 'Teknik Informatika',
            'angkatan' => '20' . fake()->numberBetween(21, 24),
            'semester_aktif' => fake()->numberBetween(1, 8),
        ];
    }
}
