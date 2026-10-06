@extends('layouts.app')

@section('title', 'Hasil Pertandingan — Nugroho Aquatic Club')
@section('meta_description', 'Hasil pertandingan dan kejuaraan renang yang diikuti atlet Nugroho Aquatic Club, Sangatta, Kutai Timur.')

@section('content')

<section class="nac-page-header @if($setting->event_header_type === 'photo' && $setting->event_header_photo_url) nac-page-header--photo @elseif($setting->event_header_type === 'video' && $setting->event_header_video_embed_url) nac-page-header--photo @endif"
    @if($setting->event_header_type === 'photo' && $setting->event_header_photo_url)
        style="background-image: url('{{ $setting->event_header_photo_url }}');"
    @endif>

    @if($setting->event_header_type === 'video' && $setting->event_header_video_embed_url)
        <div class="nac-page-header__bg-video-wrap">
            <iframe src="{{ $setting->event_header_video_embed_url }}"
                class="nac-page-header__bg-video"
                allow="autoplay; encrypted-media"
                title="Background video halaman Acara"></iframe>
        </div>
    @endif

    <div class="container text-center" data-aos="fade-up">
        <h1 class="nac-page-header__title">Hasil Pertandingan.</h1>
        <p class="nac-page-header__desc">
            Dokumentasi hasil pertandingan yang pernah diikuti.
        </p>
    </div>
</section>

<section class="nac-section nac-section--decorated nac-section--tint">
    <div class="container">
        @if ($events->isEmpty())
            <p class="text-center nac-muted">Belum ada hasil pertandingan yang ditampilkan.</p>
        @else
            @php
                $eventYears = $events->map(fn ($e) => optional($e->event_date)->format('Y'))->filter()->unique()->sortDesc()->values();
            @endphp

            <div class="nac-result-filter nac-event-filter" data-aos="fade-up">
                <div class="nac-result-filter__field nac-result-filter__field--search">
                    <label for="eventSearch">Cari Kejuaraan</label>
                    <div class="nac-result-filter__search">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input type="search" id="eventSearch" placeholder="Ketik nama kejuaraan..." data-event-search autocomplete="off">
                    </div>
                </div>
                <div class="nac-result-filter__field">
                    <label for="eventYear">Tahun</label>
                    <select id="eventYear" data-event-year>
                        <option value="">Semua Tahun</option>
                        @foreach ($eventYears as $year)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="nac-result-group nac-event-table-wrap" data-aos="fade-up">
                <div class="table-responsive">
                    <table class="nac-result-table nac-event-table">
                        <thead>
                            <tr>
                                <th style="width:60px;">No</th>
                                <th>Nama Kejuaraan</th>
                                <th>Tanggal</th>
                                <th>Lokasi</th>
                                <th class="text-end">Hasil</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($events as $i => $event)
                                <tr data-event-row
                                    data-name="{{ \Illuminate\Support\Str::lower($event->title) }}"
                                    data-year="{{ optional($event->event_date)->format('Y') }}"
                                    data-href="{{ route('event.show', $event->slug) }}">
                                    <td class="nac-event-table__no" data-event-no>{{ $i + 1 }}</td>
                                    <td>
                                        <a href="{{ route('event.show', $event->slug) }}" class="nac-event-table__title">
                                            @if ($event->photo_url)
                                                <img src="{{ $event->photo_url }}" alt="" class="nac-event-table__thumb" loading="lazy">
                                            @else
                                                <span class="nac-event-table__thumb nac-event-table__thumb--empty"><i class="fa-solid fa-trophy"></i></span>
                                            @endif
                                            <span>{{ $event->title }}</span>
                                        </a>
                                    </td>
                                    <td>{{ $event->event_date_label ?? '-' }}</td>
                                    <td>{{ $event->location ?: '-' }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('event.show', $event->slug) }}" class="nac-event-table__cta">
                                            Lihat Hasil <i class="fa-solid fa-arrow-right"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="nac-result-empty d-none" data-event-empty>
                    <i class="fa-solid fa-filter-circle-xmark"></i>
                    <p>Tidak ada kejuaraan yang cocok dengan filter ini.</p>
                </div>
            </div>
        @endif
    </div>
</section>

@if ($events->isNotEmpty())
<script>
(function () {
    var search = document.querySelector('[data-event-search]');
    var year   = document.querySelector('[data-event-year]');
    var rows   = document.querySelectorAll('[data-event-row]');
    var empty  = document.querySelector('[data-event-empty]');

    function apply() {
        var q = search.value.trim().toLowerCase(), y = year.value, n = 0;
        rows.forEach(function (r) {
            var ok = (!q || r.dataset.name.indexOf(q) !== -1) && (!y || r.dataset.year === y);
            r.classList.toggle('d-none', !ok);
            if (ok) { n++; r.querySelector('[data-event-no]').textContent = n; }
        });
        empty.classList.toggle('d-none', n > 0);
    }
    search.addEventListener('input', apply);
    year.addEventListener('change', apply);

    rows.forEach(function (r) {
        r.addEventListener('click', function (e) {
            if (e.target.closest('a')) return;
            window.location.href = r.dataset.href;
        });
    });
})();
</script>
@endif

@endsection
