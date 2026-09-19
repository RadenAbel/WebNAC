<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class JoinRequest extends Model
{
    protected $fillable = [
        'name',
        'nickname',
        'birth_date',
        'whatsapp',
        'category',
        'photo',
        'status',
        'responded_at',
    ];

    protected $casts = [
        'birth_date'   => 'date',
        'responded_at' => 'datetime',
    ];

    public function getPhotoUrlAttribute(): ?string
    {
        return $this->photo ? asset('storage/' . $this->photo) : null;
    }

    public function getBirthDateLabelAttribute(): ?string
    {
        return $this->birth_date ? $this->birth_date->translatedFormat('d F Y') : null;
    }

    /**
     * Normalisasi nomor WhatsApp ke format internasional TANPA "+" (syarat
     * link wa.me) — terima input umum orang Indonesia: "08...", "8...",
     * "+62...", "62...". Kalau setelah dibersihkan formatnya masih tidak
     * masuk akal (kurang dari 9 digit), return null — biar wa.me link
     * tidak pernah dibuat dari nomor yang jelas-jelas rusak.
     */
    public function getWhatsappNormalizedAttribute(): ?string
    {
        $digits = preg_replace('/\D/', '', (string) $this->whatsapp);

        if (! $digits) {
            return null;
        }

        if (str_starts_with($digits, '0')) {
            $digits = '62' . substr($digits, 1);
        } elseif (! str_starts_with($digits, '62')) {
            $digits = '62' . $digits;
        }

        return strlen($digits) >= 10 ? $digits : null;
    }

    /**
     * Link wa.me siap pakai, dengan pesan sudah ke-URL-encode. $message
     * WAJIB dikirim dari luar (bukan hardcode di sini) — supaya isi pesan
     * penerimaan/penolakan gampang diubah tanpa sentuh model ini.
     */
    public function whatsappLink(string $message): ?string
    {
        $number = $this->whatsapp_normalized;

        if (! $number) {
            return null;
        }

        return 'https://wa.me/' . $number . '?text=' . rawurlencode($message);
    }

    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', 'pending');
    }

    public function scopeLatestFirst(Builder $query): Builder
    {
        return $query->orderByDesc('created_at');
    }
}