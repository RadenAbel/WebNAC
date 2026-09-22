@extends('layouts.app')

@section('title', 'Pelatih Renang — Nugroho Aquatic Club Sangatta')
@section('meta_description', 'Kenali pelatih renang bersertifikat Nugroho Aquatic Club yang melatih di Everglade Aquatic Center, Sangatta, Kutai Timur.')

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
                title="Background video halaman Pelatih"></iframe>
        </div>
    @endif

    <div class="container text-center" data-aos="fade-up">
        <h1 class="nac-page-header__title">Di balik setiap catatan waktu terbaik.</h1>
        <p class="nac-page-header__desc">
            Dipandu langsung oleh pelatih bersertifikat dengan jam terbang tinggi di dunia akuatik.
        </p>
    </div>
</section>

<section class="nac-section nac-section--decorated nac-dot-pattern" id="pelatih">
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

@include('team.partials.fan-script')

@endsection