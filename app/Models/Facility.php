<?php

namespace App\Models;

use App\Models\Concerns\FlushesPublicCache;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    use FlushesPublicCache;

    protected $fillable = [
        'name',
        'description',
        'highlights',
        'photo',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'sort_order' => 'integer',
        'is_active'  => 'boolean',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

    public function getPhotoUrlAttribute(): ?string
    {
        return $this->photo ? asset('storage/' . $this->photo) : null;
    }

    /** Poin keunggulan sebagai array — disimpan 1 baris per poin. */
    public function getHighlightListAttribute(): array
    {
        if (! $this->highlights) {
            return [];
        }

        return collect(preg_split('/\r\n|\r|\n/', $this->highlights))
            ->map(fn ($line) => trim($line))
            ->filter()
            ->values()
            ->all();
    }
} 