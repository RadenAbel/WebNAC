<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'photo',
        'event_date',
        'description',
        'pdf_report',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'event_date' => 'date',
        'is_active'  => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * URL foto. Return null (bukan gambar fallback) kalau belum ada foto —
     * supaya tampilan bisa munculkan placeholder "No Image" yang rapi,
     * sama seperti pola di TeamMember.
     */
    public function getPhotoUrlAttribute(): ?string
    {
        return $this->photo ? asset('storage/' . $this->photo) : null;
    }

    /**
     * URL laporan PDF kegiatan.
     */
    public function getPdfUrlAttribute(): ?string
    {
        return $this->pdf_report ? asset('storage/' . $this->pdf_report) : null;
    }

    /**
     * Tanggal siap tampil, mis. "17 Agustus 2026".
     */
    public function getEventDateLabelAttribute(): ?string
    {
        return $this->event_date ? $this->event_date->translatedFormat('d F Y') : null;
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true)
            ->orderBy('sort_order')
            ->orderByDesc('event_date');
    }
}