<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /*
     * Buat/update akun admin. Kredensial diambil dari .env (ADMIN_EMAIL,
     * ADMIN_PASSWORD) supaya TIDAK ada password tertulis langsung di kode
     * yang bisa ikut ter-commit ke Git.
     *
     * Cara pakai:
     * 1. Tambahkan di .env:
     *      ADMIN_EMAIL=admin@nugrohoaquatic.id
     *      ADMIN_PASSWORD=passwordkuat123!
     * 2. Jalankan: php artisan db:seed --class=AdminUserSeeder
     * 3. Setelah berhasil login, SANGAT disarankan hapus baris ADMIN_PASSWORD
     *    dari .env (akun sudah tersimpan terenkripsi di database).
     */
    public function run(): void
    {
        $email    = env('ADMIN_EMAIL', 'admin@nugrohoaquatic.id');
        $password = env('ADMIN_PASSWORD');

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
            ]
        );

        $this->command->info("Akun admin siap: {$email}");
    }
}