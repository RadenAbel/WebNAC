@extends('layouts.app')

@section('title', 'Our Team — Nugroho Aquatic Center')
@section('meta_description', 'Kenali pelatih bersertifikat dan atlet berprestasi Nugroho Aquatic Center.')

@section('content')

<section class="nac-page-header">
    <div class="container text-center" data-aos="fade-up">
        <nav class="nac-breadcrumb" aria-label="Breadcrumb">
            <a href="{{ url('/') }}">Beranda</a>
            <i class="fa-solid fa-chevron-right"></i>
            <span aria-current="page">Our Team</span>
        </nav>

        <span class="nac-page-header__icon"><i class="fa-solid fa-people-group"></i></span>

        <h1 class="nac-page-header__title">Di balik setiap catatan waktu terbaik.</h1>
        <p class="nac-page-header__desc">
            Gabungan pelatih berpengalaman dan atlet berdedikasi yang membentuk
            identitas Nugroho Aquatic Center.
        </p>
    </div>

    <svg class="nac-hero__wave" viewBox="0 0 1440 120" preserveAspectRatio="none" aria-hidden="true">
        <path d="M0,64 C240,120 480,0 720,32 C960,64 1200,120 1440,64 L1440,120 L0,120 Z"></path>
    </svg>
</section>

{{-- ============ PELATIH ============ --}}
<section class="nac-section" id="pelatih">
    <div class="container">
        @include('team.partials.fan', [
            'members'      => $coaches,
            'fanId'        => 'pelatih',
            'icon'         => 'fa-user-graduate',
            'eyebrow'      => 'Pelatih',
            'title'        => 'Tim Pelatih',
            'description'  => 'Dipandu langsung oleh pelatih bersertifikat dengan jam terbang tinggi di dunia akuatik.',
            'emptyText'    => 'Data pelatih belum tersedia.',
            'labelClosed'  => 'Lihat Semua Pelatih',
            'labelOpen'    => 'Tutup Tim Pelatih',
            'hintText'     => 'Klik tombol di atas untuk melihat semua pelatih',
        ])
    </div>
</section>

<div class="nac-divider" aria-hidden="true">
    <span class="nac-divider__line"></span>
    <span class="nac-divider__icon"><i class="fa-solid fa-medal"></i></span>
    <span class="nac-divider__line"></span>
</div>

{{-- ============ ATLET ============ --}}
<section class="nac-section nac-section--tint" id="atlet">
    <div class="container">
        @include('team.partials.fan', [
            'members'      => $athletes,
            'fanId'        => 'atlet',
            'icon'         => 'fa-medal',
            'eyebrow'      => 'Atlet',
            'title'        => 'Tim Atlet',
            'description'  => 'Atlet berprestasi yang mengharumkan nama Nugroho Aquatic Center di berbagai kejuaraan.',
            'emptyText'    => 'Data atlet belum tersedia.',
            'labelClosed'  => 'Lihat Semua Atlet',
            'labelOpen'    => 'Tutup Tim Atlet',
            'hintText'     => 'Klik tombol di atas untuk melihat semua atlet',
        ])
    </div>
</section>


<script>
(function () {
    var groups = document.querySelectorAll('[data-fan-group]');

    groups.forEach(function (group) {
        var trigger = group.querySelector('[data-fan-trigger]');
        var grid    = group.querySelector('[data-fan-grid]');
        if (!trigger || !grid) return;

        var labelClosed = trigger.getAttribute('data-label-closed');
        var labelOpen   = trigger.getAttribute('data-label-open');
        var textEl      = trigger.querySelector('[data-fan-trigger-text]');

        trigger.addEventListener('click', function () {
            var willOpen = !group.classList.contains('is-open');

            group.classList.toggle('is-open', willOpen);
            trigger.setAttribute('aria-expanded', String(willOpen));
            if (textEl) {
                textEl.textContent = willOpen ? labelOpen : labelClosed;
            }

            if (willOpen) {
                // Bring the newly revealed grid comfortably into view.
                window.setTimeout(function () {
                    grid.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                }, 80);
            }
        });

        // Allow closing by pressing Escape while focus is inside the group.
        group.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && group.classList.contains('is-open')) {
                trigger.click();
                trigger.focus();
            }
        });
    });
})();
</script>

@endsection