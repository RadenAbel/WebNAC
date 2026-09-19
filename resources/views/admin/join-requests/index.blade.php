@extends('admin.layouts.app')

@section('admin_title', 'Pendaftaran')

@section('admin_content')

    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-4">
        <div>
            <h1 class="h4 mb-1">Pendaftaran Join Us</h1>
            <p class="text-secondary mb-0" style="font-size:0.9rem;">
                Tinjau pendaftaran calon murid NAC Swim School, lalu tandai Diterima/Ditolak.
            </p>
        </div>
        @if($pendingCount > 0)
            <span class="nac-admin-pending-badge">
                <i class="bi bi-hourglass-split"></i> {{ $pendingCount }} menunggu tinjauan
            </span>
        @endif
    </div>

    <div class="bg-white border rounded-3 d-none d-md-block">
        @if ($joinRequests->isEmpty())
            <div class="nac-admin-empty">
                <div class="nac-admin-empty__icon"><i class="bi bi-person-plus"></i></div>
                <p class="nac-admin-empty__title">Belum ada pendaftaran</p>
                <p class="nac-admin-empty__desc">Pendaftaran dari halaman Join Us akan muncul di sini.</p>
            </div>
        @else
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width:60px;">Foto</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>No. WhatsApp</th>
                        <th>Tanggal Daftar</th>
                        <th class="text-center" style="width:110px;">Status</th>
                        <th class="text-end" style="width:70px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($joinRequests as $req)
                        <tr>
                            <td>
                                @if ($req->photo_url)
                                    <img src="{{ $req->photo_url }}" alt="{{ $req->name }}"
                                        style="width:42px; height:42px; object-fit:cover; border-radius:50%; border:2px solid #fff; box-shadow:0 0 0 1px #E5E9EF;">
                                @else
                                    <div style="width:42px; height:42px; border-radius:50%; background:#F5F7FA; color:#94A3B8; display:flex; align-items:center; justify-content:center; font-size:0.75rem; font-weight:800;">
                                        {{ strtoupper(substr($req->name, 0, 1)) }}
                                    </div>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.join-requests.show', $req) }}" class="fw-bold text-decoration-none">{{ $req->name }}</a>
                                @if($req->nickname)
                                    <div class="text-secondary" style="font-size:0.78rem;">"{{ $req->nickname }}"</div>
                                @endif
                            </td>
                            <td style="font-size:0.85rem;">{{ $req->category }}</td>
                            <td style="font-size:0.85rem;">{{ $req->whatsapp }}</td>
                            <td class="text-secondary" style="font-size:0.82rem;">{{ $req->created_at->translatedFormat('d M Y, H:i') }}</td>
                            <td class="text-center">
                                @if ($req->status === 'accepted')
                                    <span class="badge bg-success">Diterima</span>
                                @elseif ($req->status === 'rejected')
                                    <span class="badge bg-secondary">Ditolak</span>
                                @else
                                    <span class="badge bg-warning text-dark">Menunggu</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <div class="nac-dropdown">
                                    <button type="button" class="btn btn-sm btn-outline-secondary" data-dropdown-toggle aria-expanded="false">
                                        <i class="bi bi-three-dots"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end nac-dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('admin.join-requests.show', $req) }}">
                                                <i class="bi bi-eye me-2"></i>Lihat Detail
                                            </a>
                                        </li>
                                        @if ($req->status === 'pending')
                                            <li>
                                                <form action="{{ route('admin.join-requests.accept', $req) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="dropdown-item text-success">
                                                        <i class="bi bi-check-lg me-2"></i>Terima
                                                    </button>
                                                </form>
                                            </li>
                                            <li>
                                                <form action="{{ route('admin.join-requests.reject', $req) }}" method="POST" class="nac-confirm-delete-form"
                                                    data-confirm-title="Tolak pendaftaran {{ $req->name }}?"
                                                    data-confirm-text="Pesan penolakan akan disiapkan untuk dikirim lewat WhatsApp.">
                                                    @csrf
                                                    <button type="submit" class="dropdown-item text-danger">
                                                        <i class="bi bi-x-lg me-2"></i>Tolak
                                                    </button>
                                                </form>
                                            </li>
                                        @endif
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form action="{{ route('admin.join-requests.destroy', $req) }}" method="POST" class="nac-confirm-delete-form"
                                                data-confirm-title="Hapus pendaftaran {{ $req->name }}?"
                                                data-confirm-text="Data ini akan terhapus secara permanen, termasuk foto yang diupload.">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger">
                                                    <i class="bi bi-trash me-2"></i>Hapus
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    {{-- ============ VERSI KARTU (khusus mobile, < 768px) ============ --}}
    <div class="d-md-none">
        @if ($joinRequests->isEmpty())
            <div class="bg-white border rounded-3">
                <div class="nac-admin-empty">
                    <div class="nac-admin-empty__icon"><i class="bi bi-person-plus"></i></div>
                    <p class="nac-admin-empty__title">Belum ada pendaftaran</p>
                    <p class="nac-admin-empty__desc">Pendaftaran dari halaman Join Us akan muncul di sini.</p>
                </div>
            </div>
        @else
            <div class="d-flex flex-column gap-2">
                @foreach ($joinRequests as $req)
                    <div class="nac-admin-member-card">
                        <div class="nac-admin-member-card__top">
                            @if ($req->photo_url)
                                <img src="{{ $req->photo_url }}" alt="{{ $req->name }}" class="nac-admin-member-card__photo">
                            @else
                                <div class="nac-admin-member-card__photo nac-admin-member-card__photo--fallback">
                                    {{ strtoupper(substr($req->name, 0, 1)) }}
                                </div>
                            @endif
                            <div class="nac-admin-member-card__info">
                                <div class="nac-admin-member-card__name">{{ $req->name }}</div>
                                <div class="text-secondary" style="font-size:0.8rem;">{{ $req->category }} · {{ $req->whatsapp }}</div>
                                <div class="mt-1">
                                    @if ($req->status === 'accepted')
                                        <span class="badge bg-success">Diterima</span>
                                    @elseif ($req->status === 'rejected')
                                        <span class="badge bg-secondary">Ditolak</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Menunggu</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="nac-admin-member-card__actions">
                            @if ($req->status === 'pending')
                                <form action="{{ route('admin.join-requests.accept', $req) }}" method="POST" class="flex-grow-1">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-success w-100"><i class="bi bi-check-lg"></i> Terima</button>
                                </form>
                                <form action="{{ route('admin.join-requests.reject', $req) }}" method="POST" class="flex-grow-1 nac-confirm-delete-form"
                                    data-confirm-title="Tolak pendaftaran {{ $req->name }}?"
                                    data-confirm-text="Pesan penolakan akan disiapkan untuk dikirim lewat WhatsApp.">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-danger w-100"><i class="bi bi-x-lg"></i> Tolak</button>
                                </form>
                            @else
                                <a href="{{ route('admin.join-requests.show', $req) }}" class="btn btn-sm btn-outline-secondary flex-grow-1">
                                    <i class="bi bi-eye"></i> Lihat Detail
                                </a>
                            @endif
                            <div class="nac-dropdown">
                                <button type="button" class="btn btn-sm btn-outline-secondary" data-dropdown-toggle aria-expanded="false">
                                    <i class="bi bi-three-dots"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end nac-dropdown-menu">
                                    @if ($req->status === 'pending')
                                        <li>
                                            <a class="dropdown-item" href="{{ route('admin.join-requests.show', $req) }}">
                                                <i class="bi bi-eye me-2"></i>Lihat Detail
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                    @endif
                                    <li>
                                        <form action="{{ route('admin.join-requests.destroy', $req) }}" method="POST" class="nac-confirm-delete-form"
                                            data-confirm-title="Hapus pendaftaran {{ $req->name }}?"
                                            data-confirm-text="Data ini akan terhapus secara permanen, termasuk foto yang diupload.">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="bi bi-trash me-2"></i>Hapus
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    @if ($joinRequests->isNotEmpty())
        <div class="mt-3">{{ $joinRequests->links() }}</div>
    @endif

    @if (session('status'))
        @push('scripts')
        <script>
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: @json(session('status')),
                showConfirmButton: false,
                timer: 3500,
                timerProgressBar: true,
            });
        </script>
        @endpush
    @endif

@endsection