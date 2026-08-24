@extends('layouts.app')

@php
    $roleLabel = $member->role === 'pelatih' ? 'Pelatih' : 'Atlet';

    // Route halaman "Our Team" sesuai routes/web.php kamu.
    $teamUrl    = route('team.index');
    $sectionUrl = $teamUrl . ($member->role === 'pelatih' ? '#pelatih' : '#atlet');

    // ⚠️ Ganti nomor/link ini sesuai kontak resmi Nugroho Aquatic Center.
    $contactUrl = 'https://wa.me/6281234567890';
@endphp

@section('title', $member->name . ' — ' . $roleLabel . ' Nugroho Aquatic Center')
@section('meta_description', 'Profil ' . $roleLabel . ' ' . $member->name . ' di Nugroho Aquatic Center.')

@section('content')

{{-- ============ HERO PROFIL ============ --}}
<section class="nac-profile-hero">
    <div class="container">

        <nav class="nac-breadcrumb" aria-label="Breadcrumb" data-aos="fade-right">
            <a href="{{ url('/') }}">Beranda</a>
            <i class="fa-solid fa-chevron-right"></i>
            <a href="{{ $teamUrl }}">Our Team</a>
            <i class="fa-solid fa-chevron-right"></i>
            <a href="{{ $sectionUrl }}">{{ $roleLabel }}</a>
            <i class="fa-solid fa-chevron-right"></i>
            <span aria-current="page">{{ $member->name }}</span>
        </nav>

        <div class="row align-items-start g-5 mt-1">
            <div class="col-lg-5" data-aos="fade-up">
                <div class="nac-profile-photo">
                    <img src="{{ $member->photo_url }}"
                         alt="Foto {{ $member->name }}"
                         width="640" height="800"
                         fetchpriority="high">
                    <span class="nac-profile-photo__role">{{ $roleLabel }}</span>
                </div>
            </div>

            <div class="col-lg-7" data-aos="fade-up" data-aos-delay="100">
                <span class="nac-eyebrow nac-eyebrow--light">{{ $roleLabel }} &middot; Nugroho Aquatic Center</span>
                <h1 class="nac-profile-name">{{ $member->name }}</h1>

                @if(!empty($member->tagline))
                    <p class="nac-profile-tagline">{{ $member->tagline }}</p>
                @endif

                @if(!empty($member->age) || !empty($member->category) || !empty($member->experience_years))
                    <div class="nac-profile-stats">
                        @if(!empty($member->age))
                            <div class="nac-profile-stats__item">
                                <i class="fa-solid fa-cake-candles"></i>
                                <div>
                                    <span class="nac-profile-stats__num">{{ $member->age }}</span>
                                    <span class="nac-profile-stats__label">Tahun</span>
                                </div>
                            </div>
                        @endif
                        @if(!empty($member->category))
                            <div class="nac-profile-stats__item">
                                <i class="fa-solid fa-medal"></i>
                                <div>
                                    <span class="nac-profile-stats__num nac-profile-stats__num--text">{{ $member->category }}</span>
                                    <span class="nac-profile-stats__label">Kategori</span>
                                </div>
                            </div>
                        @endif
                        @if(!empty($member->experience_years))
                            <div class="nac-profile-stats__item">
                                <i class="fa-solid fa-timeline"></i>
                                <div>
                                    <span class="nac-profile-stats__num">{{ $member->experience_years }}+</span>
                                    <span class="nac-profile-stats__label">Tahun Pengalaman</span>
                                </div>
                            </div>
                        @endif
                    </div>
                @endif

                <div class="nac-profile-actions">
                    <a href="{{ $contactUrl }}" target="_blank" rel="noopener" class="nac-btn nac-btn--primary">
                        <i class="fa-brands fa-whatsapp"></i> Hubungi Kami
                    </a>

                    @if(!empty($member->instagram) || !empty($member->email) || !empty($member->phone))
                        <div class="nac-profile-social">
                            @if(!empty($member->instagram))
                                <a href="https://instagram.com/{{ ltrim($member->instagram, '@') }}" target="_blank" rel="noopener" aria-label="Instagram {{ $member->name }}">
                                    <i class="fa-brands fa-instagram"></i>
                                </a>
                            @endif
                            @if(!empty($member->email))
                                <a href="mailto:{{ $member->email }}" aria-label="Email {{ $member->name }}">
                                    <i class="fa-solid fa-envelope"></i>
                                </a>
                            @endif
                            @if(!empty($member->phone))
                                <a href="https://wa.me/{{ preg_replace('/\D/', '', $member->phone) }}" target="_blank" rel="noopener" aria-label="WhatsApp {{ $member->name }}">
                                    <i class="fa-brands fa-whatsapp"></i>
                                </a>
                            @endif
                        </div>
                    @endif
                </div>

                @if((!empty($member->best_times) && count($member->best_times)) || (!empty($member->competitions) && count($member->competitions)))
                <div class="row g-3 nac-hero-sliders">
                    @if(!empty($member->best_times) && count($member->best_times))
                        <div class="col-sm-6">
                            <div class="nac-hero-slider nac-hero-slider--times">
                                <div class="nac-hero-slider__head">
                                    <i class="fa-solid fa-stopwatch"></i>
                                    <span>Kecepatan Terbaik</span>
                                </div>
                                <div id="heroTimesSlider" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3200">
                                    <div class="carousel-inner">
                                        @foreach($member->best_times as $i => $bestTime)
                                            <div class="carousel-item @if($i === 0) active @endif">
                                                <div class="nac-hero-slide">
                                                    <span class="nac-hero-slide__value">{{ is_array($bestTime) ? ($bestTime['time'] ?? '') : $bestTime }}</span>
                                                    <span class="nac-hero-slide__label">{{ is_array($bestTime) ? ($bestTime['style'] ?? '') : '' }}</span>
                                                    @if(is_array($bestTime) && !empty($bestTime['event']))
                                                        <span class="nac-hero-slide__meta">{{ $bestTime['event'] }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(!empty($member->competitions) && count($member->competitions))
                        <div class="col-sm-6">
                            <div class="nac-hero-slider nac-hero-slider--trophy">
                                <div class="nac-hero-slider__head">
                                    <i class="fa-solid fa-trophy"></i>
                                    <span>Kejuaraan</span>
                                </div>
                                <div id="heroCompetitionsSlider" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3800">
                                    <div class="carousel-inner">
                                        @foreach($member->competitions as $i => $competition)
                                            <div class="carousel-item @if($i === 0) active @endif">
                                                <div class="nac-hero-slide">
                                                    <span class="nac-hero-slide__label">{{ is_array($competition) ? ($competition['name'] ?? '') : $competition }}</span>
                                                    @if(is_array($competition) && (!empty($competition['result']) || !empty($competition['year'])))
                                                        <span class="nac-hero-slide__meta">
                                                            @if(!empty($competition['result'])){{ $competition['result'] }}@endif
                                                            @if(!empty($competition['year'])) &middot; {{ $competition['year'] }}@endif
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                @endif
            </div>
        </div>
    </div>

    <svg class="nac-hero__wave" viewBox="0 0 1440 120" preserveAspectRatio="none" aria-hidden="true">
        <path d="M0,64 C240,120 480,0 720,32 C960,64 1200,120 1440,64 L1440,120 L0,120 Z"></path>
    </svg>
</section>

{{-- ============ BIO / TENTANG ============ --}}
@if(!empty($member->bio))
<section class="nac-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center" data-aos="fade-up">
                <span class="nac-eyebrow">Tentang</span>
                <h2 class="nac-section__title mb-4">Mengenal {{ $member->name }}</h2>
                <p class="nac-lead mx-auto" style="max-width: 42rem;">{{ $member->bio }}</p>
            </div>
        </div>
    </div>
</section>
@endif

{{-- ============ PRESTASI ============ --}}
@if(!empty($member->achievements) && count($member->achievements))
<section class="nac-section nac-section--dark">
    <div class="container">
        <div class="nac-section__head mx-auto text-center" data-aos="fade-up">
            <span class="nac-eyebrow">Prestasi</span>
            <h2 class="nac-section__title nac-section__title--light">Pencapaian & Penghargaan</h2>
        </div>

        <div class="row g-4 mt-3">
            @foreach($member->achievements as $i => $achievement)
                <div class="col-6 col-md-4" data-aos="fade-up" data-aos-delay="{{ $i * 80 }}">
                    <div class="nac-achievement-card">
                        <i class="fa-solid fa-medal"></i>
                        <h5>{{ is_array($achievement) ? ($achievement['title'] ?? '') : $achievement }}</h5>
                        @if(is_array($achievement) && !empty($achievement['year']))
                            <span class="nac-achievement-card__year">{{ $achievement['year'] }}</span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ============ ANGGOTA LAIN ============ --}}
@if($related->count())
<section class="nac-section">
    <div class="container">
        <div class="nac-section__head mx-auto text-center" data-aos="fade-up">
            <span class="nac-eyebrow">{{ $roleLabel }} Lainnya</span>
            <h2 class="nac-section__title">Kenali yang Lain</h2>
        </div>

        <div class="row g-4 mt-3 justify-content-center">
            @foreach($related as $i => $otherMember)
                <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="{{ $i * 80 }}">
                    @include('team.partials.card', ['member' => $otherMember])
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection