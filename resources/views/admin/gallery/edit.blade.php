@extends('admin.layouts.app')

@section('admin_title', 'Edit Foto Galeri')

@section('admin_content')

    <div class="mb-4">
        <a href="{{ route('admin.galleries.index') }}" class="text-secondary text-decoration-none" style="font-size:0.85rem;">
            <i class="bi bi-arrow-left"></i> Kembali ke galeri
        </a>
        <h1 class="h4 fw-bold mt-2 mb-1">Edit Foto Galeri</h1>
    </div>

    <div class="bg-white border rounded-3 p-4">
        <form action="{{ route('admin.galleries.update', $gallery) }}" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @include('admin.gallery.partials.form')

            <div class="mt-4 pt-3 border-top">
                <button type="submit" class="btn nac-admin-btn"><i class="bi bi-check-lg me-1"></i> Simpan Perubahan</button>
            </div>
        </form>
    </div>

@endsection