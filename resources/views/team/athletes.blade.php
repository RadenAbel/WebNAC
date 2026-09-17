@extends('layouts.app')

@section('title', 'Atlet — Nugroho Aquatic Club')
@section('meta_description', 'Kenali atlet berprestasi Nugroho Aquatic Club.')

@section('content')

<section class="nac-page-header">
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