<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Route Nugroho Aquatic Center
|--------------------------------------------------------------------------
| Tempel blok ini ke dalam routes/web.php yang sudah ada di project Anda.
| Jangan generate ulang seluruh file web.php, cukup gabungkan bagian ini.
| Route 'home' WAJIB ada karena dipakai di navbar/footer via route('home').
*/

Route::get('/', [HomeController::class, 'index'])
    ->name('home');

Route::get('/our-team', [TeamController::class, 'index'])
    ->name('team.index');

// Opsional: detail per anggota tim (kalau nanti dibutuhkan)
Route::get('/our-team/{teamMember}', [TeamController::class, 'show'])
    ->name('team.show');