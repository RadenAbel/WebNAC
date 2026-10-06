<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\EventResultController;
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

Route::get('/', [HomeController::class, 'index'])
    ->name('home');

Route::get('/tentang-kami', [AboutController::class, 'index'])
    ->name('about.index');

Route::redirect('/our-team', '/our-team/atlet', 301)
    ->name('team.index');

Route::get('/our-team/atlet', [TeamController::class, 'athletes'])
    ->name('team.athletes');

Route::get('/our-team/pelatih', [TeamController::class, 'coaches'])
    ->name('team.coaches');

Route::get('/our-team/{slug}', [TeamController::class, 'show'])
    ->name('team.show');

Route::get('/acara', [EventController::class, 'index'])
    ->name('event.index');

Route::get('/acara/{event:slug}', [EventController::class, 'show'])
    ->name('event.show');

Route::get('/galeri', [GalleryController::class, 'index'])
    ->name('gallery.index');

Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
Route::get('/robots.txt', [SitemapController::class, 'robots'])->name('robots');

Route::get('/join', [JoinController::class, 'create'])->name('join.create');
Route::post('/join', [JoinController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('join.store');

Route::middleware('guest')->prefix('admin')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])
        ->middleware('throttle:5,1')
        ->name('admin.login.attempt');

    Route::get('/login/two-factor', [AdminAuthController::class, 'showTwoFactorChallenge'])
        ->name('admin.two-factor.challenge');
    Route::post('/login/two-factor', [AdminAuthController::class, 'verifyTwoFactorChallenge'])
        ->middleware('throttle:5,1')
        ->name('admin.two-factor.verify');
});

Route::middleware(['auth', 'auth.session'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    Route::get('/password', [AccountPasswordController::class, 'edit'])->name('password.edit');
    Route::put('/password', [AccountPasswordController::class, 'update'])
        ->middleware('throttle:6,1')
        ->name('password.update');

    Route::get('/two-factor', [TwoFactorController::class, 'show'])->name('two-factor.show');
    Route::middleware('throttle:6,1')->group(function () {
        Route::post('/two-factor', [TwoFactorController::class, 'confirm'])->name('two-factor.confirm');
        Route::post('/two-factor/recovery-codes', [TwoFactorController::class, 'regenerateRecoveryCodes'])->name('two-factor.recovery-codes');
        Route::delete('/two-factor', [TwoFactorController::class, 'disable'])->name('two-factor.disable');
    });

    Route::middleware('permission:team')->group(function () {
        Route::resource('team', AdminTeamMemberController::class)
            ->except(['show'])
            ->parameters(['team' => 'teamMember']);

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

        Route::post('team/{teamMember}/licenses', [TeamMemberLicenseController::class, 'store'])
            ->name('team.licenses.store');
        Route::put('team/{teamMember}/licenses/{license}', [TeamMemberLicenseController::class, 'update'])
            ->name('team.licenses.update');
        Route::delete('team/{teamMember}/licenses/{license}', [TeamMemberLicenseController::class, 'destroy'])
            ->name('team.licenses.destroy');
    });

    Route::middleware('permission:sliders')->group(function () {
        Route::resource('sliders', AdminSliderController::class)->except(['show']);
    });

    Route::middleware('permission:galleries')->group(function () {
        Route::resource('galleries', AdminGalleryController::class)->except(['show']);
    });

    Route::middleware('permission:management')->group(function () {
        Route::resource('management', ManagementMemberController::class)->except(['show']);
    });

    Route::middleware('permission:join-requests')->group(function () {
        Route::get('join-requests', [JoinRequestController::class, 'index'])->name('join-requests.index');
        Route::get('join-requests/{joinRequest}', [JoinRequestController::class, 'show'])->name('join-requests.show');
        Route::get('join-requests/{joinRequest}/photo', [JoinRequestController::class, 'photo'])->name('join-requests.photo');
        Route::post('join-requests/{joinRequest}/accept', [JoinRequestController::class, 'accept'])->name('join-requests.accept');
        Route::post('join-requests/{joinRequest}/reject', [JoinRequestController::class, 'reject'])->name('join-requests.reject');
        Route::delete('join-requests/{joinRequest}', [JoinRequestController::class, 'destroy'])->name('join-requests.destroy');
    });

    Route::middleware('permission:schedules')->group(function () {
        Route::resource('schedules', AdminScheduleController::class)->except(['show']);
    });

    Route::middleware('permission:events')->group(function () {
        Route::resource('events', AdminEventController::class)->except(['show']);
        Route::post('events/{event}/results', [EventResultController::class, 'store'])->name('events.results.store');
        Route::put('events/{event}/results/{result}', [EventResultController::class, 'update'])->name('events.results.update');
        Route::delete('events/{event}/results/{result}', [EventResultController::class, 'destroy'])->name('events.results.destroy');
    });

    Route::middleware('permission:facilities')->group(function () {
        Route::resource('facilities', FacilityController::class)->except(['show']);
    });

    Route::middleware('permission:pricing')->group(function () {
        Route::resource('pricing', PricingPlanController::class)
            ->except(['show'])
            ->parameters(['pricing' => 'pricingPlan']);
    });

    Route::middleware('permission:settings')->group(function () {
        Route::get('settings', [AdminSiteSettingController::class, 'edit'])->name('settings.edit');
        Route::put('settings', [AdminSiteSettingController::class, 'update'])->name('settings.update');
    });

    Route::middleware('super_admin')->group(function () {
        Route::resource('users', AdminUserController::class)->except(['show']);
        Route::delete('users/{user}/two-factor', [AdminUserController::class, 'resetTwoFactor'])
            ->name('users.two-factor.reset');
    });
});
