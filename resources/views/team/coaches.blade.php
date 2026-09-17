@extends('layouts.app')

@section('title', 'Pelatih — Nugroho Aquatic Club')
@section('meta_description', 'Kenali pelatih bersertifikat Nugroho Aquatic Club.')

@section('content')

<section class="nac-page-header">
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