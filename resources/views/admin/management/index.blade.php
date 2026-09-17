@extends('admin.layouts.app')

@section('admin_title', 'Tim Manajemen')

@section('admin_content')

    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-4">
        <div>
            <h1 class="h4 mb-1">Tim Manajemen</h1>
            <p class="text-secondary mb-0" style="font-size:0.9rem;">
                Kelola anggota Tim Manajemen yang tampil di halaman Tentang Kami.
            </p>
        </div>
        <a href="{{ route('admin.management.create') }}" class="btn nac-admin-btn">
            <i class="bi bi-plus-lg"></i> Tambah Anggota
        </a>
    </div>

    @if (session('status'))
        <div class="alert alert-success py-2 px-3 mb-3" style="font-size:0.9rem;">{{ session('status') }}</div>
    @endif

    <div class="bg-white border rounded-3 overflow-hidden d-none d-md-block">
        @if ($managementMembers->isEmpty())
            <div class="nac-admin-empty">
                <div class="nac-admin-empty__icon"><i class="bi bi-person-badge"></i></div>
                <p class="nac-admin-empty__title">Belum ada data</p>
                <p class="nac-admin-empty__desc">Tambahkan anggota Tim Manajemen pertama untuk mulai.</p>
                <a href="{{ route('admin.management.create') }}" class="btn nac-admin-btn">
                    <i class="bi bi-plus-lg"></i> Tambah Anggota
                </a>
            </div>
        @else
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width:60px;">Foto</th>
                        <th>Nama</th>
                        <th>Jabatan</th>
                        <th class="text-center">Status</th>
                        <th class="text-end" style="width:160px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($managementMembers as $member)
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
                            <td>{{ $member->position }}</td>
                            <td class="text-center">
                                @if ($member->is_active)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Nonaktif</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.management.edit', $member) }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('admin.management.destroy', $member) }}" method="POST" class="d-inline nac-confirm-delete-form"
                                    data-confirm-title="Hapus {{ $member->name }}?"
                                    data-confirm-text="Data anggota tim manajemen ini akan terhapus secara permanen.">
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
        @if ($managementMembers->isEmpty())
            <div class="bg-white border rounded-3">
                <div class="nac-admin-empty">
                    <div class="nac-admin-empty__icon"><i class="bi bi-person-badge"></i></div>
                    <p class="nac-admin-empty__title">Belum ada data</p>
                    <p class="nac-admin-empty__desc">Tambahkan anggota Tim Manajemen pertama untuk mulai.</p>
                    <a href="{{ route('admin.management.create') }}" class="btn nac-admin-btn">
                        <i class="bi bi-plus-lg"></i> Tambah Anggota
                    </a>
                </div>
            </div>
        @else
            <div class="d-flex flex-column gap-2">
                @foreach ($managementMembers as $member)
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
                                <div class="text-secondary" style="font-size:0.82rem;">{{ $member->position }}</div>
                                <div class="d-flex flex-wrap gap-1 mt-1">
                                    @if ($member->is_active)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-secondary">Nonaktif</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="nac-admin-member-card__actions">
                            <a href="{{ route('admin.management.edit', $member) }}" class="btn btn-sm btn-outline-secondary flex-grow-1">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            <form action="{{ route('admin.management.destroy', $member) }}" method="POST" class="flex-grow-1 nac-confirm-delete-form"
                                data-confirm-title="Hapus {{ $member->name }}?"
                                data-confirm-text="Data anggota tim manajemen ini akan terhapus secara permanen.">
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

    @if ($managementMembers->isNotEmpty())
        <div class="mt-3">{{ $managementMembers->links() }}</div>
    @endif

@endsection