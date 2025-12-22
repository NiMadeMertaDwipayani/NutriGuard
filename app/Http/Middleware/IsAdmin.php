<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sudah login DAN role-nya adalah 'admin'
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            // Jika bukan admin, tampilkan error 403 (Forbidden)
            abort(403, 'AKSES DITOLAK: Halaman ini khusus Admin NutriGuard.');
        }

        return $next($request);
    }
}
