<?php

namespace App\Models\Concerns;

trait HasYoutubeVideo
{
    /**
     * Ekstrak ID video dari berbagai format link YouTube yang umum:
     * - https://www.youtube.com/watch?v=XXXXXXXXXXX
     * - https://youtu.be/XXXXXXXXXXX
     * - https://www.youtube.com/embed/XXXXXXXXXXX
     * - https://www.youtube.com/shorts/XXXXXXXXXXX
     */
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

    /**
     * URL embed khusus buat dipakai sebagai BACKGROUND video (autoplay, mute,
     * loop, tanpa kontrol pemutar) — dipakai di Hero. Video YouTube modern
     * mewajibkan mute=1 supaya autoplay diizinkan browser.
     */
    public function getYoutubeBackgroundEmbedUrlAttribute(): ?string
    {
        if (! $this->youtube_id) {
            return null;
        }

        return "https://www.youtube.com/embed/{$this->youtube_id}?autoplay=1&mute=1&loop=1&playlist={$this->youtube_id}&controls=0&showinfo=0&modestbranding=1&rel=0&playsinline=1";
    }

    /**
     * Thumbnail otomatis dari YouTube — dipakai sebagai gambar pratinjau
     * (kartu kecil, ikon play) tanpa perlu admin upload gambar terpisah.
     */
    public function getYoutubeThumbnailUrlAttribute(): ?string
    {
        return $this->youtube_id ? "https://img.youtube.com/vi/{$this->youtube_id}/hqdefault.jpg" : null;
    }

    public function getIsVideoAttribute(): bool
    {
        return $this->type === 'video';
    }
}