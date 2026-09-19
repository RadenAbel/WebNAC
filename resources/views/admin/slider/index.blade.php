@extends('admin.layouts.app')

@section('admin_title', 'Slider')

@section('admin_content')

    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-4">
        <div>
            <h1 class="h4 mb-1">Slider Beranda</h1>
            <p class="text-secondary mb-0" style="font-size:0.9rem;">Kelola foto hero slider di halaman utama.</p>
        </div>
        <a href="{{ route('admin.sliders.create') }}" class="btn nac-admin-btn">
            <i class="bi bi-plus-lg"></i> Tambah Slider
        </a>
    </div>

    @include('admin.partials.toast')

    @if ($sliders->isEmpty())

        <div class="bg-white border rounded-3">
            <div class="nac-admin-empty">
                <div class="nac-admin-empty__icon"><i class="bi bi-images"></i></div>
                <p class="nac-admin-empty__title">Belum ada slider</p>
                <p class="nac-admin-empty__desc">Tambahkan foto pertama untuk hero beranda website.</p>
                <a href="{{ route('admin.sliders.create') }}" class="btn nac-admin-btn">
                    <i class="bi bi-plus-lg"></i> Tambah Slider
                </a>
            </div>
        </div>

    @else

        {{-- ============ DESKTOP: tabel (>= 768px) ============ --}}
        <div class="bg-white border rounded-3 overflow-hidden d-none d-md-block">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width:100px;">Foto</th>
                        <th>Judul</th>
                        <th style="width:100px;">Jenis</th>
                        <th class="text-center" style="width:100px;">Status</th>
                        <th class="text-end" style="width:120px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sliders as $slider)
                        <tr>
                            <td>
                                <img src="{{ $slider->image_url }}" alt="{{ $slider->title }}"
                                    style="width:80px; height:45px; object-fit:cover; border-radius:6px;">
                            </td>
                            <td class="fw-bold">{{ $slider->title ?? '(tanpa judul)' }}</td>
                            <td>
                                @if ($slider->type === 'video')
                                    <span class="badge bg-info-subtle text-info-emphasis"><i class="bi bi-youtube"></i> Video</span>
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary-emphasis"><i class="bi bi-image"></i> Foto</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if ($slider->is_active)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Nonaktif</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.sliders.edit', $slider) }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.sliders.destroy', $slider) }}" method="POST" class="d-inline nac-confirm-delete-form"
                                    data-confirm-title="Hapus slider ini?"
                                    data-confirm-text="Slider ini akan terhapus secara permanen.">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- ============ MOBILE: tumpukan kartu (< 768px), tap untuk buka semua ============ --}}
        <div class="d-md-none nac-admin-stack-group" data-stack-group>

            <div class="nac-admin-stack-deck-wrap">
                <div class="nac-admin-stack-deck">
                    <div class="nac-admin-stack-deck__spacer"></div>
                    @foreach ($sliders->take(3) as $i => $slider)
                        @php
                            $y = $i * -14;
                            $scale = round(1 - $i * 0.06, 2);
                            $z = 30 - $i * 10;
                            $bright = round(1 - $i * 0.12, 2);
                        @endphp
                        <div class="nac-admin-stack-card" style="--y:{{ $y }}px; --scale:{{ $scale }}; --z:{{ $z }}; --bright:{{ $bright }};">
                            @include('admin.slider.partials.card', ['slider' => $slider])
                        </div>
                    @endforeach
                    <span class="nac-admin-stack-count"><i class="bi bi-images"></i> {{ $sliders->count() }}</span>
                </div>

                <button type="button" class="nac-admin-stack-trigger" data-stack-trigger
                    data-label-closed="Lihat Semua Slider" data-label-open="Tutup">
                    <span data-stack-trigger-text>Lihat Semua Slider</span>
                    <i class="bi bi-chevron-right"></i>
                </button>
            </div>

            <div class="nac-admin-stack-grid">
                <div class="d-flex flex-column gap-3">
                    @foreach ($sliders as $slider)
                        @include('admin.slider.partials.card', ['slider' => $slider])
                    @endforeach
                </div>
            </div>
        </div>

        <div class="mt-3">{{ $sliders->links() }}</div>

    @endif

@endsection