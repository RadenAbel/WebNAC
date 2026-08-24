<nav class="navbar navbar-expand-lg navbar-dark nac-navbar fixed-top" id="nacNavbar">
    <div class="container">
        <a class="navbar-brand nac-brand" href="{{ route('home') }}">
            <img src="{{ asset('img/Logo.png') }}" alt="Logo NAC" class="nac-brand__mark">
            <span class="nac-brand__text">Nugroho Aquatic Center</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nacNavbarNav"
            aria-controls="nacNavbarNav" aria-expanded="false" aria-label="Buka menu navigasi">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="nacNavbarNav">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">
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
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('team.*') ? 'active' : '' }}" href="{{ route('team.index') }}">Our Team</a>
                </li>
            </ul>
        </div>
    </div>
</nav>