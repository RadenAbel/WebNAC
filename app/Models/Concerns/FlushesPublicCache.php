<?php

namespace App\Models\Concerns;

use App\Support\PublicCache;

trait FlushesPublicCache
{
    public static function bootFlushesPublicCache(): void
    {
        static::saved(fn () => PublicCache::flush());
        static::deleted(fn () => PublicCache::flush());
    }
}
