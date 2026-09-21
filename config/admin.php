<?php

/*
|--------------------------------------------------------------------------
| Kredensial Admin Awal
|--------------------------------------------------------------------------
| PENTING: kenapa nilai .env dibaca di sini, bukan langsung pakai env()
| di dalam AdminUserSeeder?
|
| Kalau nanti project ini di-deploy dan menjalankan `php artisan config:cache`
| (umum dilakukan di hosting/production demi performa), Laravel akan BERHENTI
| membaca file .env sama sekali — hanya memakai file config yang sudah
| di-cache. Pemanggilan env() di luar folder config/ (misal langsung di
| seeder/controller) akan selalu bernilai null setelah itu.
|
| Dengan menaruh env() di sini (di dalam config/), nilainya ikut ter-cache
| dengan benar saat `config:cache` dijalankan, dan tetap bisa diambil lewat
| config('admin.email') / config('admin.password') kapan pun.
*/

return [
    'email'    => env('ADMIN_EMAIL', 'admin@nugrohoaquatic.id'),
    'password' => env('ADMIN_PASSWORD'),
];