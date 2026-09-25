@extends('admin.layouts.app')

@section('admin_title', 'Fasilitas')

@section('admin_content')

    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-4">
        <div>
            <h1 class="h4 mb-1">Fasilitas</h1>
            <p class="text-secondary mb-0" style="font-size:0.9rem;">
                Tampil di halaman Tentang Kami, bagian "Fasilitas". Urutan di sini = urutan tampil.
            </p>
        </div>
        <a href="{{ route('admin.facilities.create') }}" class="btn nac-admin-btn">
            <i class="bi bi-plus-lg"></i> Tambah Fasilitas
        </a>
    </div>

    @include('admin.partials.toast')

    @if ($facilities->isEmpty())
        <div class="bg-white border rounded-3">
            <div class="nac-admin-empty">
                <div class="nac-admin-empty__icon"><i class="bi bi-building"></i></div>
                <p class="nac-admin-empty__title">Belum ada fasilitas</p>
                <p class="nac-admin-empty__desc">Bagian Fasilitas di halaman Tentang Kami baru muncul setelah ada minimal satu fasilitas aktif.</p>
                <a href="{{ route('admin.facilities.create') }}" class="btn nac-admin-btn">
                    <i class="bi bi-plus-lg"></i> Tambah Fasilitas
                </a>
            </div>
        </div>
    @else
        <div class="d-flex flex-column gap-2">
            @foreach ($facilities as $facility)
                <div class="bg-white border rounded-3 p-3 d-flex align-items-center gap-3 flex-wrap">
                    @if ($facility->photo_url)
                        <img src="{{ $facility->photo_url }}" alt="{{ $facility->name }}"
                            style="width:96px; height:64px; object-fit:cover; border-radius:8px; flex-shrink:0;">
                    @else
                        <div class="d-flex align-items-center justify-content-center text-secondary"
                            style="width:96px; height:64px; border-radius:8px; background:#F5F7FA; flex-shrink:0;">
                            <i class="bi bi-image"></i>
                        </div>
                    @endif

                    <div class="flex-grow-1" style="min-width:180px;">
                        <div class="fw-bold">{{ $facility->name }}</div>
                        <div class="text-secondary" style="font-size:0.82rem;">
                            Urutan {{ $facility->sort_order }}
                            @if (count($facility->highlight_list)) · {{ count($facility->highlight_list) }} poin keunggulan @endif
                        </div>
                    </div>

                    @if ($facility->is_active)
                        <span class="badge bg-success">Aktif</span>
                    @else
                        <span class="badge bg-secondary">Nonaktif</span>
                    @endif

                    <div class="d-flex gap-1">
                        <a href="{{ route('admin.facilities.edit', $facility) }}" class="btn btn-sm btn-outline-secondary" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('admin.facilities.destroy', $facility) }}" method="POST" class="nac-confirm-delete-form"
                            data-confirm-title="Hapus fasilitas {{ $facility->name }}?"
                            data-confirm-text="Fasilitas beserta fotonya akan terhapus secara permanen.">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus"><i class="bi bi-trash"></i></button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

@endsection