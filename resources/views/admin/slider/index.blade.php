@extends('admin.layouts.app')

@section('admin_title', 'Slider')

@section('admin_content')

    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-4">
        <div>
            <h1 class="h4 fw-bold mb-1">Slider Beranda</h1>
            <p class="text-secondary mb-0" style="font-size:0.9rem;">Kelola foto hero slider di halaman utama.</p>
        </div>
        <a href="{{ route('admin.sliders.create') }}" class="btn nac-admin-btn">
            <i class="bi bi-plus-lg me-1"></i> Tambah Slider
        </a>
    </div>

    @if (session('status'))
        <div class="alert alert-success py-2 px-3 mb-3" style="font-size:0.9rem;">{{ session('status') }}</div>
    @endif

    <div class="bg-white border rounded-3 overflow-hidden">
        <table class="table align-middle mb-0">
            <thead style="background:#f8f9fb;">
                <tr style="font-size:0.8rem; text-transform:uppercase; letter-spacing:.04em; color:#6b7a8a;">
                    <th style="width:120px;">Foto</th>
                    <th>Judul</th>
                    <th class="text-center">Urutan</th>
                    <th class="text-center">Status</th>
                    <th class="text-end" style="width:160px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($sliders as $slider)
                    <tr>
                        <td>
                            <img src="{{ $slider->image_url }}" alt="{{ $slider->title }}"
                                style="width:100px; height:56px; object-fit:cover; border-radius:8px;">
                        </td>
                        <td class="fw-bold">{{ $slider->title ?? '-' }}</td>
                        <td class="text-center">{{ $slider->sort_order }}</td>
                        <td class="text-center">
                            @if ($slider->is_active)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary">Nonaktif</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.sliders.edit', $slider) }}" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            <form action="{{ route('admin.sliders.destroy', $slider) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Yakin hapus slider ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-secondary py-4">
                            Belum ada slider. Klik "Tambah Slider" untuk mulai.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">{{ $sliders->links() }}</div>

@endsection