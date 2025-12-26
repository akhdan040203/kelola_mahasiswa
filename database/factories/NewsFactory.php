<?php

namespace Database\Factories;

use App\Models\News;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class NewsFactory extends Factory
{
    protected $model = News::class;

    public function definition(): array
    {
        // Daftar judul berita kampus yang realistis
        $titles = [
            'Universitas Membuka Pendaftaran Mahasiswa Baru Tahun Akademik 2024/2025',
            'Seminar Nasional Teknologi Informasi Dihadiri Ratusan Peserta',
            'Mahasiswa Fakultas Teknik Raih Juara 1 Kompetisi Robotika Nasional',
            'Pengumuman Libur Semester Genap dan Jadwal UAS',
            'Beasiswa Prestasi Tersedia untuk Mahasiswa Berprestasi',
            'Workshop Kewirausahaan: Membangun Startup dari Kampus',
            'Tim Basket Universitas Juara Turnamen Antar Kampus',
            'Kuliah Tamu: Praktisi Industri Berbagi Pengalaman Karir',
            'Pendaftaran KKN Gelombang 2 Dibuka Hingga Akhir Bulan',
            'Lomba Karya Tulis Ilmiah Tingkat Nasional dengan Total Hadiah 50 Juta',
            'Wisuda Periode Februari: 500 Mahasiswa Siap Menjadi Sarjana',
            'Pekan Olahraga dan Seni Mahasiswa Akan Digelar Bulan Depan',
            'Kerjasama Universitas dengan Perusahaan Multinasional',
            'Pengumuman Penting: Perubahan Jadwal Kuliah Semester Ini',
            'Mahasiswa Teknik Informatika Ciptakan Aplikasi Inovatif',
            'Donor Darah Massal di Kampus: Mari Berbagi untuk Sesama',
            'Seminar Kesehatan Mental Mahasiswa di Era Digital',
            'Perpustakaan Kampus Tambah Koleksi Buku Digital',
            'Kompetisi Debat Bahasa Inggris Tingkat Universitas',
            'Program Magang Bersertifikat untuk Mahasiswa Semester 6',
        ];

        // Daftar paragraf berita yang realistis
        $bodies = [
            'Universitas dengan bangga mengumumkan pembukaan pendaftaran mahasiswa baru untuk tahun akademik mendatang. Program studi yang tersedia meliputi berbagai bidang ilmu dari teknik, ekonomi, hingga ilmu sosial. Calon mahasiswa dapat mendaftar secara online melalui website resmi universitas. Proses seleksi akan dilakukan secara ketat untuk mendapatkan mahasiswa terbaik.',
            
            'Acara seminar nasional yang diselenggarakan oleh fakultas berhasil menarik perhatian ratusan peserta dari berbagai universitas. Narasumber yang hadir adalah para ahli dan praktisi terkemuka di bidangnya. Seminar ini membahas perkembangan terbaru dalam dunia teknologi dan inovasi. Peserta mendapatkan sertifikat dan materi yang sangat bermanfaat untuk pengembangan ilmu pengetahuan.',
            
            'Tim mahasiswa kami berhasil meraih prestasi gemilang dalam kompetisi tingkat nasional. Mereka mengalahkan puluhan tim dari universitas terkemuka di Indonesia. Pencapaian ini merupakan hasil dari kerja keras, dedikasi, dan bimbingan dari dosen pembimbing. Universitas memberikan apresiasi dan penghargaan atas prestasi yang telah diraih.',
            
            'Dalam rangka libur semester, universitas mengumumkan jadwal ujian akhir semester dan libur akademik. Mahasiswa diharapkan mempersiapkan diri dengan baik untuk menghadapi ujian. Jadwal lengkap dapat dilihat di portal akademik masing-masing. Libur semester akan berlangsung selama dua minggu sebelum semester baru dimulai.',
            
            'Program beasiswa prestasi kembali dibuka untuk mahasiswa yang memiliki prestasi akademik dan non-akademik yang luar biasa. Beasiswa ini mencakup biaya kuliah penuh dan tunjangan bulanan. Persyaratan dan formulir pendaftaran dapat diunduh melalui website resmi. Kesempatan ini terbuka untuk semua mahasiswa aktif yang memenuhi kriteria.',
            
            'Workshop kewirausahaan menghadirkan para entrepreneur sukses yang akan berbagi pengalaman dan tips membangun bisnis. Acara ini bertujuan untuk menumbuhkan jiwa wirausaha di kalangan mahasiswa. Peserta akan mendapatkan pelatihan praktis tentang cara memulai dan mengembangkan startup. Pendaftaran terbatas untuk 100 peserta pertama.',
            
            'Tim olahraga universitas kembali mengharumkan nama kampus dengan meraih juara dalam turnamen bergengsi. Pertandingan final yang berlangsung sengit berhasil dimenangkan dengan skor telak. Para atlet mahasiswa menunjukkan sportivitas dan kemampuan yang luar biasa. Prestasi ini menambah koleksi trofi universitas di bidang olahraga.',
            
            'Kuliah tamu dengan menghadirkan praktisi industri memberikan wawasan berharga bagi mahasiswa tentang dunia kerja. Narasumber berbagi pengalaman karir dan memberikan tips sukses di industri. Sesi tanya jawab yang interaktif membuat mahasiswa semakin termotivasi. Acara ini rutin diadakan setiap semester untuk menjembatani dunia akademik dan industri.',
            
            'Program Kuliah Kerja Nyata (KKN) membuka pendaftaran gelombang kedua untuk mahasiswa yang belum terdaftar. KKN merupakan kegiatan wajib yang memberikan pengalaman langsung berinteraksi dengan masyarakat. Lokasi KKN tersebar di berbagai daerah di Indonesia. Mahasiswa akan mendapatkan bimbingan dari dosen pembimbing lapangan.',
            
            'Lomba karya tulis ilmiah tingkat nasional dengan tema inovasi dan teknologi dibuka untuk mahasiswa seluruh Indonesia. Total hadiah yang diperebutkan mencapai puluhan juta rupiah. Karya terbaik akan dipublikasikan di jurnal ilmiah nasional. Pendaftaran dapat dilakukan secara online dengan mengirimkan abstrak dan proposal.',
        ];

        return [
            'title' => fake()->randomElement($titles),
            'body' => fake()->randomElement($bodies) . ' ' . 
                      fake()->randomElement($bodies) . ' ' . 
                      'Untuk informasi lebih lanjut, silakan hubungi bagian kemahasiswaan atau kunjungi website resmi universitas.',
            // author_id akan diisi dari seeder
        ];
    }
}
