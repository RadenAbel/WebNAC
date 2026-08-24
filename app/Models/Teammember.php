<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class TeamMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'photo',
        'age',
        'role',
        'category',
        'bio',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'age'       => 'integer',
        'sort_order' => 'integer',
        'best_times'   => 'array',
        'competitions' => 'array',
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