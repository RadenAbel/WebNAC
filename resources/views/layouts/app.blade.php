<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Nugroho Aquatic Center')</title>
    <meta name="description" content="@yield('meta_description', 'Nugroho Aquatic Center — fasilitas renang premium, pelatih profesional, dan program latihan untuk semua level.')">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.2/css/all.min.css">

    <!-- Google Fonts: Archivo Black (display), Plus Jakarta Sans (body), Roboto Mono (angka/data) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Roboto+Mono:wght@500;600&display=swap" rel="stylesheet">

    <!-- AOS (scroll reveal, dipakai secukupnya) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css">

    <!-- Custom theme -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    @stack('styles')
</head>
<body class="page-{{ Route::currentRouteName() ? str_replace('.', '-', Route::currentRouteName()) : 'default' }}">

    @include('partials.navbar')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')

    <!-- Bootstrap Bundle (JS + Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- AOS -->
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>

    <!-- Custom script -->
    <script src="{{ asset('js/app.js') }}"></script>

    @stack('scripts')
</body>
</html>