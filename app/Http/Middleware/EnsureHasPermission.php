<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureHasPermission
{
    /**
     * Dipakai di route lewat: Route::middleware('permission:sliders')
     * — $section otomatis terisi "sliders" dari parameter setelah titik dua.
     * Selalu dipasang SETELAH middleware 'auth' (supaya request()->user()
     * pasti ada).
     */
    public function handle(Request $request, Closure $next, string $section): Response
    {
        if (! $request->user() || ! $request->user()->canAccess($section)) {
            abort(403, 'Anda tidak memiliki izin akses ke bagian ini. Hubungi Super Admin kalau merasa ini seharusnya bisa diakses.');
        }

        return $next($request);
    }
}