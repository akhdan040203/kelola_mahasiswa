@extends('layouts.dashboard')

@section('title', 'Jadwal Perkuliahan')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">Jadwal Perkuliahan</h1>
            <p class="text-sm text-gray-500 italic">Daftar mata kuliah Anda berdasarkan KRS yang telah disetujui.</p>
        </div>
        @if(isset($days))
        <div class="flex items-center gap-2">
            <span class="px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full text-xs font-bold uppercase tracking-widest border border-indigo-200">
                Semester Aktif
            </span>
        </div>
        @endif
    </div>

    @if(empty($groupedSchedule))
        <div class="bg-white dark:bg-gray-800 rounded-3xl p-12 text-center border-2 border-dashed border-gray-100 dark:border-gray-700 mt-10">
            <div class="w-20 h-20 bg-gray-50 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-2">{{ $message ?? 'Belum ada jadwal tersedia.' }}</h3>
            <p class="text-gray-500 max-w-sm mx-auto">Silakan hubungi bagian akademik atau admin jika Anda merasa ini adalah kesalahan.</p>
        </div>
    @else
        <div class="space-y-12">
            @foreach($days as $day)
                @if($groupedSchedule[$day]->count() > 0)
                    <div>
                        <div class="flex items-center gap-4 mb-6">
                            <h2 class="text-xl font-black text-gray-900 dark:text-white uppercase tracking-tighter">{{ $day }}</h2>
                            <div class="h-px flex-1 bg-gradient-to-r from-gray-200 to-transparent dark:from-gray-700"></div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($groupedSchedule[$day] as $subject)
                                <div class="group relative bg-white dark:bg-gray-800 rounded-3xl border border-gray-100 dark:border-gray-700 p-6 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                                    <!-- Header: Time & Room -->
                                    <div class="flex items-center justify-between mb-4">
                                        <div class="flex items-center gap-2 px-3 py-1 bg-indigo-50 dark:bg-indigo-500/10 rounded-full text-indigo-600 dark:text-indigo-400 font-bold text-[10px] uppercase tracking-wider border border-indigo-100 dark:border-indigo-500/20">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            @if($subject->jam_mulai && $subject->jam_selesai)
                                                {{ \Carbon\Carbon::parse($subject->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($subject->jam_selesai)->format('H:i') }}
                                            @else
                                                TBA
                                            @endif
                                        </div>
                                        <div class="flex items-center gap-1 text-xs font-bold text-gray-400 uppercase tracking-tighter">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                            {{ $subject->ruangan ?? 'TBA' }}
                                        </div>
                                    </div>

                                    <!-- Subject Info -->
                                    <div class="mb-6">
                                        <h4 class="text-lg font-black text-gray-900 dark:text-white leading-tight group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors uppercase tracking-tight mb-1">{{ $subject->nama_mk }}</h4>
                                        <p class="text-xs text-gray-400 font-medium italic mb-2">{{ $subject->dosen ? $subject->dosen->name : 'Dosen belum ditentukan' }}</p>
                                        <span class="inline-block px-2 py-0.5 bg-gray-100 dark:bg-gray-700 rounded text-[9px] font-bold text-gray-500 uppercase tracking-widest">{{ $subject->sks }} SKS • SMSTR {{ $subject->semester }}</span>
                                    </div>

                                    <!-- Stats Grid -->
                                    <div class="grid grid-cols-2 gap-3 pb-4 border-b border-gray-50 dark:border-gray-700/50 mb-4">
                                        <div class="p-3 bg-gray-50/50 dark:bg-gray-900/10 rounded-2xl flex flex-col gap-1">
                                            <span class="text-[9px] font-bold text-gray-400 uppercase tracking-widest leading-none">Kehadiran</span>
                                            <div class="flex items-baseline gap-1">
                                                <span class="text-lg font-black text-gray-900 dark:text-white">{{ $subject->attendance_summary['attended'] }}</span>
                                                <span class="text-[10px] text-gray-400 font-bold">/{{ $subject->attendance_summary['total'] }}</span>
                                            </div>
                                            <!-- Progress Bar Mini -->
                                            <div class="w-full h-1 bg-gray-100 dark:bg-gray-700 rounded-full mt-1 overflow-hidden">
                                                <div class="h-full bg-green-500" style="width: {{ $subject->attendance_summary['percent'] }}%"></div>
                                            </div>
                                        </div>
                                        <div class="p-3 bg-gray-50/50 dark:bg-gray-900/10 rounded-2xl flex flex-col gap-1">
                                            <span class="text-[9px] font-bold text-gray-400 uppercase tracking-widest leading-none">Tugas Baru</span>
                                            <div class="flex items-baseline gap-1">
                                                <span class="text-lg font-black text-indigo-600 dark:text-indigo-400">{{ $subject->assignment_count }}</span>
                                                <span class="text-[10px] text-gray-400 font-bold uppercase">Item</span>
                                            </div>
                                            <p class="text-[8px] text-gray-400 italic font-medium leading-none">Cek halaman tugas</p>
                                        </div>
                                    </div>

                                    <!-- Quick Actions -->
                                    <div class="flex gap-2">
                                        <a href="{{ route('student.absensi.index') }}" class="flex-1 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-[10px] font-bold rounded-xl text-center uppercase tracking-widest shadow-lg shadow-indigo-200 dark:shadow-none transition-all">
                                            Absen
                                        </a>
                                        <a href="#" class="flex-1 py-2 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 text-[10px] font-bold rounded-xl text-center uppercase tracking-widest hover:bg-gray-50 dark:hover:bg-gray-800 transition-all">
                                            Tugas
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    @endif
</div>
@endsection
