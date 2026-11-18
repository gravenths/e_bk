<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class DenyViewer
{
    /**
     * Blok semua request write (POST/PUT/PATCH/DELETE) dari akun role Viewer.
     * Logout (POST /logout) tetap diizinkan agar Viewer bisa keluar.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (
            Auth::check() &&
            Auth::user()->role === 'Viewer' &&
            !in_array($request->method(), ['GET', 'HEAD']) &&
            !$request->is('logout')
        ) {
            return redirect()->back()
                ->with('error', 'Akun Viewer hanya memiliki akses baca. Modifikasi data tidak diizinkan.');
        }

        return $next($request);
    }
}
