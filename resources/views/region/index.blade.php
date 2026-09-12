@extends('layouts.app')

@section('title', 'Kutai Timur — Nugroho Aquatic Center')
@section('meta_description', 'Kenali Kabupaten Kutai Timur: wisata alam, karst prasejarah, dan peta 18 kecamatannya.')

@php
    // Parse "0 0 1000 613" -> lebar & tinggi, dipakai untuk menghitung posisi
    // pin wisata dalam persen (supaya tetap presisi walau SVG di-resize).
    $vb = explode(' ', $mapData['viewBox']);
    $vbW = (float) ($vb[2] ?? 1000);
    $vbH = (float) ($vb[3] ?? 613);

    // Estimasi lat/long tiap kecamatan dari posisi cx/cy di peta SVG, dipetakan
    // linear terhadap bounding box GEOGRAFIS ASLI Kabupaten Kutai Timur:
    // 115°56'26"-118°58'19" BT dan 1°17'1" LS-1°52'39" LU (sumber: BAPPEDA
    // Kutai Timur). ESTIMASI, bukan titik survei presisi per kecamatan — kalau
    // nanti sudah ada koordinat asli tiap kecamatan, ganti $lat/$lng di bawah
    // dengan nilai itu langsung (tidak perlu hitung dari cx/cy lagi).
    $lonMin = 115 + 56 / 60 + 26 / 3600;
    $lonMax = 118 + 58 / 60 + 19 / 3600;
    $latMin = -(1 + 17 / 60 + 1 / 3600);
    $latMax = 1 + 52 / 60 + 39 / 3600;

    $estimateLatLng = function (float $cx, float $cy) use ($vbW, $vbH, $lonMin, $lonMax, $latMin, $latMax) {
        return [
            round($latMax - ($cy / $vbH) * ($latMax - $latMin), 5),
            round($lonMin + ($cx / $vbW) * ($lonMax - $lonMin), 5),
        ];
    };
@endphp

@section('content')

<section class="nac-page-header">
    <div class="container text-center" data-aos="fade-up">
        <h1 class="nac-page-header__title">Kutai Timur, Permata Kalimantan.</h1>
        <p class="nac-page-header__desc">
            Dari hutan hujan tertua di Indonesia hingga lukisan tangan manusia purba di gua-gua
            karst — kenali lebih dekat kabupaten tempat Nugroho Aquatic Center berdiri.
        </p>
    </div>
</section>

{{-- ============ WISATA UNGGULAN ============ --}}
<section class="nac-section nac-section--decorated nac-dot-pattern" id="wisata">
    <div class="container">
        <div class="nac-section__head mx-auto text-center" data-aos="fade-up">
            <span class="nac-eyebrow">Wisata &amp; Keindahan Alam</span>
            <h2 class="nac-section__title">Lima destinasi yang wajib dikunjungi.</h2>
        </div>

        <div class="row g-4 mt-3">
            @foreach($mapData['attractions'] as $i => $spot)
                @php
                    $iconMap = [
                        'leaf' => 'fa-leaf',
                        'mountain' => 'fa-mountain',
                        'water' => 'fa-water',
                        'tree' => 'fa-tree',
                        'mountain-sun' => 'fa-mountain-sun',
                    ];
                    $icon = $iconMap[$spot['icon']] ?? 'fa-location-dot';
                @endphp
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ $i * 70 }}">
                    <div class="nac-region-spot">
                        <div class="nac-region-spot__icon"><i class="fa-solid {{ $icon }}"></i></div>
                        <span class="nac-region-spot__kec">
                            <i class="fa-solid fa-location-dot"></i> Kec. {{ $spot['kecamatan'] }}
                        </span>
                        <h5>{{ $spot['name'] }}</h5>
                        <p>{{ $spot['desc'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<div class="nac-divider" aria-hidden="true">
    <span class="nac-divider__line"></span>
    <span class="nac-divider__icon"><i class="fa-solid fa-draw-polygon"></i></span>
    <span class="nac-divider__line"></span>
</div>

{{-- ============ PETA KECAMATAN INTERAKTIF ============ --}}
<section class="nac-section" id="peta">
    <div class="container">
        <div class="nac-section__head mx-auto text-center" data-aos="fade-up">
            <span class="nac-eyebrow">Peta Wilayah</span>
            <h2 class="nac-section__title">18 kecamatan, satu Kutai Timur.</h2>
        </div>

        <div class="nac-region-map-wrap mt-4" data-aos="fade-up" data-aos-delay="100">
            <div class="nac-region-map" data-region-map>
                <div class="nac-region-map__canvas" data-region-canvas>
                    <svg viewBox="{{ $mapData['viewBox'] }}" preserveAspectRatio="xMidYMid meet" data-region-svg>
                        @foreach($mapData['kecamatan'] as $k)
                            @php [$kLat, $kLng] = $estimateLatLng($k['cx'], $k['cy']); @endphp
                            <path
                                class="nac-region-path"
                                d="{{ $k['path'] }}"
                                data-name="{{ $k['name'] }}"
                                data-desc="{{ $k['desc'] }}"
                                data-lat="{{ $kLat }}"
                                data-lng="{{ $kLng }}"
                                tabindex="0"
                                role="button"
                                aria-label="Kecamatan {{ $k['name'] }}"
                                style="transform-origin: {{ $k['cx'] }}px {{ $k['cy'] }}px;"
                            ><title>{{ $k['name'] }}</title></path>
                        @endforeach
                    </svg>

                    @foreach($mapData['attractions'] as $spot)
                        <button type="button" class="nac-region-pin"
                                data-pin-name="{{ $spot['name'] }}"
                                data-pin-kec="{{ $spot['kecamatan'] }}"
                                data-pin-desc="{{ $spot['desc'] }}"
                                style="left: {{ round($spot['x'] / $vbW * 100, 2) }}%; top: {{ round($spot['y'] / $vbH * 100, 2) }}%;"
                                aria-label="Info {{ $spot['name'] }}">
                            <span class="nac-region-pin__dot"></span>
                        </button>
                    @endforeach
                </div>

                {{-- Kontrol zoom --}}
                <div class="nac-region-map__zoom" role="group" aria-label="Kontrol zoom peta">
                    <button type="button" data-region-zoom-in aria-label="Perbesar peta"><i class="fa-solid fa-plus"></i></button>
                    <button type="button" data-region-zoom-out aria-label="Perkecil peta"><i class="fa-solid fa-minus"></i></button>
                    <button type="button" data-region-zoom-reset aria-label="Reset zoom"><i class="fa-solid fa-arrows-to-dot"></i></button>
                </div>

                {{-- Card hover: nama kecamatan + estimasi lat/long, pojok kanan-bawah peta --}}
                <div class="nac-region-hover-card" data-region-hover-card>
                    <strong data-region-hover-name></strong>
                    <span data-region-hover-coord></span>
                </div>
            </div>

            {{-- Panel sekilas fakta — statis, dipindahkan dari section "Fakta Singkat" --}}
            <div class="nac-region-facts">
                <div class="nac-region-facts__item">
                    <span class="nac-region-fact__num">18</span>
                    <span class="nac-region-fact__label">Kecamatan</span>
                </div>
                <div class="nac-region-facts__item">
                    <span class="nac-region-fact__num nac-region-fact__num--text">Sangatta</span>
                    <span class="nac-region-fact__label">Ibu Kota Kabupaten</span>
                </div>
                <div class="nac-region-facts__item">
                    <span class="nac-region-fact__num nac-region-fact__num--text">Kalimantan Timur</span>
                    <span class="nac-region-fact__label">Provinsi</span>
                </div>
                <div class="nac-region-facts__item">
                    <span class="nac-region-fact__num nac-region-fact__num--text">TN Kutai</span>
                    <span class="nac-region-fact__label">Rumah Orangutan Kalimantan</span>
                </div>

                <p class="nac-region-facts__hint">
                    <i class="fa-solid fa-hand-pointer"></i>
                    Klik salah satu kecamatan di peta (atau titik birunya) untuk melihat wisata &amp; penjelasannya di bawah.
                </p>
            </div>
        </div>

        {{-- Card detail — muncul di bawah peta saat sebuah kecamatan/titik wisata diklik --}}
        <div class="nac-region-detail" data-region-detail hidden>
            <button type="button" class="nac-region-detail__close" data-region-detail-close aria-label="Tutup">
                <i class="fa-solid fa-xmark"></i>
            </button>

            <span class="nac-region-detail__tag" data-region-detail-tag>Kecamatan</span>
            <h3 class="nac-region-detail__title" data-region-detail-title></h3>
            <p class="nac-region-detail__desc" data-region-detail-desc></p>

            <div class="nac-region-detail__gallery" data-region-detail-gallery></div>
            <p class="nac-region-detail__empty" data-region-detail-empty hidden>
                Belum ada data wisata untuk kecamatan ini.
            </p>
        </div>
    </div>
</section>

{{-- Data wisata per kecamatan — sumber untuk JS di bawah. Nanti kalau sudah
     dinamis dari database, cukup ganti isi <script id="region-attractions-data">
     ini jadi endpoint API (lihat komentar di fungsi getKecamatanDetail). --}}
<script type="application/json" id="region-attractions-data">{!! json_encode($mapData['attractions']) !!}</script>

<script>
(function () {
    var svg = document.querySelector('[data-region-svg]');
    if (!svg) return;

    /* ================= ZOOM & PAN ================= */
    var mapEl  = document.querySelector('[data-region-map]');
    var canvas = document.querySelector('[data-region-canvas]');
    var zoomInBtn    = document.querySelector('[data-region-zoom-in]');
    var zoomOutBtn   = document.querySelector('[data-region-zoom-out]');
    var zoomResetBtn = document.querySelector('[data-region-zoom-reset]');

    var scale = 1, minScale = 1, maxScale = 4, step = 0.5;
    var panX = 0, panY = 0;
    var isPanning = false, startX = 0, startY = 0;

    function clampPan() {
        var rect = mapEl.getBoundingClientRect();
        var minX = Math.min(0, rect.width * (1 - scale));
        var minY = Math.min(0, rect.height * (1 - scale));
        panX = Math.min(0, Math.max(minX, panX));
        panY = Math.min(0, Math.max(minY, panY));
    }

    function applyTransform() {
        canvas.style.transform = 'translate(' + panX + 'px, ' + panY + 'px) scale(' + scale + ')';
        mapEl.classList.toggle('is-zoomed', scale > 1);
    }

    function setScale(next) {
        scale = Math.min(maxScale, Math.max(minScale, next));
        if (scale === 1) { panX = 0; panY = 0; }
        clampPan();
        applyTransform();
    }

    zoomInBtn.addEventListener('click', function () { setScale(scale + step); });
    zoomOutBtn.addEventListener('click', function () { setScale(scale - step); });
    zoomResetBtn.addEventListener('click', function () { setScale(1); });

    // Scroll/wheel di atas peta = zoom (bukan scroll halaman).
    mapEl.addEventListener('wheel', function (e) {
        e.preventDefault();
        setScale(scale + (e.deltaY < 0 ? step / 2 : -step / 2));
    }, { passive: false });

    // Drag untuk geser (pan) saat sedang di-zoom.
    mapEl.addEventListener('pointerdown', function (e) {
        if (scale <= 1) return;
        isPanning = true;
        mapEl.classList.add('is-panning');
        startX = e.clientX - panX;
        startY = e.clientY - panY;
    });
    window.addEventListener('pointermove', function (e) {
        if (!isPanning) return;
        panX = e.clientX - startX;
        panY = e.clientY - startY;
        clampPan();
        applyTransform();
    });
    window.addEventListener('pointerup', function () {
        isPanning = false;
        mapEl.classList.remove('is-panning');
    });

    /* ================= HOVER CARD (nama + estimasi koordinat) ================= */
    var hoverCard  = document.querySelector('[data-region-hover-card]');
    var hoverName  = document.querySelector('[data-region-hover-name]');
    var hoverCoord = document.querySelector('[data-region-hover-coord]');

    function formatCoord(lat, lng) {
        lat = parseFloat(lat);
        lng = parseFloat(lng);
        var latDir = lat >= 0 ? 'LU' : 'LS';
        var lngDir = lng >= 0 ? 'BT' : 'BB';
        return Math.abs(lat).toFixed(4) + '° ' + latDir + ', ' + Math.abs(lng).toFixed(4) + '° ' + lngDir;
    }

    function showHoverCard(path) {
        hoverName.textContent = path.getAttribute('data-name');
        hoverCoord.textContent = formatCoord(path.getAttribute('data-lat'), path.getAttribute('data-lng'));
        hoverCard.classList.add('is-visible');
    }
    function hideHoverCard() {
        hoverCard.classList.remove('is-visible');
    }

    svg.querySelectorAll('.nac-region-path').forEach(function (path) {
        path.addEventListener('pointerenter', function () { showHoverCard(path); });
        path.addEventListener('focus', function () { showHoverCard(path); });
        path.addEventListener('pointerleave', hideHoverCard);
        path.addEventListener('blur', hideHoverCard);
    });

    /* ================= KLIK -> CARD DETAIL DI BAWAH PETA ================= */

    var detailEl     = document.querySelector('[data-region-detail]');
    var detailTag    = document.querySelector('[data-region-detail-tag]');
    var detailTitle  = document.querySelector('[data-region-detail-title]');
    var detailDesc   = document.querySelector('[data-region-detail-desc]');
    var detailGallery = document.querySelector('[data-region-detail-gallery]');
    var detailEmpty  = document.querySelector('[data-region-detail-empty]');
    var detailClose  = document.querySelector('[data-region-detail-close]');

    // Data wisata (statis, dari JSON kutim-map.json) dikelompokkan per kecamatan.
    var attractionsData = JSON.parse(document.getElementById('region-attractions-data').textContent || '[]');
    var attractionsByKecamatan = {};
    attractionsData.forEach(function (spot) {
        if (!attractionsByKecamatan[spot.kecamatan]) attractionsByKecamatan[spot.kecamatan] = [];
        attractionsByKecamatan[spot.kecamatan].push(spot);
    });

    // Deskripsi tiap kecamatan diambil dari attribute data-desc pada <path>,
    // dikumpulkan sekali di awal supaya pin (yang cuma tahu nama kecamatannya)
    // juga bisa ambil deskripsi yang sama saat diklik.
    var kecamatanDescByName = {};
    svg.querySelectorAll('.nac-region-path').forEach(function (path) {
        kecamatanDescByName[path.getAttribute('data-name')] = path.getAttribute('data-desc');
    });

    /**
     * Ambil data lengkap 1 kecamatan (deskripsi + daftar wisatanya).
     *
     * SEKARANG: baca dari data statis di atas (dibungkus Promise supaya
     * pemanggilnya tidak perlu berubah nanti).
     *
     * NANTI (dinamis dari database): ganti isi fungsi ini jadi:
     *   return fetch('/api/kecamatan/' + encodeURIComponent(name)).then(r => r.json());
     * asalkan response API-nya punya bentuk yang sama:
     *   { name, desc, attractions: [{ name, desc, image }] }
     */
    function getKecamatanDetail(name) {
        var attractions = (attractionsByKecamatan[name] || []).map(function (spot) {
            return {
                name: spot.name,
                desc: spot.desc,
                // Placeholder — ganti ke URL foto asli tiap wisata kalau sudah ada.
                image: 'https://picsum.photos/seed/' + encodeURIComponent(spot.name) + '/480/360',
            };
        });

        return Promise.resolve({
            name: name,
            desc: kecamatanDescByName[name] || 'Penjelasan untuk kecamatan ini belum tersedia.',
            attractions: attractions,
        });
    }

    function renderRegionDetail(data) {
        detailTag.textContent = 'Kecamatan';
        detailTitle.textContent = data.name;
        detailDesc.textContent = data.desc;

        if (data.attractions.length) {
            detailGallery.hidden = false;
            detailEmpty.hidden = true;
            detailGallery.innerHTML = data.attractions.map(function (spot) {
                return (
                    '<div class="nac-region-detail__photo">' +
                        '<img src="' + spot.image + '" alt="' + spot.name + '" loading="lazy">' +
                        '<div class="nac-region-detail__photo-body">' +
                            '<h6>' + spot.name + '</h6>' +
                            '<p>' + spot.desc + '</p>' +
                        '</div>' +
                    '</div>'
                );
            }).join('');
        } else {
            detailGallery.hidden = true;
            detailGallery.innerHTML = '';
            detailEmpty.hidden = false;
        }

        detailEl.hidden = false;
        // Beri browser 1 frame supaya transition CSS ke-trigger (dari hidden -> tampil).
        requestAnimationFrame(function () {
            detailEl.classList.add('is-open');
        });
        detailEl.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }

    function closeRegionDetail() {
        detailEl.classList.remove('is-open');
        window.setTimeout(function () { detailEl.hidden = true; }, 300);
    }

    function openKecamatan(name) {
        getKecamatanDetail(name).then(renderRegionDetail);
    }

    svg.querySelectorAll('.nac-region-path').forEach(function (path) {
        var name = path.getAttribute('data-name');

        // Klik (atau tap di HP) = tampilkan card detail di bawah peta.
        path.addEventListener('click', function (e) {
            e.preventDefault();
            openKecamatan(name);
        });
        // Aksesibilitas keyboard: Enter/Space juga memicu.
        path.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                openKecamatan(name);
            }
        });
    });

    // Pin wisata — klik akan membuka card kecamatan tempat wisata itu berada.
    document.querySelectorAll('[data-pin-name]').forEach(function (pin) {
        pin.addEventListener('click', function () {
            openKecamatan(pin.getAttribute('data-pin-kec'));
        });
    });

    detailClose.addEventListener('click', closeRegionDetail);
})();
</script>

@endsection