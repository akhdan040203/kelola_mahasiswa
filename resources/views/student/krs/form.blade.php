@extends('layouts.dashboard')

@section('title', isset($krs) ? 'Edit KRS' : 'Pilih Mata Kuliah')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-6 flex items-center">
        <a href="{{ route('student.krs.index') }}" class="mr-4 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
        </a>
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
            {{ isset($krs) ? 'Ubah Rencana Studi' : 'Pengisian Kartu Rencana Studi' }}
        </h1>
    </div>

    <form action="{{ isset($krs) ? route('student.krs.update', $krs->id) : route('student.krs.store') }}" method="POST" id="krs-form">
        @csrf
        @if(isset($krs))
            @method('PUT')
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <!-- Form Info -->
            <div class="lg:col-span-1">
                <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 sticky top-6">
                    <h2 class="text-xl font-semibold mb-4 text-gray-900 dark:text-white">Informasi KRS</h2>
                    
                    <div class="space-y-4 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Semester</label>
                            <select name="semester" class="w-full rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                                <option value="Ganjil" {{ (isset($krs) && $krs->semester == 'Ganjil') ? 'selected' : '' }}>Ganjil</option>
                                <option value="Genap" {{ (isset($krs) && $krs->semester == 'Genap') ? 'selected' : '' }}>Genap</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tahun Ajaran</label>
                            <input type="text" name="tahun_ajaran" value="{{ $krs->tahun_ajaran ?? '2024/2025' }}" class="w-full rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="e.g., 2024/2025" required>
                        </div>
                    </div>

                    <div class="border-t border-gray-100 dark:border-gray-700 pt-4">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm text-gray-500 dark:text-gray-400">Total SKS Terpilih:</span>
                            <span id="total-sks-display" class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">0</span>
                        </div>
                        <p class="text-xs text-gray-400 italic mb-6">*Maksimal SKS biasanya ditentukan oleh IPK semester lalu.</p>
                        
                        <div class="flex flex-col space-y-2">
                            <button type="submit" name="submit_action" value="draft" class="w-full px-6 py-3 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 font-bold rounded-lg hover:bg-gray-200 transition">
                                Simpan Draft
                            </button>
                            <button type="submit" name="submit_action" value="submit" class="w-full px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg transition shadow-lg">
                                Simpan & Ajukan
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Course Selection -->
            <div class="lg:col-span-3">
                <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
                    <div class="p-6 border-b border-gray-100 dark:border-gray-700">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Pilih Mata Kuliah</h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Silakan pilih mata kuliah yang akan diambil untuk semester ini.</p>
                    </div>
                    
                    @php
                        $groupedMK = $mataKuliah->groupBy('semester');
                    @endphp

                    @foreach($groupedMK as $semester => $courses)
                    <div class="border-b border-gray-100 dark:border-gray-700 last:border-0">
                        <div class="bg-gray-50 dark:bg-gray-700/50 px-6 py-3">
                            <h3 class="font-bold text-gray-700 dark:text-gray-300">Semester {{ $semester }}</h3>
                        </div>
                        <div class="divide-y divide-gray-100 dark:divide-gray-700">
                            @foreach($courses as $mk)
                            <label class="flex items-center p-4 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 cursor-pointer transition">
                                <input type="checkbox" name="mata_kuliah_ids[]" value="{{ $mk->id }}" data-sks="{{ $mk->sks }}" 
                                    class="mk-checkbox w-5 h-5 rounded text-indigo-600 border-gray-300 focus:ring-indigo-500"
                                    {{ (isset($selectedIds) && in_array($mk->id, $selectedIds)) ? 'checked' : '' }}>
                                <div class="ml-4 flex-1">
                                    <div class="flex justify-between">
                                        <span class="font-medium text-gray-900 dark:text-white">{{ $mk->nama_mk }}</span>
                                        <span class="text-sm font-bold text-gray-500 dark:text-gray-400">{{ $mk->sks }} SKS</span>
                                    </div>
                                    </div>
                            </label>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkboxes = document.querySelectorAll('.mk-checkbox');
        const totalSksDisplay = document.getElementById('total-sks-display');

        function updateTotalSks() {
            let total = 0;
            checkboxes.forEach(cb => {
                if (cb.checked) {
                    total += parseInt(cb.getAttribute('data-sks'));
                }
            });
            totalSksDisplay.innerText = total;
        }

        checkboxes.forEach(cb => {
            cb.addEventListener('change', updateTotalSks);
        });

        // Initial update
        updateTotalSks();
    });
</script>
@endpush
@endsection
