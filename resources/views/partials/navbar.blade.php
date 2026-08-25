<nav class="navbar navbar-expand-lg navbar-light nac-navbar" id="nacNavbar">
    <div class="container-fluid px-3 px-lg-4">
        <a class="navbar-brand nac-brand" href="{{ route('home') }}">
            <img src="{{ asset('img/Logo.jpeg') }}" alt="Logo NAC" class="nac-brand__mark">
            <span class="nac-brand__text">Nugroho Aquatic Club</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nacNavbarNav"
            aria-controls="nacNavbarNav" aria-expanded="false" aria-label="Buka menu navigasi">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="nacNavbarNav">
            <ul class="navbar-nav mx-lg-auto align-items-lg-center gap-lg-1">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}#tentang">Tentang</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}#galeri">Galeri</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}#fasilitas">Fasilitas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}#biaya">Biaya</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}#jadwal">Jadwal</a>
                </li>
            </ul>

            <div class="d-flex align-items-center gap-3 nac-navbar__actions mt-3 mt-lg-0">
                <a href="{{ route('team.index') }}" class="btn nac-btn nac-btn--primary nac-navbar__cta">
                    Our Team
                </a>
            </div>
        </div>
    </div>
</nav>