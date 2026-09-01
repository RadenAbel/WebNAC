@extends('admin.layouts.app')

@section('admin_title', 'Edit Acara')

@section('admin_content')

    <div class="mb-4">
        <a href="{{ route('admin.events.index') }}" class="nac-admin-back-btn">
            <span class="nac-admin-back-btn__icon"><i class="bi bi-arrow-left"></i></span> Kembali ke daftar acara
        </a>
        <h1 class="h4 mt-3 mb-1">Edit Acara</h1>
    </div>

    <div class="bg-white border rounded-3 p-4">
        <form action="{{ route('admin.events.update', $event) }}" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @include('admin.event.partials.form')

            <div class="mt-4 pt-3 border-top">
                <button type="submit" class="btn nac-admin-btn"><i class="bi bi-check-lg"></i> Simpan Perubahan</button>
            </div>
        </form>
    </div>

@endsection