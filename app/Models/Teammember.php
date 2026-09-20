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
        'photo_is_cutout'    => 'boolean',
        'age'                => 'integer',
        'birth_date'         => 'date',
        'join_date'          => 'date',
        'height_cm'          => 'integer',
        'weight_kg'          => 'integer',
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

    /**
     * swim_style disimpan sebagai 1 string dipisah koma (mis. "Gaya Bebas,
     * Gaya Punggung") — accessor ini memecahnya jadi array, dipakai untuk
     * pre-fill checkbox di form admin dan render banyak tag di halaman
     * publik (tidak perlu tabel/kolom terpisah untuk multi-pilih).
     */
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

    /**
     * Lisensi/sertifikasi kepelatihan — cuma relevan buat role 'pelatih',
     * tapi tetap relasi umum di sini (sama seperti records/achievements)
     * supaya polanya konsisten. Halaman edit admin yang atur kapan
     * ditampilkan (berdasarkan $member->role).
     */
    public function licenses(): HasMany
    {
        return $this->hasMany(TeamMemberLicense::class)->orderBy('sort_order');
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
     * Total medali — sekarang murni dari kolom `total_medals` yang diisi
     * manual oleh admin di profil anggota tim (bukan dihitung otomatis
     * dari Rekor Waktu / Pencapaian lagi, karena kedua sistem itu sudah
     * tidak mencatat medali sama sekali).
     */
    public function getTotalMedalsCountAttribute(): int
    {
        return (int) ($this->total_medals ?? 0);
    }

    /**
     * Bentuk array rekor waktu terbaik sesuai format yang dipakai
     * team/show.blade.php (tabel Rekor Waktu Terbaik).
     */
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