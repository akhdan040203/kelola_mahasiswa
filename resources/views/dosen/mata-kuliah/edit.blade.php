@extends('layouts.dashboard')

@section('title', 'Atur Jadwal Kuliah')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-6 flex items-center">
        <a href="{{ route('dosen.mata-kuliah.show', $course->id) }}" class="mr-4 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
        </a>
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white leading-tight">Atur Jadwal: <span class="text-indigo-600 dark:text-indigo-400">{{ $course->nama_mk }}</span></h1>
    </div>

    <!-- Alert Informational -->
    <div class="mb-6 bg-blue-50 border-l-4 border-blue-400 p-4 rounded-r-xl">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-blue-700 font-medium">
                    Perubahan jadwal akan langsung muncul di dashboard mahasiswa yang mengambil mata kuliah ini.
                </p>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow-xl rounded-3xl overflow-hidden border border-gray-100 dark:border-gray-700">
        <form action="{{ route('dosen.mata-kuliah.update', $course->id) }}" method="POST" class="p-8">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <!-- Hari -->
                <div>
                    <label for="hari" class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">Hari Perkuliahan</label>
                    <div class="relative">
                        <select name="hari" id="hari" class="w-full h-12 pl-4 pr-10 rounded-2xl border-gray-100 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm focus:ring-2 focus:ring-indigo-500 @error('hari') border-red-500 @enderror appearance-none transition-all">
                            <option value="">-- Pilih Hari --</option>
                            @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $hari)
                                <option value="{{ $hari }}" {{ old('hari', $course->hari) == $hari ? 'selected' : '' }}>{{ $hari }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"/></svg>
                        </div>
                    </div>
                    @error('hari')
                        <p class="mt-2 text-xs text-red-500 font-bold italic">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Ruangan -->
                <div>
                    <label for="ruangan" class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">Ruangan / Lokasi</label>
                    <input type="text" name="ruangan" id="ruangan" value="{{ old('ruangan', $course->ruangan) }}" 
                        class="w-full h-12 px-5 rounded-2xl border-gray-100 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm focus:ring-2 focus:ring-indigo-500 @error('ruangan') border-red-500 @enderror transition-all" 
                        placeholder="E.g., Lab Komputer A">
                    @error('ruangan')
                        <p class="mt-2 text-xs text-red-500 font-bold italic">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Waktu Mulai -->
                <div>
                    <label for="jam_mulai" class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">Jam Kuliah Mulai</label>
                    <div class="relative group">
                        <input type="time" name="jam_mulai" id="jam_mulai" value="{{ old('jam_mulai', $course->jam_mulai ? \Carbon\Carbon::parse($course->jam_mulai)->format('H:i') : '') }}" 
                            class="w-full h-12 px-5 rounded-2xl border-gray-100 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm focus:ring-2 focus:ring-indigo-500 @error('jam_mulai') border-red-500 @enderror transition-all">
                    </div>
                    @error('jam_mulai')
                        <p class="mt-2 text-xs text-red-500 font-bold italic">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Waktu Selesai -->
                <div>
                    <label for="jam_selesai" class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">Jam Kuliah Selesai</label>
                    <div class="relative group">
                        <input type="time" name="jam_selesai" id="jam_selesai" value="{{ old('jam_selesai', $course->jam_selesai ? \Carbon\Carbon::parse($course->jam_selesai)->format('H:i') : '') }}" 
                            class="w-full h-12 px-5 rounded-2xl border-gray-100 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm focus:ring-2 focus:ring-indigo-500 @error('jam_selesai') border-red-500 @enderror transition-all">
                    </div>
                    @error('jam_selesai')
                        <p class="mt-2 text-xs text-red-500 font-bold italic">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Footer Buttons -->
            <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-50 dark:border-gray-700/50 mt-4">
                <a href="{{ route('dosen.mata-kuliah.show', $course->id) }}" class="px-8 py-3 bg-gray-50 dark:bg-gray-700 text-gray-600 dark:text-gray-300 font-extrabold text-[10px] uppercase tracking-widest rounded-2xl hover:bg-gray-100 transition-all active:scale-95">
                    Batal
                </a>
                <button type="submit" class="px-10 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-extrabold text-[10px] uppercase tracking-widest rounded-2xl shadow-lg shadow-indigo-100 dark:shadow-none transition-all active:translate-y-1">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
