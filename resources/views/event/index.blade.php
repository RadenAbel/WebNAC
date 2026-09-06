@extends('layouts.app')

@section('title', 'Acara — Nugroho Aquatic Club')
@section('meta_description', 'Kegiatan dan acara yang diselenggarakan Nugroho Aquatic Club, lengkap dengan laporan kegiatannya.')

@section('content')

<section class="nac-page-header">
    <div class="container text-center" data-aos="fade-up">
        <h1 class="nac-page-header__title">Acara &amp; Kegiatan Kami.</h1>
        <p class="nac-page-header__desc">
            Dokumentasi kegiatan dan hasil dari kegiatan yang pernah diikuti Nugroho Aquatic Club.
        </p>
    </div>
</section>

<section class="nac-section">
    <div class="container">
        @if ($events->isEmpty())
            <p class="text-center nac-muted">Belum ada kegiatan yang ditampilkan.</p>
        @else
            @php
                // Pengelompokan per bulan ini mengasumsikan setiap event punya
                // kolom tanggal asli bernama `event_date` (Carbon/date), di samping
                // `event_date_label` yang sudah ada untuk teks tampilan. Kalau nama
                // kolomnya beda, ganti `event_date` di baris groupBy() bawah ini.
                $groupedEvents = $events->groupBy(function ($event) {
                    return optional($event->event_date)->format('Y-m') ?? 'lainnya';
                });
            @endphp

            <div class="nac-event-list">
                @foreach ($groupedEvents as $monthEvents)
                    @php $firstDate = $monthEvents->first()->event_date ?? null; @endphp

                    <div class="nac-event-month" data-aos="fade-up">
                        <h2 class="nac-event-month__label">
                            @if ($firstDate)
                                {{ $firstDate->translatedFormat('F') }} <span>{{ $firstDate->format('Y') }}</span>
                            @else
                                Lainnya
                            @endif
                        </h2>

                        <div class="nac-event-month__rows">
                            @foreach ($monthEvents as $i => $event)
                                <div data-aos="fade-up" data-aos-delay="{{ ($i % 5) * 60 }}">
                                    @include('event.partials.card', ['event' => $event])
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>

{{-- ============ LIGHTBOX PREVIEW FOTO (dipakai bareng semua baris) ============ --}}
<div class="nac-lightbox" id="nacLightbox" aria-hidden="true">
    <button type="button" class="nac-lightbox__close" id="nacLightboxClose" aria-label="Tutup preview foto">
        <i class="fa-solid fa-xmark"></i>
    </button>
    <div class="nac-lightbox__inner">
        <img src="" alt="" id="nacLightboxImg" class="nac-lightbox__img">
        <div class="nac-lightbox__caption" id="nacLightboxCaption">
            <h4 id="nacLightboxTitle"></h4>
            <p id="nacLightboxDesc"></p>
        </div>
    </div>
</div>

<script>
(function () {
    var lightbox   = document.getElementById('nacLightbox');
    var img        = document.getElementById('nacLightboxImg');
    var titleEl    = document.getElementById('nacLightboxTitle');
    var descEl     = document.getElementById('nacLightboxDesc');
    var captionEl  = document.getElementById('nacLightboxCaption');
    var closeBtn   = document.getElementById('nacLightboxClose');
    if (!lightbox || !img) return;

    function openLightbox(trigger) {
        var src   = trigger.getAttribute('data-lightbox-src');
        var alt   = trigger.getAttribute('data-lightbox-alt') || '';
        var title = trigger.getAttribute('data-lightbox-title') || '';
        var desc  = trigger.getAttribute('data-lightbox-desc') || '';

        img.src = src;
        img.alt = alt;
        titleEl.textContent = title;
        descEl.textContent = desc;
        captionEl.style.display = (title || desc) ? 'block' : 'none';

        lightbox.classList.add('is-open');
        lightbox.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
    }

    function closeLightbox() {
        lightbox.classList.remove('is-open');
        lightbox.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
        img.src = '';
    }

    document.addEventListener('click', function (e) {
        var trigger = e.target.closest('[data-lightbox-src]');
        if (trigger) {
            e.preventDefault();
            openLightbox(trigger);
        }
    });

    closeBtn.addEventListener('click', closeLightbox);
    lightbox.addEventListener('click', function (e) {
        if (e.target === lightbox) closeLightbox();
    });
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && lightbox.classList.contains('is-open')) closeLightbox();
    });
})();
</script>

@endsection