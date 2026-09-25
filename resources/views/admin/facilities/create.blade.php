@extends('admin.layouts.app')

@section('admin_title', 'Tambah Fasilitas')

@section('admin_content')

    <div class="mb-4">
        <a href="{{ route('admin.facilities.index') }}" class="nac-admin-back-btn">
            <span class="nac-admin-back-btn__icon"><i class="bi bi-arrow-left"></i></span> Kembali ke daftar
        </a>
        <h1 class="h4 fw-bold mt-2 mb-1">Tambah Fasilitas</h1>
    </div>

    <div class="bg-white border rounded-3 p-4">
        <form action="{{ route('admin.facilities.store') }}" method="POST" enctype="multipart/form-data">
            @include('admin.facilities.partials.form')
        </form>
    </div>

@endsection