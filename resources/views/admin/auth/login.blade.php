<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Login Admin — Nugroho Aquatic Club</title>
    <link rel="icon" href="{{ asset('img/Logo.png') }}" type="image/png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
</head>
<body class="nac-admin-login-body">

    <div class="nac-admin-login-card">
        @php $loginSetting = \App\Models\SiteSetting::current(); @endphp
        <div class="nac-admin-login-brand">
            @if($loginSetting->logo_url)
                <img src="{{ $loginSetting->logo_url }}" alt="Logo" class="nac-admin-login-logo">
            @else
                <span class="nac-admin-login-mark">NAC</span>
            @endif
        </div>

        <h1>Selamat datang kembali</h1>
        <p>Masuk untuk mengelola konten <strong>Nugroho Aquatic Club</strong>.</p>

        @if ($errors->any())
            <div class="alert alert-danger py-2 px-3 small mb-3 d-flex align-items-center gap-2">
                <i class="bi bi-exclamation-circle-fill"></i> {{ $errors->first() }}
            </div>
        @endif

        @if (session('status'))
            <div class="alert alert-success py-2 px-3 small mb-3 d-flex align-items-center gap-2">
                <i class="bi bi-check-circle-fill"></i> {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.attempt') }}" novalidate>
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <div class="input-group nac-admin-login-input-group">
                    <span class="input-group-text">
                        <i class="bi bi-envelope"></i>
                    </span>
                    <input
                        type="email"
                        name="email"
                        id="email"
                        class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email') }}"
                        placeholder="admin@nugrohoaquatic.id"
                        required
                        autofocus
                        autocomplete="username">
                </div>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <div class="input-group nac-admin-login-input-group">
                    <span class="input-group-text">
                        <i class="bi bi-lock"></i>
                    </span>
                    <input
                        type="password"
                        name="password"
                        id="password"
                        class="form-control"
                        placeholder="••••••••"
                        required
                        autocomplete="current-password">
                    <button type="button" class="nac-admin-login-eye" data-toggle-password="password" aria-label="Tampilkan/sembunyikan password">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
            </div>

            <div class="form-check mb-4">
                <input type="checkbox" name="remember" class="form-check-input" id="remember">
                <label class="form-check-label nac-admin-login-remember" for="remember">
                    Ingat saya di perangkat ini
                </label>
            </div>

            <button type="submit" class="btn nac-admin-btn w-100 justify-content-center py-2">
                Masuk <i class="bi bi-arrow-right"></i>
            </button>
        </form>

        <a href="{{ route('home') }}" class="nac-admin-back-link">
            <i class="bi bi-arrow-left"></i> Kembali ke website
        </a>
    </div>

    <script>
        // Ikon mata di input password (halaman login tidak memuat admin.js)
        document.addEventListener('click', function (e) {
            var btn = e.target.closest('[data-toggle-password]');
            if (!btn) return;
            var input = document.getElementById(btn.getAttribute('data-toggle-password'));
            if (!input) return;
            var show = input.type === 'password';
            input.type = show ? 'text' : 'password';
            btn.setAttribute('aria-pressed', show ? 'true' : 'false');
            btn.querySelector('i').className = show ? 'bi bi-eye-slash' : 'bi bi-eye';
        });
    </script>
</body>
</html>