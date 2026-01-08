@extends('layouts.dashboard')

@section('title', 'Manajemen KRS Mahasiswa')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Manajemen KRS</h1>
    </div>

    <!-- Filter Status -->
    <div class="mb-6 flex space-x-2">
        <a href="{{ route('admin.krs.index', ['status' => 'all']) }}" 
            class="px-4 py-2 rounded-lg text-sm font-medium {{ $status == 'all' ? 'bg-indigo-600 text-white' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600' }}">
            Semua
        </a>
        <a href="{{ route('admin.krs.index', ['status' => 'submitted']) }}" 
            class="px-4 py-2 rounded-lg text-sm font-medium {{ $status == 'submitted' ? 'bg-indigo-600 text-white' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600' }}">
            Perlu Review
        </a>
        <a href="{{ route('admin.krs.index', ['status' => 'approved']) }}" 
            class="px-4 py-2 rounded-lg text-sm font-medium {{ $status == 'approved' ? 'bg-indigo-600 text-white' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600' }}">
            Disetujui
        </a>
        <a href="{{ route('admin.krs.index', ['status' => 'rejected']) }}" 
            class="px-4 py-2 rounded-lg text-sm font-medium {{ $status == 'rejected' ? 'bg-indigo-600 text-white' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600' }}">
            Ditolak
        </a>
    </div>

    @if(session('success'))
    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif

    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Mahasiswa</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Semester / TA</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">SKS Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Submit Pada</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($krs as $item)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $item->mahasiswa->nama }}</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ $item->mahasiswa->nim }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            {{ $item->semester }}<br>
                            <span class="text-xs text-gray-400 italic">TA: {{ $item->tahun_ajaran }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                            {{ $item->total_sks }} SKS
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $item->status == 'approved' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $item->status == 'rejected' ? 'bg-red-100 text-red-800' : '' }}
                                {{ $item->status == 'submitted' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $item->status == 'draft' ? 'bg-gray-100 text-gray-800' : '' }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            {{ $item->submitted_at ? $item->submitted_at->format('d M Y H:i') : '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('admin.krs.show', $item->id) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 font-bold">
                                Review Details
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center text-sm text-gray-500 dark:text-gray-400">
                            Tidak ada pengajuan KRS dengan status ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700">
            {{ $krs->links() }}
        </div>
    </div>
</div>
@endsection
