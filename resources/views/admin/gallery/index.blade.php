@extends('admin.layouts.app')

@section('admin_title', 'Galeri')

@section('admin_content')

    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-4">
        <div>
            <h1 class="h4 fw-bold mb-1">Galeri Foto</h1>
            <p class="text-secondary mb-0" style="font-size:0.9rem;">Kelola foto yang tampil di section Galeri website.</p>
        </div>
        <a href="{{ route('admin.galleries.create') }}" class="btn nac-admin-btn">
            <i class="bi bi-plus-lg me-1"></i> Tambah Foto
        </a>
    </div>

    @if (session('status'))
        <div class="alert alert-success py-2 px-3 mb-3" style="font-size:0.9rem;">{{ session('status') }}</div>
    @endif

    <div class="row g-3">
        @forelse ($galleries as $gallery)
            <div class="col-6 col-md-4 col-lg-3">
                <div class="bg-white border rounded-3 overflow-hidden h-100">
                    <img src="{{ $gallery->image_url }}" alt="{{ $gallery->caption }}"
                        style="width:100%; aspect-ratio:4/5; object-fit:cover;">
                    <div class="p-2">
                        <div class="fw-bold" style="font-size:0.85rem;">{{ $gallery->caption ?? '(tanpa caption)' }}</div>
                        <div class="d-flex justify-content-between align-items-center mt-2">
                            @if ($gallery->is_active)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary">Nonaktif</span>
                            @endif
                            <div>
                                <a href="{{ route('admin.galleries.edit', $gallery) }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.galleries.destroy', $gallery) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Yakin hapus foto ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center text-secondary py-5 bg-white border rounded-3">
                    Belum ada foto galeri. Klik "Tambah Foto" untuk mulai.
                </div>
            </div>
        @endforelse
    </div>

    <div class="mt-3">{{ $galleries->links() }}</div>

@endsection