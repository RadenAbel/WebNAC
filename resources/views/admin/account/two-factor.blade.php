@extends('admin.layouts.app')

@section('admin_title', 'Verifikasi Dua Langkah')

@section('admin_content')

    <div class="mb-4">
        <h1 class="h4 mb-1">Verifikasi Dua Langkah</h1>
        <p class="text-secondary mb-0" style="font-size:0.9rem;">
            Lapisan keamanan tambahan: setelah memasukkan password, login juga meminta kode 6 digit dari aplikasi di HP Anda.
        </p>
    </div>

    @include('admin.partials.toast')

    {{-- ============ KODE PEMULIHAN (hanya tampil SEKALI setelah dibuat) ============ --}}
    @if (session('recovery_codes'))
        <div class="bg-white border rounded-3 p-4 mb-4" style="border-color:#F0B429 !important;">
            <p class="fw-bold mb-1"><i class="bi bi-exclamation-triangle-fill text-warning me-1"></i> Simpan kode pemulihan ini sekarang</p>
            <p class="text-secondary mb-3" style="font-size:0.85rem;">
                Kode ini <strong>hanya ditampilkan sekali</strong>. Pakai salah satunya untuk login kalau HP Anda hilang atau rusak.
                Setiap kode hanya bisa dipakai sekali. Simpan di tempat aman (misalnya dicetak atau dicatat), jangan di HP yang sama.
            </p>
            <div class="row g-2 mb-3" style="font-family:'Poppins', sans-serif;">
                @foreach (session('recovery_codes') as $code)
                    <div class="col-6 col-md-3">
                        <div class="border rounded-2 text-center py-2" style="background:#fafbfc; font-size:0.9rem;">{{ $code }}</div>
                    </div>
                @endforeach
            </div>
            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="window.print()">
                <i class="bi bi-printer"></i> Cetak
            </button>
        </div>
    @endif

    @if ($enabled)
        {{-- ============ SUDAH AKTIF ============ --}}
        <div class="bg-white border rounded-3 p-4 mb-4">
            <div class="d-flex align-items-center gap-2 mb-2">
                <span class="badge bg-success"><i class="bi bi-shield-check"></i> Aktif</span>
                <span class="fw-bold">Verifikasi dua langkah sedang aktif untuk akun ini.</span>
            </div>
            <p class="text-secondary mb-0" style="font-size:0.85rem;">
                Sisa kode pemulihan yang belum dipakai: <strong>{{ $remainingCodes }}</strong> dari 8.
                @if ($remainingCodes <= 2)
                    <span class="text-danger">Sebaiknya buat kode pemulihan baru.</span>
                @endif
            </p>
        </div>

        <div class="row g-4">
            <div class="col-lg-6">
                <div class="bg-white border rounded-3 p-4 h-100">
                    <p class="fw-bold mb-1">Buat Kode Pemulihan Baru</p>
                    <p class="text-secondary" style="font-size:0.85rem;">Kode pemulihan lama langsung tidak berlaku lagi.</p>
                    <form action="{{ route('admin.two-factor.recovery-codes') }}" method="POST">
                        @csrf
                        <label for="regenPassword" class="form-label">Password Anda</label>
                        <div class="input-group has-validation mb-3">
                            <input type="password" name="current_password" id="regenPassword" autocomplete="current-password"
                                class="form-control @if($errors->has('current_password') && old('_action') === 'regen') is-invalid @endif" required>
                            <button type="button" class="btn btn-outline-secondary" data-toggle-password="regenPassword" aria-label="Tampilkan/sembunyikan password"><i class="bi bi-eye"></i></button>
                            @if ($errors->has('current_password') && old('_action') === 'regen')
                                <div class="invalid-feedback">{{ $errors->first('current_password') }}</div>
                            @endif
                        </div>
                        <input type="hidden" name="_action" value="regen">
                        <button type="submit" class="btn nac-admin-btn"><i class="bi bi-arrow-repeat"></i> Buat Kode Baru</button>
                    </form>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="bg-white border rounded-3 p-4 h-100">
                    <p class="fw-bold mb-1 text-danger">Nonaktifkan Verifikasi Dua Langkah</p>
                    <p class="text-secondary" style="font-size:0.85rem;">Login akan kembali hanya memakai email & password. Tidak disarankan.</p>
                    <form action="{{ route('admin.two-factor.disable') }}" method="POST" class="nac-confirm-delete-form"
                        data-confirm-title="Nonaktifkan verifikasi dua langkah?"
                        data-confirm-text="Akun Anda jadi hanya dilindungi password.">
                        @csrf
                        @method('DELETE')
                        <label for="disablePassword" class="form-label">Password Anda</label>
                        <div class="input-group has-validation mb-3">
                            <input type="password" name="current_password" id="disablePassword" autocomplete="current-password"
                                class="form-control @if($errors->has('current_password') && old('_action') === 'disable') is-invalid @endif" required>
                            <button type="button" class="btn btn-outline-secondary" data-toggle-password="disablePassword" aria-label="Tampilkan/sembunyikan password"><i class="bi bi-eye"></i></button>
                            @if ($errors->has('current_password') && old('_action') === 'disable')
                                <div class="invalid-feedback">{{ $errors->first('current_password') }}</div>
                            @endif
                        </div>
                        <input type="hidden" name="_action" value="disable">
                        <button type="submit" class="btn btn-outline-danger"><i class="bi bi-shield-x"></i> Nonaktifkan</button>
                    </form>
                </div>
            </div>
        </div>
    @else
        {{-- ============ BELUM AKTIF: panduan aktivasi ============ --}}
        <div class="bg-white border rounded-3 p-4">
            <div class="row g-4 align-items-start">
                <div class="col-lg-5">
                    <p class="fw-bold mb-1">1. Pasang aplikasi authenticator</p>
                    <p class="text-secondary" style="font-size:0.85rem;">
                        Misalnya <strong>Google Authenticator</strong> atau <strong>Microsoft Authenticator</strong> (gratis di Play Store / App Store).
                    </p>

                    <p class="fw-bold mb-1">2. Pindai QR code ini</p>
                    <p class="text-secondary mb-2" style="font-size:0.85rem;">Di aplikasi, pilih tambah akun lalu pindai kode di bawah.</p>
                    <div class="d-inline-block border rounded-3 p-2 bg-white mb-2">{!! $qrSvg !!}</div>
                    <p class="text-secondary mb-1" style="font-size:0.8rem;">Tidak bisa memindai? Masukkan kode ini secara manual:</p>
                    <code class="d-inline-block px-2 py-1 rounded-2" style="background:#F5F7FA; font-size:0.85rem; word-break:break-all;">{{ trim(chunk_split($secret, 4, ' ')) }}</code>
                </div>

                <div class="col-lg-7">
                    <p class="fw-bold mb-1">3. Masukkan kode 6 digit dari aplikasi</p>
                    <p class="text-secondary" style="font-size:0.85rem;">
                        Setelah berhasil, Anda akan mendapat 8 kode pemulihan. Simpan baik-baik untuk berjaga-jaga kalau HP hilang.
                    </p>
                    <form action="{{ route('admin.two-factor.confirm') }}" method="POST" novalidate>
                        @csrf
                        <div class="mb-3" style="max-width:260px;">
                            <input type="text" name="code" inputmode="numeric" autocomplete="one-time-code" maxlength="7"
                                class="form-control form-control-lg text-center @error('code') is-invalid @enderror"
                                style="letter-spacing:0.3em; font-family:'Poppins', sans-serif;" placeholder="000000" required>
                            @error('code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <button type="submit" class="btn nac-admin-btn"><i class="bi bi-shield-check"></i> Aktifkan</button>
                    </form>
                </div>
            </div>
        </div>
    @endif

@endsection