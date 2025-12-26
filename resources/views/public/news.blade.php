<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Semua Berita - SIM-Kampus</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#FDFDFC] text-[#1b1b18] antialiased">

<header id="site-header" class="bg-white border-b border-gray-100 sticky top-0 z-50 transition-all duration-300 ease-in-out">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            
            <div class="md:flex md:items-center md:gap-12">
                <a class="block text-indigo-600" href="{{ route('home') }}">
                    <h2 class="text-2xl font-bold tracking-tight">🎓 SIM-Kampus</h2>
                </a>
            </div>

            <div class="hidden md:block">
                <nav>
                    <ul class="flex items-center gap-8 text-sm font-medium">
                        <li><a class="text-gray-600 transition hover:text-indigo-600" href="{{ route('home') }}">Beranda</a></li>
                        <li><a class="text-indigo-600 font-semibold" href="{{ route('news.index') }}">Berita</a></li>
                        @auth
                            <li><a class="text-gray-600 transition hover:text-indigo-600" href="{{ url('/dashboard') }}">Dashboard</a></li>
                        @else
                            <li><a class="text-gray-600 transition hover:text-indigo-600" href="{{ route('login') }}">Login</a></li>
                        @endauth
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</header>

<main class="min-h-screen">
    <section class="bg-gradient-to-br from-indigo-600 to-purple-700 py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center text-white" data-aos="fade-up">
                <h1 class="text-4xl font-bold sm:text-5xl"> News Kampus</h1>
                <p class="mt-4 text-lg text-indigo-100">
                    Ikuti perkembangan terkini seputar kampus, prestasi mahasiswa, dan pengumuman penting
                </p>
            </div>
        </div>
    </section>


    <section class="py-16 bg-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            
            @if($news->count() > 0)
                {{-- Grid --}}
                <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($news as $item)
                    <article 
                        class="group overflow-hidden rounded-2xl bg-white shadow-md transition hover:shadow-xl border border-gray-100"
                        data-aos="fade-up"
                        data-aos-delay="{{ $loop->index % 9 * 50 }}"
                    >
                        {{-- Image Placeholder --}}
                        <div class="relative h-48 bg-gradient-to-br from-indigo-500 to-purple-600 overflow-hidden">
                            <div class="absolute inset-0 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-16 text-white/30" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                </svg>
                            </div>
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                            
                            {{-- Date Badge --}}
                            <div class="absolute top-3 left-3">
                                <span class="inline-flex items-center gap-1 rounded-full bg-white/90 backdrop-blur-sm px-2.5 py-1 text-xs font-semibold text-gray-900">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    {{ $item->created_at->format('d M Y') }}
                                </span>
                            </div>
                        </div>

                        {{-- Content --}}
                        <div class="p-5">
                            {{-- Author --}}
                            <div class="flex items-center gap-2 text-xs text-gray-500 mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <span>{{ $item->author->name }}</span>
                            </div>

                            {{-- Title --}}
                            <h3 class="text-lg font-bold text-gray-900 group-hover:text-indigo-600 transition line-clamp-2 mb-2">
                                {{ $item->title }}
                            </h3>

                            {{-- Excerpt --}}
                            <p class="text-sm text-gray-600 line-clamp-3 mb-4">
                                {{ Str::limit(strip_tags($item->body), 120) }}
                            </p>

                            {{-- Read More --}}
                            <a href="{{ route('news.show', $item->id) }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-indigo-600 hover:text-indigo-700 group-hover:gap-2 transition-all">
                                Baca Selengkapnya
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </article>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-12" data-aos="fade-up">
                    {{ $news->links() }}
                </div>
            @else
                {{-- Empty State --}}
                <div class="text-center py-20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto size-20 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                    </svg>
                    <h3 class="mt-4 text-xl font-semibold text-gray-900">Belum Ada Berita</h3>
                    <p class="mt-2 text-gray-500">Berita akan ditampilkan di sini setelah dipublikasikan.</p>
                    <a href="{{ route('home') }}" class="mt-6 inline-block rounded-lg bg-indigo-600 px-6 py-3 text-white font-semibold hover:bg-indigo-700 transition">
                        Kembali ke Beranda
                    </a>
                </div>
            @endif
        </div>
    </section>
</main>

{{-- FOOTER --}}
<footer class="bg-gray-900 py-10">
    <div class="mx-auto max-w-7xl px-4 text-center">
        <p class="text-gray-300 font-medium">&copy; {{ date('Y') }} SIM-KAMPUS. All rights reserved.</p>
        <p class="text-gray-500 text-sm mt-2">
            Dikembangkan dengan <span class="text-indigo-500">Laravel & Tailwind CSS</span>
        </p>
    </div>
</footer>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 800,
        once: true,
        offset: 50,
    });
</script>

</body>
</html>
