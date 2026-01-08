@extends('layouts.dashboard')

@section('title', isset($tugas) ? 'Edit Tugas' : 'Buat Tugas')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
            {{ isset($tugas) ? 'Edit Tugas' : 'Buat Tugas Baru' }}
        </h1>
        <p class="text-gray-500 dark:text-gray-400 mt-2">
            Mata Kuliah: {{ isset($tugas) ? $tugas->mataKuliah->nama_mk : $course->nama_mk }}
        </p>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow-md rounded-xl p-8 border border-gray-100 dark:border-gray-700">
        <form action="{{ isset($tugas) ? route('dosen.tugas.update', $tugas->id) : route('dosen.tugas.store') }}" method="POST">
            @csrf
            @if(isset($tugas))
                @method('PUT')
                <input type="hidden" name="mata_kuliah_id" value="{{ $tugas->mata_kuliah_id }}">
            @else
                <input type="hidden" name="mata_kuliah_id" value="{{ $course->id }}">
            @endif

            <div class="space-y-6">
                <div>
                    <label for="judul" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Judul Tugas</label>
                    <input type="text" name="judul" id="judul" value="{{ old('judul', $tugas->judul ?? '') }}" 
                        class="w-full rounded-xl border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-indigo-500 focus:border-indigo-500 @error('judul') border-red-500 @enderror" 
                        placeholder="Contoh: Tugas Mandiri - Dasar HTML" required>
                    @error('judul')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="deskripsi" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Deskripsi/Instruksi Tugas</label>
                    <textarea name="deskripsi" id="deskripsi" rows="6" 
                        class="w-full rounded-xl border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-indigo-500 focus:border-indigo-500 @error('deskripsi') border-red-500 @enderror" 
                        placeholder="Jelaskan instruksi tugas secara detail..." required>{{ old('deskripsi', $tugas->deskripsi ?? '') }}</textarea>
                    @error('deskripsi')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="max-w-xs">
                    <label for="deadline" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Batas Waktu (Deadline)</label>
                    <input type="datetime-local" name="deadline" id="deadline" 
                        value="{{ old('deadline', isset($tugas) ? $tugas->deadline->format('Y-m-d\TH:i') : '') }}" 
                        class="w-full rounded-xl border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-indigo-500 focus:border-indigo-500 @error('deadline') border-red-500 @enderror" 
                        required>
                    @error('deadline')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-6 border-t border-gray-50 dark:border-gray-700 flex justify-end space-x-4">
                    <a href="{{ route('dosen.mata-kuliah.show', isset($tugas) ? $tugas->mata_kuliah_id : $course->id) }}" 
                        class="px-6 py-2.5 border border-gray-200 text-gray-600 dark:text-gray-300 font-bold rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                        Batal
                    </a>
                    <button type="submit" class="px-8 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl transition shadow-indigo-200 dark:shadow-none shadow-lg">
                        {{ isset($tugas) ? 'Perbarui Tugas' : 'Publikasikan Tugas' }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
