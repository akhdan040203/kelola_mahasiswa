<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    public function handle(Request $request, Closure $next, string $permission)
    {
        if (!Auth::check()) {
            abort(403, 'Kamu belum login.');
        }

        $user = Auth::user(); // sekarang dikenali lebih baik oleh editor

        if (!$user || !$user->hasPermission($permission)) {
            abort(403, 'Kamu tidak punya akses.');
        }

        return $next($request);
    }
}
