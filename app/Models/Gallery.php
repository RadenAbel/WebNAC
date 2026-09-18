<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Concerns\HasYoutubeVideo;

class Gallery extends Model
{
    use HasFactory, HasYoutubeVideo;

    protected $fillable = [
        'image',
        'type',
        'youtube_url',
        'caption',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active'  => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Kalau type = photo, pakai foto yang diupload admin. Kalau type = video,
     * otomatis pakai thumbnail YouTube-nya (admin tidak perlu upload gambar
     * terpisah untuk item video).
     */
    public function getImageUrlAttribute(): ?string
    {
        if ($this->type === 'video') {
            return $this->youtube_thumbnail_url;
        }

        return $this->image ? asset('storage/' . $this->image) : null;
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }
}