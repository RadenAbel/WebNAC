<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
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