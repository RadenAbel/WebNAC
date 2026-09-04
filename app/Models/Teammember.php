<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TeamMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'photo',
        'whatsapp',
        'instagram_url',
        'facebook_url',
        'tiktok_url',
        'age',
        'birth_date',
        'birth_place',
        'join_date',
        'role',
        'category',
        'swim_style',
        'origin_city',
        'years_experience',
        'total_medals',
        'total_achievements',
        'bio',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active'          => 'boolean',
        'age'                => 'integer',
        'birth_date'         => 'date',
        'join_date'          => 'date',
        'years_experience'   => 'integer',
        'total_medals'       => 'integer',
        'total_achievements' => 'integer',
        'sort_order'         => 'integer',
    ];

    /**
     * Accessor untuk URL foto. SENGAJA return null (bukan gambar fallback)
     * kalau belum ada foto — supaya tampilan (card & halaman profil) bisa
     * menampilkan placeholder "No Image" yang lebih rapi, bukan gambar
     * default generik atau broken image.
     */
    public function getPhotoUrlAttribute(): ?string
    {
        return $this->photo ? asset('storage/' . $this->photo) : null;
    }

    /**
     * Umur DIHITUNG OTOMATIS dari birth_date setiap kali dipanggil — jadi
     * selalu akurat mengikuti tanggal hari ini, tidak perlu di-update manual
     * tiap tahun. Kalau birth_date belum diisi (data lama), tetap pakai
     * angka yang tersimpan manual di kolom `age` sebagai fallback, supaya
     * data lama tidak mendadak kosong.
     */
    public function getAgeAttribute($value): ?int
    {
        if ($this->birth_date) {
            return $this->birth_date->age;
        }

        return $value;
    }

    public function getBirthDateLabelAttribute(): ?string
    {
        return $this->birth_date ? $this->birth_date->translatedFormat('d F Y') : null;
    }

    public function getJoinDateLabelAttribute(): ?string
    {
        return $this->join_date ? $this->join_date->translatedFormat('d F Y') : null;
    }

    /**
     * Rekor waktu terbaik milik anggota tim ini, terurut sesuai sort_order.
     */
    public function records(): HasMany
    {
        return $this->hasMany(TeamMemberRecord::class)->orderBy('sort_order');
    }

    /**
     * Pencapaian & penghargaan milik anggota tim ini.
     */
    public function achievements(): HasMany
    {
        return $this->hasMany(TeamMemberAchievement::class)->orderBy('sort_order');
    }

    // ========================================================================
    // ACCESSOR ALIAS
    // ------------------------------------------------------------------------
    // Halaman profil publik (team/show.blade.php) memakai beberapa nama field
    // yang beda dari nama kolom aslinya di database. Accessor di bawah ini
    // cuma "jembatan" penamaan — tidak menambah kolom baru, cuma alias.
    // ========================================================================

    public function getHometownAttribute(): ?string
    {
        return $this->origin_city;
    }

    public function getExperienceYearsAttribute(): ?int
    {
        return $this->years_experience;
    }

    /**
     * Dipakai untuk tombol "Hubungi Saya" (link wa.me) di halaman profil.
     */
    public function getPhoneAttribute(): ?string
    {
        return $this->whatsapp;
    }

    /**
     * Blade menyusun link Instagram dari @handle (bukan URL penuh), jadi
     * di sini kita ekstrak handle-nya dari instagram_url yang disimpan admin.
     */
    public function getInstagramAttribute(): ?string
    {
        if (! $this->instagram_url) {
            return null;
        }

        $path = trim((string) parse_url($this->instagram_url, PHP_URL_PATH), '/');

        return $path ?: null;
    }

    /**
     * Breakdown medali emas/perak/perunggu, dihitung dari relasi `records`
     * (bukan dari kolom total_medals yang diisi manual admin) — supaya
     * angkanya selalu akurat mengikuti rekor yang benar-benar diinput.
     */
    public function getMedalStatsAttribute(): array
    {
        $records = $this->relationLoaded('records') ? $this->records : $this->records()->get();

        return [
            'gold'   => $records->where('medal', 'Emas')->count(),
            'silver' => $records->where('medal', 'Perak')->count(),
            'bronze' => $records->where('medal', 'Perunggu')->count(),
        ];
    }

    /**
     * Bentuk array rekor waktu terbaik sesuai format yang dipakai
     * team/show.blade.php (tabel Rekor Waktu Terbaik).
     */
    public function getPersonalBestsAttribute(): array
    {
        $records = $this->relationLoaded('records') ? $this->records : $this->records()->get();

        $medalKeyMap = [
            'Emas'     => 'gold',
            'Perak'    => 'silver',
            'Perunggu' => 'bronze',
        ];

        return $records->map(function ($record) use ($medalKeyMap) {
            return [
                'event'        => $record->event,
                'time'         => $record->time,
                'medal'        => $medalKeyMap[$record->medal] ?? null,
                'pool_length'  => $record->pool_length ? $record->pool_length . 'm' : null,
                'age'          => $record->age_at_record,
                'competition'  => $record->competition,
                'country_code' => $record->country ? strtolower($record->country) : null,
                'country'      => $record->country_name,
                'date'         => $record->record_date ? $record->record_date->format('d/m/Y') : null,
            ];
        })->values()->all();
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