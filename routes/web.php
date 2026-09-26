<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\GalleryController as AdminGalleryController;
use App\Http\Controllers\Admin\ManagementMemberController;
use App\Http\Controllers\Admin\JoinRequestController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\PricingPlanController;
use App\Http\Controllers\Admin\FacilityController;
use App\Http\Controllers\Admin\AccountPasswordController;
use App\Http\Controllers\Admin\TwoFactorController;
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
use App\Http\Controllers\SitemapController;
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

// {slug} = alamat berbentuk nama, mis. /our-team/javiero-jesaya-lengkong.
// Alamat lama berbentuk angka (/our-team/12) otomatis dialihkan (301).
Route::get('/our-team/{slug}', [TeamController::class, 'show'])
    ->name('team.show');

Route::get('/acara', [EventController::class, 'index'])
    ->name('event.index');

Route::get('/galeri', [GalleryController::class, 'index'])
    ->name('gallery.index');

// Halaman pendaftaran "Join Us" — form publik, submit-nya disimpan ke tabel
// join_requests dan ditinjau admin lewat menu "Pendaftaran" (bukan email
// langsung lagi — lihat App\Http\Controllers\JoinController & Admin\JoinRequestController).
// SEO: sitemap & robots.txt untuk Google (lihat SitemapController)
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
Route::get('/robots.txt', [SitemapController::class, 'robots'])->name('robots');

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

    // Langkah kedua login untuk akun yang memakai verifikasi dua langkah
    Route::get('/login/two-factor', [AdminAuthController::class, 'showTwoFactorChallenge'])
        ->name('admin.two-factor.challenge');
    Route::post('/login/two-factor', [AdminAuthController::class, 'verifyTwoFactorChallenge'])
        ->middleware('throttle:5,1')
        ->name('admin.two-factor.verify');
});

// Sudah login — akses dashboard & fitur admin lainnya
// 'auth.session' (bawaan Laravel): menyimpan sidik password di sesi. Begitu
// password akun diganti (oleh pemiliknya sendiri atau oleh super admin lewat
// Kelola Admin), semua sesi lain yang masih memakai password lama otomatis
// ter-logout di request berikutnya.
Route::middleware(['auth', 'auth.session'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    // Ganti password akun sendiri — terbuka untuk SEMUA akun yang login
    // (tidak memakai middleware izin), dibatasi 6 percobaan per menit supaya
    // kolom "password lama" tidak bisa ditebak-tebak berulang kali.
    Route::get('/password', [AccountPasswordController::class, 'edit'])->name('password.edit');
    Route::put('/password', [AccountPasswordController::class, 'update'])
        ->middleware('throttle:6,1')
        ->name('password.update');

    // Verifikasi dua langkah (2FA) akun sendiri — terbuka untuk semua akun
    Route::get('/two-factor', [TwoFactorController::class, 'show'])->name('two-factor.show');
    Route::middleware('throttle:6,1')->group(function () {
        Route::post('/two-factor', [TwoFactorController::class, 'confirm'])->name('two-factor.confirm');
        Route::post('/two-factor/recovery-codes', [TwoFactorController::class, 'regenerateRecoveryCodes'])->name('two-factor.recovery-codes');
        Route::delete('/two-factor', [TwoFactorController::class, 'disable'])->name('two-factor.disable');
    });

    // ============ Tim (Pelatih/Atlet) — butuh izin 'team' ============
    Route::middleware('permission:team')->group(function () {
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
    });

    // CRUD Slider — butuh izin 'sliders'
    Route::middleware('permission:sliders')->group(function () {
        Route::resource('sliders', AdminSliderController::class)->except(['show']);
    });

    // CRUD Galeri — butuh izin 'galleries'
    Route::middleware('permission:galleries')->group(function () {
        Route::resource('galleries', AdminGalleryController::class)->except(['show']);
    });

    // CRUD Tim Manajemen — butuh izin 'management'
    Route::middleware('permission:management')->group(function () {
        Route::resource('management', ManagementMemberController::class)->except(['show']);
    });

    // Pendaftaran Join Us — butuh izin 'join-requests'
    Route::middleware('permission:join-requests')->group(function () {
        Route::get('join-requests', [JoinRequestController::class, 'index'])->name('join-requests.index');
        Route::get('join-requests/{joinRequest}', [JoinRequestController::class, 'show'])->name('join-requests.show');
        Route::post('join-requests/{joinRequest}/accept', [JoinRequestController::class, 'accept'])->name('join-requests.accept');
        Route::post('join-requests/{joinRequest}/reject', [JoinRequestController::class, 'reject'])->name('join-requests.reject');
        Route::delete('join-requests/{joinRequest}', [JoinRequestController::class, 'destroy'])->name('join-requests.destroy');
    });

    // CRUD Jadwal — butuh izin 'schedules'
    Route::middleware('permission:schedules')->group(function () {
        Route::resource('schedules', AdminScheduleController::class)->except(['show']);
    });

    // CRUD Hasil Pertandingan — butuh izin 'events'
    Route::middleware('permission:events')->group(function () {
        Route::resource('events', AdminEventController::class)->except(['show']);
    });

    // CRUD Fasilitas (halaman Tentang Kami) — butuh izin 'facilities'
    Route::middleware('permission:facilities')->group(function () {
        Route::resource('facilities', FacilityController::class)->except(['show']);
    });

    // CRUD Biaya Pendaftaran — butuh izin 'pricing'
    // parameters(['pricing' => 'pricingPlan']) WAJIB ada — sama seperti
    // 'team' di atas, supaya nama parameter di URL ({pricingPlan}) sama
    // persis dengan nama argumen di controller (PricingPlan $pricingPlan).
    Route::middleware('permission:pricing')->group(function () {
        Route::resource('pricing', PricingPlanController::class)
            ->except(['show'])
            ->parameters(['pricing' => 'pricingPlan']);
    });

    // Pengaturan Situs — butuh izin 'settings' (bisa diberikan Super Admin
    // ke akun 'admin' juga kalau mau, lewat Kelola Admin).
    Route::middleware('permission:settings')->group(function () {
        // Singleton (cuma 1 baris data), jadi cuma butuh edit & update,
        // tidak ada index/create/destroy.
        Route::get('settings', [AdminSiteSettingController::class, 'edit'])->name('settings.edit');
        Route::put('settings', [AdminSiteSettingController::class, 'update'])->name('settings.update');
    });

    // ============================================================
    // KHUSUS SUPER ADMIN — Kelola Akun Admin. Middleware 'super_admin'
    // (alias untuk EnsureSuperAdmin, lihat bootstrap/app.php) menolak
    // akses (403) kalau role akun yang login bukan 'super_admin' —
    // berlaku SETELAH middleware 'auth' di atas, jadi auth()->user()
    // pasti sudah ada di sini.
    // ============================================================
    Route::middleware('super_admin')->group(function () {
        // Kelola Akun Admin — resource penuh KECUALI show (tidak perlu
        // halaman detail terpisah, cukup index + form edit).
        Route::resource('users', AdminUserController::class)->except(['show']);
        // Reset 2FA akun lain (mis. admin kehilangan HP & kode pemulihan)
        Route::delete('users/{user}/two-factor', [AdminUserController::class, 'resetTwoFactor'])
            ->name('users.two-factor.reset');
    });
});