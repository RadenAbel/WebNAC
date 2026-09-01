@extends('layouts.app')

@section('title', 'Acara — Nugroho Aquatic Center')
@section('meta_description', 'Kegiatan dan acara yang diselenggarakan Nugroho Aquatic Center, lengkap dengan laporan kegiatannya.')

@section('content')

<section class="nac-page-header">
    <div class="container text-center" data-aos="fade-up">
        <h1 class="nac-page-header__title">Acara &amp; Kegiatan Kami.</h1>
        <p class="nac-page-header__desc">
            Dokumentasi kegiatan dan hasil dari kegiatan yang pernah diikuti Nugroho Aquatic Club.
        </p>
    </div>

    <svg class="nac-hero__wave" viewBox="0 0 1440 120" preserveAspectRatio="none" aria-hidden="true">
        <path d="M0,64 C240,120 480,0 720,32 C960,64 1200,120 1440,64 L1440,120 L0,120 Z"></path>
    </svg>
</section>

<section class="nac-section">
    <div class="container">
        @if ($events->isEmpty())
            <p class="text-center nac-muted">Belum ada kegiatan yang ditampilkan.</p>
        @else
            <div class="row g-4">
                @foreach ($events as $i => $event)
                    <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ ($i % 3) * 100 }}">
                        @include('event.partials.card', ['event' => $event])
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>

@endsection