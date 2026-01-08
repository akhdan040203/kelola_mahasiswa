@extends('layouts.dashboard')

@section('title', 'Detail KRS Mahasiswa')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-6 flex items-center justify-between">
        <div class="flex items-center">
            <a href="{{ route('admin.krs.index') }}" class="mr-4 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Detail Pengajuan KRS</h1>
        </div>
        <div class="flex items-center space-x-2">
            <span class="px-3 py-1 text-sm font-semibold rounded-full 
                {{ $krs->status == 'approved' ? 'bg-green-100 text-green-800' : '' }}
                {{ $krs->status == 'rejected' ? 'bg-red-100 text-red-800' : '' }}
                {{ $krs->status == 'submitted' ? 'bg-yellow-100 text-yellow-800' : '' }}
                {{ $krs->status == 'draft' ? 'bg-gray-100 text-gray-800' : '' }}">
                Status: {{ ucfirst($krs->status) }}
            </span>
        </div>
    </div>

    @if(session('success'))
    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Student Info -->
        <div class="lg:col-span-1">
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 mb-6">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4 border-b border-gray-100 dark:border-gray-700 pb-2">Informasi Mahasiswa</h2>
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Lengkap</label>
                        <p class="text-lg font-medium text-gray-900 dark:text-white">{{ $krs->mahasiswa->nama }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider">NIM</label>
                        <p class="text-gray-900 dark:text-white">{{ $krs->mahasiswa->nim }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider">Prodi / Angkatan</label>
                        <p class="text-gray-900 dark:text-white">{{ $krs->mahasiswa->prodi }} / {{ $krs->mahasiswa->angkatan }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider">Semester KRS</label>
                        <p class="text-gray-900 dark:text-white">{{ $krs->semester }} (TA: {{ $krs->tahun_ajaran }})</p>
                    </div>
                </div>
            </div>

            @if($krs->status == 'submitted')
            <!-- Action Approval -->
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Tinjau Pengajuan</h2>
                <div class="flex flex-col space-y-3">
                    <form action="{{ route('admin.krs.approve', $krs->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition" onclick="return confirm('Apakah Anda yakin ingin menyetujui KRS ini?')">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Setujui KRS
                        </button>
                    </form>
                    
                    <div class="border-t border-gray-100 dark:border-gray-700 pt-3">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Alasan Penolakan (Jika ditolak)</label>
                        <form action="{{ route('admin.krs.reject', $krs->id) }}" method="POST">
                            @csrf
                            <textarea name="catatan_admin" rows="3" class="w-full rounded-lg @error('catatan_admin') border-red-500 @else border-gray-300 @enderror shadow-sm focus:border-red-500 focus:ring-red-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white text-sm" placeholder="Tuliskan alasan penolakan..."></textarea>
                            @error('catatan_admin')
                                <p class="mt-1 text-xs text-red-500 font-medium italic">{{ $message }}</p>
                            @enderror
                            <button type="submit" class="mt-2 w-full inline-flex justify-center items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition" onclick="return confirm('Apakah Anda yakin ingin MENOLAK KRS ini?')">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Tolak KRS
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endif

            @if($krs->status == 'rejected')
            <div class="bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 rounded-lg p-6">
                <h3 class="text-sm font-bold text-red-800 dark:text-red-300 uppercase mb-2">Catatan Penolakan:</h3>
                <p class="text-red-700 dark:text-red-400">{{ $krs->catatan_admin }}</p>
            </div>
            @endif
        </div>

        <!-- Course List & Dosen Assignment -->
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Daftar Mata Kuliah yang Diambil</h2>
                    <span class="text-lg font-bold text-indigo-600 dark:text-indigo-400">Total SKS: {{ $krs->total_sks }}</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Kode / Nama MK</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider text-center">SKS</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Dosen Pengajar</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($krs->mataKuliah as $mk)
                            <tr>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $mk->nama_mk }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">Semester {{ $mk->semester }}</div>
                                </td>
                                <td class="px-6 py-4 text-center text-sm text-gray-900 dark:text-white">
                                    {{ $mk->sks }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($mk->dosen)
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 mr-2">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                                </svg>
                                            </div>
                                            <span class="text-sm">{{ $mk->dosen->name }}</span>
                                        </div>
                                    @else
                                        <span class="text-sm text-gray-400 italic">Belum ditentukan</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
