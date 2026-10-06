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
        'event_date',
        'country',
        'description',
        'sort_order',
    ];

    protected $casts = [
        'event_date'   => 'date',
        'sort_order'   => 'integer',
    ];

    public function teamMember(): BelongsTo
    {
        return $this->belongsTo(TeamMember::class);
    }

    public function getEventDateLabelAttribute(): ?string
    {
        return $this->event_date ? $this->event_date->translatedFormat('d F Y') : null;
    }

    public function getCountryNameAttribute(): ?string
    {
        if (! $this->country) {
            return null;
        }

        return config('countries.' . strtoupper($this->country), $this->country);
    }

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
