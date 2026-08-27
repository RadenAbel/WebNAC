<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TeamMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'photo',
        'whatsapp',
        'instagram_url',
        'facebook_url',
        'tiktok_url',
        'age',
        'role',
        'category',
        'origin_city',
        'years_experience',
        'total_medals',
        'total_achievements',
        'bio',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active'          => 'boolean',
        'age'                => 'integer',
        'years_experience'   => 'integer',
        'total_medals'       => 'integer',
        'total_achievements' => 'integer',
        'sort_order'         => 'integer',
    ];

    /**
     * Accessor untuk URL foto lengkap (kalau disimpan di storage/public).
     */
    public function getPhotoUrlAttribute(): string
    {
        return $this->photo
            ? asset('storage/' . $this->photo)
            : asset('images/default-avatar.jpg');
    }

    /**
     * Rekor waktu terbaik milik anggota tim ini, terurut sesuai sort_order.
     */
    public function records(): HasMany
    {
        return $this->hasMany(TeamMemberRecord::class)->orderBy('sort_order');
    }

    /**
     * Pencapaian & penghargaan milik anggota tim ini.
     */
    public function achievements(): HasMany
    {
        return $this->hasMany(TeamMemberAchievement::class)->orderBy('sort_order');
    }

    /**
     * Scope: hanya pelatih
     */
    public function scopePelatih(Builder $query): Builder
    {
        return $query->where('role', 'pelatih');
    }

    /**
     * Scope: hanya atlit
     */
    public function scopeAtlet(Builder $query): Builder
    {
        return $query->where('role', 'atlet');
    }

    /**
     * Scope: hanya yang aktif, urut sesuai sort_order lalu nama
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name');
    }
}