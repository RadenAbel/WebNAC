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

    <div class="nac-admin-shell">
        <aside class="nac-admin-sidebar">
            <div class="nac-admin-sidebar__brand">NAC Admin</div>

            <nav class="nac-admin-nav">
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <span><i class="bi bi-speedometer2 me-1"></i> Dashboard</span>
                </a>

                <span class="nac-admin-nav__group">Konten Website</span>

                <a href="{{ route('admin.sliders.index') }}" class="{{ request()->routeIs('admin.sliders.*') ? 'active' : '' }}">
                    <span><i class="bi bi-images me-1"></i> Slider</span>
                </a>
                <a href="{{ route('admin.galleries.index') }}" class="{{ request()->routeIs('admin.galleries.*') ? 'active' : '' }}">
                    <span><i class="bi bi-camera me-1"></i> Galeri</span>
                </a>
                <a href="{{ route('admin.schedules.index') }}" class="{{ request()->routeIs('admin.schedules.*') ? 'active' : '' }}">
                    <span><i class="bi bi-calendar-week me-1"></i> Jadwal</span>
                </a>
                <a href="{{ route('admin.team.index') }}" class="{{ request()->routeIs('admin.team.*') ? 'active' : '' }}">
                    <span><i class="bi bi-people me-1"></i> Tim (Pelatih/Atlet)</span>
                </a>
                <a href="{{ route('admin.settings.edit') }}" class="{{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                    <span><i class="bi bi-gear me-1"></i> Pengaturan Situs</span>
                </a>
            </nav>

            <form method="POST" action="{{ route('admin.logout') }}" class="nac-admin-logout-form">
                @csrf
                <button type="submit"><i class="bi bi-box-arrow-right me-1"></i> Keluar</button>
            </form>
        </aside>

        <div class="nac-admin-main">
            <header class="nac-admin-topbar">
                <span>Halo, {{ auth()->user()->name }}</span>
            </header>

            <div class="nac-admin-content">
                @yield('admin_content')
            </div>
        </div>
    </div>

</body>
</html>