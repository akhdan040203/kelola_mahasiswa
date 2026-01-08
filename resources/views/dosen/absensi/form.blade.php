@extends('layouts.dashboard')

@section('title', 'Buat Absensi')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Form Absensi</h1>
        <p class="text-gray-500 dark:text-gray-400 mt-2">Mata Kuliah: {{ $course->nama_mk }}</p>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow-md rounded-xl p-6">
        <form action="{{ route('dosen.absensi.store') }}" method="POST">
            @csrf
            <input type="hidden" name="mata_kuliah_id" value="{{ $course->id }}">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Pertemuan Ke-</label>
                    <select name="pertemuan_ke" class="w-full rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                        @for($i=1; $i<=16; $i++)
                            <option value="{{ $i }}">Pertemuan {{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tanggal</label>
                    <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" class="w-full rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                </div>
            </div>

            <h3 class="font-bold text-gray-900 dark:text-white mb-4 border-b border-gray-100 dark:border-gray-700 pb-2 text-lg">Kehadiran Mahasiswa</h3>
            
            <div class="space-y-4 mb-8">
                @forelse($students as $index => $mhs)
                <div class="p-4 border border-indigo-100 dark:border-indigo-900/30 rounded-xl bg-indigo-50/50 dark:bg-indigo-900/10">
                    <div class="flex items-center justify-between flex-wrap gap-4">
                        <div class="flex-1">
                            <p class="font-bold text-gray-900 dark:text-white">{{ $mhs->nama }}</p>
                            <p class="text-xs text-gray-500">{{ $mhs->nim }}</p>
                            <input type="hidden" name="absensi[{{ $index }}][mahasiswa_id]" value="{{ $mhs->id }}">
                        </div>
                        <div class="flex items-center space-x-3">
                            <label class="inline-flex items-center">
                                <input type="radio" name="absensi[{{ $index }}][status]" value="hadir" class="text-green-600" checked>
                                <span class="ml-1 text-sm text-gray-700 dark:text-gray-300">Hadir</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="absensi[{{ $index }}][status]" value="izin" class="text-yellow-600">
                                <span class="ml-1 text-sm text-gray-700 dark:text-gray-300">Izin</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="absensi[{{ $index }}][status]" value="sakit" class="text-blue-600">
                                <span class="ml-1 text-sm text-gray-700 dark:text-gray-300">Sakit</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="absensi[{{ $index }}][status]" value="alpha" class="text-red-600">
                                <span class="ml-1 text-sm text-gray-700 dark:text-gray-300">Alpha</span>
                            </label>
                        </div>
                    </div>
                    <div class="mt-3">
                        <input type="text" name="absensi[{{ $index }}][keterangan]" class="w-full text-xs rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white py-1" placeholder="Catatan tambahan (opsional)...">
                    </div>
                </div>
                @empty
                <p class="text-center text-gray-500 py-4 italic">Tidak ada mahasiswa terdaftar di kelas ini.</p>
                @endforelse
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('dosen.mata-kuliah.show', $course->id) }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 transition font-bold">Batal</a>
                <button type="submit" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg transition" {{ $students->isEmpty() ? 'disabled' : '' }}>Simpan Absensi</button>
            </div>
        </form>
    </div>
</div>
@endsection
