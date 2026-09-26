@extends('admin.layouts.app')

@section('admin_title', 'Edit Akun Admin')

@section('admin_content')

    <div class="mb-4">
        <a href="{{ route('admin.users.index') }}" class="nac-admin-back-btn">
            <span class="nac-admin-back-btn__icon"><i class="bi bi-arrow-left"></i></span> Kembali ke daftar
        </a>
        <h1 class="h4 fw-bold mt-2 mb-1">Edit Akun: {{ $user->name }}</h1>
    </div>

    @if ($user->id === auth()->id())
        <div class="alert alert-warning py-2 px-3 mb-3" style="font-size:0.85rem;">
            <i class="bi bi-info-circle me-1"></i> Ini akun yang sedang Anda pakai sendiri — hati-hati mengubah role-nya sendiri jadi bukan Super Admin, karena bisa kehilangan akses ke Pengaturan Situs.
        </div>
    @endif

    @include('admin.partials.toast')

    <div class="bg-white border rounded-3 p-3 mb-3 d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div style="font-size:0.9rem;">
            <i class="bi bi-shield-lock me-1"></i> Verifikasi dua langkah:
            @if ($user->hasTwoFactorEnabled())
                <span class="badge bg-success">Aktif</span>
            @else
                <span class="badge bg-secondary">Tidak aktif</span>
            @endif
        </div>
        @if ($user->hasTwoFactorEnabled() && $user->id !== auth()->id())
            <form action="{{ route('admin.users.two-factor.reset', $user) }}" method="POST" class="nac-confirm-delete-form"
                data-confirm-title="Reset verifikasi dua langkah {{ $user->name }}?"
                data-confirm-text="Akun ini bisa login hanya dengan email & password sampai 2FA diaktifkan lagi. Lakukan ini hanya kalau pemiliknya kehilangan HP dan kode pemulihan.">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-arrow-counterclockwise"></i> Reset 2FA</button>
            </form>
        @endif
    </div>

    <div class="bg-white border rounded-3 p-4">
        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @method('PUT')
            @include('admin.users.partials.form')
        </form>
    </div>

@endsection