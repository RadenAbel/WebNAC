<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- ============ SEO DASAR ============ --}}
    <title>@yield('title', 'Nugroho Aquatic Club — Kolam Renang Premium di Kutai Timur')</title>
    <meta name="description" content="@yield('meta_description', 'Nugroho Aquatic Club — fasilitas renang premium di Kutai Timur dengan pelatih bersertifikat, untuk atlet junior hingga senior.')">
    <meta name="robots" content="@yield('meta_robots', 'index, follow')">
    <link rel="canonical" href="@yield('canonical_url', url()->current())">

    {{-- ============ OPEN GRAPH (Facebook, WhatsApp, dll) ============ --}}
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Nugroho Aquatic Club">
    <meta property="og:locale" content="id_ID">
    <meta property="og:title" content="@yield('og_title', 'Nugroho Aquatic Club — Kolam Renang Premium di Kutai Timur')">
    <meta property="og:description" content="@yield('og_description', 'Fasilitas renang premium dengan pelatih bersertifikat untuk atlet junior hingga senior.')">
    <meta property="og:url" content="@yield('canonical_url', url()->current())">
    <meta property="og:image" content="@yield('og_image', asset('img/Logo.png'))">

    {{-- ============ TWITTER CARD ============ --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('og_title', 'Nugroho Aquatic Club')">
    <meta name="twitter:description" content="@yield('og_description', 'Fasilitas renang premium dengan pelatih bersertifikat untuk atlet junior hingga senior.')">
    <meta name="twitter:image" content="@yield('og_image', asset('img/Logo.png'))">

    <meta name="theme-color" content="#0A0E14">
    <link rel="icon" href="{{ asset('img/Logo.png') }}" type="image/png">

    {{-- ============ STRUCTURED DATA (JSON-LD) ============ --}}
    {{-- Membantu Google memahami bisnis ini sebagai lokasi olahraga fisik.
         PENTING: semua tanda "@" di dalam JSON ini SENGAJA ditulis "@@"
         (mis. "@@context", "@@type"). Kalau ditulis "@context" biasa, Blade
         akan salah mengira itu directive (@if, dst) dan bikin ParseError
         "expecting elseif or else or endif" — persis error yang tadi
         muncul. "@@" adalah cara Blade menulis tanda "@" literal. --}}
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "SportsActivityLocation",
        "name": "Nugroho Aquatic Club",
        "image": "{{ asset('img/Logo.png') }}",
        "url": "{{ url('/') }}",
        "address": {
            "@@type": "PostalAddress",
            "addressCountry": "ID"
        }
    }
    </script>

    {{-- ============ ASET ============ --}}
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

    <!-- Flag Icons: ikon bendera berbasis gambar (konsisten di semua OS,
         beda dari emoji bendera yang tidak didukung font default Windows) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@7.2.3/css/flag-icons.min.css">

    <!-- Custom theme -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    @stack('styles')
</head>
<body class="page-{{ Route::currentRouteName() ? str_replace('.', '-', Route::currentRouteName()) : 'default' }}">

    {{-- ============ SKIP LINK (aksesibilitas keyboard) ============ --}}
    <a href="#konten-utama" class="nac-skip-link">Langsung ke konten utama</a>

    @include('partials.navbar')

    <main id="konten-utama">
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