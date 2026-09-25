@extends('admin.layouts.app')

@section('admin_title', $activeRole === 'pelatih' ? 'Data Pelatih' : 'Data Atlet')

@section('admin_content')

    @php $roleName = $activeRole === 'pelatih' ? 'Pelatih' : 'Atlet'; @endphp

    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-4">
        <div>
            <h1 class="h4 mb-1">Data {{ $roleName }}</h1>
            <p class="text-secondary mb-0" style="font-size:0.9rem;">
                {{ $activeRole === 'pelatih' ? 'Kelola profil dan lisensi pelatih.' : 'Kelola profil, rekor waktu, dan prestasi atlet.' }}
            </p>
        </div>
        <a href="{{ route('admin.team.create', ['role' => $activeRole]) }}" class="btn nac-admin-btn">
            <i class="bi bi-plus-lg"></i> Tambah {{ $roleName }}
        </a>
    </div>

    @include('admin.partials.toast')

    <div class="bg-white border rounded-3 overflow-hidden d-none d-md-block">
        @if ($members->isEmpty())
            <div class="nac-admin-empty">
                <div class="nac-admin-empty__icon"><i class="bi bi-people"></i></div>
                <p class="nac-admin-empty__title">Belum ada data</p>
                <p class="nac-admin-empty__desc">Tambahkan {{ strtolower($roleName) }} pertama untuk mulai.</p>
                <a href="{{ route('admin.team.create', ['role' => $activeRole]) }}" class="btn nac-admin-btn">
                    <i class="bi bi-plus-lg"></i> Tambah {{ $roleName }}
                </a>
            </div>
        @else
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width:60px;">Foto</th>
                        <th>Nama</th>
                        <th>Peran</th>
                        <th>Kategori</th>
                        <th class="text-center">Status</th>
                        <th class="text-end" style="width:160px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($members as $member)
                        <tr>
                            <td>
                                @if ($member->photo_url)
                                    <img src="{{ $member->photo_url }}" alt="{{ $member->name }}"
                                        style="width:42px; height:42px; object-fit:cover; border-radius:50%; border:2px solid #fff; box-shadow:0 0 0 1px #E5E9EF;">
                                @else
                                    <div style="width:42px; height:42px; border-radius:50%; background:#F5F7FA; color:#94A3B8; display:flex; align-items:center; justify-content:center; font-size:0.75rem; font-weight:800;">
                                        {{ strtoupper(substr($member->name, 0, 1)) }}
                                    </div>
                                @endif
                            </td>
                            <td class="fw-bold">{{ $member->name }}</td>
                            <td>
                                <span class="badge {{ $member->role === 'pelatih' ? 'bg-primary' : 'bg-info' }}">
                                    {{ ucfirst($member->role) }}
                                </span>
                            </td>
                            <td>{{ $member->category ?? '-' }}</td>
                            <td class="text-center">
                                @if ($member->is_active)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Nonaktif</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.team.edit', $member) }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('admin.team.destroy', $member) }}" method="POST" class="d-inline nac-confirm-delete-form"
                                    data-confirm-title="Hapus {{ $member->name }}?"
                                    data-confirm-text="Rekor & pencapaiannya juga akan ikut terhapus secara permanen.">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    {{-- ============ VERSI KARTU (khusus mobile, < 768px) ============ --}}
    <div class="d-md-none">
        @if ($members->isEmpty())
            <div class="bg-white border rounded-3">
                <div class="nac-admin-empty">
                    <div class="nac-admin-empty__icon"><i class="bi bi-people"></i></div>
                    <p class="nac-admin-empty__title">Belum ada data</p>
                    <p class="nac-admin-empty__desc">Tambahkan {{ strtolower($roleName) }} pertama untuk mulai.</p>
                    <a href="{{ route('admin.team.create', ['role' => $activeRole]) }}" class="btn nac-admin-btn">
                        <i class="bi bi-plus-lg"></i> Tambah {{ $roleName }}
                    </a>
                </div>
            </div>
        @else
            <div class="d-flex flex-column gap-2">
                @foreach ($members as $member)
                    <div class="nac-admin-member-card">
                        <div class="nac-admin-member-card__top">
                            @if ($member->photo_url)
                                <img src="{{ $member->photo_url }}" alt="{{ $member->name }}" class="nac-admin-member-card__photo">
                            @else
                                <div class="nac-admin-member-card__photo nac-admin-member-card__photo--fallback">
                                    {{ strtoupper(substr($member->name, 0, 1)) }}
                                </div>
                            @endif

                            <div class="nac-admin-member-card__info">
                                <div class="nac-admin-member-card__name">{{ $member->name }}</div>
                                <div class="d-flex flex-wrap gap-1 mt-1">
                                    <span class="badge {{ $member->role === 'pelatih' ? 'bg-primary' : 'bg-info' }}">
                                        {{ ucfirst($member->role) }}
                                    </span>
                                    @if ($member->category)
                                        <span class="badge bg-secondary">{{ $member->category }}</span>
                                    @endif
                                    @if ($member->is_active)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-secondary">Nonaktif</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="nac-admin-member-card__actions">
                            <a href="{{ route('admin.team.edit', $member) }}" class="btn btn-sm btn-outline-secondary flex-grow-1">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            <form action="{{ route('admin.team.destroy', $member) }}" method="POST" class="flex-grow-1 nac-confirm-delete-form"
                                data-confirm-title="Hapus {{ $member->name }}?"
                                data-confirm-text="Rekor & pencapaiannya juga akan ikut terhapus secara permanen.">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger w-100">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    @if ($members->isNotEmpty())
        <div class="mt-3">
            {{ $members->links() }}
        </div>
    @endif

@endsection