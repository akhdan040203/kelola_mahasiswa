@extends('layouts.dashboard')

@section('title', 'Absensi Mahasiswa')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">Absensi Online</h1>
        <p class="text-sm text-gray-500 italic">Silakan isi absensi untuk pertemuan yang sedang berlangsung.</p>
    </div>

    @if(session('success'))
    <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center gap-3">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
        <span class="font-medium text-sm">{{ session('success') }}</span>
    </div>
    @endif
    
    @if(session('error'))
    <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl flex items-center gap-3">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
        <span class="font-medium text-sm">{{ session('error') }}</span>
    </div>
    @endif

    <div class="space-y-6">
        @forelse($sessions as $session)
            @php $userAbsensi = $session->absensi->first(); @endphp
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden transition-all hover:shadow-md">
                <div class="p-6 flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div class="flex items-start gap-5">
                        <div class="w-14 h-14 bg-indigo-50 dark:bg-indigo-500/10 rounded-2xl flex flex-col items-center justify-center border border-indigo-100 dark:border-indigo-500/20">
                            <span class="text-[10px] font-bold text-indigo-400 uppercase tracking-tighter">MEET</span>
                            <span class="text-lg font-extrabold text-indigo-600 dark:text-indigo-400 leading-none">{{ $session->pertemuan_ke }}</span>
                        </div>
                        <div>
                            <h3 class="font-extrabold text-gray-900 dark:text-white text-lg tracking-tight">{{ $session->mataKuliah->nama_mk }}</h3>
                            <div class="flex flex-wrap items-center gap-x-4 gap-y-1 mt-1">
                                <span class="text-xs text-gray-400 font-medium italic flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    {{ $session->tanggal->translatedFormat('d M Y') }}
                                </span>
                                <span class="text-xs text-gray-400 font-medium italic flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                    {{ $session->mataKuliah->dosen->name }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        @if($userAbsensi && $userAbsensi->status)
                            <div class="px-6 py-2 bg-green-50 dark:bg-green-500/10 border border-green-200 dark:border-green-500/20 rounded-xl">
                                <span class="text-green-600 dark:text-green-400 font-extrabold text-sm uppercase tracking-widest">
                                    ✅ {{ ucfirst($userAbsensi->status) }}
                                </span>
                            </div>
                        @elseif($session->is_open)
                            <form action="{{ route('student.absensi.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="absensi_pertemuan_id" value="{{ $session->id }}">
                                <button type="submit" class="px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg shadow-indigo-200 dark:shadow-none transition-all active:scale-95 flex items-center gap-2">
                                    HADIR SEKARANG
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                                </button>
                            </form>
                        @else
                            <div class="px-6 py-2 bg-gray-50 dark:bg-gray-700 rounded-xl border border-gray-100 dark:border-gray-600 italic">
                                <span class="text-gray-400 font-bold text-xs uppercase tracking-tight">Sesi Ditutup</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="py-20 flex flex-col items-center text-center opacity-60">
                <div class="w-20 h-20 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h4 class="text-xl font-bold text-gray-900 dark:text-gray-100">Menunggu Sesi...</h4>
                <p class="text-gray-500 text-sm italic max-w-xs mt-1">Saat ini belum ada mata kuliah yang membuka absensi.</p>
            </div>
        @endforelse

        <div class="mt-8">
            {{ $sessions->links() }}
        </div>
    </div>
</div>
@endsection
