<?php

namespace App\Models;

use App\Models\Concerns\FlushesPublicCache;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Concerns\HasYoutubeVideo;

class Slider extends Model
{
    use HasFactory, HasYoutubeVideo, FlushesPublicCache;

    protected $fillable = [
        'image',
        'type',
        'youtube_url',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active'  => 'boolean',
        'sort_order' => 'integer',
    ];

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