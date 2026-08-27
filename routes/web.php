<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\GalleryController as AdminGalleryController;
use App\Http\Controllers\Admin\ScheduleController as AdminScheduleController;
use App\Http\Controllers\Admin\SiteSettingController as AdminSiteSettingController;
use App\Http\Controllers\Admin\SliderController as AdminSliderController;
use App\Http\Controllers\Admin\TeamMemberAchievementController;
use App\Http\Controllers\Admin\TeamMemberController as AdminTeamMemberController;
use App\Http\Controllers\Admin\TeamMemberRecordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Route Publik
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])
    ->name('home');

Route::get('/our-team', [TeamController::class, 'index'])
    ->name('team.index');

Route::get('/our-team/{teamMember}', [TeamController::class, 'show'])
    ->name('team.show');

/*
|--------------------------------------------------------------------------
| Route Admin
|--------------------------------------------------------------------------
| Route 'login' SENGAJA diberi nama persis 'login' (bukan 'admin.login')
| karena middleware 'auth' bawaan Laravel otomatis redirect ke route
| bernama 'login' saat pengunjung belum login mengakses halaman terproteksi.
|
| Login dibatasi 5x percobaan per menit (throttle) untuk mencegah brute-force.
*/

// Belum login — hanya bisa akses halaman login
Route::middleware('guest')->prefix('admin')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])
        ->middleware('throttle:5,1')
        ->name('admin.login.attempt');
});

// Sudah login — akses dashboard & fitur admin lainnya
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    // CRUD Tim (Pelatih/Atlet)
    // parameters(['team' => 'teamMember']) WAJIB ada — supaya nama parameter
    // di URL ({teamMember}) sama persis dengan nama argumen di controller
    // (TeamMember $teamMember). Kalau tidak disamakan, Laravel gagal
    // mengenali route model binding dan diam-diam mengisi model kosong.
    Route::resource('team', AdminTeamMemberController::class)
        ->except(['show'])
        ->parameters(['team' => 'teamMember']);

    // Nested: Rekor waktu terbaik & Pencapaian — dikelola dari halaman edit anggota tim
    Route::post('team/{teamMember}/records', [TeamMemberRecordController::class, 'store'])
        ->name('team.records.store');
    Route::delete('team/{teamMember}/records/{record}', [TeamMemberRecordController::class, 'destroy'])
        ->name('team.records.destroy');

    Route::post('team/{teamMember}/achievements', [TeamMemberAchievementController::class, 'store'])
        ->name('team.achievements.store');
    Route::delete('team/{teamMember}/achievements/{achievement}', [TeamMemberAchievementController::class, 'destroy'])
        ->name('team.achievements.destroy');

    // CRUD Slider
    Route::resource('sliders', AdminSliderController::class)->except(['show']);

    // CRUD Galeri
    Route::resource('galleries', AdminGalleryController::class)->except(['show']);

    // CRUD Jadwal
    Route::resource('schedules', AdminScheduleController::class)->except(['show']);

    // Pengaturan Situs — singleton (cuma 1 baris data), jadi cuma butuh
    // edit & update, tidak ada index/create/destroy.
    Route::get('settings', [AdminSiteSettingController::class, 'edit'])->name('settings.edit');
    Route::put('settings', [AdminSiteSettingController::class, 'update'])->name('settings.update');
});