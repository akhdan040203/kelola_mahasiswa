@extends('layouts.dashboard')

@section('title', 'Monitor Absensi - Pertemuan ' . $pertemuan->pertemuan_ke)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="flex items-center gap-4">
            <a href="{{ route('dosen.absensi.index', ['mata_kuliah_id' => $pertemuan->mata_kuliah_id]) }}" 
               class="p-2.5 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl text-gray-500 hover:text-indigo-600 transition-all shadow-sm">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">Monitor Absensi</h1>
                <p class="text-sm text-gray-500">Pertemuan {{ $pertemuan->pertemuan_ke }} • {{ $pertemuan->tanggal->translatedFormat('d F Y') }}</p>
            </div>
        </div>
        <div class="flex items-center gap-3">
             <div class="bg-indigo-50 dark:bg-indigo-500/10 px-4 py-2 rounded-xl text-indigo-700 dark:text-indigo-400 font-bold border border-indigo-100 dark:border-indigo-500/20 text-xs">
                {{ $pertemuan->absensi->whereNotNull('status')->count() }} / {{ $pertemuan->absensi->count() }} Terisi
             </div>
        </div>
    </div>

    @if(session('success'))
    <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center gap-3">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
        <span class="font-medium text-sm">{{ session('success') }}</span>
    </div>
    @endif

    <form action="{{ route('dosen.absensi.update', $pertemuan->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="px-6 py-4 bg-gray-50/50 dark:bg-gray-700/50 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between">
                <h3 class="text-sm font-bold text-gray-700 dark:text-gray-300 uppercase tracking-widest">Daftar Mahasiswa</h3>
                <div class="flex items-center">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_open" value="1" {{ $pertemuan->is_open ? 'checked' : '' }} class="sr-only peer">
                        <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 dark:peer-focus:ring-indigo-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-indigo-600"></div>
                        <span class="ms-3 text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-tight">Sesi Terbuka</span>
                    </label>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead>
                        <tr class="text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest bg-gray-50/30 dark:bg-gray-900/10">
                            <th class="px-6 py-4">Mahasiswa</th>
                            <th class="px-6 py-4 text-center">Status Kehadiran</th>
                            <th class="px-6 py-4">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @foreach($pertemuan->absensi as $index => $absen)
                        <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/30 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <input type="hidden" name="absensi[{{ $index }}][id]" value="{{ $absen->id }}">
                                <div class="font-bold text-gray-900 dark:text-white mb-1">{{ $absen->mahasiswa->nama }}</div>
                                <div class="text-[10px] font-medium text-gray-400 tracking-tighter">{{ $absen->mahasiswa->nim }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center gap-2">
                                    @php $statuses = ['hadir' => 'text-green-600', 'izin' => 'text-blue-600', 'sakit' => 'text-yellow-600', 'alpha' => 'text-red-600']; @endphp
                                    @foreach($statuses as $status => $color)
                                    <label class="cursor-pointer group">
                                        <input type="radio" name="absensi[{{ $index }}][status]" value="{{ $status }}" 
                                               {{ $absen->status == $status ? 'checked' : '' }} class="sr-only peer">
                                        <div class="px-3 py-1.5 rounded-lg border border-gray-100 dark:border-gray-700 italic font-bold text-[10px] uppercase transition-all
                                                    peer-checked:bg-indigo-600 peer-checked:text-white peer-checked:border-indigo-600 
                                                    peer-checked:not-italic peer-checked:shadow-sm">
                                            {{ $status }}
                                        </div>
                                    </label>
                                    @endforeach
                                </div>
                                @if(!$absen->status)
                                    <p class="text-[9px] text-center mt-2 text-red-400 italic font-medium anim-pulse">Belum absen</p>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <input type="text" name="absensi[{{ $index }}][keterangan]" value="{{ $absen->keterangan }}"
                                       class="w-full text-xs rounded-lg border-gray-100 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 placeholder-gray-300 italic"
                                       placeholder="Tambahkan catatan...">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-8 py-6 bg-gray-50/50 dark:bg-gray-700/50 border-t border-gray-100 dark:border-gray-700 text-right">
                <button type="submit" class="inline-flex items-center px-8 py-3 bg-gray-900 dark:bg-indigo-600 hover:bg-black dark:hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg transition-all active:scale-95">
                    SIMPAN PERUBAHAN
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
