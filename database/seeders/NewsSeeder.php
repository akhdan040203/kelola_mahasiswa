<?php

namespace Database\Seeders;

use App\Models\News;
use App\Models\User;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Mulai seeding data berita...');

        // Cari user admin
        $admin = User::where('email', 'admin@universitas.test')->first();

        if (!$admin) {
            $this->command->warn('User admin tidak ditemukan. Jalankan SetupAuthSeeder terlebih dahulu!');
            return;
        }

        // Hapus berita lama jika ada (opsional, untuk development)
        News::truncate();
        $this->command->info('Menghapus berita lama...');

        // Buat 20 berita dengan author admin
        $this->command->info('Membuat 20 berita dengan author: ' . $admin->name);
        
        News::factory()
            ->count(20)
            ->create([
                'author_id' => $admin->id,
            ]);

        $totalNews = News::count();
        $this->command->info("Berhasil membuat {$totalNews} berita!");
        $this->command->newLine();
    }
}
