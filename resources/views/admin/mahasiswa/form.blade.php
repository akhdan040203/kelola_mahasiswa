@extends('layouts.dashboard')

@section('title', isset($mahasiswa) ? 'Edit Mahasiswa' : 'Tambah Mahasiswa')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
            {{ isset($mahasiswa) ? 'Edit Mahasiswa' : 'Tambah Mahasiswa' }}
        </h1>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            Pastikan data NIM dan Email tidak duplikat dengan mahasiswa lain.
        </p>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
        <form action="{{ isset($mahasiswa) ? route('admin.mahasiswa.update', $mahasiswa->id) : route('admin.mahasiswa.store') }}" method="POST">
            @csrf
            @if(isset($mahasiswa))
                @method('PUT')
            @endif

            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 border-b pb-2">Informasi Akun</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nama Lengkap</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $mahasiswa->user->name ?? '') }}" 
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white @error('name') border-red-500 @enderror" 
                        placeholder="Nama sesuai ijazah" required>
                    @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email Kampus</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $mahasiswa->user->email ?? '') }}" 
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white @error('email') border-red-500 @enderror" 
                        placeholder="mahasiswa@kampus.ac.id" required>
                    @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                @if(!isset($mahasiswa))
                <div class="md:col-span-2">
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Password Akun</label>
                    <input type="password" name="password" id="password" 
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white @error('password') border-red-500 @enderror" 
                        placeholder="Minimal 8 karakter" required>
                    <p class="mt-1 text-xs text-gray-500">Mahasiswa dapat mengubah password ini setelah login.</p>
                    @error('password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                @endif
            </div>

            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 border-b pb-2">Data Akademik</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="nim" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">NIM (Nomor Induk Mahasiswa)</label>
                    <input type="text" name="nim" id="nim" value="{{ old('nim', $mahasiswa->nim ?? '') }}" 
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white @error('nim') border-red-500 @enderror" 
                        placeholder="E.g., 20240001" required>
                    @error('nim') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="angkatan" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Angkatan</label>
                    <select name="angkatan" id="angkatan" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                        @for($year = date('Y'); $year >= 2020; $year--)
                            <option value="{{ $year }}" {{ old('angkatan', $mahasiswa->angkatan ?? '') == $year ? 'selected' : '' }}>Tahun {{ $year }}</option>
                        @endfor
                    </select>
                </div>

                <div>
                    <label for="prodi" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Program Studi</label>
                    <select name="prodi" id="prodi" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                        <option value="">-- Pilih Prodi --</option>
                        @foreach(['Teknik Informatika', 'Sistem Informasi', 'Teknik Elektro'] as $p)
                            <option value="{{ $p }}" {{ old('prodi', $mahasiswa->prodi ?? '') == $p ? 'selected' : '' }}>{{ $p }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status Mahasiswa</label>
                    <select name="status" id="status" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                        <option value="aktif" {{ old('status', $mahasiswa->status ?? 'aktif') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="cuti" {{ old('status', $mahasiswa->status ?? '') == 'cuti' ? 'selected' : '' }}>Cuti</option>
                        <option value="non-aktif" {{ old('status', $mahasiswa->status ?? '') == 'non-aktif' ? 'selected' : '' }}>Non-Aktif / DO</option>
                        <option value="lulus" {{ old('status', $mahasiswa->status ?? '') == 'lulus' ? 'selected' : '' }}>Lulus</option>
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label for="dosen_pembimbing_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Dosen Pembimbing Akademik (DPA)</label>
                    <select name="dosen_pembimbing_id" id="dosen_pembimbing_id" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white @error('dosen_pembimbing_id') border-red-500 @enderror">
                        <option value="">-- Pilih DPA --</option>
                        @foreach($dosens as $dosen)
                            <option value="{{ $dosen->id }}" {{ old('dosen_pembimbing_id', $mahasiswa->dosen_pembimbing_id ?? '') == $dosen->id ? 'selected' : '' }}>
                                {{ $dosen->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('dosen_pembimbing_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-100 dark:border-gray-700">
                <a href="{{ route('admin.mahasiswa.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition font-medium">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition font-medium shadow-sm">
                    {{ isset($mahasiswa) ? 'Simpan Perubahan' : 'Daftarkan Mahasiswa' }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection