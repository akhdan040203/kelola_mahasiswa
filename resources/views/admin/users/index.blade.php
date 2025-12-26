@extends('layouts.dashboard')

@section('title', 'Kelola Users')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8 text-center">
        <div class="inline-flex items-center justify-center w-20 h-20 bg-purple-100 dark:bg-purple-900 rounded-full mb-6">
            <svg class="w-10 h-10 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
        </div>
        
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
            Kelola Users & Roles
        </h1>
        
        <p class="text-gray-600 dark:text-gray-400 mb-8 max-w-md mx-auto">
            Fitur ini sedang dalam pengembangan. Anda akan dapat mengelola users, assign roles, manage permissions, dan kontrol akses sistem.
        </p>
        
        <div class="flex justify-center space-x-4">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali ke Dashboard
            </a>
        </div>
    </div>
</div>
@endsection
