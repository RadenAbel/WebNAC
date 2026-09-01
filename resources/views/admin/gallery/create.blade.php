@extends('admin.layouts.app')

@section('admin_title', 'Tambah Foto Galeri')

@section('admin_content')

    <div class="mb-4">
        <a href="{{ route('admin.galleries.index') }}" class="nac-admin-back-btn">
            <span class="nac-admin-back-btn__icon"><i class="bi bi-arrow-left"></i></span> Kembali ke galeri
        </a>
        <h1 class="h4 fw-bold mt-2 mb-1">Tambah Foto Galeri</h1>
    </div>

    <div class="bg-white border rounded-3 p-4">
        <form action="{{ route('admin.galleries.store') }}" method="POST" enctype="multipart/form-data">
            @include('admin.gallery.partials.form')

            <div class="mt-4 pt-3 border-top">
                <button type="submit" class="btn nac-admin-btn"><i class="bi bi-check-lg me-1"></i> Simpan</button>
                <a href="{{ route('admin.galleries.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>

@endsection