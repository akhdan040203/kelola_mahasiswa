@extends('layouts.dashboard')

@section('title', 'Buka Sesi Absensi')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8 flex items-center gap-4">
        <a href="{{ route('dosen.absensi.index', ['mata_kuliah_id' => $course->id]) }}" 
           class="p-2.5 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl text-gray-500 hover:text-indigo-600 transition-all shadow-sm">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </a>
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">Buka Sesi Baru</h1>
            <p class="text-sm text-gray-500">{{ $course->nama_mk }}</p>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-100 dark:border-white/5 overflow-hidden">
        <form action="{{ route('dosen.absensi.store') }}" method="POST" class="p-8 space-y-6">
            @csrf
            <input type="hidden" name="mata_kuliah_id" value="{{ $course->id }}">

            <div>
                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2 uppercase tracking-wide">Nomor Pertemuan</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">#</span>
                    <input type="number" name="pertemuan_ke" value="{{ old('pertemuan_ke', $nextMeeting) }}" 
                           class="w-full pl-8 rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all"
                           placeholder="Contoh: 1, 2, dst" required min="1" max="16">
                </div>
                @error('pertemuan_ke') <p class="mt-2 text-xs text-red-500 font-medium italic">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2 uppercase tracking-wide">Tanggal Pertemuan</label>
                <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" 
                       class="w-full rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all"
                       required>
                @error('tanggal') <p class="mt-2 text-xs text-red-500 font-medium italic">{{ $message }}</p> @enderror
            </div>

            <div class="p-4 bg-indigo-50 dark:bg-indigo-500/10 rounded-xl border border-indigo-100 dark:border-indigo-500/20">
                <div class="flex gap-3">
                    <svg class="w-5 h-5 text-indigo-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p class="text-xs text-indigo-700 dark:text-indigo-400 leading-relaxed font-medium">
                        Setelah sesi ini dibuka, semua mahasiswa yang mengambil mata kuliah ini akan melihat form absensi di dashboard mereka. Sesi akan otomatis terbuka secara default.
                    </p>
                </div>
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg shadow-indigo-200 dark:shadow-none transition-all hover:-translate-y-1 active:scale-95">
                    BUKA SESI ABSENSI SEKARANG
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
