<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public const DEFAULT = 'id';

    public function handle(Request $request, Closure $next): Response
    {
        app()->setLocale(self::DEFAULT);
        Carbon::setLocale(self::DEFAULT);

        return $next($request);
    }
}
