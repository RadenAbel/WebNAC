<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('admin_title', 'Dashboard') — Admin Nugroho Aquatic Center</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Plus+Jakarta+Sans:wght@400;600;700;800&family=Roboto+Mono:wght@500;600&display=swap" rel="stylesheet">
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body class="nac-admin-body">

    <div class="nac-admin-backdrop" id="sidebarBackdrop"></div>

    <div class="nac-admin-shell">
        <aside class="nac-admin-sidebar">
            <div class="nac-admin-sidebar__brand">
                <span class="nac-admin-sidebar__brand-mark">NAC</span>
                <span class="nac-admin-sidebar__brand-text">
                    Admin Panel
                    <small>Nugroho Aquatic</small>
                </span>
            </div>

            <nav class="nac-admin-nav">
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" title="Dashboard">
                    <i class="bi bi-speedometer2"></i>
                    <span class="nac-admin-nav__label">Dashboard</span>
                </a>

                <span class="nac-admin-nav__group">Konten Website</span>

                <a href="{{ route('admin.sliders.index') }}" class="{{ request()->routeIs('admin.sliders.*') ? 'active' : '' }}" title="Slider">
                    <i class="bi bi-images"></i>
                    <span class="nac-admin-nav__label">Slider</span>
                </a>
                <a href="{{ route('admin.galleries.index') }}" class="{{ request()->routeIs('admin.galleries.*') ? 'active' : '' }}" title="Galeri">
                    <i class="bi bi-camera"></i>
                    <span class="nac-admin-nav__label">Galeri</span>
                </a>
                <a href="{{ route('admin.schedules.index') }}" class="{{ request()->routeIs('admin.schedules.*') ? 'active' : '' }}" title="Jadwal">
                    <i class="bi bi-calendar-week"></i>
                    <span class="nac-admin-nav__label">Jadwal</span>
                </a>
                <a href="{{ route('admin.events.index') }}" class="{{ request()->routeIs('admin.events.*') ? 'active' : '' }}" title="Acara">
                    <i class="bi bi-calendar-event"></i>
                    <span class="nac-admin-nav__label">Acara</span>
                </a>
                <a href="{{ route('admin.team.index') }}" class="{{ request()->routeIs('admin.team.*') ? 'active' : '' }}" title="Tim (Pelatih/Atlet)">
                    <i class="bi bi-people"></i>
                    <span class="nac-admin-nav__label">Tim (Pelatih/Atlet)</span>
                </a>

                <span class="nac-admin-nav__group">Pengaturan</span>

                <a href="{{ route('admin.settings.edit') }}" class="{{ request()->routeIs('admin.settings.*') ? 'active' : '' }}" title="Pengaturan Situs">
                    <i class="bi bi-gear"></i>
                    <span class="nac-admin-nav__label">Pengaturan Situs</span>
                </a>
            </nav>

            <div class="nac-admin-sidebar__footer">
                <form method="POST" action="{{ route('admin.logout') }}" class="nac-admin-logout-form">
                    @csrf
                    <button type="submit" title="Keluar"><i class="bi bi-box-arrow-right"></i> <span>Keluar</span></button>
                </form>
            </div>
        </aside>

        <div class="nac-admin-main">
            <header class="nac-admin-topbar">
                <div class="nac-admin-topbar__left">
                    <button type="button" class="nac-admin-sidebar-toggle d-none d-lg-inline-flex" id="sidebarToggle" aria-label="Buka/tutup sidebar">
                        <i class="bi bi-list"></i>
                    </button>
                    <button type="button" class="nac-admin-sidebar-toggle nac-admin-mobile-toggle" id="mobileSidebarToggle" aria-label="Buka menu">
                        <i class="bi bi-list"></i>
                    </button>
                    <p class="nac-admin-topbar__title">@yield('admin_title', 'Dashboard')</p>
                </div>

                <div class="nac-admin-topbar__right">
                    <a href="{{ route('home') }}" target="_blank" class="nac-admin-topbar__view-site">
                        <i class="bi bi-box-arrow-up-right"></i> <span>Lihat Situs</span>
                    </a>
                    <div class="nac-admin-topbar__user">
                        <span class="nac-admin-topbar__avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                        <div class="d-none d-sm-block">
                            <div class="nac-admin-topbar__user-name">{{ auth()->user()->name }}</div>
                            <div class="nac-admin-topbar__user-role">Administrator</div>
                        </div>
                    </div>
                </div>
            </header>

            <div class="nac-admin-content">
                @yield('admin_content')
            </div>
        </div>
    </div>

    <script src="{{ asset('js/admin.js') }}"></script>
    @stack('scripts')
</body>
</html>