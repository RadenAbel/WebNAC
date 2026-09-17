<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeamMemberLicense extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_member_id',
        'title',
        'issuer',
        'license_number',
        'issued_date',
        'expiry_date',
        'certificate_file',
        'sort_order',
    ];

    protected $casts = [
        'issued_date' => 'date',
        'expiry_date' => 'date',
        'sort_order'  => 'integer',
    ];

    public function teamMember(): BelongsTo
    {
        return $this->belongsTo(TeamMember::class);
    }

    public function getCertificateUrlAttribute(): ?string
    {
        return $this->certificate_file ? asset('storage/' . $this->certificate_file) : null;
    }

    public function getIssuedDateLabelAttribute(): ?string
    {
        return $this->issued_date ? $this->issued_date->translatedFormat('d F Y') : null;
    }

    public function getExpiryDateLabelAttribute(): ?string
    {
        return $this->expiry_date ? $this->expiry_date->translatedFormat('d F Y') : null;
    }

    /**
     * Dipakai buat kasih tanda visual di admin/publik kalau lisensi sudah lewat masa berlaku.
     */
    public function getIsExpiredAttribute(): bool
    {
        return $this->expiry_date !== null && $this->expiry_date->isPast();
    }
}