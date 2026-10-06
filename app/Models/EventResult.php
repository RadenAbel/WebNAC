<?php

namespace App\Models;

use App\Models\Concerns\FlushesPublicCache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;

class EventResult extends Model
{
    use FlushesPublicCache;

    public const GENDERS = [
        'putra'    => 'Putra',
        'putri'    => 'Putri',
        'campuran' => 'Campuran',
    ];

    protected $fillable = [
        'event_id',
        'swim_event',
        'age_group',
        'gender',
        'team_member_id',
        'athlete_name',
        'school_name',
        'birth_date',
        'club',
        'heat',
        'lane',
        'rank',
        'time',
        'note',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'heat'       => 'integer',
        'lane'       => 'integer',
        'rank'       => 'integer',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function teamMember(): BelongsTo
    {
        return $this->belongsTo(TeamMember::class);
    }

    public function getGenderLabelAttribute(): string
    {
        return self::GENDERS[$this->gender] ?? ucfirst((string) $this->gender);
    }

    public function getMedalAttribute(): ?string
    {
        return match ($this->rank) {
            1 => 'gold',
            2 => 'silver',
            3 => 'bronze',
            default => null,
        };
    }

    /**
     * Terima input waktu seperti "32.45", "1:02.45", "1.02.45" atau "00:32:45"
     * (menit:detik:perseratus) dan ubah ke detik.
     */
    public static function timeToSeconds(?string $time): ?float
    {
        $time = trim(str_replace(',', '.', (string) $time));
        if ($time === '') {
            return null;
        }

        if (preg_match('/^(\d{1,2})[:.](\d{1,2})[:.](\d{1,2})$/', $time, $m)) {
            return (int) $m[1] * 60 + (int) $m[2] + (int) str_pad($m[3], 2, '0') / 100;
        }

        if (preg_match('/^(\d{1,2}):(\d{1,2}(?:\.\d{1,2})?)$/', $time, $m)) {
            return (int) $m[1] * 60 + (float) $m[2];
        }

        if (preg_match('/^\d{1,4}(?:\.\d{1,2})?$/', $time)) {
            return (float) $time;
        }

        return null;
    }

    /** Format detik ke "mm:ss.cc", mis. 00:32.45. */
    public static function formatTime(float $seconds): string
    {
        $cs = (int) round($seconds * 100);

        return sprintf('%02d:%02d.%02d', intdiv($cs, 6000), intdiv($cs % 6000, 100), $cs % 100);
    }

    /** Gap ke juara: "+00.65" atau "+01:02.30" bila lebih dari semenit. */
    public static function formatGap(float $seconds): string
    {
        $cs = (int) round($seconds * 100);

        if ($cs < 6000) {
            return sprintf('+%02d.%02d', intdiv($cs, 100), $cs % 100);
        }

        return '+' . self::formatTime($seconds);
    }

    /**
     * Isi gap_label tiap baris dalam satu nomor lomba, dihitung dari waktu juara.
     * Juara selalu "00.00"; baris tanpa waktu valid (DQ/DNS/DNF) tanpa gap.
     */
    public static function assignGapLabels(Collection $rows): void
    {
        $valid = $rows->filter(fn ($r) => ! $r->note && self::timeToSeconds($r->time) !== null);
        $leader = $valid->firstWhere('rank', 1) ?? $valid->sortBy(fn ($r) => self::timeToSeconds($r->time))->first();
        $leaderSeconds = $leader ? self::timeToSeconds($leader->time) : null;

        $rows->each(function ($r) use ($leader, $leaderSeconds) {
            $sec = $r->note ? null : self::timeToSeconds($r->time);

            $r->gap_label = match (true) {
                $leader === null || $sec === null => null,
                $r->is($leader)                   => '00.00',
                default                           => self::formatGap(max(0, $sec - $leaderSeconds)),
            };
        });
    }

    public function setTimeAttribute(?string $value): void
    {
        $seconds = self::timeToSeconds($value);
        $this->attributes['time'] = $seconds === null ? (filled($value) ? trim($value) : null) : self::formatTime($seconds);
    }

    public function getTimeLabelAttribute(): ?string
    {
        $seconds = self::timeToSeconds($this->time);

        return $seconds === null ? $this->time : self::formatTime($seconds);
    }

    public function getSchoolLabelAttribute(): ?string
    {
        return $this->school_name ?: ($this->teamMember?->school_name ?: null);
    }

    public function getBirthDateLabelAttribute(): ?string
    {
        return $this->birth_date ? $this->birth_date->translatedFormat('d M Y') : null;
    }

    public function getProfileUrlAttribute(): ?string
    {
        $member = $this->teamMember;

        return ($member && $member->is_active && $member->slug)
            ? route('team.show', $member->slug)
            : null;
    }
}
