@extends('layouts.app')

@section('title', 'Nugroho Aquatic Center — Kolam Renang Premium')
@section('meta_description', 'Fasilitas renang premium di Surabaya dengan pelatih bersertifikat untuk atlet junior hingga senior.')

@section('content')

{{-- ============ HERO ============ --}}
<section class="nac-hero">
    <div class="container">
        <div class="row align-items-center min-vh-100 py-5 g-5">
            <div class="col-lg-6" data-aos="fade-up">
                <span class="nac-eyebrow">Nugroho Aquatic Center</span>
                <h1 class="nac-hero__title">
                    Setiap tarikan napas,<br>
                    <span class="nac-text-gradient">setiap detik</span> berarti.
                </h1>
                <p class="nac-hero__subtitle">
                    Kolam renang standar kompetisi dengan pelatih bersertifikat nasional.
                    Dari langkah pertama di air hingga catatan waktu terbaikmu di lintasan.
                </p>
                <div class="d-flex flex-wrap gap-3 mt-4">
                    <a href="#biaya" class="btn nac-btn nac-btn--primary btn-lg">Daftar Latihan</a>
                    <a href="{{ route('team.index') }}" class="btn nac-btn nac-btn--outline btn-lg">Kenali Tim Kami</a>
                </div>
            </div>

            <div class="col-lg-6" data-aos="fade-left" data-aos-delay="150">
                @php
                    // ============================================================
                    // DUMMY / FALLBACK DATA — pola: $variable ?? [dummy].
                    // Begitu controller mengirim $heroStats & $heroPhotos asli
                    // (mis. dari tabel pool_stats & hero_photos), blade ini
                    // otomatis memakainya tanpa perlu diubah lagi.
                    // ============================================================
                    $heroStats = $heroStats ?? [
                        ['icon' => 'fa-water',          'num' => '2',   'unit' => null, 'label' => 'Lintasan'],
                        ['icon' => 'fa-ruler-combined',  'num' => '50',  'unit' => 'm',  'label' => 'Panjang Kolam Utama'],
                        ['icon' => 'fa-certificate',     'num' => '3',   'unit' => null, 'label' => 'Pelatih Bersertifikat'],
                        ['icon' => 'fa-users',           'num' => '20+', 'unit' => null, 'label' => 'Atlet Aktif Berlatih'],
                    ];

                    $heroPhotos = $heroPhotos ?? [
                        ['photo_url' => 'https://picsum.photos/seed/nac-hero-1/700/560', 'alt' => 'Suasana latihan pagi di kolam', 'icon' => 'fa-water',     'caption' => 'Latihan Pagi'],
                        ['photo_url' => 'https://picsum.photos/seed/nac-hero-2/700/560', 'alt' => 'Sesi latihan teknik start',      'icon' => 'fa-stopwatch', 'caption' => 'Teknik Start'],
                        ['photo_url' => 'https://picsum.photos/seed/nac-hero-3/700/560', 'alt' => 'Suasana kejuaraan renang',        'icon' => 'fa-trophy',    'caption' => 'Hari Kejuaraan'],
                    ];

                    $heroSlideCount = 1 + count($heroPhotos); // 1 slide statistik + N slide foto
                @endphp

                <div class="nac-hero-slider">
                    <div id="heroStatsCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4500">
                        <div class="carousel-inner">

                            {{-- Slide 1: statistik --}}
                            <div class="carousel-item active">
                                <div class="nac-hero-carousel-slide nac-hero-carousel-slide--stats">
                                    @foreach($heroStats as $stat)
                                        <div class="nac-hero-stats__item">
                                            <i class="fa-solid {{ $stat['icon'] }}"></i>
                                            <div>
                                                <div class="nac-hero-stats__num">{{ $stat['num'] }}@if(!empty($stat['unit']))<span>{{ $stat['unit'] }}</span>@endif</div>
                                                <div class="nac-hero-stats__label">{{ $stat['label'] }}</div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Slide 2..N: foto --}}
                            @foreach($heroPhotos as $photo)
                                <div class="carousel-item">
                                    <div class="nac-hero-carousel-slide nac-hero-carousel-slide--photo @if(empty($photo['photo_url'])) is-empty @endif">
                                        @if(!empty($photo['photo_url']))
                                            <img src="{{ $photo['photo_url'] }}"
                                                 alt="{{ $photo['alt'] ?? '' }}"
                                                 loading="lazy"
                                                 onload="this.closest('.nac-hero-carousel-slide').classList.add('is-loaded')">
                                        @else
                                            <div class="nac-photo-placeholder">
                                                <i class="fa-solid fa-image"></i>
                                                <span>Foto belum tersedia</span>
                                            </div>
                                        @endif
                                        @if(!empty($photo['caption']))
                                            <span class="nac-hero-carousel-slide__caption">
                                                <i class="fa-solid {{ $photo['icon'] ?? 'fa-circle' }}"></i> {{ $photo['caption'] }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach

                        </div>

                        <div class="carousel-indicators">
                            @for($i = 0; $i < $heroSlideCount; $i++)
                                <button type="button" data-bs-target="#heroStatsCarousel" data-bs-slide-to="{{ $i }}"
                                        @if($i === 0) class="active" aria-current="true" @endif
                                        aria-label="Slide {{ $i + 1 }}"></button>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <svg class="nac-hero__wave" viewBox="0 0 1440 120" preserveAspectRatio="none" aria-hidden="true">
        <path d="M0,64 C240,120 480,0 720,32 C960,64 1200,120 1440,64 L1440,120 L0,120 Z"></path>
    </svg>
</section>

<div class="nac-divider" aria-hidden="true">
    <span class="nac-divider__line"></span>
    <span class="nac-divider__icon"><i class="fa-solid fa-water"></i></span>
    <span class="nac-divider__line"></span>
</div>

{{-- ============ TENTANG KAMI ============ --}}
<section class="nac-section" id="tentang">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6" data-aos="fade-right">
                <div class="nac-about-photo">
                    <img src="{{ $setting->about_photo_url ?? 'https://picsum.photos/seed/nac-about/700/560' }}"
                        alt="Suasana latihan di Nugroho Aquatic Center" loading="lazy">
                    <div class="nac-about-photo__badge">
                        <span>Sejak</span>
                        <strong>{{ $setting->since_year ?? '2010' }}</strong>
                    </div>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <span class="nac-eyebrow">Tentang Kami</span>
                <h2 class="nac-section__title">{{ $setting->about_title ?? 'Lebih dari sekadar tempat berenang.' }}</h2>
                <p class="nac-lead">
                    {{ $setting->about_description ?? 'Sejak berdiri, Nugroho Aquatic Center menjadi tempat lahirnya atlet renang dari tingkat daerah hingga nasional. Kami percaya setiap perenang — dari yang baru mengenal air hingga yang mengejar rekor pribadi — berhak mendapat bimbingan yang sama seriusnya.' }}
                </p>
                <ul class="nac-check-list">
                    <li><i class="fa-solid fa-certificate"></i> Pelatih bersertifikat nasional</li>
                    <li><i class="fa-solid fa-layer-group"></i> Kurikulum bertingkat: Junior, Senior, Swim Class A &amp; B</li>
                    <li><i class="fa-solid fa-water"></i> Kolam, 2 lintasan</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<div class="nac-divider" aria-hidden="true">
    <span class="nac-divider__line"></span>
    <span class="nac-divider__icon"><i class="fa-solid fa-image"></i></span>
    <span class="nac-divider__line"></span>
</div>

{{-- ============ GALERI ============ --}}
<section class="nac-section nac-gallery" id="galeri">
    <div class="container">
        <div class="nac-gallery__head" data-aos="fade-up">
            <div>
                <span class="nac-eyebrow">Galeri</span>
                <h2 class="nac-section__title">Momen di Nugroho Aquatic Center</h2>
            </div>
            <div class="nac-gallery__nav">
                <button type="button" class="nac-gallery__arrow" data-gallery-prev aria-label="Foto sebelumnya">
                    <i class="fa-solid fa-arrow-left"></i>
                </button>
                <button type="button" class="nac-gallery__arrow" data-gallery-next aria-label="Foto berikutnya">
                    <i class="fa-solid fa-arrow-right"></i>
                </button>
            </div>
        </div>

        @php
            // 🔧 DUMMY — ganti dengan data asli galeri dari controller (mis. $galleryItems).
            $galleryItems = $galleryItems ?? [
                ['photo_url' => 'https://picsum.photos/seed/nac-pool-1/640/800', 'alt' => 'Latihan di kolam utama',         'caption' => 'Latihan Pagi'],
                ['photo_url' => 'https://picsum.photos/seed/nac-pool-2/640/800', 'alt' => 'Sesi latihan teknik start',       'caption' => 'Teknik Start'],
                ['photo_url' => 'https://picsum.photos/seed/nac-pool-3/640/800', 'alt' => 'Suasana kejuaraan renang',        'caption' => 'Hari Kejuaraan'],
                ['photo_url' => 'https://picsum.photos/seed/nac-pool-4/640/800', 'alt' => 'Pelatih membimbing atlet junior', 'caption' => 'Bimbingan Pelatih'],
                ['photo_url' => 'https://picsum.photos/seed/nac-pool-5/640/800', 'alt' => 'Fasilitas kolam dari atas',       'caption' => 'Kolam Standar Kompetisi'],
                ['photo_url' => 'https://picsum.photos/seed/nac-pool-6/640/800', 'alt' => 'Sesi latihan fisik di gym',       'caption' => 'Fitness & Recovery'],
            ];
        @endphp

        <div class="nac-gallery__track" data-gallery-track data-aos="fade-up" data-aos-delay="100">
            @forelse($galleryItems as $item)
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
                <p class="text-center nac-muted">Galeri belum tersedia.</p>
            @endforelse
        </div>
    </div>
</section>

<div class="nac-divider" aria-hidden="true">
    <span class="nac-divider__line"></span>
    <span class="nac-divider__icon"><i class="fa-solid fa-person-swimming"></i></span>
    <span class="nac-divider__line"></span>
</div>

{{-- ============ FASILITAS ============ --}}
<section class="nac-section" id="fasilitas">
    <div class="container">
        <div class="nac-section__head" data-aos="fade-up">
            <span class="nac-eyebrow">Fasilitas</span>
            <h2 class="nac-section__title">Dirancang untuk performa, bukan sekadar kolam.</h2>
        </div>

        <div class="row g-4 mt-3">
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="0">
                <div class="nac-facility-card">
                    <div class="nac-facility-card__icon"><i class="bi bi-water"></i></div>
                    <h5>Kolam Standar Kompetisi</h5>
                    <p>2 lintasan sepanjang 50 meter dengan sistem sirkulasi air dan pencahayaan bawah air.</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="nac-facility-card">
                    <div class="nac-facility-card__icon"><i class="bi bi-stopwatch"></i></div>
                    <h5>Sistem Timing Elektronik</h5>
                    <p>Pencatatan waktu otomatis untuk latihan interval dan simulasi kejuaraan.</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="nac-facility-card">
                    <div class="nac-facility-card__icon"><i class="bi bi-heart-pulse"></i></div>
                    <h5>Food &amp; Drink</h5>
                    <p>Area bersantai untuk mengisi perut dan menghilangkan dahaga.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="nac-divider" aria-hidden="true">
    <span class="nac-divider__line"></span>
    <span class="nac-divider__icon"><i class="fa-solid fa-tags"></i></span>
    <span class="nac-divider__line"></span>
</div>

{{-- ============ BIAYA PENDAFTARAN ============ --}}
<section class="nac-section" id="biaya">
    <div class="container">
        <div class="nac-section__head" data-aos="fade-up">
            <span class="nac-eyebrow">Biaya Pendaftaran</span>
            <h2 class="nac-section__title">Pilih program sesuai levelmu.</h2>
        </div>

        <div class="row g-4 mt-3">
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="0">
                <div class="nac-price-card">
                    <h5>Junior</h5>
                    <p class="nac-price-card__desc">Usia 6–12 tahun, pengenalan teknik dasar renang.</p>
                    <div class="nac-price-card__price">Rp250<span>rb/bulan</span></div>
                    <ul class="nac-price-card__list">
                        <li><i class="fa-solid fa-check"></i> 2x latihan per minggu</li>
                        <li><i class="fa-solid fa-check"></i> Pengenalan teknik dasar</li>
                        <li><i class="fa-solid fa-check"></i> Pendampingan pelatih junior</li>
                    </ul>
                    <a href="https://wa.me/6282252019243?text=Halo%2C%20saya%20ingin%20mendaftar" target="_blank" rel="noopener" class="btn nac-btn nac-btn--outline-dark w-100">Daftar Sekarang</a>
                </div>
            </div>

            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="75">
                <div class="nac-price-card">
                    <h5>Senior</h5>
                    <p class="nac-price-card__desc">Usia 13–18 tahun, program menuju kompetisi.</p>
                    <div class="nac-price-card__price">Rp350<span>rb/bulan</span></div>
                    <ul class="nac-price-card__list">
                        <li><i class="fa-solid fa-check"></i> 3x latihan per minggu</li>
                        <li><i class="fa-solid fa-check"></i> Program persiapan kompetisi</li>
                        <li><i class="fa-solid fa-check"></i> Evaluasi performa bulanan</li>
                    </ul>
                    <a href="https://wa.me/6282252019243?text=Halo%2C%20saya%20ingin%20mendaftar" target="_blank" rel="noopener" class="btn nac-btn nac-btn--outline-dark w-100">Daftar Sekarang</a>
                </div>
            </div>

            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="150">
                <div class="nac-price-card nac-price-card--highlight">
                    <span class="nac-price-card__tag">Paling Diminati</span>
                    <h5>Swim Class A</h5>
                    <p class="nac-price-card__desc">Level lanjutan untuk mengejar performa kompetisi.</p>
                    <div class="nac-price-card__price">Rp450<span>rb/bulan</span></div>
                    <ul class="nac-price-card__list">
                        <li><i class="fa-solid fa-check"></i> Latihan intensif harian</li>
                        <li><i class="fa-solid fa-check"></i> Program menuju kejuaraan</li>
                        <li><i class="fa-solid fa-check"></i> Akses ruang fitness &amp; recovery</li>
                    </ul>
                    <a href="https://wa.me/6282252019243?text=Halo%2C%20saya%20ingin%20mendaftar" target="_blank" rel="noopener" class="btn nac-btn nac-btn--outline-dark w-100">Daftar Sekarang</a>
                </div>
            </div>

            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="225">
                <div class="nac-price-card">
                    <h5>Swim Class B</h5>
                    <p class="nac-price-card__desc">Level menengah, pembinaan teknik berkelanjutan.</p>
                    <div class="nac-price-card__price">Rp400<span>rb/bulan</span></div>
                    <ul class="nac-price-card__list">
                        <li><i class="fa-solid fa-check"></i> 4x latihan per minggu</li>
                        <li><i class="fa-solid fa-check"></i> Pembinaan teknik lanjutan</li>
                        <li><i class="fa-solid fa-check"></i> Evaluasi rutin</li>
                    </ul>
                    <a href="https://wa.me/6282252019243?text=Halo%2C%20saya%20ingin%20mendaftar" target="_blank" rel="noopener" class="btn nac-btn nac-btn--outline-dark w-100">Daftar Sekarang</a>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="nac-divider" aria-hidden="true">
    <span class="nac-divider__line"></span>
    <span class="nac-divider__icon"><i class="fa-solid fa-calendar-days"></i></span>
    <span class="nac-divider__line"></span>
</div>

{{-- ============ JADWAL ============ --}}
<section class="nac-section" id="jadwal">
    <div class="container">
        <div class="nac-section__head nac-fade-in">
            <span class="nac-eyebrow">Jadwal Latihan</span>
            <h2 class="nac-section__title">Atur waktu latihanmu.</h2>
            <p class="nac-lead">Pilih kategori sesuai levelmu, lalu catat hari dan jamnya.</p>
        </div>

        @php
            // Pemetaan ikon per kategori — cocokkan dengan nama kategori yang
            // kamu pakai di tabel schedules. Tidak ketemu? otomatis pakai fa-water.
            $scheduleIcon = function (string $category): string {
                $c = strtolower($category);
                return match(true) {
                    str_contains($c, 'junior')  => 'fa-child-reaching',
                    str_contains($c, 'senior')  => 'fa-person-swimming',
                    str_contains($c, 'class a') || str_contains($c, 'kelas a') => 'fa-medal',
                    str_contains($c, 'class b') || str_contains($c, 'kelas b') => 'fa-stopwatch',
                    default => 'fa-water',
                };
            };
        @endphp

        <div class="nac-schedule-table-wrap mt-4 nac-fade-in nac-fade-in--delay">
            <div class="table-responsive">
                <table class="nac-schedule-table mb-0">
                    <thead>
                        <tr>
                            <th>Kategori</th>
                            <th>Hari</th>
                            <th>Jam</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($schedules as $schedule)
                            @php
                                // Pecah "Senin, Rabu, Jumat" jadi badge per hari. Format
                                // rentang seperti "Senin - Jumat" sengaja tidak dipecah.
                                $days = array_values(array_filter(array_map('trim', preg_split('/[,\/]+/', $schedule->days_label))));
                            @endphp
                            <tr>
                                <td>
                                    <span class="nac-schedule-table__cat">
                                        <span class="nac-schedule-table__icon">
                                            <i class="fa-solid {{ $scheduleIcon($schedule->category) }}"></i>
                                        </span>
                                        {{ $schedule->category }}
                                    </span>
                                </td>
                                <td>
                                    <div class="nac-schedule-table__days">
                                        @foreach($days as $day)
                                            <span class="nac-schedule-table__day">{{ $day }}</span>
                                        @endforeach
                                    </div>
                                </td>
                                <td>
                                    <span class="nac-schedule-table__time">
                                        <i class="fa-regular fa-clock"></i> {{ $schedule->time_label }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-secondary py-4">
                                    Jadwal belum tersedia.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

@endsection