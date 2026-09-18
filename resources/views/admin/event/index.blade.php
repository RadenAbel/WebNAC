@extends('admin.layouts.app')

@section('admin_title', 'Acara')

@section('admin_content')

    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-4">
        <div>
            <h1 class="h4 mb-1">Hasil Pertandingan</h1>
            <p class="text-secondary mb-0" style="font-size:0.9rem;">Kelola hasil pertandingan beserta laporan PDF-nya.</p>
        </div>
        <a href="{{ route('admin.events.create') }}" class="btn nac-admin-btn">
            <i class="bi bi-plus-lg"></i> Tambah Hasil Pertandingan
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

        {{-- ============ DESKTOP: tabel (>= 768px) ============ --}}
        <div class="bg-white border rounded-3 overflow-hidden d-none d-md-block">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width:100px;">Foto</th>
                        <th>Judul</th>
                        <th>Tanggal</th>
                        <th class="text-center" style="width:100px;">Status</th>
                        <th class="text-end" style="width:160px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($events as $event)
                        <tr>
                            <td>
                                <img src="{{ $event->photo_url ?? asset('images/default-avatar.jpg') }}" alt="{{ $event->title }}"
                                    style="width:80px; height:60px; object-fit:cover; border-radius:6px;">
                            </td>
                            <td class="fw-bold">{{ $event->title }}</td>
                            <td class="text-secondary" style="font-size:0.85rem;">
                                <i class="bi bi-calendar3 me-1"></i>{{ $event->event_date_label ?? '-' }}
                            </td>
                            <td class="text-center">
                                @if ($event->is_active)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Nonaktif</span>
                                @endif
                            </td>
                            <td class="text-end">
                                @if ($event->pdf_url)
                                    <a href="{{ $event->pdf_url }}" target="_blank" class="btn btn-sm btn-outline-secondary" title="Lihat PDF">
                                        <i class="bi bi-file-earmark-pdf"></i>
                                    </a>
                                @endif
                                <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.events.destroy', $event) }}" method="POST" class="d-inline nac-confirm-delete-form"
                                    data-confirm-title="Hapus hasil pertandingan ini?"
                                    data-confirm-text="Hasil pertandingan beserta laporan PDF-nya akan terhapus secara permanen.">
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