@extends('admin.layouts.app')

@section('admin_title', 'Tim')

@section('admin_content')

    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-4">
        <div>
            <h1 class="h4 fw-bold mb-1">Tim (Pelatih &amp; Atlet)</h1>
            <p class="text-secondary mb-0" style="font-size:0.9rem;">
                Kelola profil, rekor waktu, dan pencapaian pelatih &amp; atlet.
            </p>
        </div>
        <a href="{{ route('admin.team.create') }}" class="btn nac-admin-btn">
            <i class="bi bi-plus-lg me-1"></i> Tambah Anggota
        </a>
    </div>

    @if (session('status'))
        <div class="alert alert-success py-2 px-3 mb-3" style="font-size:0.9rem;">
            {{ session('status') }}
        </div>
    @endif

    {{-- Filter peran --}}
    <div class="btn-group mb-3" role="group">
        <a href="{{ route('admin.team.index') }}"
            class="btn btn-sm {{ $activeRole === 'semua' ? 'btn-dark' : 'btn-outline-secondary' }}">Semua</a>
        <a href="{{ route('admin.team.index', ['role' => 'pelatih']) }}"
            class="btn btn-sm {{ $activeRole === 'pelatih' ? 'btn-dark' : 'btn-outline-secondary' }}">Pelatih</a>
        <a href="{{ route('admin.team.index', ['role' => 'atlet']) }}"
            class="btn btn-sm {{ $activeRole === 'atlet' ? 'btn-dark' : 'btn-outline-secondary' }}">Atlet</a>
    </div>

    <div class="bg-white border rounded-3 overflow-hidden">
        <table class="table align-middle mb-0">
            <thead style="background:#f8f9fb;">
                <tr style="font-size:0.8rem; text-transform:uppercase; letter-spacing:.04em; color:#6b7a8a;">
                    <th style="width:60px;">Foto</th>
                    <th>Nama</th>
                    <th>Peran</th>
                    <th>Kategori</th>
                    <th class="text-center">Status</th>
                    <th class="text-end" style="width:160px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($members as $member)
                    <tr>
                        <td>
                            <img src="{{ $member->photo_url }}" alt="{{ $member->name }}"
                                style="width:42px; height:42px; object-fit:cover; border-radius:8px;">
                        </td>
                        <td class="fw-bold">{{ $member->name }}</td>
                        <td>
                            <span class="badge {{ $member->role === 'pelatih' ? 'bg-primary' : 'bg-info text-dark' }}">
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
                            <form action="{{ route('admin.team.destroy', $member) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Yakin hapus {{ $member->name }}? Rekor & pencapaiannya juga akan ikut terhapus.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-secondary py-4">
                            Belum ada data. Klik "Tambah Anggota" untuk mulai.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $members->links() }}
    </div>

@endsection