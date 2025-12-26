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
                        <li><a class="text-gray-600 transition hover:text-indigo-600" href="{{ route('news.index') }}"> Berita </a></li>
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
            <a class="text-gray-600 hover:text-indigo-600" href="{{ route('news.index') }}">Berita</a>
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
