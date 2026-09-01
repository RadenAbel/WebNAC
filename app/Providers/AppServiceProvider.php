<?php

namespace App\Providers;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        /*
        |----------------------------------------------------------------
        | View Composer: $setting untuk navbar & footer
        |----------------------------------------------------------------
        | Navbar & footer muncul di SEMUA halaman (Home, Our Team, dst),
        | jadi datanya di-share di sini sekali saja — bukan dikirim manual
        | dari tiap controller satu-satu (HomeController, TeamController, ...).
        | Kalau nanti ada controller baru, navbar/footer tetap otomatis
        | dapat data $setting tanpa perlu diubah apa-apa lagi.
        */
        View::composer(['partials.navbar', 'partials.footer'], function ($view) {
            $view->with('setting', SiteSetting::current());
        });
    }
}