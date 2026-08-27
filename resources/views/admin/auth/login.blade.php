<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Login Admin — Nugroho Aquatic Center</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Plus+Jakarta+Sans:wght@400;600;700;800&family=Roboto+Mono:wght@500;600&display=swap" rel="stylesheet">
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
</head>
<body class="nac-admin-login-body">

    <div class="nac-admin-login-card">
        <div class="nac-admin-login-brand">
            <span class="nac-admin-login-mark">NAC</span>
            <span>Nugroho Aquatic Center</span>
        </div>

        <h1>Masuk ke Admin</h1>
        <p>Kelola konten website dari sini.</p>

        @if ($errors->any())
            <div class="alert alert-danger py-2 px-3 small mb-3">
                {{ $errors->first() }}
            </div>
        @endif

        @if (session('status'))
            <div class="alert alert-success py-2 px-3 small mb-3">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.attempt') }}" novalidate>
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input
                    type="email"
                    name="email"
                    id="email"
                    class="form-control @error('email') is-invalid @enderror"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    autocomplete="username">
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input
                    type="password"
                    name="password"
                    id="password"
                    class="form-control"
                    required
                    autocomplete="current-password">
            </div>

            <div class="form-check mb-3">
                <input type="checkbox" name="remember" class="form-check-input" id="remember">
                <label class="form-check-label" for="remember" style="font-size:0.85rem;">
                    Ingat saya
                </label>
            </div>

            <button type="submit" class="btn nac-admin-btn w-100">Masuk</button>
        </form>

        <a href="{{ route('home') }}" class="nac-admin-back-link">&larr; Kembali ke website</a>
    </div>

</body>
</html>