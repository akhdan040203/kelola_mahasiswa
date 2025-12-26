<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get statistics for admin
        if ($user->hasRole('admin')) {
            $stats = [
                'total_news' => News::count(),
                'total_users' => User::count(),
                'recent_news' => News::latest()->take(5)->get(),
            ];
            
            return view('dashboard.admin', compact('stats'));
        }
        
        // Dosen dashboard
        if ($user->hasRole('dosen')) {
            return view('dashboard.dosen');
        }
        
        // Siswa dashboard
        if ($user->hasRole('siswa')) {
            return view('dashboard.siswa');
        }
        
        // Default fallback
        return view('dashboard.default');
    }
}
