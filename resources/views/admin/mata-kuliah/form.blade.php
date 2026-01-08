@extends('layouts.dashboard')

@section('title', isset($mataKuliah) ? 'Edit Mata Kuliah' : 'Tambah Mata Kuliah')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
            {{ isset($mataKuliah) ? 'Edit Mata Kuliah' : 'Tambah Mata Kuliah' }}
        </h1>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
        <form action="{{ isset($mataKuliah) ? route('admin.mata-kuliah.update', $mataKuliah->id) : route('admin.mata-kuliah.store') }}" method="POST">
            @csrf
            @if(isset($mataKuliah))
                @method('PUT')
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="kode_mk" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Kode Mata Kuliah</label>
                    <input type="text" name="kode_mk" id="kode_mk" value="{{ old('kode_mk', $mataKuliah->kode_mk ?? '') }}" 
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white @error('kode_mk') border-red-500 @enderror" 
                        placeholder="E.g., TIF101" required>
                    @error('kode_mk')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="nama_mk" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nama Mata Kuliah</label>
                    <input type="text" name="nama_mk" id="nama_mk" value="{{ old('nama_mk', $mataKuliah->nama_mk ?? '') }}" 
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white @error('nama_mk') border-red-500 @enderror" 
                        placeholder="E.g., Pemrograman Web" required>
                    @error('nama_mk')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="sks" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">SKS</label>
                    <select name="sks" id="sks" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white @error('sks') border-red-500 @enderror" required>
                        @for($i = 1; $i <= 6; $i++)
                            <option value="{{ $i }}" {{ old('sks', $mataKuliah->sks ?? '') == $i ? 'selected' : '' }}>{{ $i }} SKS</option>
                        @endfor
                    </select>
                    @error('sks')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="semester" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Semester</label>
                    <select name="semester" id="semester" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white @error('semester') border-red-500 @enderror" required>
                        @for($i = 1; $i <= 8; $i++)
                            <option value="{{ $i }}" {{ old('semester', $mataKuliah->semester ?? '') == $i ? 'selected' : '' }}>Semester {{ $i }}</option>
                        @endfor
                    </select>
                    @error('semester')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="dosen_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Dosen Pengampu</label>
                    <select name="dosen_id" id="dosen_id" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white @error('dosen_id') border-red-500 @enderror" required>
                        <option value="">-- Pilih Dosen --</option>
                        @foreach($dosens as $dosen)
                            <option value="{{ $dosen->id }}" {{ old('dosen_id', $mataKuliah->dosen_id ?? '') == $dosen->id ? 'selected' : '' }}>
                                {{ $dosen->name }} ({{ $dosen->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('dosen_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2 pt-4 border-t border-gray-100 dark:border-gray-700 mt-2">
                    <h3 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wider mb-4">Jadwal Perkuliahan</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="hari" class="block text-xs font-semibold text-gray-500 uppercase tracking-widest mb-2">Hari</label>
                            <select name="hari" id="hari" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                <option value="">-- Pilih Hari --</option>
                                @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $hari)
                                    <option value="{{ $hari }}" {{ old('hari', $mataKuliah->hari ?? '') == $hari ? 'selected' : '' }}>{{ $hari }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="ruangan" class="block text-xs font-semibold text-gray-500 uppercase tracking-widest mb-2">Ruangan / Lokasi</label>
                            <input type="text" name="ruangan" id="ruangan" value="{{ old('ruangan', $mataKuliah->ruangan ?? '') }}" 
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" 
                                placeholder="E.g., Ruang 301 / Lab Komputer">
                        </div>
                        <div>
                            <label for="jam_mulai" class="block text-xs font-semibold text-gray-500 uppercase tracking-widest mb-2">Jam Mulai</label>
                            <input type="time" name="jam_mulai" id="jam_mulai" value="{{ old('jam_mulai', isset($mataKuliah->jam_mulai) ? \Carbon\Carbon::parse($mataKuliah->jam_mulai)->format('H:i') : '') }}" 
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>
                        <div>
                            <label for="jam_selesai" class="block text-xs font-semibold text-gray-500 uppercase tracking-widest mb-2">Jam Selesai</label>
                            <input type="time" name="jam_selesai" id="jam_selesai" value="{{ old('jam_selesai', isset($mataKuliah->jam_selesai) ? \Carbon\Carbon::parse($mataKuliah->jam_selesai)->format('H:i') : '') }}" 
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <label for="deskripsi" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Deskripsi (Opsional)</label>
                <textarea name="deskripsi" id="deskripsi" rows="4" 
                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white @error('deskripsi') border-red-500 @enderror" 
                    placeholder="Deskripsi singkat mengenai mata kuliah...">{{ old('deskripsi', $mataKuliah->deskripsi ?? '') }}</textarea>
                @error('deskripsi')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.mata-kuliah.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition font-medium">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition font-medium shadow-sm">
                    {{ isset($mataKuliah) ? 'Simpan Perubahan' : 'Tambah Mata Kuliah' }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
