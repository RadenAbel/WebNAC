<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Login Admin — Nugroho Aquatic Center</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Plus+Jakarta+Sans:wght@400;600;700;800&family=Roboto+Mono:wght@500;600&display=swap" rel="stylesheet">
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
</head>
<body class="nac-admin-login-body">

    <div class="nac-admin-login-card">
        <div class="nac-admin-login-brand">
            <span class="nac-admin-login-mark">NAC</span>
            <span>Nugroho Aquatic Center</span>
        </div>

        <h1>Selamat datang kembali</h1>
        <p>Masuk untuk mengelola konten website.</p>

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
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0" style="border-color:#E5E9EF; border-radius:8px 0 0 8px;">
                        <i class="bi bi-envelope text-secondary"></i>
                    </span>
                    <input
                        type="email"
                        name="email"
                        id="email"
                        class="form-control border-start-0 @error('email') is-invalid @enderror"
                        style="border-radius:0 8px 8px 0;"
                        value="{{ old('email') }}"
                        placeholder="admin@nugrohoaquatic.id"
                        required
                        autofocus
                        autocomplete="username">
                </div>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0" style="border-color:#E5E9EF; border-radius:8px 0 0 8px;">
                        <i class="bi bi-lock text-secondary"></i>
                    </span>
                    <input
                        type="password"
                        name="password"
                        id="password"
                        class="form-control border-start-0"
                        style="border-radius:0 8px 8px 0;"
                        placeholder="••••••••"
                        required
                        autocomplete="current-password">
                </div>
            </div>

            <div class="form-check mb-4">
                <input type="checkbox" name="remember" class="form-check-input" id="remember">
                <label class="form-check-label" for="remember" style="font-size:0.85rem; color:#64748B;">
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

</body>
</html>