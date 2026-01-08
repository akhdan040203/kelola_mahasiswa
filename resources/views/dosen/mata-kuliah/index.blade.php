@extends('layouts.dashboard')

@section('title', 'Mata Kuliah Diampu')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Mata Kuliah Diampu</h1>
        <p class="text-gray-500 dark:text-gray-400 mt-2">Daftar mata kuliah yang Anda ajar pada semester ini.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($assignedCourses as $assigned)
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow border border-gray-100 dark:border-gray-700">
            <div class="p-6">
                <div class="flex justify-between items-start mb-4">
                    <span class="px-2 py-1 bg-indigo-100 text-indigo-700 text-xs font-bold rounded uppercase">
                        SMT {{ $assigned->semester }}
                    </span>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2 leading-tight">
                    {{ $assigned->nama_mk }}
                </h3>
                <div class="flex items-center text-sm text-gray-500 dark:text-gray-400 mb-6">
                    <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    Total Mahasiswa: {{ \App\Models\Mahasiswa::whereHas('krs', function($q) use ($assigned) {
                        $q->where('status', 'approved')->whereHas('mataKuliah', function($q2) use ($assigned) {
                            $q2->where('mata_kuliah.id', $assigned->id);
                        });
                    })->count() }}
                </div>
                
                <div class="pt-4 border-t border-gray-50 dark:border-gray-700 flex justify-between items-center">
                    <a href="{{ route('dosen.mata-kuliah.show', $assigned->id) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-lg transition">
                        Kelola Kelas
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full bg-white dark:bg-gray-800 rounded-xl shadow-md p-10 text-center">
            <div class="w-20 h-20 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                </svg>
            </div>
            <p class="text-gray-500 dark:text-gray-400 text-lg">Anda belum ditugaskan untuk mengajar mata kuliah apapun.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
