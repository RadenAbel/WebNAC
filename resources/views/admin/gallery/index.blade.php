@extends('admin.layouts.app')

@section('admin_title', 'Galeri')

@section('admin_content')

    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-4">
        <div>
            <h1 class="h4 mb-1">Galeri Foto</h1>
            <p class="text-secondary mb-0" style="font-size:0.9rem;">Kelola foto yang tampil di section Galeri website.</p>
        </div>
        <a href="{{ route('admin.galleries.create') }}" class="btn nac-admin-btn">
            <i class="bi bi-plus-lg"></i> Tambah Foto
        </a>
    </div>

    @if (session('status'))
        <div class="alert alert-success py-2 px-3 mb-3" style="font-size:0.9rem;">{{ session('status') }}</div>
    @endif

    @if ($galleries->isEmpty())

        <div class="bg-white border rounded-3">
            <div class="nac-admin-empty">
                <div class="nac-admin-empty__icon"><i class="bi bi-camera"></i></div>
                <p class="nac-admin-empty__title">Belum ada foto galeri</p>
                <p class="nac-admin-empty__desc">Tambahkan foto pertama untuk section Galeri di website.</p>
                <a href="{{ route('admin.galleries.create') }}" class="btn nac-admin-btn">
                    <i class="bi bi-plus-lg"></i> Tambah Foto
                </a>
            </div>
        </div>

    @else

        {{-- ============ DESKTOP: grid biasa (>= 768px) ============ --}}
        <div class="row g-3 d-none d-md-flex">
            @foreach ($galleries as $gallery)
                <div class="col-md-4 col-lg-3">
                    @include('admin.gallery.partials.card', ['gallery' => $gallery])
                </div>
            @endforeach
        </div>

        {{-- ============ MOBILE: tumpukan kartu (< 768px), tap untuk buka semua ============ --}}
        <div class="d-md-none nac-admin-stack-group" data-stack-group>

            <div class="nac-admin-stack-deck-wrap">
                <div class="nac-admin-stack-deck">
                    <div class="nac-admin-stack-deck__spacer" style="padding-top:118%;"></div>
                    @foreach ($galleries->take(3) as $i => $gallery)
                        @php
                            $y = $i * -14;
                            $scale = round(1 - $i * 0.06, 2);
                            $z = 30 - $i * 10;
                            $bright = round(1 - $i * 0.12, 2);
                        @endphp
                        <div class="nac-admin-stack-card" style="--y:{{ $y }}px; --scale:{{ $scale }}; --z:{{ $z }}; --bright:{{ $bright }};">
                            @include('admin.gallery.partials.card', ['gallery' => $gallery])
                        </div>
                    @endforeach
                    <span class="nac-admin-stack-count"><i class="bi bi-camera"></i> {{ $galleries->count() }}</span>
                </div>

                <button type="button" class="nac-admin-stack-trigger" data-stack-trigger
                    data-label-closed="Lihat Semua Foto" data-label-open="Tutup">
                    <span data-stack-trigger-text>Lihat Semua Foto</span>
                    <i class="bi bi-chevron-right"></i>
                </button>
            </div>

            <div class="nac-admin-stack-grid">
                <div class="row g-3">
                    @foreach ($galleries as $gallery)
                        <div class="col-6">
                            @include('admin.gallery.partials.card', ['gallery' => $gallery])
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="mt-3 d-none d-md-block">{{ $galleries->links() }}</div>

    @endif

@endsection