<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\GalleryController as AdminGalleryController;
use App\Http\Controllers\Admin\ManagementMemberController;
use App\Http\Controllers\Admin\JoinRequestController;
use App\Http\Controllers\Admin\ScheduleController as AdminScheduleController;
use App\Http\Controllers\Admin\SiteSettingController as AdminSiteSettingController;
use App\Http\Controllers\Admin\SliderController as AdminSliderController;
use App\Http\Controllers\Admin\TeamMemberAchievementController;
use App\Http\Controllers\Admin\TeamMemberLicenseController;
use App\Http\Controllers\Admin\TeamMemberController as AdminTeamMemberController;
use App\Http\Controllers\Admin\TeamMemberRecordController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\JoinController;
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

Route::get('/tentang-kami', [AboutController::class, 'index'])
    ->name('about.index');

// 'team.index' dipertahankan sebagai redirect ke Atlet — supaya link/bookmark
// lama yang mengarah ke /our-team tidak jadi 404.
Route::redirect('/our-team', '/our-team/atlet', 301)
    ->name('team.index');

Route::get('/our-team/atlet', [TeamController::class, 'athletes'])
    ->name('team.athletes');

Route::get('/our-team/pelatih', [TeamController::class, 'coaches'])
    ->name('team.coaches');

Route::get('/our-team/{teamMember}', [TeamController::class, 'show'])
    ->name('team.show');

Route::get('/acara', [EventController::class, 'index'])
    ->name('event.index');

Route::get('/galeri', [GalleryController::class, 'index'])
    ->name('gallery.index');

Route::get('/acara/{event}', [EventController::class, 'show'])
    ->name('event.show');

// Halaman pendaftaran "Join Us" — form publik, submit-nya disimpan ke tabel
// join_requests dan ditinjau admin lewat menu "Pendaftaran" (bukan email
// langsung lagi — lihat App\Http\Controllers\JoinController & Admin\JoinRequestController).
Route::get('/join', [JoinController::class, 'create'])->name('join.create');
Route::post('/join', [JoinController::class, 'store'])
    ->middleware('throttle:5,1') // cegah spam submit bertubi-tubi
    ->name('join.store');

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
    Route::put('team/{teamMember}/records/{record}', [TeamMemberRecordController::class, 'update'])
        ->name('team.records.update');
    Route::delete('team/{teamMember}/records/{record}', [TeamMemberRecordController::class, 'destroy'])
        ->name('team.records.destroy');

    Route::post('team/{teamMember}/achievements', [TeamMemberAchievementController::class, 'store'])
        ->name('team.achievements.store');
    Route::put('team/{teamMember}/achievements/{achievement}', [TeamMemberAchievementController::class, 'update'])
        ->name('team.achievements.update');
    Route::delete('team/{teamMember}/achievements/{achievement}', [TeamMemberAchievementController::class, 'destroy'])
        ->name('team.achievements.destroy');

    // Nested: Lisensi — khusus role 'pelatih', dikelola dari halaman edit anggota tim
    Route::post('team/{teamMember}/licenses', [TeamMemberLicenseController::class, 'store'])
        ->name('team.licenses.store');
    Route::put('team/{teamMember}/licenses/{license}', [TeamMemberLicenseController::class, 'update'])
        ->name('team.licenses.update');
    Route::delete('team/{teamMember}/licenses/{license}', [TeamMemberLicenseController::class, 'destroy'])
        ->name('team.licenses.destroy');

    // CRUD Slider
    Route::resource('sliders', AdminSliderController::class)->except(['show']);

    // CRUD Galeri
    Route::resource('galleries', AdminGalleryController::class)->except(['show']);

    // CRUD Tim Manajemen (halaman Tentang Kami)
    Route::resource('management', ManagementMemberController::class)->except(['show']);

    // Pendaftaran Join Us — cuma index/show + 2 aksi (terima/tolak), bukan
    // resource CRUD penuh (tidak ada create/edit/delete manual oleh admin).
    Route::get('join-requests', [JoinRequestController::class, 'index'])->name('join-requests.index');
    Route::get('join-requests/{joinRequest}', [JoinRequestController::class, 'show'])->name('join-requests.show');
    Route::post('join-requests/{joinRequest}/accept', [JoinRequestController::class, 'accept'])->name('join-requests.accept');
    Route::post('join-requests/{joinRequest}/reject', [JoinRequestController::class, 'reject'])->name('join-requests.reject');
    Route::delete('join-requests/{joinRequest}', [JoinRequestController::class, 'destroy'])->name('join-requests.destroy');

    // CRUD Jadwal
    Route::resource('schedules', AdminScheduleController::class)->except(['show']);

    // CRUD Acara
    Route::resource('events', AdminEventController::class)->except(['show']);

    // Pengaturan Situs — singleton (cuma 1 baris data), jadi cuma butuh
    // edit & update, tidak ada index/create/destroy.
    Route::get('settings', [AdminSiteSettingController::class, 'edit'])->name('settings.edit');
    Route::put('settings', [AdminSiteSettingController::class, 'update'])->name('settings.update');
});