<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role', 'permissions'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'permissions' => 'array',
        ];
    }

    /**
     * 'super_admin' -> semua akses biasa + Pengaturan Situs + kelola akun admin.
     * 'admin'       -> akses CRUD konten biasa saja (default kalau kolom
     * role masih kosong, jaga-jaga untuk akun lama sebelum fitur ini ada).
     */
    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    /**
     * Cek apakah akun ini boleh mengakses section tertentu (lihat
     * config/admin_sections.php untuk daftar key yang valid, mis.
     * 'sliders', 'galleries', 'team', dst).
     *
     * - Super Admin: selalu true, apa pun section-nya.
     * - Admin dengan permissions NULL: dianggap akses semua section —
     *   ini supaya akun admin LAMA (dibuat sebelum fitur ini ada, kolom
     *   permissions-nya kosong) tidak mendadak kehilangan akses semua menu.
     * - Admin dengan permissions berisi array (termasuk array kosong []):
     *   cuma section yang ada di dalam array itu yang boleh diakses.
     */
    public function canAccess(string $section): bool
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        if (is_null($this->permissions)) {
            return true;
        }

        return in_array($section, $this->permissions);
    }
}