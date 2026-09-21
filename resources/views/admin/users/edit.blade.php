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

    <div class="bg-white border rounded-3 p-4">
        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @method('PUT')
            @include('admin.users.partials.form')
        </form>
    </div>

@endsection