<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', config('seo.default_title'))</title>
    <meta name="description" content="@yield('meta_description', config('seo.default_description'))">
    <meta name="robots" content="@yield('meta_robots', 'index, follow')">
    <link rel="canonical" href="@yield('canonical_url', url()->current())">
    @if (config('seo.google_site_verification'))
        <meta name="google-site-verification" content="{{ config('seo.google_site_verification') }}">
    @endif

    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ config('seo.club_name') }}">
    <meta property="og:locale" content="id_ID">
    <meta property="og:title" content="@yield('og_title', $__env->yieldContent('title', config('seo.default_title')))">
    <meta property="og:description" content="@yield('og_description', $__env->yieldContent('meta_description', config('seo.default_description')))">
    <meta property="og:url" content="@yield('canonical_url', url()->current())">
    <meta property="og:image" content="@yield('og_image', asset('img/og-logo.png'))">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('og_title', $__env->yieldContent('title', config('seo.default_title')))">
    <meta name="twitter:description" content="@yield('og_description', $__env->yieldContent('meta_description', config('seo.default_description')))">
    <meta name="twitter:image" content="@yield('og_image', asset('img/og-logo.png'))">

    <meta name="theme-color" content="#0A0E14">
    <link rel="icon" href="{{ asset('img/favicon-32.png') }}" type="image/png" sizes="32x32">
    <link rel="apple-touch-icon" href="{{ asset('img/apple-touch-icon.png') }}">

    <script type="application/ld+json">
{!! \App\Support\Seo::clubSchema(\App\Models\SiteSetting::current()) !!}
    </script>

    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.2/css/all.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css">

    @stack('vendor-styles')

    <link href="{{ \App\Support\Asset::url('css/style.css') }}" rel="stylesheet">

    @stack('styles')
</head>
<body class="page-{{ Route::currentRouteName() ? str_replace('.', '-', Route::currentRouteName()) : 'default' }}">

    <a href="#konten-utama" class="nac-skip-link">Langsung ke konten utama</a>

    @include('partials.navbar')

    <main id="konten-utama">
        @yield('content')
    </main>

    @include('partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>

    <script src="{{ \App\Support\Asset::url('js/app.js') }}"></script>

    @stack('scripts')
</body>
</html>
