@extends('layouts.dashboard')

@section('title', 'Detail KRS Saya')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-6 flex items-center justify-between">
        <div class="flex items-center">
            <a href="{{ route('student.krs.index') }}" class="mr-4 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Detail KRS</h1>
        </div>
        <div class="flex items-center space-x-4">
            <span class="px-4 py-1.5 text-sm font-bold rounded-full shadow-sm
                {{ $krs->status == 'approved' ? 'bg-green-100 text-green-800 border border-green-200' : '' }}
                {{ $krs->status == 'rejected' ? 'bg-red-100 text-red-800 border border-red-200' : '' }}
                {{ $krs->status == 'submitted' ? 'bg-yellow-100 text-yellow-800 border border-yellow-200' : '' }}
                {{ $krs->status == 'draft' ? 'bg-gray-100 text-gray-800 border border-gray-200' : '' }}">
                {{ ucfirst($krs->status) }}
            </span>
            
            @if($krs->status == 'approved')
            <button onclick="window.print()" class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition no-print">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                Cetak KRS
            </button>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <!-- Summary Info -->
        <div class="lg:col-span-1">
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 mb-6">
                <h2 class="text-xl font-semibold mb-4 text-gray-900 dark:text-white border-b border-gray-100 dark:border-gray-700 pb-2">Ringkasan</h2>
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase">Semester / TA</label>
                        <p class="text-gray-900 dark:text-white font-medium">{{ $krs->semester }} ({{ $krs->tahun_ajaran }})</p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase">Total SKS</label>
                        <p class="text-indigo-600 dark:text-indigo-400 text-2xl font-bold">{{ $krs->total_sks }} SKS</p>
                    </div>
                    @if($krs->approved_at)
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase">Disetujui Pada</label>
                        <p class="text-gray-900 dark:text-white">{{ $krs->approved_at->format('d M Y') }}</p>
                    </div>
                    @endif
                </div>
            </div>

            @if($krs->catatan_admin && $krs->status == 'rejected')
            <div class="bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 rounded-lg p-6">
                <h3 class="text-sm font-bold text-red-800 dark:text-red-300 uppercase mb-2">Pesan dari Admin:</h3>
                <p class="text-red-700 dark:text-red-400 text-sm italic">"{{ $krs->catatan_admin }}"</p>
                <div class="mt-4">
                    <a href="{{ route('student.krs.edit', $krs->id) }}" class="inline-flex items-center text-red-600 hover:text-red-800 font-bold text-sm">
                        Perbaiki KRS
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                </div>
            </div>
            @endif
        </div>

        <!-- Course Details -->
        <div class="lg:col-span-3">
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Daftar Mata Kuliah</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Kode / Nama MK</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider text-center">Semester</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider text-center">SKS</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Dosen Pengajar</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($krs->mataKuliah as $mk)
                            <tr>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $mk->nama_mk }}</div>
                                </td>
                                <td class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                    {{ $mk->semester }}
                                </td>
                                <td class="px-6 py-4 text-center text-sm text-gray-900 dark:text-white font-bold">
                                    {{ $mk->sks }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">
                                    @if($mk->dosen)
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 mr-2">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                                </svg>
                                            </div>
                                            <span>{{ $mk->dosen->name }}</span>
                                        </div>
                                    @else
                                        <span class="text-gray-400 italic">Dosen belum ditentukan</span>
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

<style>
@media print {
    .no-print { display: none !important; }
}
</style>
@endsection
