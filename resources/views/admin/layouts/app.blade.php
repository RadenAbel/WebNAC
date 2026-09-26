<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('admin_title', 'Dashboard') — Admin Nugroho Aquatic Club</title>
    <link rel="icon" href="{{ asset('img/Logo.png') }}" type="image/png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@7.2.3/css/flag-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body class="nac-admin-body">

    <div class="nac-admin-backdrop" id="sidebarBackdrop"></div>

    <div class="nac-admin-shell">
        <aside class="nac-admin-sidebar">
            <div class="nac-admin-sidebar__brand">
                @php $adminLogoSetting = \App\Models\SiteSetting::current(); @endphp
                @if($adminLogoSetting->logo_url)
                    <img src="{{ $adminLogoSetting->logo_url }}" alt="Logo" class="nac-admin-sidebar__brand-mark nac-admin-sidebar__brand-mark--img">
                @else
                    <span class="nac-admin-sidebar__brand-mark">NAC</span>
                @endif
                <span class="nac-admin-sidebar__brand-text">
                    Admin Panel
                    <small>Nugroho Aquatic Club</small>
                </span>
            </div>

            <nav class="nac-admin-nav">
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" title="Dashboard">
                    <i class="bi bi-speedometer2"></i>
                    <span class="nac-admin-nav__label">Dashboard</span>
                </a>

                <span class="nac-admin-nav__group">Konten Website</span>

                @if(auth()->user()->canAccess('sliders'))
                    <a href="{{ route('admin.sliders.index') }}" class="{{ request()->routeIs('admin.sliders.*') ? 'active' : '' }}" title="Slider">
                        <i class="bi bi-images"></i>
                        <span class="nac-admin-nav__label">Slider</span>
                    </a>
                @endif
                @if(auth()->user()->canAccess('galleries'))
                    <a href="{{ route('admin.galleries.index') }}" class="{{ request()->routeIs('admin.galleries.*') ? 'active' : '' }}" title="Galeri">
                        <i class="bi bi-camera"></i>
                        <span class="nac-admin-nav__label">Galeri</span>
                    </a>
                @endif
                @if(auth()->user()->canAccess('schedules'))
                    <a href="{{ route('admin.schedules.index') }}" class="{{ request()->routeIs('admin.schedules.*') ? 'active' : '' }}" title="Jadwal">
                        <i class="bi bi-calendar-week"></i>
                        <span class="nac-admin-nav__label">Jadwal</span>
                    </a>
                @endif
                @if(auth()->user()->canAccess('events'))
                    <a href="{{ route('admin.events.index') }}" class="{{ request()->routeIs('admin.events.*') ? 'active' : '' }}" title="Hasil Pertandingan">
                        <i class="bi bi-calendar-event"></i>
                        <span class="nac-admin-nav__label">Hasil Pertandingan</span>
                    </a>
                @endif
                @if(auth()->user()->canAccess('pricing'))
                    <a href="{{ route('admin.pricing.index') }}" class="{{ request()->routeIs('admin.pricing.*') ? 'active' : '' }}" title="Biaya Pendaftaran">
                        <i class="bi bi-tag"></i>
                        <span class="nac-admin-nav__label">Biaya Pendaftaran</span>
                    </a>
                @endif
                @if(auth()->user()->canAccess('team'))
                    @php
                        $teamNavActive = request()->routeIs('admin.team.*');
                        $teamNavRole = (request('role') === 'pelatih' || optional(request()->route('teamMember'))->role === 'pelatih') ? 'pelatih' : 'atlet';
                    @endphp
                    <div class="nac-admin-nav__dropdown {{ $teamNavActive ? 'is-open' : '' }}" data-nav-dropdown>
                        <button type="button" class="nac-admin-nav__item nac-admin-nav__toggle {{ $teamNavActive ? 'is-active' : '' }}"
                            data-nav-dropdown-toggle aria-expanded="{{ $teamNavActive ? 'true' : 'false' }}" title="Tim">
                            <i class="bi bi-people"></i>
                            <span class="nac-admin-nav__label">Tim</span>
                            <i class="bi bi-chevron-down nac-admin-nav__chevron"></i>
                        </button>
                        <div class="nac-admin-nav__sub">
                            <a href="{{ route('admin.team.index', ['role' => 'atlet']) }}" class="{{ $teamNavActive && $teamNavRole === 'atlet' ? 'active' : '' }}" title="Atlet">
                                <i class="bi bi-trophy"></i>
                                <span class="nac-admin-nav__label">Atlet</span>
                            </a>
                            <a href="{{ route('admin.team.index', ['role' => 'pelatih']) }}" class="{{ $teamNavActive && $teamNavRole === 'pelatih' ? 'active' : '' }}" title="Pelatih">
                                <i class="bi bi-person-workspace"></i>
                                <span class="nac-admin-nav__label">Pelatih</span>
                            </a>
                        </div>
                    </div>
                @endif
                @if(auth()->user()->canAccess('management'))
                    <a href="{{ route('admin.management.index') }}" class="{{ request()->routeIs('admin.management.*') ? 'active' : '' }}" title="Tim Manajemen">
                        <i class="bi bi-person-badge"></i>
                        <span class="nac-admin-nav__label">Tim Manajemen</span>
                    </a>
                @endif
                @if(auth()->user()->canAccess('facilities'))
                    <a href="{{ route('admin.facilities.index') }}" class="{{ request()->routeIs('admin.facilities.*') ? 'active' : '' }}" title="Fasilitas">
                        <i class="bi bi-building"></i>
                        <span class="nac-admin-nav__label">Fasilitas</span>
                    </a>
                @endif
                @if(auth()->user()->canAccess('join-requests'))
                    <a href="{{ route('admin.join-requests.index') }}" class="{{ request()->routeIs('admin.join-requests.*') ? 'active' : '' }}" title="Pendaftaran">
                        <i class="bi bi-person-plus"></i>
                        <span class="nac-admin-nav__label">Pendaftaran</span>
                        @php $navPendingCount = \App\Models\JoinRequest::pending()->count(); @endphp
                        @if($navPendingCount > 0)
                            <span class="badge bg-danger ms-auto">{{ $navPendingCount }}</span>
                        @endif
                    </a>
                @endif

                @if(auth()->user()->canAccess('settings') || auth()->user()->isSuperAdmin())
                    <span class="nac-admin-nav__group">Pengaturan</span>

                    @if(auth()->user()->canAccess('settings'))
                        <a href="{{ route('admin.settings.edit') }}" class="{{ request()->routeIs('admin.settings.*') ? 'active' : '' }}" title="Pengaturan Situs">
                            <i class="bi bi-gear"></i>
                            <span class="nac-admin-nav__label">Pengaturan Situs</span>
                        </a>
                    @endif
                    @if(auth()->user()->isSuperAdmin())
                        <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}" title="Kelola Admin">
                            <i class="bi bi-shield-lock"></i>
                            <span class="nac-admin-nav__label">Kelola Admin</span>
                        </a>
                    @endif
                @endif
                <span class="nac-admin-nav__group">Akun</span>
                <a href="{{ route('admin.password.edit') }}" class="{{ request()->routeIs('admin.password.*') ? 'active' : '' }}" title="Ganti Password">
                    <i class="bi bi-key"></i>
                    <span class="nac-admin-nav__label">Ganti Password</span>
                </a>
                <a href="{{ route('admin.two-factor.show') }}" class="{{ request()->routeIs('admin.two-factor.*') ? 'active' : '' }}" title="Verifikasi Dua Langkah">
                    <i class="bi bi-shield-lock"></i>
                    <span class="nac-admin-nav__label">Verifikasi Dua Langkah</span>
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
                    <a href="{{ route('admin.password.edit') }}" class="nac-admin-topbar__user" title="Ganti password">
                        <span class="nac-admin-topbar__avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                        <div class="d-none d-sm-block">
                            <div class="nac-admin-topbar__user-name">{{ auth()->user()->name }}</div>
                            <div class="nac-admin-topbar__user-role">{{ auth()->user()->isSuperAdmin() ? 'Super Admin' : 'Admin' }}</div>
                        </div>
                    </a>
                </div>
            </header>

            <div class="nac-admin-content">
                @yield('admin_content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/admin.js') }}"></script>
    <script>
        // Konfirmasi hapus (SweetAlert2) — berlaku untuk semua form dengan class "nac-confirm-delete-form"
        // di seluruh halaman admin, cukup didefinisikan sekali di layout ini.
        document.addEventListener('submit', function (e) {
            const form = e.target.closest('.nac-confirm-delete-form');
            if (!form) return;

            e.preventDefault();

            Swal.fire({
                title: form.dataset.confirmTitle || 'Yakin hapus data ini?',
                text: form.dataset.confirmText || 'Data ini akan dihapus secara permanen dan tidak bisa dikembalikan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                reverseButtons: true,
                focusCancel: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    </script>
    @if(session('whatsapp_redirect'))
        <script>
            // PENTING: window.open() otomatis saat halaman dimuat (tanpa klik
            // pengguna) hampir pasti diblokir oleh pop-up blocker browser.
            // Makanya di sini dibungkus jadi tombol konfirmasi (SweetAlert2)
            // dulu — window.open() dipanggil DI DALAM handler klik tombolnya,
            // supaya dianggap browser sebagai aksi asli pengguna, bukan popup liar.
            Swal.fire({
                title: 'Siap kirim pesan WhatsApp?',
                text: 'Pesan sudah disiapkan otomatis sesuai status pendaftaran ini.',
                icon: 'success',
                confirmButtonText: 'Buka WhatsApp',
                confirmButtonColor: '#25D366',
                showCancelButton: true,
                cancelButtonText: 'Nanti saja',
                reverseButtons: true,
            }).then(function (result) {
                if (result.isConfirmed) {
                    window.open("{{ session('whatsapp_redirect') }}", '_blank');
                }
            });
        </script>
    @elseif(session('whatsapp_error'))
        <script>
            Swal.fire({
                title: 'Nomor WhatsApp Tidak Valid',
                text: @json(session('whatsapp_error')),
                icon: 'warning',
                confirmButtonText: 'Mengerti',
                confirmButtonColor: '#dc3545',
            });
        </script>
    @endif
    <script>
        // Buka/tutup menu dropdown di sidebar (mis. Tim > Atlet / Pelatih)
        document.querySelectorAll('[data-nav-dropdown-toggle]').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var box = btn.closest('[data-nav-dropdown]');
                var open = box.classList.toggle('is-open');
                btn.setAttribute('aria-expanded', open ? 'true' : 'false');
            });
        });
    </script>
    @stack('scripts')
</body>
</html>