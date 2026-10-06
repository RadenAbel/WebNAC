<?php

namespace App\Models;

use App\Models\Concerns\FlushesPublicCache;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Event extends Model
{
    use HasFactory, FlushesPublicCache;

    protected $fillable = [
        'title',
        'slug',
        'photo',
        'event_date',
        'location',
        'description',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'event_date' => 'date',
        'is_active'  => 'boolean',
        'sort_order' => 'integer',
    ];

    protected static function booted(): void
    {
        static::saving(function (Event $event) {
            if (! $event->slug || $event->isDirty('title')) {
                $event->slug = static::uniqueSlug($event->title, $event->id);
            }
        });
    }

    public static function uniqueSlug(?string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug((string) $title) ?: 'kejuaraan';
        $slug = $base;
        $i = 2;

        while (static::where('slug', $slug)
            ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
            ->exists()) {
            $slug = "{$base}-{$i}";
            $i++;
        }

        return $slug;
    }

    public function results(): HasMany
    {
        return $this->hasMany(EventResult::class);
    }

    public function getPhotoUrlAttribute(): ?string
    {
        return $this->photo ? asset('storage/' . $this->photo) : null;
    }

    public function getEventDateLabelAttribute(): ?string
    {
        return $this->event_date ? $this->event_date->translatedFormat('d F Y') : null;
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true)
            ->orderBy('sort_order')
            ->orderByDesc('event_date');
    }
}
