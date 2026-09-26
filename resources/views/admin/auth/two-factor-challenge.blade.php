<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Verifikasi Dua Langkah — Nugroho Aquatic Club</title>
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

        <h1>Verifikasi Dua Langkah</h1>
        <p id="twoFactorHint">Buka aplikasi authenticator di HP Anda, lalu masukkan kode 6 digit yang tampil.</p>

        @if ($errors->any())
            <div class="alert alert-danger py-2 px-3 small mb-3 d-flex align-items-center gap-2">
                <i class="bi bi-exclamation-circle-fill"></i> {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.two-factor.verify') }}" novalidate>
            @csrf

            {{-- Kode dari aplikasi authenticator --}}
            <div class="mb-3" id="codeField">
                <label for="code" class="form-label">Kode Verifikasi</label>
                <div class="input-group nac-admin-login-input-group">
                    <span class="input-group-text"><i class="bi bi-shield-lock"></i></span>
                    <input type="text" name="code" id="code" class="form-control nac-admin-otp-input"
                        inputmode="numeric" autocomplete="one-time-code" maxlength="7"
                        placeholder="000000" autofocus>
                </div>
            </div>

            {{-- Kode pemulihan (kalau HP tidak tersedia) — disembunyikan dulu --}}
            <div class="mb-3" id="recoveryField" hidden>
                <label for="recovery_code" class="form-label">Kode Pemulihan</label>
                <div class="input-group nac-admin-login-input-group">
                    <span class="input-group-text"><i class="bi bi-key"></i></span>
                    <input type="text" name="recovery_code" id="recovery_code" class="form-control"
                        autocomplete="off" placeholder="XXXXX-XXXXX" disabled>
                </div>
            </div>

            <button type="submit" class="btn nac-admin-btn w-100 justify-content-center py-2">
                Verifikasi <i class="bi bi-arrow-right"></i>
            </button>
        </form>

        <button type="button" class="btn btn-link w-100 mt-2 p-0" id="toggleRecovery" style="font-size:0.85rem;">
            Tidak bisa membuka aplikasi? Pakai kode pemulihan
        </button>

        <a href="{{ route('login') }}" class="nac-admin-back-link">
            <i class="bi bi-arrow-left"></i> Kembali ke halaman login
        </a>
    </div>

    <script>
        // Ganti antara kode aplikasi <-> kode pemulihan. Input yang tidak
        // dipakai dimatikan supaya tidak ikut terkirim.
        (function () {
            var toggle = document.getElementById('toggleRecovery');
            var codeField = document.getElementById('codeField');
            var recoveryField = document.getElementById('recoveryField');
            var code = document.getElementById('code');
            var recovery = document.getElementById('recovery_code');
            var hint = document.getElementById('twoFactorHint');
            var usingRecovery = false;

            toggle.addEventListener('click', function () {
                usingRecovery = !usingRecovery;
                codeField.hidden = usingRecovery;
                recoveryField.hidden = !usingRecovery;
                code.disabled = usingRecovery;
                recovery.disabled = !usingRecovery;
                (usingRecovery ? recovery : code).focus();
                toggle.textContent = usingRecovery
                    ? 'Pakai kode dari aplikasi authenticator'
                    : 'Tidak bisa membuka aplikasi? Pakai kode pemulihan';
                hint.textContent = usingRecovery
                    ? 'Masukkan salah satu kode pemulihan yang Anda simpan saat mengaktifkan verifikasi dua langkah. Setiap kode hanya bisa dipakai sekali.'
                    : 'Buka aplikasi authenticator di HP Anda, lalu masukkan kode 6 digit yang tampil.';
            });
        })();
    </script>
</body>
</html>