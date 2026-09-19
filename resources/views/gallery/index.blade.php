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
        <span class="nac-page-header__icon"><i class="fa-solid fa-images"></i></span>

        <h1 class="nac-page-header__title">Momen di Nugroho Aquatic Club.</h1>
        <p class="nac-page-header__desc">
            Dokumentasi foto dan video kegiatan latihan, kejuaraan, dan keseharian di NAC.
        </p>
    </div>

    <svg class="nac-hero__wave" viewBox="0 0 1440 120" preserveAspectRatio="none" aria-hidden="true">
        <path d="M0,64 C240,120 480,0 720,32 C960,64 1200,120 1440,64 L1440,120 L0,120 Z"></path>
    </svg>
</section>

<section class="nac-section">
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
                            <img src="{{ $item->image_url }}" alt="{{ $item->caption }}" loading="lazy"
                                class="nac-gallery-page__photo-trigger"
                                data-lightbox-src="{{ $item->image_url }}"
                                data-lightbox-alt="{{ $item->caption }}"
                                data-lightbox-title="{{ $item->caption }}">
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

{{-- ============ LIGHTBOX PREVIEW FOTO ============ --}}
<div class="nac-lightbox" id="nacLightbox" aria-hidden="true">
    <button type="button" class="nac-lightbox__close" id="nacLightboxClose" aria-label="Tutup preview foto">
        <i class="fa-solid fa-xmark"></i>
    </button>
    <div class="nac-lightbox__inner">
        <img src="" alt="" id="nacLightboxImg" class="nac-lightbox__img">
        <div class="nac-lightbox__caption" id="nacLightboxCaption">
            <h4 id="nacLightboxTitle"></h4>
            <p id="nacLightboxDesc"></p>
        </div>
    </div>
</div>

<script>
(function () {
    var lightbox   = document.getElementById('nacLightbox');
    var img        = document.getElementById('nacLightboxImg');
    var titleEl    = document.getElementById('nacLightboxTitle');
    var descEl     = document.getElementById('nacLightboxDesc');
    var captionEl  = document.getElementById('nacLightboxCaption');
    var closeBtn   = document.getElementById('nacLightboxClose');
    if (!lightbox || !img) return;

    function openLightbox(trigger) {
        var src   = trigger.getAttribute('data-lightbox-src');
        var alt   = trigger.getAttribute('data-lightbox-alt') || '';
        var title = trigger.getAttribute('data-lightbox-title') || '';
        var desc  = trigger.getAttribute('data-lightbox-desc') || '';

        img.src = src;
        img.alt = alt;
        titleEl.textContent = title;
        descEl.textContent = desc;
        captionEl.style.display = (title || desc) ? 'block' : 'none';

        lightbox.classList.add('is-open');
        lightbox.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
    }

    function closeLightbox() {
        lightbox.classList.remove('is-open');
        lightbox.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
        img.src = '';
    }

    document.addEventListener('click', function (e) {
        var trigger = e.target.closest('[data-lightbox-src]');
        if (trigger) {
            e.preventDefault();
            openLightbox(trigger);
        }
    });

    closeBtn.addEventListener('click', closeLightbox);
    lightbox.addEventListener('click', function (e) {
        if (e.target === lightbox) closeLightbox();
    });
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && lightbox.classList.contains('is-open')) closeLightbox();
    });
})();
</script>

@endsection