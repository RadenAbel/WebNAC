<?php

namespace App\Support;

use Closure;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Facades\Cache;

class PublicCache
{
    public const TTL = 600;

    private const VERSION_KEY = 'public_cache.version';

    private static ?int $version = null;

    public static function remember(string $key, Closure $callback): mixed
    {
        return Cache::remember(static::key($key), self::TTL, $callback);
    }

    public static function models(string $key, string $modelClass, Closure $query): EloquentCollection
    {
        $rows = static::remember($key, function () use ($query) {
            return $query()->map(fn ($model) => $model->getAttributes())->values()->all();
        });

        return $modelClass::hydrate($rows);
    }

    public static function flush(): void
    {
        $next = static::version() + 1;
        Cache::forever(self::VERSION_KEY, $next);
        static::$version = $next;
    }

    private static function version(): int
    {
        return static::$version ??= (int) Cache::get(self::VERSION_KEY, 1);
    }

    private static function key(string $key): string
    {
        return 'public.v' . static::version() . '.' . $key;
    }
}
