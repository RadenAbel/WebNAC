<?php

namespace App\Models\Concerns;

trait HasYoutubeVideo
{
    public function getYoutubeIdAttribute(): ?string
    {
        if (! $this->youtube_url) {
            return null;
        }

        if (preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/|shorts\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $this->youtube_url, $match)) {
            return $match[1];
        }

        return null;
    }

    public function getYoutubeEmbedUrlAttribute(): ?string
    {
        return $this->youtube_id ? "https://www.youtube.com/embed/{$this->youtube_id}" : null;
    }

    public function getYoutubeBackgroundEmbedUrlAttribute(): ?string
    {
        if (! $this->youtube_id) {
            return null;
        }

        return "https://www.youtube.com/embed/{$this->youtube_id}?autoplay=1&mute=1&loop=1&playlist={$this->youtube_id}&controls=0&showinfo=0&modestbranding=1&rel=0&playsinline=1";
    }

    public function getYoutubeThumbnailUrlAttribute(): ?string
    {
        return $this->youtube_id ? "https://img.youtube.com/vi/{$this->youtube_id}/hqdefault.jpg" : null;
    }

    public function getIsVideoAttribute(): bool
    {
        return $this->type === 'video';
    }
}
