@extends('admin.layouts.app')

@section('admin_title', 'Tambah Jadwal')

@section('admin_content')

    <div class="mb-4">
        <a href="{{ route('admin.schedules.index') }}" class="nac-admin-back-btn">
            <span class="nac-admin-back-btn__icon"><i class="bi bi-arrow-left"></i></span> Kembali ke daftar jadwal
        </a>
        <h1 class="h4 fw-bold mt-2 mb-1">Tambah Jadwal</h1>
    </div>

    <div class="bg-white border rounded-3 p-4">
        <form action="{{ route('admin.schedules.store') }}" method="POST">
            @include('admin.schedule.partials.form')

            <div class="mt-4 pt-3 border-top">
                <button type="submit" class="btn nac-admin-btn"><i class="bi bi-check-lg me-1"></i> Simpan</button>
                <a href="{{ route('admin.schedules.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>

@endsection