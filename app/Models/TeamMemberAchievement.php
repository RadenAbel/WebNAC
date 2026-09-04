<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeamMemberAchievement extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_member_id',
        'title',
        'year',
        'country',
        'description',
        'sort_order',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    public function teamMember(): BelongsTo
    {
        return $this->belongsTo(TeamMember::class);
    }

    /**
     * Nama negara lengkap dari kode ISO alpha-2, mis. "ID" -> "Indonesia".
     * Diambil dari config/countries.php.
     */
    public function getCountryNameAttribute(): ?string
    {
        if (! $this->country) {
            return null;
        }

        return config('countries.' . strtoupper($this->country), $this->country);
    }

    /**
     * Konversi kode negara ISO alpha-2 jadi emoji bendera, mis. "ID" -> 🇮🇩.
     * Caranya: tiap huruf digeser ke "Regional Indicator Symbol" di Unicode
     * (offset 127397 dari kode ASCII huruf kapital) — teknik standar untuk
     * menampilkan bendera tanpa perlu file gambar/ikon terpisah.
     */
    public function getFlagEmojiAttribute(): ?string
    {
        if (! $this->country || strlen($this->country) !== 2) {
            return null;
        }

        $codePoints = array_map(
            fn ($char) => 127397 + ord($char),
            str_split(strtoupper($this->country))
        );

        return implode('', array_map('mb_chr', $codePoints));
    }
}