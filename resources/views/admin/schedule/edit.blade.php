@extends('admin.layouts.app')

@section('admin_title', 'Edit Jadwal')

@section('admin_content')

    <div class="mb-4">
        <a href="{{ route('admin.schedules.index') }}" class="text-secondary text-decoration-none" style="font-size:0.85rem;">
            <i class="bi bi-arrow-left"></i> Kembali ke daftar jadwal
        </a>
        <h1 class="h4 fw-bold mt-2 mb-1">Edit Jadwal: {{ $schedule->category }}</h1>
    </div>

    <div class="bg-white border rounded-3 p-4">
        <form action="{{ route('admin.schedules.update', $schedule) }}" method="POST">
            @method('PUT')
            @include('admin.schedule.partials.form')

            <div class="mt-4 pt-3 border-top">
                <button type="submit" class="btn nac-admin-btn"><i class="bi bi-check-lg me-1"></i> Simpan Perubahan</button>
            </div>
        </form>
    </div>

@endsection