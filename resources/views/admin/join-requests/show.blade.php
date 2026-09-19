@extends('admin.layouts.app')

@section('admin_title', 'Detail Pendaftaran')

@section('admin_content')

    <div class="mb-4">
        <a href="{{ route('admin.join-requests.index') }}" class="nac-admin-back-btn">
            <span class="nac-admin-back-btn__icon"><i class="bi bi-arrow-left"></i></span> Kembali ke daftar
        </a>
        <h1 class="h4 fw-bold mt-2 mb-1">Detail Pendaftaran</h1>
    </div>

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="bg-white border rounded-3 p-4 text-center">
                @if ($joinRequest->photo_url)
                    <img src="{{ $joinRequest->photo_url }}" alt="{{ $joinRequest->name }}"
                        class="rounded-3 mb-3" style="width:100%; aspect-ratio:4/5; object-fit:cover;">
                @else
                    <div class="rounded-3 mb-3 d-flex align-items-center justify-content-center"
                        style="width:100%; aspect-ratio:4/5; background:#F5F7FA; color:#94A3B8; font-size:3rem; font-weight:800;">
                        {{ strtoupper(substr($joinRequest->name, 0, 1)) }}
                    </div>
                @endif

                @if ($joinRequest->status === 'accepted')
                    <span class="badge bg-success mb-2">Diterima</span>
                @elseif ($joinRequest->status === 'rejected')
                    <span class="badge bg-secondary mb-2">Ditolak</span>
                @else
                    <span class="badge bg-warning text-dark mb-2">Menunggu Tinjauan</span>
                @endif

                @if ($joinRequest->responded_at)
                    <p class="text-secondary mb-0" style="font-size:0.8rem;">
                        Ditinjau {{ $joinRequest->responded_at->translatedFormat('d M Y, H:i') }}
                    </p>
                @endif
            </div>

            @if ($joinRequest->status === 'pending')
                <div class="bg-white border rounded-3 p-4 mt-3">
                    <p class="fw-bold mb-3" style="font-size:0.9rem;">Tindak Lanjut</p>
                    <form action="{{ route('admin.join-requests.accept', $joinRequest) }}" method="POST" class="mb-2">
                        @csrf
                        <button type="submit" class="btn nac-admin-btn w-100"><i class="bi bi-check-lg"></i> Terima Pendaftaran</button>
                    </form>
                    <form action="{{ route('admin.join-requests.reject', $joinRequest) }}" method="POST" class="nac-confirm-delete-form"
                        data-confirm-title="Tolak pendaftaran {{ $joinRequest->name }}?"
                        data-confirm-text="Pesan penolakan akan disiapkan untuk dikirim lewat WhatsApp.">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger w-100"><i class="bi bi-x-lg"></i> Tolak Pendaftaran</button>
                    </form>
                </div>
            @endif

            <div class="bg-white border rounded-3 p-4 mt-3">
                <form action="{{ route('admin.join-requests.destroy', $joinRequest) }}" method="POST" class="nac-confirm-delete-form"
                    data-confirm-title="Hapus pendaftaran {{ $joinRequest->name }}?"
                    data-confirm-text="Data ini akan terhapus secara permanen, termasuk foto yang diupload.">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger w-100"><i class="bi bi-trash"></i> Hapus Data Pendaftaran</button>
                </form>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="bg-white border rounded-3 p-4">
                <h2 class="h6 fw-bold mb-3">Data Calon Murid</h2>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="text-secondary d-block" style="font-size:0.78rem;">Nama Lengkap</label>
                        <p class="fw-bold mb-0">{{ $joinRequest->name }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-secondary d-block" style="font-size:0.78rem;">Nama Panggilan</label>
                        <p class="fw-bold mb-0">{{ $joinRequest->nickname ?? '–' }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-secondary d-block" style="font-size:0.78rem;">Tanggal Lahir</label>
                        <p class="fw-bold mb-0">{{ $joinRequest->birth_date_label }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-secondary d-block" style="font-size:0.78rem;">No. WhatsApp</label>
                        <p class="fw-bold mb-0">
                            {{ $joinRequest->whatsapp }}
                            @if ($joinRequest->whatsapp_normalized)
                                <a href="https://wa.me/{{ $joinRequest->whatsapp_normalized }}" target="_blank" rel="noopener" class="ms-2" title="Chat manual">
                                    <i class="bi bi-whatsapp text-success"></i>
                                </a>
                            @endif
                        </p>
                    </div>
                    <div class="col-12">
                        <label class="text-secondary d-block" style="font-size:0.78rem;">Kategori yang Diminati</label>
                        <p class="fw-bold mb-0">{{ $joinRequest->category }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-secondary d-block" style="font-size:0.78rem;">Tanggal Daftar</label>
                        <p class="fw-bold mb-0">{{ $joinRequest->created_at->translatedFormat('d F Y, H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection