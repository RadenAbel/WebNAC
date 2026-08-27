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
    ];

    public function getLogoUrlAttribute(): ?string
    {
        return $this->logo ? asset('storage/' . $this->logo) : null;
    }

    public function getAboutPhotoUrlAttribute(): ?string
    {
        return $this->about_photo ? asset('storage/' . $this->about_photo) : null;
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