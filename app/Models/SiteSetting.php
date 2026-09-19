<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use HasFactory;

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

    public function getGalleryHeaderPhotoUrlAttribute(): ?string
    {
        return $this->gallery_header_photo ? asset('storage/' . $this->gallery_header_photo) : null;
    }

    /**
     * Ekstrak ID video YouTube dari link header Galeri. Ditulis manual
     * (bukan pakai trait HasYoutubeVideo) karena nama kolomnya beda —
     * SiteSetting punya banyak field YouTube berbeda (channel sosmed,
     * header Galeri, dst), tidak cuma satu seperti Gallery/Slider.
     */
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

    /**
     * Bentuk link https://wa.me/... otomatis dari nomor WA yang diinput
     * admin (boleh diketik pakai spasi/strip/+, di sini dibersihkan dulu).
     */
    public function getWhatsappUrlAttribute(): ?string
    {
        if (! $this->whatsapp) {
            return null;
        }

        $digitsOnly = preg_replace('/\D/', '', $this->whatsapp);

        return "https://wa.me/{$digitsOnly}";
    }

    /**
     * Ambil satu-satunya baris pengaturan situs. Kalau belum pernah diisi
     * sama sekali (fresh install, admin belum buka menu Pengaturan),
     * otomatis dibuatkan baris kosong dengan nilai default supaya blade
     * view tidak error saat memanggil SiteSetting::current()->whatsapp dst.
     */
    public static function current(): self
    {
        return static::query()->firstOrCreate([], [
            'site_name' => 'Nugroho Aquatic Center',
        ]);
    }
}