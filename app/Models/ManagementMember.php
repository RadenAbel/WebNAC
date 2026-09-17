<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManagementMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'position',
        'photo',
        'short_bio',
        'full_bio',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active'  => 'boolean',
        'sort_order' => 'integer',
    ];

    public function getPhotoUrlAttribute(): ?string
    {
        return $this->photo ? asset('storage/' . $this->photo) : null;
    }

    /**
     * Bio lengkap dipecah jadi array per paragraf — admin nulisnya di satu
     * textarea biasa, tiap paragraf dipisah baris kosong (kayak nulis email/
     * dokumen biasa). Dipakai di modal detail halaman Tentang Kami, supaya
     * tiap paragraf jadi <p> terpisah, bukan satu blok teks panjang.
     */
    public function getFullBioParagraphsAttribute(): array
    {
        if (! $this->full_bio) {
            return [];
        }

        $paragraphs = preg_split('/\r?\n\r?\n/', trim($this->full_bio));

        return array_values(array_filter(array_map('trim', $paragraphs)));
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }
}