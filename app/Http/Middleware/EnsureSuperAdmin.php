<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureSuperAdmin
{
    /**
     * Membatasi akses HANYA untuk akun dengan role 'super_admin' — dipakai
     * untuk route Pengaturan Situs dan Kelola Akun Admin. Selalu dipasang
     * SETELAH middleware 'auth' di route (supaya auth()->user() pasti ada).
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user() || ! $request->user()->isSuperAdmin()) {
            abort(403, 'Halaman ini khusus untuk Super Admin.');
        }

        return $next($request);
    }
}