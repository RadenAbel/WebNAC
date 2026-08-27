@extends('admin.layouts.app')

@section('admin_title', 'Tambah Anggota Tim')

@section('admin_content')

    <div class="mb-4">
        <a href="{{ route('admin.team.index') }}" class="text-secondary text-decoration-none" style="font-size:0.85rem;">
            <i class="bi bi-arrow-left"></i> Kembali ke daftar tim
        </a>
        <h1 class="h4 fw-bold mt-2 mb-1">Tambah Anggota Tim</h1>
        <p class="text-secondary mb-0" style="font-size:0.9rem;">
            Rekor waktu &amp; pencapaian bisa ditambahkan setelah data ini disimpan.
        </p>
    </div>

    <div class="bg-white border rounded-3 p-4">
        <form action="{{ route('admin.team.store') }}" method="POST" enctype="multipart/form-data">
            @include('admin.team.partials.form')

            <div class="mt-4 pt-3 border-top">
                <button type="submit" class="btn nac-admin-btn">
                    <i class="bi bi-check-lg me-1"></i> Simpan
                </button>
                <a href="{{ route('admin.team.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>

@endsection