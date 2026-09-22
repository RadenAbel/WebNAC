@extends('layouts.app')

@section('title', 'Atlet Renang — Nugroho Aquatic Club Sangatta')
@section('meta_description', 'Kenali atlet renang berprestasi Nugroho Aquatic Club, Sangatta, Kutai Timur, beserta rekor waktu dan prestasinya.')

@section('content')

<section class="nac-page-header @if($setting->team_header_type === 'photo' && $setting->team_header_photo_url) nac-page-header--photo @elseif($setting->team_header_type === 'video' && $setting->team_header_video_embed_url) nac-page-header--photo @endif"
    @if($setting->team_header_type === 'photo' && $setting->team_header_photo_url)
        style="background-image: url('{{ $setting->team_header_photo_url }}');"
    @endif>

    @if($setting->team_header_type === 'video' && $setting->team_header_video_embed_url)
        <div class="nac-page-header__bg-video-wrap">
            <iframe src="{{ $setting->team_header_video_embed_url }}"
                class="nac-page-header__bg-video"
                allow="autoplay; encrypted-media"
                title="Background video halaman Atlet"></iframe>
        </div>
    @endif

    <div class="container text-center" data-aos="fade-up">
        <h1 class="nac-page-header__title">Atlet yang mengharumkan nama klub.</h1>
        <p class="nac-page-header__desc">
            Atlet berprestasi yang mengharumkan nama Nugroho Aquatic Club di berbagai kejuaraan.
        </p>
    </div>
</section>

<section class="nac-section nac-section--decorated nac-dot-pattern" id="atlet">
    <div class="container">
        @include('team.partials.fan', [
            'members'      => $athletes,
            'fanId'        => 'atlet',
            'icon'         => 'fa-medal',
            'eyebrow'      => 'Atlet',
            'title'        => 'Tim Atlet',
            'description'  => 'Atlet berprestasi yang mengharumkan nama Nugroho Aquatic Club di berbagai kejuaraan.',
            'emptyText'    => 'Data atlet belum tersedia.',
            'labelClosed'  => 'Lihat Semua Atlet',
            'labelOpen'    => 'Tutup Tim Atlet',
            'hintText'     => 'Klik tombol di atas untuk melihat semua atlet',
        ])
    </div>
</section>

@include('team.partials.fan-script')

@endsection