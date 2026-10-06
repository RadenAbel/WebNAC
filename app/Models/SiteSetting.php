<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Mews\Purifier\Casts\CleanHtml;

class SiteSetting extends Model
{
    use HasFactory;

    private const CURRENT_CACHE_KEY = 'site_setting.current';

    protected static ?self $currentMemo = null;

    protected $fillable = [
        'site_name',
        'logo',
        'since_year',
        'whatsapp',
        'phone',
        'email',
        'instagram_url',
        'facebook_url',
        'youtube_url',
        'tiktok_url',
        'address',
        'map_embed_url',
        'opening_hours_weekday',
        'opening_hours_weekend',
        'about_title',
        'about_description',
        'about_photo',
        'classes_section_photo',
        'pool_section_photo',
        'pool_section_title',
        'pool_section_description',
        'join_cta_photo',
        'join_cta_title',
        'join_cta_description',
        'gallery_header_type',
        'gallery_header_photo',
        'gallery_header_youtube_url',
        'event_header_type',
        'event_header_photo',
        'event_header_youtube_url',
        'team_header_type',
        'team_header_photo',
        'team_header_youtube_url',
        'join_header_type',
        'join_header_photo',
        'join_header_youtube_url',
    ];

    protected $casts = [
        'about_description' => CleanHtml::class . ':rich_text',
    ];

    public function getLogoUrlAttribute(): ?string
    {
        return $this->logo ? asset('storage/' . $this->logo) : null;
    }

    public function getAboutPhotoUrlAttribute(): ?string
    {
        return $this->about_photo ? asset('storage/' . $this->about_photo) : null;
    }

    public function getClassesSectionPhotoUrlAttribute(): ?string
    {
        return $this->classes_section_photo ? asset('storage/' . $this->classes_section_photo) : null;
    }

    public function getPoolSectionPhotoUrlAttribute(): ?string
    {
        return $this->pool_section_photo ? asset('storage/' . $this->pool_section_photo) : null;
    }

    public function getJoinCtaPhotoUrlAttribute(): ?string
    {
        return $this->join_cta_photo ? asset('storage/' . $this->join_cta_photo) : null;
    }

    public function getGalleryHeaderPhotoUrlAttribute(): ?string
    {
        return $this->gallery_header_photo ? asset('storage/' . $this->gallery_header_photo) : null;
    }

    public function getGalleryHeaderYoutubeIdAttribute(): ?string
    {
        if (! $this->gallery_header_youtube_url) {
            return null;
        }

        if (preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/|shorts\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $this->gallery_header_youtube_url, $match)) {
            return $match[1];
        }

        return null;
    }

    public function getGalleryHeaderVideoEmbedUrlAttribute(): ?string
    {
        $id = $this->gallery_header_youtube_id;

        if (! $id) {
            return null;
        }

        return "https://www.youtube.com/embed/{$id}?autoplay=1&mute=1&loop=1&playlist={$id}&controls=0&showinfo=0&modestbranding=1&rel=0&playsinline=1";
    }

    public function getEventHeaderPhotoUrlAttribute(): ?string
    {
        return $this->event_header_photo ? asset('storage/' . $this->event_header_photo) : null;
    }

    public function getEventHeaderYoutubeIdAttribute(): ?string
    {
        if (! $this->event_header_youtube_url) {
            return null;
        }

        if (preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/|shorts\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $this->event_header_youtube_url, $match)) {
            return $match[1];
        }

        return null;
    }

    public function getEventHeaderVideoEmbedUrlAttribute(): ?string
    {
        $id = $this->event_header_youtube_id;

        if (! $id) {
            return null;
        }

        return "https://www.youtube.com/embed/{$id}?autoplay=1&mute=1&loop=1&playlist={$id}&controls=0&showinfo=0&modestbranding=1&rel=0&playsinline=1";
    }

    public function getTeamHeaderPhotoUrlAttribute(): ?string
    {
        return $this->team_header_photo ? asset('storage/' . $this->team_header_photo) : null;
    }

    public function getTeamHeaderYoutubeIdAttribute(): ?string
    {
        if (! $this->team_header_youtube_url) {
            return null;
        }

        if (preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/|shorts\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $this->team_header_youtube_url, $match)) {
            return $match[1];
        }

        return null;
    }

    public function getTeamHeaderVideoEmbedUrlAttribute(): ?string
    {
        $id = $this->team_header_youtube_id;

        if (! $id) {
            return null;
        }

        return "https://www.youtube.com/embed/{$id}?autoplay=1&mute=1&loop=1&playlist={$id}&controls=0&showinfo=0&modestbranding=1&rel=0&playsinline=1";
    }

    public function getJoinHeaderPhotoUrlAttribute(): ?string
    {
        return $this->join_header_photo ? asset('storage/' . $this->join_header_photo) : null;
    }

    public function getJoinHeaderYoutubeIdAttribute(): ?string
    {
        if (! $this->join_header_youtube_url) {
            return null;
        }

        if (preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/|shorts\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $this->join_header_youtube_url, $match)) {
            return $match[1];
        }

        return null;
    }

    public function getJoinHeaderVideoEmbedUrlAttribute(): ?string
    {
        $id = $this->join_header_youtube_id;

        if (! $id) {
            return null;
        }

        return "https://www.youtube.com/embed/{$id}?autoplay=1&mute=1&loop=1&playlist={$id}&controls=0&showinfo=0&modestbranding=1&rel=0&playsinline=1";
    }

    public function getWhatsappUrlAttribute(): ?string
    {
        if (! $this->whatsapp) {
            return null;
        }

        $digitsOnly = preg_replace('/\D/', '', $this->whatsapp);

        return "https://wa.me/{$digitsOnly}";
    }

    public static function current(): self
    {
        if (static::$currentMemo) {
            return static::$currentMemo;
        }

        $attributes = Cache::get(self::CURRENT_CACHE_KEY);

        if (! is_array($attributes)) {
            $attributes = static::query()->firstOrCreate([], [
                'site_name' => 'Nugroho Aquatic Club',
            ])->getAttributes();

            Cache::forever(self::CURRENT_CACHE_KEY, $attributes);
        }

        return static::$currentMemo = (new static)->newFromBuilder($attributes);
    }

    public static function flushCurrentCache(): void
    {
        static::$currentMemo = null;
        Cache::forget(self::CURRENT_CACHE_KEY);
    }

    protected static function booted(): void
    {
        static::saved(fn () => static::flushCurrentCache());
        static::deleted(fn () => static::flushCurrentCache());
    }
}
