<?php

/*
|--------------------------------------------------------------------------
| Daftar Section Admin yang Bisa Diatur Izinnya
|--------------------------------------------------------------------------
| Key di sini HARUS sama persis dengan nama yang dipakai di:
| - Route::middleware('permission:<key>')->group(...) di routes/web.php
| - checkbox di form Kelola Admin (admin/users/partials/form.blade.php)
| - pengecekan @if(auth()->user()->canAccess('<key>')) di sidebar
|
| Kelola Admin SENGAJA tidak ada di sini — itu selalu khusus Super Admin,
| tidak bisa diberikan ke akun 'admin' biasa (karena berisiko: kalau admin
| biasa bisa atur akun/izin admin lain, dia bisa naikkan izinnya sendiri).
| Pengaturan Situs BOLEH diberikan ke admin biasa kalau Super Admin mau.
*/

return [
    'sliders'       => 'Slider',
    'galleries'     => 'Galeri',
    'schedules'     => 'Jadwal',
    'events'        => 'Hasil Pertandingan',
    'pricing'       => 'Biaya Pendaftaran',
    'team'          => 'Tim (Pelatih/Atlet)',
    'management'    => 'Tim Manajemen',
    'facilities'    => 'Fasilitas',
    'join-requests' => 'Pendaftaran',
    'settings'      => 'Pengaturan Situs',
];