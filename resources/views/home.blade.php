@extends('layouts.app')

@section('title', 'Nugroho Aquatic Club — Klub Renang di Sangatta, Kutai Timur')
@section('meta_description', 'Klub dan sekolah renang di Sangatta Utara, Kutai Timur. Latihan di Everglade Aquatic Center bersama pelatih bersertifikat, dari pemula hingga atlet kompetisi.')

@section('content')

<section class="nac-hero nac-hero--photo">
    @if(count($heroPhotos))
        <div id="heroBgCarousel" class="carousel slide nac-hero__bg" data-bs-ride="carousel" data-bs-interval="6000">
            <div class="carousel-inner h-100">
                @foreach($heroPhotos as $i => $photo)
                    <div class="carousel-item h-100 {{ $i === 0 ? 'active' : '' }}">
                        @if(($photo['type'] ?? 'photo') === 'video' && !empty($photo['video_embed_url']))
                            <div class="nac-hero__bg-video-wrap">
                                <iframe src="{{ $photo['video_embed_url'] }}"
                                    class="nac-hero__bg-video"
                                    allow="autoplay; encrypted-media"
                                    loading="{{ $i === 0 ? 'eager' : 'lazy' }}"
                                    title="{{ $photo['alt'] ?? '' }}"></iframe>
                            </div>
                        @else
                            <img src="{{ $photo['photo_url'] }}" alt="{{ $photo['alt'] ?? '' }}" class="nac-hero__bg-img" loading="{{ $i === 0 ? 'eager' : 'lazy' }}">
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
        <div class="nac-hero__overlay"></div>
    @endif

    <div class="container position-relative">
        <div class="row align-items-center min-vh-100 py-5 g-5">
            <div class="col-lg-7" data-aos="fade-up">
                <span class="nac-eyebrow">Nugroho Aquatic CLUB</span>
                <h1 class="nac-hero__title">
                    Setiap tarikan napas,<br>
                    setiap detik berarti
                </h1>
                <p class="nac-hero__subtitle">
                    Kolam renang standar kompetisi dengan pelatih bersertifikat nasional. Dari langkah pertama di air hingga catatan waktu terbaikmu di lintasan.
                </p>
                <div class="d-flex flex-wrap gap-3 mt-4">
                    <a href="{{ route('about.index') }}#biaya" class="btn nac-btn nac-btn--primary btn-lg">Daftar Latihan</a>
                    <a href="{{ route('team.athletes') }}" class="btn nac-btn nac-btn--outline btn-lg">Kenali Tim Kami</a>
                </div>
            </div>

            <div class="col-lg-5" data-aos="fade-up" data-aos-delay="200">
                <div class="nac-hero-stats-strip nac-hero-stats-strip--grid">
                    @foreach($heroStats as $stat)
                        <div class="nac-hero-stats-strip__item">
                            <i class="fa-solid {{ $stat['icon'] }}"></i>
                            <div>
                                <div class="nac-hero-stats-strip__num">{{ $stat['num'] }}@if(!empty($stat['unit']))<span>{{ $stat['unit'] }}</span>@endif</div>
                                <div class="nac-hero-stats-strip__label">{{ $stat['label'] }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

<section class="nac-section nac-section--decorated nac-section--tint" id="tentang">
    <div class="container">
        <div class="nac-pool-highlight nac-about-card" data-aos="fade-up"
            style="background-image: linear-gradient(90deg, rgba(10, 14, 20, 0.88) 0%, rgba(10, 14, 20, 0.65) 50%, rgba(10, 14, 20, 0.3) 100%)@if($setting->about_photo_url), url('{{ $setting->about_photo_url }}')@endif;">

            <div class="nac-about-photo__badge nac-about-card__badge">
                <span>Sejak</span>
                <strong>{{ $setting->since_year }}</strong>
            </div>

            <div class="nac-pool-highlight__content nac-about-card__content">
                <span class="nac-eyebrow nac-about-card__eyebrow">Tentang Kami</span>
                <h2 class="nac-pool-highlight__title">{{ $setting->about_title }}</h2>
                <div class="nac-lead nac-lead--clamp-3 nac-about-card__lead">
                    {!! $setting->about_description !!}
                </div>
                <ul class="nac-check-list nac-about-card__list">
                    <li><i class="fa-solid fa-certificate"></i> Pelatih bersertifikat nasional</li>
                    <li><i class="fa-solid fa-layer-group"></i> Kurikulum bertingkat: Novato, Avance, Campeón</li>
                    <li><i class="fa-solid fa-water"></i> Kolam, 2 lintasan</li>
                </ul>

                <a href="{{ route('about.index') }}" class="nac-btn nac-btn--primary nac-join-cta__btn">
                    Selengkapnya Tentang Kami <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<section class="nac-section nac-gallery" id="galeri">
    <div class="container">
        <div class="nac-gallery__head" data-aos="fade-up">
            <div>
                <span class="nac-eyebrow">Galeri</span>
                <h2 class="nac-section__title">Momen di Nugroho Aquatic Club</h2>
            </div>
            <a href="{{ route('gallery.index') }}" class="nac-btn nac-btn--outline-dark nac-gallery__see-all">
                Lihat Selengkapnya <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>

        @php
            $featuredItem = $galleryItems[0] ?? null;
            $sliderItems  = array_slice($galleryItems, 1);
        @endphp

        <div class="nac-gallery__layout" data-aos="fade-up" data-aos-delay="100">
            @if($featuredItem)
                <figure class="nac-gallery__item nac-gallery__item--featured @if(empty($featuredItem['photo_url'])) is-empty @endif">
                    @if(($featuredItem['type'] ?? 'photo') === 'video' && !empty($featuredItem['video_embed_url']))
                        <button type="button" class="nac-gallery__play-trigger" data-play-video="{{ $featuredItem['video_embed_url'] }}" aria-label="Putar video">
                            <img src="{{ $featuredItem['photo_url'] }}" alt="{{ $featuredItem['alt'] ?? '' }}" loading="lazy"
                                 onload="this.closest('.nac-gallery__item').classList.add('is-loaded')">
                            <span class="nac-gallery__play-icon"><i class="fa-solid fa-play"></i></span>
                        </button>
                    @elseif(!empty($featuredItem['photo_url']))
                        <img src="{{ $featuredItem['photo_url'] }}"
                             alt="{{ $featuredItem['alt'] ?? '' }}"
                             loading="lazy"
                             onload="this.closest('.nac-gallery__item').classList.add('is-loaded')">
                    @else
                        <div class="nac-photo-placeholder">
                            <i class="fa-solid fa-image"></i>
                            <span>Foto belum tersedia</span>
                        </div>
                    @endif
                    @if(!empty($featuredItem['caption']))
                        <figcaption>{{ $featuredItem['caption'] }}</figcaption>
                    @endif
                </figure>
            @endif

            <div class="nac-gallery__track-wrap">
                <div class="nac-gallery__track" data-gallery-track>
                    @forelse($sliderItems as $item)
                        <figure class="nac-gallery__item @if(empty($item['photo_url'])) is-empty @endif">
                            @if(!empty($item['photo_url']))
                                <img src="{{ $item['photo_url'] }}"
                                     alt="{{ $item['alt'] ?? '' }}"
                                     loading="lazy"
                                     onload="this.closest('.nac-gallery__item').classList.add('is-loaded')">
                            @else
                                <div class="nac-photo-placeholder">
                                    <i class="fa-solid fa-image"></i>
                                    <span>Foto belum tersedia</span>
                                </div>
                            @endif
                            @if(!empty($item['caption']))
                                <figcaption>{{ $item['caption'] }}</figcaption>
                            @endif
                        </figure>
                    @empty
                        @if(!$featuredItem)
                            <p class="text-center nac-muted">Galeri belum tersedia.</p>
                        @endif
                    @endforelse
                </div>

                <button type="button" class="nac-gallery__arrow nac-gallery__arrow--prev" data-gallery-prev aria-label="Foto sebelumnya">
                    <i class="fa-solid fa-chevron-left"></i>
                </button>
                <button type="button" class="nac-gallery__arrow nac-gallery__arrow--next" data-gallery-next aria-label="Foto berikutnya">
                    <i class="fa-solid fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </div>
</section>

<section class="nac-section nac-section--decorated nac-section--tint nac-join-cta-section" id="gabung">
    <div class="container">
        <div class="nac-pool-highlight nac-join-cta" data-aos="fade-up"
            style="background-image: linear-gradient(90deg, rgba(10, 14, 20, 0.85) 0%, rgba(10, 14, 20, 0.6) 45%, rgba(10, 14, 20, 0.25) 100%)@if($setting->join_cta_photo_url), url('{{ $setting->join_cta_photo_url }}')@endif;">
            <div class="nac-pool-highlight__content">
                @if($setting->join_cta_title)
                    <h2 class="nac-pool-highlight__title">{{ $setting->join_cta_title }}</h2>
                @endif
                @if($setting->join_cta_description)
                    <p class="nac-pool-highlight__desc">{{ $setting->join_cta_description }}</p>
                @endif
                <a href="{{ route('join.create') }}" class="nac-btn nac-btn--primary nac-join-cta__btn">
                    Gabung Bersama Kami <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</section>

@endsection
