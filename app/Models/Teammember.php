<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Models\Concerns\FlushesPublicCache;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TeamMember extends Model
{
    use HasFactory, FlushesPublicCache;

    protected $fillable = [
        'name',
        'photo',
        'photo_is_cutout',
        'whatsapp',
        'instagram_url',
        'facebook_url',
        'tiktok_url',
        'age',
        'birth_date',
        'birth_place',
        'gender',
        'height_cm',
        'weight_kg',
        'join_date',
        'role',
        'category',
        'member_status',
        'school_name',
        'swim_style',
        'origin_city',
        'years_experience',
        'total_medals',
        'bio',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active'          => 'boolean',
        'photo_is_cutout'    => 'boolean',
        'age'                => 'integer',
        'birth_date'         => 'date',
        'join_date'          => 'date',
        'height_cm'          => 'integer',
        'weight_kg'          => 'integer',
        'years_experience'   => 'integer',
        'total_medals'       => 'integer',
        'sort_order'         => 'integer',
    ];

    public function getPhotoUrlAttribute(): ?string
    {
        return $this->photo ? asset('storage/' . $this->photo) : null;
    }

    public function getAgeAttribute($value): ?int
    {
        if ($this->birth_date) {
            return $this->birth_date->age;
        }

        return $value;
    }

    public function getSwimStyleArrayAttribute(): array
    {
        if (! $this->swim_style) {
            return [];
        }

        return array_map('trim', explode(',', $this->swim_style));
    }

    public function getBirthDateLabelAttribute(): ?string
    {
        return $this->birth_date ? $this->birth_date->translatedFormat('d F Y') : null;
    }

    public function getJoinDateLabelAttribute(): ?string
    {
        return $this->join_date ? $this->join_date->translatedFormat('d F Y') : null;
    }

    public function records(): HasMany
    {
        return $this->hasMany(TeamMemberRecord::class)->orderBy('sort_order');
    }

    public function achievements(): HasMany
    {
        return $this->hasMany(TeamMemberAchievement::class)->orderBy('sort_order');
    }

    public function licenses(): HasMany
    {
        return $this->hasMany(TeamMemberLicense::class)->orderBy('sort_order');
    }

    public function getHometownAttribute(): ?string
    {
        return $this->origin_city;
    }

    public function getExperienceYearsAttribute(): ?int
    {
        return $this->years_experience;
    }

    public function getPhoneAttribute(): ?string
    {
        return $this->whatsapp;
    }

    public function getInstagramAttribute(): ?string
    {
        if (! $this->instagram_url) {
            return null;
        }

        $path = trim((string) parse_url($this->instagram_url, PHP_URL_PATH), '/');

        return $path ?: null;
    }

    public function getTotalMedalsCountAttribute(): int
    {
        return (int) ($this->total_medals ?? 0);
    }

    public function getPersonalBestsAttribute(): array
    {
        $records = $this->relationLoaded('records') ? $this->getRelationValue('records') : $this->records()->get();

        return $records->map(function ($record) {
            return [
                'event'        => $record->event,
                'time'         => $record->time,
                'pool_length'  => $record->pool_length ? $record->pool_length . 'm' : null,
                'age'          => $record->age_at_record,
                'competition'  => $record->competition,
                'country_code' => $record->country ? strtolower($record->country) : null,
                'country'      => $record->country_name,
                'date'         => $record->record_date ? $record->record_date->format('d/m/Y') : null,
            ];
        })->values()->all();
    }

    protected static function booted(): void
    {
        static::saving(function (TeamMember $member) {
            if (! $member->slug || $member->isDirty('name')) {
                $member->slug = static::uniqueSlug($member->name, $member->id);
            }
        });
    }

    public static function uniqueSlug(?string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug((string) $name) ?: 'anggota';
        $slug = $base;
        $i = 2;

        while (in_array($slug, ['atlet', 'pelatih'], true) || static::where('slug', $slug)
            ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
            ->exists()) {
            $slug = "{$base}-{$i}";
            $i++;
        }

        return $slug;
    }
    public function getIsMemberActiveAttribute(): bool
    {
        return ($this->member_status ?? 'aktif') !== 'tidak_aktif';
    }

    public function getMemberStatusLabelAttribute(): string
    {
        return $this->is_member_active ? 'Aktif' : 'Tidak Aktif';
    }

    public function scopePelatih(Builder $query): Builder
    {
        return $query->where('role', 'pelatih');
    }

    public function scopeAtlet(Builder $query): Builder
    {
        return $query->where('role', 'atlet');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name');
    }
}
