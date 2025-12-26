<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $news->title }} - SIM-Kampus</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-900 antialiased">


<header class="bg-white border-b border-gray-100 sticky top-0 z-50 shadow-sm">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            <a href="{{ route('home') }}" class="text-2xl font-bold text-indigo-600">🎓 SIM-Kampus</a>
            <nav class="hidden md:block">
                <ul class="flex items-center gap-6 text-sm font-medium">
                    <li><a href="{{ route('home') }}" class="text-gray-600 hover:text-indigo-600 transition">Beranda</a></li>
                    <li><a href="{{ route('news.index') }}" class="text-indigo-600 font-semibold">Berita</a></li>
                    @auth
                        <li><a href="{{ url('/dashboard') }}" class="text-gray-600 hover:text-indigo-600 transition">Dashboard</a></li>
                    @endauth
                </ul>
            </nav>
        </div>
    </div>
</header>


<main class="min-h-screen py-12">
    <article class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
        
        {{-- Breadcrumb --}}
        <nav class="mb-8" data-aos="fade-down">
            <ol class="flex items-center gap-2 text-sm text-gray-500">
                <li><a href="{{ route('home') }}" class="hover:text-indigo-600 transition">Beranda</a></li>
                <li>/</li>
                <li><a href="{{ route('news.index') }}" class="hover:text-indigo-600 transition">Berita</a></li>
                <li>/</li>
                <li class="text-gray-900 font-medium truncate">{{ Str::limit($news->title, 40) }}</li>
            </ol>
        </nav>

        {{-- Article Header --}}
        <header class="mb-8" data-aos="fade-up">
            <h1 class="text-3xl font-bold text-gray-900 sm:text-4xl leading-tight">
                {{ $news->title }}
            </h1>
            
            <div class="mt-6 flex flex-wrap items-center gap-4 text-sm text-gray-600">
                {{-- Author --}}
                <div class="flex items-center gap-2">
                    <div class="size-10 rounded-full bg-indigo-100 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-900">{{ $news->author->name }}</p>
                        <p class="text-xs text-gray-500">Penulis</p>
                    </div>
                </div>

                {{-- Date --}}
                <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span>{{ $news->created_at->format('d F Y') }}</span>
                </div>

                {{-- Reading Time --}}
                <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ ceil(str_word_count($news->body) / 200) }} menit baca</span>
                </div>
            </div>
        </header>

        {{-- Featured Image Placeholder --}}
        <div class="mb-10 rounded-2xl overflow-hidden shadow-xl" data-aos="zoom-in">
            <div class="relative h-96 bg-gradient-to-br from-indigo-500 to-purple-600">
                <div class="absolute inset-0 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-32 text-white/20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- Article Body --}}
        <div class="prose prose-lg max-w-none mb-12" data-aos="fade-up">
            <div class="text-gray-700 leading-relaxed whitespace-pre-line">
                {{ $news->body }}
            </div>
        </div>

        {{-- Share Buttons --}}
        <div class="border-t border-b border-gray-200 py-6 mb-12" data-aos="fade-up">
            <p class="text-sm font-semibold text-gray-900 mb-3">Bagikan Berita:</p>
            <div class="flex gap-3">
                <button class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700 transition">
                    <svg class="size-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    Facebook
                </button>
                <button class="inline-flex items-center gap-2 rounded-lg bg-sky-500 px-4 py-2 text-sm font-medium text-white hover:bg-sky-600 transition">
                    <svg class="size-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                    Twitter
                </button>
                <button class="inline-flex items-center gap-2 rounded-lg bg-green-600 px-4 py-2 text-sm font-medium text-white hover:bg-green-700 transition">
                    <svg class="size-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                    WhatsApp
                </button>
            </div>
        </div>

        {{-- Related News --}}
        @if($relatedNews->count() > 0)
        <section data-aos="fade-up">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Berita Terkait</h2>
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
                @foreach($relatedNews as $related)
                <a href="{{ route('news.show', $related->id) }}" class="group">
                    <article class="overflow-hidden rounded-xl bg-white shadow-sm hover:shadow-md transition border border-gray-100">
                        <div class="h-40 bg-gradient-to-br from-indigo-400 to-purple-500"></div>
                        <div class="p-4">
                            <p class="text-xs text-gray-500 mb-2">{{ $related->created_at->format('d M Y') }}</p>
                            <h3 class="font-semibold text-gray-900 group-hover:text-indigo-600 transition line-clamp-2">
                                {{ $related->title }}
                            </h3>
                        </div>
                    </article>
                </a>
                @endforeach
            </div>
        </section>
        @endif

        {{-- Back Button --}}
        <div class="mt-12 text-center" data-aos="fade-up">
            <a href="{{ route('news.index') }}" class="inline-flex items-center gap-2 rounded-lg border-2 border-indigo-600 px-6 py-3 font-semibold text-indigo-600 hover:bg-indigo-50 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Semua Berita
            </a>
        </div>

    </article>
</main>

{{-- FOOTER --}}
<footer class="bg-gray-900 py-10 mt-16">
    <div class="mx-auto max-w-7xl px-4 text-center">
        <p class="text-gray-300 font-medium">&copy; {{ date('Y') }} SIM-KAMPUS. All rights reserved.</p>
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
