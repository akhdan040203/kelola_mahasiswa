<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SIM-Kampus</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#FDFDFC] text-[#1b1b18] antialiased">
{{-- NAVBAR --}}
<header id="site-header" class="bg-white border-b border-gray-100 sticky top-0 z-50 transition-all duration-300 ease-in-out">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            
            <div class="md:flex md:items-center md:gap-12">
                <a class="block text-indigo-600" href="/">
                    <span class="sr-only">Home</span>
                    <h2 class="text-2xl font-bold tracking-tight">🎓 SIM-Kampus</h2>
                </a>
            </div>

            <div class="hidden md:block">
                <nav aria-label="Global">
                    <ul class="flex items-center gap-8 text-sm font-medium">
                        <li><a class="text-gray-600 transition hover:text-indigo-600" href="/"> Beranda </a></li>
                        <li><a class="text-gray-600 transition hover:text-indigo-600" href="#prodi"> Program Studi </a></li>
                        <li><a class="text-gray-600 transition hover:text-indigo-600" href="#kegiatan"> Kegiatan </a></li>
                        <li><a class="text-gray-600 transition hover:text-indigo-600" href="#tentang"> Tentang </a></li>
                        <li><a class="text-gray-600 transition hover:text-indigo-600" href="#kontak"> Kontak </a></li>
                    </ul>
                </nav>
            </div>

            <div class="flex items-center gap-4">
                @if (Route::has('login'))
                    <div class="sm:flex sm:gap-4">
                        @auth
                            <a class="rounded-md bg-indigo-600 px-5 py-2.5 text-sm font-medium text-white shadow transition hover:bg-indigo-700" href="{{ url('/dashboard') }}">
                                Dashboard
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="hidden sm:block">
                                @csrf
                                <button type="submit" class="rounded-md bg-gray-100 px-5 py-2.5 text-sm font-medium text-indigo-600 transition hover:bg-gray-200">
                                    Keluar
                                </button>
                            </form>
                        @else
                            <a class="rounded-md bg-indigo-600 px-5 py-2.5 text-sm font-medium text-white shadow transition hover:bg-indigo-700" href="{{ route('login') }}">
                                Login
                            </a>

                            @if (Route::has('register'))
                                <div class="hidden sm:flex">
                                    <a class="rounded-md bg-gray-100 px-5 py-2.5 text-sm font-medium text-indigo-600 transition hover:text-indigo-700" href="{{ route('register') }}">
                                        Register
                                    </a>
                                </div>
                            @endif
                        @endauth
                    </div>
                @endif

                <div class="block md:hidden">
                    <button id="hamburger-button" class="rounded bg-gray-100 p-2 text-gray-600 transition hover:bg-gray-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div id="mobile-menu" class="hidden md:hidden border-t border-gray-100 bg-white shadow-lg">
        <nav class="flex flex-col gap-4 p-4 text-sm font-medium">
            <a class="text-gray-600 hover:text-indigo-600" href="/">Beranda</a>
            <a class="text-gray-600 hover:text-indigo-600" href="#prodi">Program Studi</a>
            <a class="text-gray-600 hover:text-indigo-600" href="#kegiatan">Kegiatan</a>
            <a class="text-gray-600 hover:text-indigo-600" href="#tentang">Tentang</a>
            <a class="text-gray-600 hover:text-indigo-600" href="#kontak">Kontak</a>
            <hr class="my-2 border-gray-100">
            
            @auth
                <a class="text-indigo-600 font-bold" href="{{ url('/dashboard') }}">Dashboard</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-red-600 font-bold text-left w-full">Keluar</button>
                </form>
            @else
                <a class="text-indigo-600 font-bold" href="{{ route('login') }}">Login</a>
                @if (Route::has('register'))
                    <a class="text-gray-600 font-bold" href="{{ route('register') }}">Register</a>
                @endif
            @endauth
        </nav>
    </div>
</header>

{{-- <script>
    document.getElementById('hamburger-button').addEventListener('click', function() {
        const menu = document.getElementById('mobile-menu');
        menu.classList.toggle('hidden');
    });
</script> --}}
{{-- END-NAVBAR --}}
    <main>
        {{-- HERO --}}
        <section class="overflow-hidden bg-gray-50 sm:grid sm:grid-cols-2 sm:items-center">
            <div class="p-8 md:p-12 lg:px-16 lg:py-24" data-aos="fade-right">
                <div class="mx-auto max-w-xl text-center sm:text-left">
                    <h2 class="text-3xl font-bold text-gray-900 md:text-4xl leading-tight">
                        Kelola Data Akademik Lebih Modern dengan <span class="text-indigo-600">SIM-Kampus</span>
                    </h2>

                    <p class="hidden text-gray-600 md:mt-4 md:block leading-relaxed">
                        Platform terintegrasi untuk memudahkan pendataan mahasiswa, pemantauan program studi, 
                        hingga manajemen kegiatan kampus. Solusi cerdas untuk efisiensi administrasi akademik Anda.
                    </p>

                    <div class="mt-4 md:mt-8 flex flex-wrap gap-4 justify-center sm:justify-start">
                        <a href="{{ route('login') }}" class="inline-block rounded-lg bg-indigo-600 px-12 py-3 text-sm font-medium text-white transition hover:bg-indigo-700 focus:ring-3 focus:ring-indigo-300">
                            Mulai Sekarang
                        </a>
                        
                        <a href="#prodi" class="inline-block rounded-lg border border-indigo-600 px-12 py-3 text-sm font-medium text-indigo-600 transition hover:bg-indigo-50">
                            Lihat Prodi
                        </a>
                    </div>
                </div>
            </div>

            <img 
                data-aos="fade-left"
                alt="Mahasiswa Kampus" 
                src="{{ asset('img/hero.jpeg') }}" 
                class="h-full w-full object-cover sm:h-[calc(100%-2rem)] sm:self-end sm:rounded-ss-[30px] md:h-[calc(100%-4rem)] md:rounded-ss-[60px]"
            >
        </section>
        {{-- END-HERO --}}

    {{-- Program Studi --}}
<section id="prodi" class="py-20 bg-white scroll-mt-24" data-aos="fade-up">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        
        <!-- Heading -->
        <div class="text-center mb-16">
            <h2 
                class="text-3xl font-bold text-gray-900 sm:text-4xl tracking-tight"
                data-aos="fade-down"
                data-aos-delay="100"
            >
                Program Studi Terakreditasi
            </h2>

            <p 
                class="mt-4 text-gray-600 max-w-2xl mx-auto"
                data-aos="fade-up"
                data-aos-delay="200"
            >
                Temukan bidang yang sesuai dengan <em>passion</em> kamu. Kami menghadirkan kurikulum berbasis industri untuk mempersiapkan karir profesionalmu.
            </p>
        </div>

        <!-- Grid -->
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5">
            
            @php
                $prodis = [
                    ['nama' => 'Sistem Informasi', 'icon' => 'M4 7v10c0 2.21 3.58 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.58 4 8 4s8-1.79 8-4M4 7c0-2.21 3.58-4 8-4s8 1.79 8 4', 'desc' => 'Manajemen data & teknologi.'],
                    ['nama' => 'Teknik Informatika', 'icon' => 'M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4', 'desc' => 'Software & AI development.'],
                    ['nama' => 'Manajemen', 'icon' => 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6', 'desc' => 'Bisnis & tata kelola organisasi.'],
                    ['nama' => 'Akuntansi', 'icon' => 'M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01', 'desc' => 'Analisis keuangan & audit.'],
                    ['nama' => 'Hukum', 'icon' => 'M3 6l3 1m0 0l-3 9a5 5 0 0010 0l-3-9m-4 10l5-2m6 5l3-1m0 0l-3 9a5 5 0 0010 0l-3-9', 'desc' => 'Keadilan & konsultan hukum.'],
                    ['nama' => 'Kedokteran', 'icon' => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z', 'desc' => 'Kesehatan & tenaga medis.'],
                    ['nama' => 'Psikologi', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197', 'desc' => 'Perilaku & mental manusia.'],
                    ['nama' => 'Teknik Sipil', 'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4', 'desc' => 'Infrastruktur & pembangunan.'],
                    ['nama' => 'Ilmu Komunikasi', 'icon' => 'M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.581 9 8z', 'desc' => 'Media & hubungan publik.'],
                    ['nama' => 'Ekonomi', 'icon' => 'M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3z M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M6.34 17.66l-1.41 1.41M19.07 4.93l-1.41 1.41', 'desc' => 'Analisis pasar & moneter.'],
                ];
            @endphp

            @foreach ($prodis as $prodi)
            <div 
                class="group flex flex-col justify-between rounded-xl border border-gray-100 bg-white p-6 shadow-sm transition hover:shadow-md hover:border-indigo-100"
                data-aos="zoom-in-up"
                data-aos-delay="{{ $loop->index * 100 }}"
            >
                <div>
                    <div 
                        class="inline-flex rounded-lg bg-indigo-50 p-3 text-indigo-600 
                               group-hover:bg-indigo-600 group-hover:text-white transition-colors duration-300"
                        data-aos="flip-left"
                        data-aos-delay="{{ $loop->index * 120 }}"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $prodi['icon'] }}" />
                        </svg>
                    </div>

                    <h3 class="mt-4 text-lg font-bold text-gray-900">
                        {{ $prodi['nama'] }}
                    </h3>

                    <p class="mt-2 text-sm text-gray-500">
                        {{ $prodi['desc'] }}
                    </p>
                </div>

                <div class="mt-6">
                    <a href="#" class="text-xs font-semibold text-indigo-600 hover:text-indigo-700 inline-flex items-center gap-1">
                        Selengkapnya
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</section>
    {{-- END-Program Studi --}}

{{-- KEGIATAN --}}
<section id="kegiatan" class="py-20 bg-gray-50 scroll-mt-24" data-aos="fade-up">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        
        <!-- Heading -->
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-4">
            <div class="max-w-2xl">
                <h2 
                    class="text-3xl font-bold text-gray-900 sm:text-4xl tracking-tight"
                    data-aos="fade-right"
                    data-aos-delay="100"
                >
                    Kegiatan Kampus
                </h2>

                <p 
                    class="mt-4 text-gray-600"
                    data-aos="fade-up"
                    data-aos-delay="200"
                >
                    Eksplorasi berbagai kegiatan seru, mulai dari seminar teknologi, organisasi mahasiswa, hingga turnamen olahraga.
                </p>
            </div>

            <div data-aos="fade-left" data-aos-delay="300">
                <a href="#" class="inline-flex items-center gap-2 text-indigo-600 font-semibold hover:underline">
                    Lihat Semua Galeri
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
            </div>
        </div>

        <!-- Grid -->
        <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
            
            <!-- Card 1 -->
            <article 
                class="overflow-hidden rounded-2xl bg-white shadow-sm transition hover:shadow-xl border border-gray-100"
                data-aos="fade-up"
                data-aos-delay="100"
            >
                <img
                    alt="Seminar Nasional"
                    src="img/ai.jpeg"
                    class="h-56 w-full object-cover transition-transform duration-700 hover:scale-105"
                    data-aos="zoom-in"
                />
                <div class="p-6">
                    <div class="flex items-center gap-2">
                        <span class="rounded-full bg-indigo-100 px-3 py-1 text-[10px] font-semibold text-indigo-600 uppercase">
                            Seminar
                        </span>
                        <span class="text-xs text-gray-500">12 Des 2025</span>
                    </div>

                    <h3 class="mt-4 text-xl font-bold text-gray-900">
                        Seminar Nasional: Masa Depan AI di Indonesia
                    </h3>
                    <p class="mt-2 line-clamp-3 text-sm/relaxed text-gray-600">
                        Menghadirkan pakar teknologi ternama untuk membahas bagaimana kecerdasan buatan akan merubah dunia kerja.
                    </p>
                </div>
            </article>

            <!-- Card 2 -->
            <article 
                class="overflow-hidden rounded-2xl bg-white shadow-sm transition hover:shadow-xl border border-gray-100"
                data-aos="fade-up"
                data-aos-delay="200"
            >
                <img
                    alt="Organisasi Mahasiswa"
                    src="https://images.unsplash.com/photo-1529156069898-49953e39b3ac?auto=format&fit=crop&q=80&w=800"
                    class="h-56 w-full object-cover transition-transform duration-700 hover:scale-105"
                    data-aos="zoom-in"
                />
                <div class="p-6">
                    <div class="flex items-center gap-2">
                        <span class="rounded-full bg-emerald-100 px-3 py-1 text-[10px] font-semibold text-emerald-600 uppercase">
                            Organisasi
                        </span>
                        <span class="text-xs text-gray-500">05 Des 2025</span>
                    </div>

                    <h3 class="mt-4 text-xl font-bold text-gray-900">
                        Open Recruitment Unit Kegiatan Mahasiswa
                    </h3>
                    <p class="mt-2 line-clamp-3 text-sm/relaxed text-gray-600">
                        Wadahi minat dan bakatmu melalui puluhan UKM mulai dari seni, olahraga, hingga penelitian ilmiah.
                    </p>
                </div>
            </article>

            <!-- Card 3 -->
            <article 
                class="overflow-hidden rounded-2xl bg-white shadow-sm transition hover:shadow-xl border border-gray-100"
                data-aos="fade-up"
                data-aos-delay="300"
            >
                <img
                    alt="Turnamen Kampus"
                    src="https://images.unsplash.com/photo-1504450758481-7338eba7524a?auto=format&fit=crop&q=80&w=800"
                    class="h-56 w-full object-cover transition-transform duration-700 hover:scale-105"
                    data-aos="zoom-in"
                />
                <div class="p-6">
                    <div class="flex items-center gap-2">
                        <span class="rounded-full bg-orange-100 px-3 py-1 text-[10px] font-semibold text-orange-600 uppercase">
                            Olahraga
                        </span>
                        <span class="text-xs text-gray-500">28 Nov 2025</span>
                    </div>

                    <h3 class="mt-4 text-xl font-bold text-gray-900">
                        Rektor Cup: Kompetisi Futsal & Basket
                    </h3>
                    <p class="mt-2 line-clamp-3 text-sm/relaxed text-gray-600">
                        Ajang tahunan unjuk sportivitas antar fakultas memperebutkan piala bergilir Rektor SIM-Kampus.
                    </p>
                </div>
            </article>

        </div>
    </div>
</section>
{{-- END-KEGIATAN --}}

{{-- Tentang --}}
<section id="tentang" class="py-20 bg-white scroll-mt-24" data-aos="fade-up">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 gap-12 lg:grid-cols-2 lg:items-center">
            
            <!-- IMAGE -->
            <div class="relative" data-aos="fade-right" data-aos-delay="100">
                <div class="relative overflow-hidden rounded-2xl shadow-2xl">
                    <img
                        alt="Gedung Kampus"
                        src="img/kampus.jpeg"
                        class="h-[400px] w-full object-cover md:h-[500px] 
                               transition-transform duration-1000 hover:scale-105"
                        data-aos="zoom-in"
                        data-aos-delay="200"
                    />
                </div>
                
                <!-- BADGE -->
                <div 
                    class="absolute -bottom-6 -right-6 hidden sm:block rounded-2xl bg-indigo-600 p-8 text-white shadow-xl"
                    data-aos="zoom-in"
                    data-aos-delay="400"
                >
                    <p class="text-4xl font-extrabold">A+</p>
                    <p class="text-sm font-medium opacity-90">Akreditasi Unggul</p>
                </div>
            </div>

            <!-- CONTENT -->
            <div class="lg:py-8">
                <h2 
                    class="text-3xl font-bold text-gray-900 sm:text-4xl"
                    data-aos="fade-left"
                    data-aos-delay="150"
                >
                    Mencetak Generasi Unggul di Era Digital
                </h2>

                <p 
                    class="mt-4 text-gray-600 leading-relaxed"
                    data-aos="fade-up"
                    data-aos-delay="250"
                >
                    Didirikan sejak tahun 2005, <strong>SIM-Kampus</strong> telah berkomitmen untuk menyelenggarakan pendidikan berkualitas tinggi yang menggabungkan teori akademis dengan praktik industri terkini. Kami percaya bahwa setiap mahasiswa memiliki potensi unik yang harus diasah dengan fasilitas terbaik.
                </p>

                <!-- VISI MISI -->
                <div class="mt-8 grid grid-cols-1 gap-4 sm:grid-cols-2">
                    
                    <div 
                        class="flex gap-4"
                        data-aos="fade-up"
                        data-aos-delay="300"
                    >
                        <span class="shrink-0 rounded-lg bg-indigo-100 p-3 text-indigo-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </span>
                        <div>
                            <h3 class="font-bold text-gray-900">Visi</h3>
                            <p class="mt-1 text-sm text-gray-500">
                                Menjadi universitas riset kelas dunia yang berwawasan global.
                            </p>
                        </div>
                    </div>

                    <div 
                        class="flex gap-4"
                        data-aos="fade-up"
                        data-aos-delay="400"
                    >
                        <span class="shrink-0 rounded-lg bg-indigo-100 p-3 text-indigo-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </span>
                        <div>
                            <h3 class="font-bold text-gray-900">Misi</h3>
                            <p class="mt-1 text-sm text-gray-500">
                                Menyelenggarakan pendidikan yang inovatif dan adaptif.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- STATS -->
                <div 
                    class="mt-10 grid grid-cols-3 border-t border-gray-100 pt-10 text-center sm:text-left"
                    data-aos="fade-up"
                    data-aos-delay="500"
                >
                    <div>
                        <p class="text-2xl font-bold text-indigo-600">15k+</p>
                        <p class="text-sm font-medium text-gray-500 italic">Alumni</p>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-indigo-600">120+</p>
                        <p class="text-sm font-medium text-gray-500 italic">Dosen Ahli</p>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-indigo-600">45+</p>
                        <p class="text-sm font-medium text-gray-500 italic">Laboratorium</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
{{-- END-Tentang --}}

{{-- KONTAK --}}
<section id="kontak" class="py-20 bg-gray-50 scroll-mt-24" data-aos="fade-up">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 gap-x-16 gap-y-8 lg:grid-cols-5">
            
            <!-- INFO KONTAK -->
            <div 
                class="lg:col-span-2 lg:py-12"
                data-aos="fade-right"
                data-aos-delay="100"
            >
                <h2 
                    class="text-3xl font-bold text-gray-900 sm:text-4xl"
                    data-aos="fade-down"
                    data-aos-delay="150"
                >
                    Hubungi Kami
                </h2>

                <p 
                    class="mt-4 text-lg text-gray-600 leading-relaxed"
                    data-aos="fade-up"
                    data-aos-delay="250"
                >
                    Punya pertanyaan tentang pendaftaran atau program studi? Tim kami siap membantu Anda.
                </p>

                <!-- ITEM KONTAK -->
                <div class="mt-8 space-y-6">
                    
                    <div 
                        class="flex items-start gap-4"
                        data-aos="fade-up"
                        data-aos-delay="300"
                    >
                        <span class="shrink-0 rounded-full bg-indigo-100 p-3 text-indigo-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </span>
                        <div>
                            <h3 class="font-bold text-gray-900">Lokasi Kampus</h3>
                            <p class="text-gray-600">
                                Jl. Pendidikan No. 123, Kota Informatika, Indonesia
                            </p>
                        </div>
                    </div>

                    <div 
                        class="flex items-start gap-4"
                        data-aos="fade-up"
                        data-aos-delay="400"
                    >
                        <span class="shrink-0 rounded-full bg-indigo-100 p-3 text-indigo-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </span>
                        <div>
                            <h3 class="font-bold text-gray-900">Telepon</h3>
                            <p class="text-gray-600">+62 21 1234 5678</p>
                        </div>
                    </div>

                    <div 
                        class="flex items-start gap-4"
                        data-aos="fade-up"
                        data-aos-delay="500"
                    >
                        <span class="shrink-0 rounded-full bg-indigo-100 p-3 text-indigo-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </span>
                        <div>
                            <h3 class="font-bold text-gray-900">Email</h3>
                            <p class="text-gray-600">info@sim-kampus.ac.id</p>
                        </div>
                    </div>

                </div>
            </div>

            <!-- FORM -->
            <div 
                class="rounded-2xl bg-white p-8 shadow-xl lg:col-span-3 lg:p-12 border border-gray-100"
                data-aos="fade-left"
                data-aos-delay="200"
            >
                <form action="#" class="space-y-4">
                    
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div data-aos="fade-up" data-aos-delay="300">
                            <label class="sr-only" for="name">Nama Lengkap</label>
                            <input
                                class="w-full rounded-lg border-gray-200 p-3 text-sm focus:border-indigo-600 focus:ring-1 focus:ring-indigo-600 transition"
                                placeholder="Nama Lengkap"
                                type="text"
                                id="name"
                            />
                        </div>

                        <div data-aos="fade-up" data-aos-delay="350">
                            <label class="sr-only" for="email">Email</label>
                            <input
                                class="w-full rounded-lg border-gray-200 p-3 text-sm focus:border-indigo-600 focus:ring-1 focus:ring-indigo-600 transition"
                                placeholder="Alamat Email"
                                type="email"
                                id="email"
                            />
                        </div>
                    </div>

                    <div data-aos="fade-up" data-aos-delay="400">
                        <label class="sr-only" for="subject">Subjek</label>
                        <input
                            class="w-full rounded-lg border-gray-200 p-3 text-sm focus:border-indigo-600 focus:ring-1 focus:ring-indigo-600 transition"
                            placeholder="Tujuan Pesan (Contoh: Pendaftaran)"
                            type="text"
                            id="subject"
                        />
                    </div>

                    <div data-aos="fade-up" data-aos-delay="450">
                        <label class="sr-only" for="message">Pesan</label>
                        <textarea
                            class="w-full rounded-lg border-gray-200 p-3 text-sm focus:border-indigo-600 focus:ring-1 focus:ring-indigo-600 transition"
                            placeholder="Tuliskan pesan Anda di sini..."
                            rows="6"
                            id="message"
                        ></textarea>
                    </div>

                    <div class="mt-4" data-aos="zoom-in" data-aos-delay="500">
                        <button
                            type="submit"
                            class="inline-block w-full rounded-lg bg-indigo-600 px-5 py-3 font-medium text-white shadow-md hover:bg-indigo-700 transition sm:w-auto"
                        >
                            Kirim Pesan
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</section>
{{-- END-KONTAK --}}


</main>

<footer class="bg-gray-900 py-10" data-aos="fade-up">
    <div class="mx-auto max-w-7xl px-4 text-center">
        <div class="flex flex-col items-center justify-center space-y-2">
            
            <p 
                class="text-gray-300 font-medium tracking-wide"
                data-aos="fade-up"
                data-aos-delay="100"
            >
                &copy; {{ date('Y') }} SIM-KAMPUS. All rights reserved.
            </p>

            <p 
                class="text-gray-500 text-sm"
                data-aos="fade-up"
                data-aos-delay="200"
            >
                Dikembangkan dengan 
                <span class="text-indigo-500">Laravel 12 & Breeze</span> oleh 
                <span class="text-gray-300 font-semibold">Rehanta & Akhdan</span>
            </p>

        </div>
    </div>
</footer>


    <script>
        const btn = document.getElementById('hamburger-button');
        const menu = document.getElementById('mobile-menu');

        btn.addEventListener('click', () => {
            menu.classList.toggle('hidden');
        });

        // Menutup menu mobile saat link diklik
        document.querySelectorAll('#mobile-menu a').forEach(link => {
            link.addEventListener('click', () => {
                menu.classList.add('hidden');
            });
        });
    </script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
    // Inisialisasi AOS
    AOS.init({
        // Pengaturan Global:
        duration: 900,     // Durasi animasi (ms), 800ms adalah standar yang nyaman
        once: false,         // Animasi hanya jalan sekali (mencegah kedap-kedip saat scroll balik)
        offset: 50,         // Jarak (px) elemen dari bawah layar sebelum animasi dimulai
        // easing: 'ease-in-out', // Jenis gerakan
        anchorPlacement: 'top-bottom', // Memicu animasi segera setelah bagian atas elemen menyentuh bawah layar
    });

    // PENTING: Refresh AOS setelah semua gambar dan aset selesai dimuat
    // Ini solusi agar elemen Hero & Header yang macet bisa berjalan
    window.addEventListener('load', function() {
        AOS.refresh();
    });
</script>

<script>
  window.addEventListener('scroll', () => {
    const header = document.getElementById('site-header');
    if (window.scrollY > 10) {
      header.classList.add('shadow-md');
    } else {
      header.classList.remove('shadow-md');
    }
  });
</script>

<script>
  const header = document.getElementById('site-header');
  let lastScrollY = window.scrollY;

  window.addEventListener('scroll', () => {
    const currentScrollY = window.scrollY;

    // Shadow saat scroll
    if (currentScrollY > 10) {
      header.classList.add('shadow-md');
    } else {
      header.classList.remove('shadow-md');
    }

    // Auto hide / show
    if (currentScrollY > lastScrollY && currentScrollY > 80) {
      // scroll ke bawah → sembunyikan
      header.classList.add('-translate-y-full');
    } else {
      // scroll ke atas → tampilkan
      header.classList.remove('-translate-y-full');
    }

    lastScrollY = currentScrollY;
  });
</script>

</body>
</html>