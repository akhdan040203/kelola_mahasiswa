@extends('layouts.dashboard')

@section('title', 'Detail Mahasiswa')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Detail Mahasiswa</h1>
        
        <div class="flex items-center justify-end space-x-2 w-full sm:w-auto">
            <a href="{{ route('admin.mahasiswa.edit', $mahasiswa->id) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition h-10 shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Edit
            </a>
            <a href="{{ route('admin.mahasiswa.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-lg transition h-10 shadow-sm">
                Kembali
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="md:col-span-1">
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
                <div class="flex flex-col items-center mb-4">
                    <div class="h-24 w-24 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-700 text-4xl font-bold mb-4">
                        {{ substr($mahasiswa->user->name, 0, 1) }}
                    </div>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white text-center">{{ $mahasiswa->user->name }}</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 text-center mt-1">{{ $mahasiswa->nim }}</p>
                </div>
                
                <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                    <div class="mb-4">
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-semibold">Status</p>
                        @if($mahasiswa->status == 'aktif')
                            <span class="mt-1 inline-block px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>
                        @elseif($mahasiswa->status == 'cuti')
                            <span class="mt-1 inline-block px-3 py-1 text-sm font-semibold rounded-full bg-yellow-100 text-yellow-800">Cuti</span>
                        @elseif($mahasiswa->status == 'lulus')
                            <span class="mt-1 inline-block px-3 py-1 text-sm font-semibold rounded-full bg-blue-100 text-blue-800">Lulus</span>
                        @else
                            <span class="mt-1 inline-block px-3 py-1 text-sm font-semibold rounded-full bg-red-100 text-red-800">Non-Aktif</span>
                        @endif
                    </div>

                    <div class="mb-4">
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-semibold">Email</p>
                        <p class="text-sm text-gray-900 dark:text-white break-all">{{ $mahasiswa->user->email }}</p>
                    </div>

                    <div class="mb-4">
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-semibold">Angkatan</p>
                        <p class="text-sm text-gray-900 dark:text-white">{{ $mahasiswa->angkatan }}</p>
                    </div>

                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-semibold">Prodi</p>
                        <p class="text-sm text-gray-900 dark:text-white">{{ $mahasiswa->prodi }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="md:col-span-2">
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 border-b pb-2">Data Akademik</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-semibold mb-1">NIM</p>
                        <p class="text-sm text-gray-900 dark:text-white font-medium">{{ $mahasiswa->nim }}</p>
                    </div>

                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-semibold mb-1">Nama Lengkap</p>
                        <p class="text-sm text-gray-900 dark:text-white font-medium">{{ $mahasiswa->user->name }}</p>
                    </div>

                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-semibold mb-1">Program Studi</p>
                        <p class="text-sm text-gray-900 dark:text-white font-medium">{{ $mahasiswa->prodi }}</p>
                    </div>

                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-semibold mb-1">Angkatan</p>
                        <p class="text-sm text-gray-900 dark:text-white font-medium">{{ $mahasiswa->angkatan }}</p>
                    </div>

                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-semibold mb-1">Semester Aktif</p>
                        <p class="text-sm text-gray-900 dark:text-white font-medium">{{ $mahasiswa->semester_aktif ?? '-' }}</p>
                    </div>

                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-semibold mb-1">Status</p>
                        @if($mahasiswa->status == 'aktif')
                            <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>
                        @elseif($mahasiswa->status == 'cuti')
                            <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Cuti</span>
                        @elseif($mahasiswa->status == 'lulus')
                            <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Lulus</span>
                        @else
                            <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Non-Aktif</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 border-b pb-2">Dosen Pembimbing Akademik</h3>
                
                @if($mahasiswa->dosenPembimbing)
                    <div class="flex items-center">
                        <div class="h-12 w-12 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-700 font-bold mr-3">
                            {{ substr($mahasiswa->dosenPembimbing->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $mahasiswa->dosenPembimbing->name }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $mahasiswa->dosenPembimbing->email }}</p>
                        </div>
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3.25a1.25 1.25 0 01-1.25-1.25V5a1.25 1.25 0 011.25-1.25h17.5a1.25 1.25 0 011.25 1.25v13.75a1.25 1.25 0 01-1.25 1.25z"/>
                        </svg>
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Belum diplot DPA</p>
                    </div>
                @endif
            </div>

            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 mt-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 border-b pb-2">Informasi Tambahan</h3>
                
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500 dark:text-gray-400">Terdaftar sejak:</span>
                        <span class="text-gray-900 dark:text-white font-medium">{{ $mahasiswa->created_at->format('d F Y H:i') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500 dark:text-gray-400">Terakhir diupdate:</span>
                        <span class="text-gray-900 dark:text-white font-medium">{{ $mahasiswa->updated_at->format('d F Y H:i') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection