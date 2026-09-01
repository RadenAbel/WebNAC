@extends('admin.layouts.app')

@section('admin_title', 'Acara')

@section('admin_content')

    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-4">
        <div>
            <h1 class="h4 mb-1">Acara / Kegiatan</h1>
            <p class="text-secondary mb-0" style="font-size:0.9rem;">Kelola acara beserta laporan PDF-nya.</p>
        </div>
        <a href="{{ route('admin.events.create') }}" class="btn nac-admin-btn">
            <i class="bi bi-plus-lg"></i> Tambah Acara
        </a>
    </div>

    @if (session('status'))
        <div class="alert alert-success py-2 px-3 mb-3" style="font-size:0.9rem;">{{ session('status') }}</div>
    @endif

    @if ($events->isEmpty())

        <div class="bg-white border rounded-3">
            <div class="nac-admin-empty">
                <div class="nac-admin-empty__icon"><i class="bi bi-calendar-event"></i></div>
                <p class="nac-admin-empty__title">Belum ada acara</p>
                <p class="nac-admin-empty__desc">Tambahkan acara pertama lengkap dengan laporan PDF-nya.</p>
                <a href="{{ route('admin.events.create') }}" class="btn nac-admin-btn">
                    <i class="bi bi-plus-lg"></i> Tambah Acara
                </a>
            </div>
        </div>

    @else

        {{-- ============ DESKTOP: grid biasa (>= 768px) ============ --}}
        <div class="row g-3 d-none d-md-flex">
            @foreach ($events as $event)
                <div class="col-md-6 col-lg-4">
                    @include('admin.event.partials.card', ['event' => $event])
                </div>
            @endforeach
        </div>

        {{-- ============ MOBILE: tumpukan kartu (< 768px) ============ --}}
        <div class="d-md-none nac-admin-stack-group" data-stack-group>

            <div class="nac-admin-stack-deck-wrap">
                <div class="nac-admin-stack-deck">
                    <div class="nac-admin-stack-deck__spacer" style="padding-top:95%;"></div>
                    @foreach ($events->take(3) as $i => $event)
                        @php
                            $y = $i * -14;
                            $scale = round(1 - $i * 0.06, 2);
                            $z = 30 - $i * 10;
                            $bright = round(1 - $i * 0.12, 2);
                        @endphp
                        <div class="nac-admin-stack-card" style="--y:{{ $y }}px; --scale:{{ $scale }}; --z:{{ $z }}; --bright:{{ $bright }};">
                            @include('admin.event.partials.card', ['event' => $event])
                        </div>
                    @endforeach
                    <span class="nac-admin-stack-count"><i class="bi bi-calendar-event"></i> {{ $events->count() }}</span>
                </div>

                <button type="button" class="nac-admin-stack-trigger" data-stack-trigger
                    data-label-closed="Lihat Semua Acara" data-label-open="Tutup">
                    <span data-stack-trigger-text>Lihat Semua Acara</span>
                    <i class="bi bi-chevron-right"></i>
                </button>
            </div>

            <div class="nac-admin-stack-grid">
                <div class="d-flex flex-column gap-3">
                    @foreach ($events as $event)
                        @include('admin.event.partials.card', ['event' => $event])
                    @endforeach
                </div>
            </div>
        </div>

        <div class="mt-3 d-none d-md-block">{{ $events->links() }}</div>

    @endif

@endsection