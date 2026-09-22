@php
    // Hasil pertandingan tidak punya halaman detail sendiri — yang bisa
    // dibuka hanya laporan PDF-nya. Tanpa PDF, baris tampil sebagai
    // informasi saja (tidak bisa diklik, tanpa tombol "View Results").
    $hasPdf = !empty($event->pdf_url);
@endphp

<div class="nac-event-row @unless($hasPdf) nac-event-row--static @endunless">

    @if ($event->photo_url)
        <button type="button" class="nac-event-row__photo"
                data-lightbox-src="{{ $event->photo_url }}"
                data-lightbox-alt="Foto {{ $event->title }}"
                data-lightbox-title="{{ $event->title }}"
                data-lightbox-desc="{{ $event->description }}"
                aria-label="Lihat foto penuh acara {{ $event->title }}">
            <img src="{{ $event->photo_url }}" alt="Foto {{ $event->title }}" loading="lazy">
            <span class="nac-event-row__photo-zoom" aria-hidden="true"><i class="fa-solid fa-magnifying-glass-plus"></i></span>
        </button>
    @else
        <div class="nac-event-row__photo nac-event-row__photo--empty">
            <div class="nac-event-row__no-photo"><i class="fa-solid fa-image"></i></div>
        </div>
    @endif

    @if ($hasPdf)
        <a href="{{ $event->pdf_url }}" target="_blank" rel="noopener"
           class="nac-event-row__link" aria-label="Lihat hasil {{ $event->title }} (PDF)">
    @else
        <div class="nac-event-row__link">
    @endif
            <div class="nac-event-row__date">
                {{ $event->event_date_label ?? '-' }}
            </div>

            <div class="nac-event-row__body">
                <h3 class="nac-event-row__title">{{ $event->title }}</h3>
                @if (!empty($event->description))
                    <p class="nac-event-row__desc">{{ Str::limit($event->description, 100) }}</p>
                @endif
            </div>

            @if ($hasPdf)
                <span class="nac-event-row__cta">
                    View Results <i class="fa-solid fa-arrow-right"></i>
                </span>
            @endif
    @if ($hasPdf)
        </a>
    @else
        </div>
    @endif
</div>