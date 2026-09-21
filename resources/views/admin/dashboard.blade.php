@extends('admin.layouts.app')

@section('admin_title', 'Dashboard')

@section('admin_content')

    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <div class="nac-admin-stat-card">
                <div>
                    <div class="nac-admin-stat-card__label">Total Tim</div>
                    <div class="nac-admin-stat-card__num">{{ $totalTeam }}</div>
                </div>
                <span class="nac-admin-stat-card__icon"><i class="bi bi-people"></i></span>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="nac-admin-stat-card">
                <div>
                    <div class="nac-admin-stat-card__label">Pelatih</div>
                    <div class="nac-admin-stat-card__num">{{ $totalCoaches }}</div>
                </div>
                <span class="nac-admin-stat-card__icon"><i class="bi bi-person-badge"></i></span>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="nac-admin-stat-card">
                <div>
                    <div class="nac-admin-stat-card__label">Atlet</div>
                    <div class="nac-admin-stat-card__num">{{ $totalAthletes }}</div>
                </div>
                <span class="nac-admin-stat-card__icon"><i class="bi bi-trophy"></i></span>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="nac-admin-stat-card">
                <div>
                    <div class="nac-admin-stat-card__label">Foto Galeri</div>
                    <div class="nac-admin-stat-card__num">{{ $totalGalleries }}</div>
                </div>
                <span class="nac-admin-stat-card__icon"><i class="bi bi-camera"></i></span>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-lg-8">
            <div class="bg-white border rounded-3 p-4 h-100">
                <h2 class="h6 mb-3" style="border:none; padding:0; margin:0 0 1rem;">Akses Cepat</h2>
                <div class="row g-3">
                    <div class="col-md-6">
                        <a href="{{ route('admin.team.create') }}" class="d-flex align-items-center gap-3 p-3 rounded-3 text-decoration-none" style="border:1px solid #E5E9EF; color:#1C2530; transition:.15s;" onmouseover="this.style.borderColor='#1E6FA8'" onmouseout="this.style.borderColor='#E5E9EF'">
                            <span class="nac-admin-stat-card__icon"><i class="bi bi-person-plus"></i></span>
                            <div>
                                <div class="fw-bold" style="font-size:0.88rem;">Tambah Anggota Tim</div>
                                <div class="text-secondary" style="font-size:0.78rem;">Pelatih atau atlet baru</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('admin.sliders.create') }}" class="d-flex align-items-center gap-3 p-3 rounded-3 text-decoration-none" style="border:1px solid #E5E9EF; color:#1C2530; transition:.15s;" onmouseover="this.style.borderColor='#1E6FA8'" onmouseout="this.style.borderColor='#E5E9EF'">
                            <span class="nac-admin-stat-card__icon"><i class="bi bi-images"></i></span>
                            <div>
                                <div class="fw-bold" style="font-size:0.88rem;">Tambah Slider</div>
                                <div class="text-secondary" style="font-size:0.78rem;">Foto hero beranda</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('admin.galleries.create') }}" class="d-flex align-items-center gap-3 p-3 rounded-3 text-decoration-none" style="border:1px solid #E5E9EF; color:#1C2530; transition:.15s;" onmouseover="this.style.borderColor='#1E6FA8'" onmouseout="this.style.borderColor='#E5E9EF'">
                            <span class="nac-admin-stat-card__icon"><i class="bi bi-camera"></i></span>
                            <div>
                                <div class="fw-bold" style="font-size:0.88rem;">Tambah Foto Galeri</div>
                                <div class="text-secondary" style="font-size:0.78rem;">Untuk section Galeri</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('admin.settings.edit') }}" class="d-flex align-items-center gap-3 p-3 rounded-3 text-decoration-none" style="border:1px solid #E5E9EF; color:#1C2530; transition:.15s;" onmouseover="this.style.borderColor='#1E6FA8'" onmouseout="this.style.borderColor='#E5E9EF'">
                            <span class="nac-admin-stat-card__icon"><i class="bi bi-gear"></i></span>
                            <div>
                                <div class="fw-bold" style="font-size:0.88rem;">Pengaturan Situs</div>
                                <div class="text-secondary" style="font-size:0.78rem;">Kontak, sosmed, lokasi</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="bg-white border rounded-3 p-4">
                <h2 class="h6 mb-3" style="border:none; padding:0; margin:0 0 1rem;">Ringkasan</h2>
                <ul class="list-unstyled mb-0" style="font-size:0.85rem;">
                    <li class="d-flex justify-content-between align-items-center py-2" style="border-bottom:1px solid #F0F2F5;">
                        <span class="text-secondary">Jadwal Aktif</span>
                        <span class="fw-bold">{{ $totalSchedules }}</span>
                    </li>
                    <li class="d-flex justify-content-between align-items-center py-2">
                        <span class="text-secondary">Total Anggota Tim</span>
                        <span class="fw-bold">{{ $totalTeam }}</span>
                    </li>
                </ul>
            </div>

            <div class="bg-white border rounded-3 p-4 mt-3">
                <h2 class="h6 mb-3" style="border:none; padding:0; margin:0 0 1rem;">
                    <i class="bi bi-award text-warning me-1"></i> Prestasi Terbaru
                </h2>

                @forelse ($recentAchievements as $i => $achievement)
                    @if ($i < 2)
                        <div class="nac-achievement-item">
                            <span class="nac-achievement-item__icon"><i class="bi bi-award-fill"></i></span>
                            <div>
                                <div class="nac-achievement-item__title">{{ $achievement->title }}</div>
                                <div class="nac-achievement-item__meta">
                                    {{ $achievement->teamMember->name ?? '-' }}
                                    @if ($achievement->year) · {{ $achievement->year }} @endif
                                </div>
                            </div>
                        </div>
                    @endif
                @empty
                    <p class="text-secondary mb-0" style="font-size:0.85rem;">Belum ada pencapaian yang diinput.</p>
                @endforelse

                @if ($recentAchievements->count() > 2)
                    <div data-stack-group>
                        <div class="nac-admin-stack-more" data-stack-content style="display:none;">
                            @foreach ($recentAchievements->slice(2) as $achievement)
                                <div class="nac-achievement-item">
                                    <span class="nac-achievement-item__icon"><i class="bi bi-award-fill"></i></span>
                                    <div>
                                        <div class="nac-achievement-item__title">{{ $achievement->title }}</div>
                                        <div class="nac-achievement-item__meta">
                                            {{ $achievement->teamMember->name ?? '-' }}
                                            @if ($achievement->year) · {{ $achievement->year }} @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <button type="button" class="btn btn-sm btn-outline-secondary w-100 mt-3" data-stack-trigger
                            data-label-closed="Lihat Selengkapnya" data-label-open="Tutup">
                            <span data-stack-trigger-text>Lihat Selengkapnya</span>
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection