<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeamMemberRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_member_id',
        'event',
        'time',
        'medal',
        'pool_length',
        'age_at_record',
        'competition',
        'country',
        'record_date',
        'sort_order',
    ];

    protected $casts = [
        'pool_length'   => 'integer',
        'age_at_record' => 'integer',
        'record_date'   => 'date',
        'sort_order'    => 'integer',
    ];

    public function teamMember(): BelongsTo
    {
        return $this->belongsTo(TeamMember::class);
    }

    /**
     * Nama negara lengkap dari kode ISO alpha-2, mis. "SG" -> "Singapura".
     */
    public function getCountryNameAttribute(): ?string
    {
        if (! $this->country) {
            return null;
        }

        return config('countries.' . strtoupper($this->country), $this->country);
    }
}