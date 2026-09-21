@extends('admin.layouts.app')

@section('admin_title', 'Kelola Admin')

@section('admin_content')

    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-4">
        <div>
            <h1 class="h4 mb-1">Kelola Admin</h1>
            <p class="text-secondary mb-0" style="font-size:0.9rem;">
                Daftar akun yang bisa masuk ke panel admin ini, beserta role-nya.
            </p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="btn nac-admin-btn">
            <i class="bi bi-plus-lg"></i> Tambah Akun
        </a>
    </div>

    @include('admin.partials.toast')

    @if (session('status_error'))
        <div class="alert alert-danger py-2 px-3 mb-3" style="font-size:0.9rem;">{{ session('status_error') }}</div>
    @endif

    <div class="bg-white border rounded-3 overflow-hidden d-none d-md-block">
        @if ($users->isEmpty())
            <div class="nac-admin-empty">
                <div class="nac-admin-empty__icon"><i class="bi bi-people"></i></div>
                <p class="nac-admin-empty__title">Belum ada akun admin</p>
                <p class="nac-admin-empty__desc">Klik "Tambah Akun" untuk membuat akun admin baru.</p>
            </div>
        @else
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th class="text-center" style="width:140px;">Role</th>
                        <th class="text-end" style="width:120px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td class="fw-bold">
                                {{ $user->name }}
                                @if ($user->id === auth()->id())
                                    <span class="badge bg-secondary-subtle text-secondary-emphasis ms-1">Anda</span>
                                @endif
                            </td>
                            <td class="text-secondary" style="font-size:0.85rem;">{{ $user->email }}</td>
                            <td class="text-center">
                                @if ($user->isSuperAdmin())
                                    <span class="badge bg-warning text-dark">Super Admin</span>
                                @else
                                    <span class="badge bg-secondary">Admin</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                @if ($user->id !== auth()->id())
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline nac-confirm-delete-form"
                                        data-confirm-title="Hapus akun {{ $user->name }}?"
                                        data-confirm-text="Akun ini tidak akan bisa masuk ke admin lagi setelah dihapus.">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    {{-- ============ VERSI KARTU (mobile) ============ --}}
    <div class="d-md-none">
        @if ($users->isEmpty())
            <div class="bg-white border rounded-3">
                <div class="nac-admin-empty">
                    <div class="nac-admin-empty__icon"><i class="bi bi-people"></i></div>
                    <p class="nac-admin-empty__title">Belum ada akun admin</p>
                    <p class="nac-admin-empty__desc">Klik "Tambah Akun" untuk membuat akun admin baru.</p>
                </div>
            </div>
        @else
            <div class="d-flex flex-column gap-2">
                @foreach ($users as $user)
                    <div class="nac-admin-member-card">
                        <div class="nac-admin-member-card__top">
                            <div class="nac-admin-member-card__photo nac-admin-member-card__photo--fallback">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div class="nac-admin-member-card__info">
                                <div class="nac-admin-member-card__name">
                                    {{ $user->name }}
                                    @if ($user->id === auth()->id())
                                        <span class="badge bg-secondary-subtle text-secondary-emphasis">Anda</span>
                                    @endif
                                </div>
                                <div class="text-secondary" style="font-size:0.8rem;">{{ $user->email }}</div>
                                <div class="mt-1">
                                    @if ($user->isSuperAdmin())
                                        <span class="badge bg-warning text-dark">Super Admin</span>
                                    @else
                                        <span class="badge bg-secondary">Admin</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="nac-admin-member-card__actions">
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-secondary flex-grow-1">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            @if ($user->id !== auth()->id())
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="flex-grow-1 nac-confirm-delete-form"
                                    data-confirm-title="Hapus akun {{ $user->name }}?"
                                    data-confirm-text="Akun ini tidak akan bisa masuk ke admin lagi setelah dihapus.">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger w-100"><i class="bi bi-trash"></i> Hapus</button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    @if ($users->isNotEmpty())
        <div class="mt-3">{{ $users->links() }}</div>
    @endif

@endsection