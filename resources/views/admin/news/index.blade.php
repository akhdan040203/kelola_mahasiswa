@extends('layouts.dashboard')

@section('title', 'Daftar Berita')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Daftar Berita</h2>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Kelola semua berita di sini</p>
        </div>
        <a href="{{ route('admin.news.create') }}" 
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            <span>Tambah Berita</span>
        </a>
    </div>

    <!-- News List -->
<div class="bg-white/80 dark:bg-gray-950/50 backdrop-blur-md rounded-[2rem] border border-gray-100 dark:border-white/5 shadow-sm overflow-hidden">
    @if($news->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b border-gray-100 dark:border-white/5">
                        <th class="px-8 py-5 text-left text-[11px] font-bold text-gray-400 uppercase tracking-[0.15em]">#</th>
                        <th class="px-6 py-5 text-left text-[11px] font-bold text-gray-400 uppercase tracking-[0.15em]">Konten</th>
                        <th class="px-6 py-5 text-left text-[11px] font-bold text-gray-400 uppercase tracking-[0.15em]">Info Penulis</th>
                        <th class="px-6 py-5 text-left text-[11px] font-bold text-gray-400 uppercase tracking-[0.15em]">Status & Waktu</th>
                        <th class="px-8 py-5 text-right text-[11px] font-bold text-gray-400 uppercase tracking-[0.15em]">Opsi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 dark:divide-white/[0.02]">
                    @foreach($news as $index => $item)
                    <tr class="group hover:bg-gray-50/50 dark:hover:bg-white/[0.02] transition-all duration-300">
                        <td class="px-8 py-6 whitespace-nowrap text-sm font-medium text-gray-400">
                            {{ Str::padLeft($news->firstItem() + $index, 2, '0') }}
                        </td>

                        <td class="px-6 py-6">
                            <div class="flex items-center gap-4">
                                <div class="relative flex-shrink-0">
                                    @if($item->image)
                                        <img src="{{ asset($item->image) }}" alt="Thumbnail" 
                                             class="h-14 w-20 object-cover rounded-2xl shadow-sm group-hover:scale-105 transition-transform duration-500">
                                    @else
                                        <div class="h-14 w-20 bg-gray-100 dark:bg-gray-800 rounded-2xl flex items-center justify-center border border-dashed border-gray-300 dark:border-gray-700">
                                            <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="max-w-xs">
                                    <div class="text-sm font-bold text-gray-800 dark:text-gray-200 group-hover:text-indigo-600 transition-colors line-clamp-1">
                                        {{ $item->title }}
                                    </div>
                                    <div class="text-[12px] text-gray-400 mt-1 line-clamp-1 font-medium">
                                        {{ Str::limit(strip_tags($item->body), 50) }}
                                    </div>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-6 whitespace-nowrap">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 bg-indigo-100 dark:bg-indigo-500/20 text-indigo-600 dark:text-indigo-400 rounded-full flex items-center justify-center text-[10px] font-bold">
                                    {{ substr($item->author->name, 0, 1) }}
                                </div>
                                <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">{{ $item->author->name }}</span>
                            </div>
                        </td>

                        <td class="px-6 py-6 whitespace-nowrap">
                            <span class="text-[12px] font-bold text-gray-500 dark:text-gray-400 block italic">
                                {{ $item->created_at->translatedFormat('d M, Y') }}
                            </span>
                        </td>

                        <td class="px-8 py-6 whitespace-nowrap text-right">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.news.edit', $item->id) }}" 
                                   class="p-2.5 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 dark:hover:bg-indigo-500/10 rounded-xl transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                
                                <form action="{{ route('admin.news.destroy', $item->id) }}" 
                                      method="POST" 
                                      onsubmit="return confirm('Hapus berita ini?')"
                                      class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2.5 text-gray-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-500/10 rounded-xl transition-all">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="px-8 py-6 border-t border-gray-50 dark:border-white/5 bg-gray-50/30 dark:bg-transparent">
            {{ $news->links() }}
        </div>

    @else
        <div class="py-24 flex flex-col items-center justify-center text-center">
            <div class="relative mb-6">
                <div class="absolute inset-0 bg-indigo-500/10 blur-3xl rounded-full"></div>
                <div class="relative w-20 h-20 bg-white dark:bg-gray-900 shadow-xl rounded-[2rem] flex items-center justify-center border border-gray-100 dark:border-white/5">
                    <svg class="w-10 h-10 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l4 4v10a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
            </div>
            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Daftar Berita Kosong</h3>
            <p class="mt-2 text-sm text-gray-400 max-w-xs mx-auto">Sepertinya Anda belum menulis berita apapun. Mari mulai buat konten hari ini!</p>
            <a href="{{ route('admin.news.create') }}" 
               class="mt-8 inline-flex items-center px-6 py-3 rounded-2xl text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 hover:shadow-lg hover:shadow-indigo-500/30 transition-all active:scale-95">
               <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                   <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
               </svg>
               Buat Berita Pertama
            </a>
        </div>
    @endif
</div>
</div>
@endsection
