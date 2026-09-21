<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Buat/update akun admin. Kredensial diambil dari .env (ADMIN_EMAIL,
     * ADMIN_PASSWORD) lewat config/admin.php — supaya TIDAK ada password
     * tertulis langsung di kode, dan tetap terbaca walau config di-cache
     * (lihat penjelasan lengkap di config/admin.php).
     *
     * Cara pakai:
     * 1. Tambahkan di .env:
     *      ADMIN_EMAIL=admin@nugrohoaquatic.id
     *      ADMIN_PASSWORD=passwordkuat123!
     * 2. Jalankan: php artisan config:clear && php artisan db:seed --class=AdminUserSeeder
     * 3. Setelah berhasil login, SANGAT disarankan hapus baris ADMIN_PASSWORD
     *    dari .env (akun sudah tersimpan terenkripsi di database).
     */
    public function run(): void
    {
        $email    = config('admin.email');
        $password = config('admin.password');

        if (! $password) {
            $this->command->error(
                'ADMIN_PASSWORD belum diatur di .env. Seeder dibatalkan demi keamanan.'
            );
            return;
        }

        User::updateOrCreate(
            ['email' => $email],
            [
                'name'              => 'Admin Nugroho Aquatic Center',
                'password'          => Hash::make($password),
                'email_verified_at' => now(),
                'role'              => 'super_admin', // akun pertama otomatis Super Admin
            ]
        );

        $this->command->info("Akun admin siap: {$email}");
    }
}