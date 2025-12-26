<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    /**
     * Display homepage with latest 2 news
     */
    public function index()
    {
        // Ambil 2 berita terbaru untuk preview di homepage
        $latestNews = News::with('author')
            ->latest()
            ->take(2)
            ->get();

        return view('landingpage', ['latestNews' => $latestNews]);
    }

    /**
     * Display all news
     */
    public function allNews()
    {
        // Ambil semua berita dengan pagination
        $news = News::with('author')
            ->latest()
            ->paginate(9); // 9 berita per halaman

        return view('public.news', ['news' => $news]);
    }

    /**
     * Display single news detail
     */
    public function showNews(News $news)
    {
        // Load relasi author
        $news->load('author');

        // Ambil berita terkait (3 berita terbaru selain yang sedang dibuka)
        $relatedNews = News::where('id', '!=', $news->id)
            ->latest()
            ->take(3)
            ->get();

        return view('public.news-detail', [
            'news' => $news,
            'relatedNews' => $relatedNews
        ]);
    }
}
