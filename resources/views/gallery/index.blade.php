@extends('layouts.app')

@section('title', 'Galeri — Nugroho Aquatic Club')
@section('meta_description', 'Dokumentasi momen, kegiatan, dan video di Nugroho Aquatic Club.')

@section('content')

<section class="nac-page-header @if($setting->gallery_header_type === 'photo' && $setting->gallery_header_photo_url) nac-page-header--photo @elseif($setting->gallery_header_type === 'video' && $setting->gallery_header_video_embed_url) nac-page-header--photo @endif"
    @if($setting->gallery_header_type === 'photo' && $setting->gallery_header_photo_url)
        style="background-image: url('{{ $setting->gallery_header_photo_url }}');"
    @endif>

    @if($setting->gallery_header_type === 'video' && $setting->gallery_header_video_embed_url)
        <div class="nac-page-header__bg-video-wrap">
            <iframe src="{{ $setting->gallery_header_video_embed_url }}"
                class="nac-page-header__bg-video"
                allow="autoplay; encrypted-media"
                title="Background video halaman Galeri"></iframe>
        </div>
    @endif

    <div class="container text-center" data-aos="fade-up">
        <h1 class="nac-page-header__title">Momen di Nugroho Aquatic Club.</h1>
        <p class="nac-page-header__desc">
            Dokumentasi foto dan video kegiatan latihan, kejuaraan, dan keseharian di NAC.
        </p>
    </div>
</section>

<section class="nac-section nac-section--decorated nac-dot-pattern">
    <div class="container">
        @if ($galleries->isEmpty())
            <p class="text-center nac-muted">Galeri belum tersedia.</p>
        @else
            <div class="nac-gallery-page__masonry">
                @foreach ($galleries as $i => $item)
                    <figure class="nac-gallery-page__item" data-aos="fade-up" data-aos-delay="{{ ($i % 3) * 100 }}">
                        @if ($item->type === 'video' && $item->youtube_embed_url)
                            <button type="button" class="nac-gallery__play-trigger" data-play-video="{{ $item->youtube_embed_url }}" aria-label="Putar video">
                                <img src="{{ $item->image_url }}" alt="{{ $item->caption }}" loading="lazy">
                                <span class="nac-gallery__play-icon"><i class="fa-solid fa-play"></i></span>
                            </button>
                        @elseif ($item->image_url)
                            <img src="{{ $item->image_url }}" alt="{{ $item->caption }}" loading="lazy">
                        @else
                            <div class="nac-photo-placeholder">
                                <i class="fa-solid fa-image"></i>
                                <span>Foto belum tersedia</span>
                            </div>
                        @endif
                        @if ($item->caption)
                            <figcaption>{{ $item->caption }}</figcaption>
                        @endif
                    </figure>
                @endforeach
            </div>

            <div class="mt-4">
                {{ $galleries->links() }}
            </div>
        @endif
    </div>
</section>

@endsection