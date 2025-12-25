<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        // 1. Cek apakah user login
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        // 2. Cek apakah role user sesuai dengan yang diminta route
        // Contoh: route minta 'admin', tapi user role-nya 'customer' -> TOLAK
        if (Auth::user()->role !== $role) {
            abort(403, 'Akses Ditolak! Anda bukan ' . ucfirst($role));
        }

        return $next($request);
    }
}