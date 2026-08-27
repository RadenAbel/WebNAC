@extends('admin.layouts.app')

@section('admin_title', 'Dashboard')

@section('admin_content')

    <h1 class="h4 fw-bold mb-1">Dashboard</h1>
    <p class="text-secondary mb-4" style="font-size:0.9rem;">
        Ringkasan konten website Nugroho Aquatic Center saat ini.
    </p>

    <div class="row g-3">
        <div class="col-6 col-lg-3">
            <div class="nac-admin-stat-card">
                <div class="nac-admin-stat-card__label">Total Tim</div>
                <div class="nac-admin-stat-card__num">{{ $totalTeam }}</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="nac-admin-stat-card">
                <div class="nac-admin-stat-card__label">Pelatih</div>
                <div class="nac-admin-stat-card__num">{{ $totalCoaches }}</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="nac-admin-stat-card">
                <div class="nac-admin-stat-card__label">Atlet</div>
                <div class="nac-admin-stat-card__num">{{ $totalAthletes }}</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="nac-admin-stat-card">
                <div class="nac-admin-stat-card__label">Foto Galeri</div>
                <div class="nac-admin-stat-card__num">{{ $totalGalleries }}</div>
            </div>
        </div>
    </div>

    <div class="alert alert-info mt-4" style="font-size:0.88rem;">
        <i class="bi bi-info-circle me-1"></i>
        Menu <strong>Slider</strong>, <strong>Galeri</strong>, <strong>Jadwal</strong>, <strong>Tim</strong>, dan
        <strong>Pengaturan Situs</strong> di sidebar akan aktif di tahap berikutnya — sistem login ini adalah
        fondasinya dulu.
    </div>

@endsection