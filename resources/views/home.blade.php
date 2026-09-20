@extends('layouts.app')

@section('title', 'Nugroho Aquatic Club — Kolam Renang Premium')
@section('meta_description', 'Fasilitas renang premium di Surabaya dengan pelatih bersertifikat untuk atlet junior hingga senior.')

@section('content')

{{-- ============ HERO ============ --}}
<section class="nac-hero nac-hero--photo">
    @php
        // ============================================================
        // DUMMY / FALLBACK DATA — pola: $variable ?? [dummy].
        // Begitu controller mengirim $heroStats & $heroPhotos asli
        // (dari tabel schedules-stats & tabel sliders), blade ini
        // otomatis memakainya tanpa perlu diubah lagi.
        // ============================================================
        $heroStats = $heroStats ?? [
            ['icon' => 'fa-water',          'num' => '2',   'unit' => null, 'label' => 'Lintasan'],
            ['icon' => 'fa-ruler-combined',  'num' => '50',  'unit' => 'm',  'label' => 'Panjang Kolam Utama'],
            ['icon' => 'fa-certificate',     'num' => '3',   'unit' => null, 'label' => 'Pelatih Bersertifikat'],
            ['icon' => 'fa-users',           'num' => '20+', 'unit' => null, 'label' => 'Atlet Aktif Berlatih'],
        ];

        $heroPhotos = $heroPhotos ?? [
            ['photo_url' => 'https://picsum.photos/seed/nac-hero-1/1600/1000', 'alt' => 'Suasana latihan pagi di kolam'],
            ['photo_url' => 'https://picsum.photos/seed/nac-hero-2/1600/1000', 'alt' => 'Sesi latihan teknik start'],
            ['photo_url' => 'https://picsum.photos/seed/nac-hero-3/1600/1000', 'alt' => 'Suasana kejuaraan renang'],
        ];
    @endphp

    {{-- Background: foto ATAU video dari Slider (admin), bergantian otomatis
         kalau lebih dari 1 slide. Kalau belum ada slider sama sekali, otomatis
         fallback ke gradasi biru lama (lihat var(--nac-gradient-hero) di
         .nac-hero, tidak pernah tampil kosong). --}}
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
        {{-- Lapisan hitam transparan di atas foto/video — biar teks putih tetap
             kebaca di atas apa pun latar belakangnya. --}}
        <div class="nac-hero__overlay"></div>
    @endif

    <div class="container position-relative">
        <div class="row align-items-center min-vh-100 py-5 g-5">
            <div class="col-lg-7" data-aos="fade-up">
                <span class="nac-eyebrow">Nugroho Aquatic CLUB</span>
                <h1 class="nac-hero__title">
                    Setiap tarikan napas,<br>
                    setiap detik berarti.
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

            {{-- Statistik — dipindah ke kolom kanan (grid 2x2), bukan lagi
                 strip horizontal di bawah teks kiri. --}}
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

{{-- ============ TENTANG KAMI ============ --}}
<section class="nac-section nac-section--decorated nac-dot-pattern" id="tentang">
    <div class="container">
        <div class="nac-about-overlap" data-aos="fade-up">
            <div class="nac-about-overlap__photo">
                <img src="{{ $setting->about_photo_url ?? 'https://picsum.photos/seed/nac-about/900/700' }}"
                    alt="Suasana latihan di Nugroho Aquatic Club" loading="lazy">
                <div class="nac-about-photo__badge nac-about-overlap__badge">
                    <span>Sejak</span>
                    <strong>{{ $setting->since_year ?? '2010' }}</strong>
                </div>
            </div>

            <div class="nac-about-overlap__card">
                <span class="nac-eyebrow">Tentang Kami</span>
                <h2 class="nac-section__title">{{ $setting->about_title ?? 'Lebih dari sekadar tempat berenang.' }}</h2>
                <div class="nac-lead nac-lead--clamp-3">
                    {!! $setting->about_description ?? '<p>Sejak berdiri, Nugroho Aquatic Club menjadi tempat lahirnya atlet renang dari tingkat daerah hingga nasional. Kami percaya setiap perenang — dari yang baru mengenal air hingga yang mengejar rekor pribadi — berhak mendapat bimbingan yang sama seriusnya.</p>' !!}
                </div>
                <ul class="nac-check-list">
                    <li><i class="fa-solid fa-certificate"></i> Pelatih bersertifikat nasional</li>
                    <li><i class="fa-solid fa-layer-group"></i> Kurikulum bertingkat: Junior, Elite, Swim Class A &amp; B</li>
                    <li><i class="fa-solid fa-water"></i> Kolam, 2 lintasan</li>
                </ul>

                {{-- Ganti 'about.index' dengan nama route halaman detail "Tentang Kami" kamu --}}
                <a href="{{ route('about.index') }}" class="nac-btn nac-btn--outline-dark mt-2">
                    Selengkapnya Tentang Kami <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</section>

{{-- ============ GALERI ============ --}}
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
            // 🔧 DUMMY — ganti dengan data asli galeri dari controller ($galleryItems).
            $galleryItems = $galleryItems ?? [
                ['type' => 'photo', 'photo_url' => 'https://picsum.photos/seed/nac-pool-1/900/500', 'alt' => 'Latihan di kolam utama',         'caption' => 'Latihan Pagi'],
                ['type' => 'photo', 'photo_url' => 'https://picsum.photos/seed/nac-pool-2/700/500', 'alt' => 'Sesi latihan teknik start',       'caption' => 'Teknik Start'],
                ['type' => 'photo', 'photo_url' => 'https://picsum.photos/seed/nac-pool-3/700/500', 'alt' => 'Suasana kejuaraan renang',        'caption' => 'Hari Kejuaraan'],
                ['type' => 'photo', 'photo_url' => 'https://picsum.photos/seed/nac-pool-4/700/500', 'alt' => 'Pelatih membimbing atlet junior', 'caption' => 'Bimbingan Pelatih'],
                ['type' => 'photo', 'photo_url' => 'https://picsum.photos/seed/nac-pool-5/700/500', 'alt' => 'Fasilitas kolam dari atas',       'caption' => 'Kolam Standar Kompetisi'],
                ['type' => 'photo', 'photo_url' => 'https://picsum.photos/seed/nac-pool-6/700/500', 'alt' => 'Sesi latihan fisik di gym',       'caption' => 'Fitness & Recovery'],
            ];

            // Item pertama tampil statis (besar, tidak ikut geser) — ini yang
            // bisa dipilih admin jadi foto ATAU video. Sisanya yang masuk
            // slider kecil di sebelahnya (selalu tampil sebagai thumbnail foto,
            // walau type-nya video — cukup pratinjau, tidak perlu diputar di situ).
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

{{-- ============ BIAYA PENDAFTARAN ============ --}}
<section class="nac-section nac-section--decorated nac-dot-pattern" id="biaya">
    <div class="container">
        <div class="nac-section__head" data-aos="fade-up">
            <span class="nac-eyebrow">Biaya Pendaftaran</span>
            <h2 class="nac-section__title">Pilih program sesuai levelmu.</h2>
        </div>

        <div class="row g-4 mt-3 justify-content-center">
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="0">
                <div class="nac-price-card nac-price-card--highlight">
                    <span class="nac-price-card__tag">Paling Diminati</span>
                    <h5>Novato</h5>
                    <p class="nac-price-card__desc">Level pemula yang baru ingin belajar renang.</p>
                    <div class="nac-price-card__price">Rp460.000<span>/bulan</span></div>
                    <ul class="nac-price-card__list">
                        <li><i class="fa-solid fa-check"></i> 2x latihan per minggu</li>
                        <li><i class="fa-solid fa-check"></i> Pengenalan teknik dasar</li>
                        <li><i class="fa-solid fa-check"></i> Pendampingan pelatih junior</li>
                    </ul>
                    <a href="{{ route('join.create', ['category' => 'Swim School A1 - Pemula']) }}" class="btn nac-btn nac-btn--outline-dark w-100">Daftar Sekarang</a>
                </div>
            </div>

            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="75">
                <div class="nac-price-card">
                    <h5>Avance</h5>
                    <p class="nac-price-card__desc">Level menengah, pembinaan teknik berkelanjutan.</p>
                    <div class="nac-price-card__price">Rp540.000<span>/bulan</span></div>
                    <ul class="nac-price-card__list">
                        <li><i class="fa-solid fa-check"></i> 4x latihan per minggu</li>
                        <li><i class="fa-solid fa-check"></i> Pembinaan teknik lanjutan</li>
                        <li><i class="fa-solid fa-check"></i> Evaluasi rutin</li>
                    </ul>
                    <a href="{{ route('join.create', ['category' => 'Swim School B1 - Intermediate']) }}" class="btn nac-btn nac-btn--outline-dark w-100">Daftar Sekarang</a>
                </div>
            </div>

            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="150">
                <div class="nac-price-card">
                    <h5>Campeón</h5>
                    <p class="nac-price-card__desc">Calon atlet yang sudah siap untuk berkompetisi.</p>
                    <div class="nac-price-card__price">Rp600.000<span>/bulan</span></div>
                    <ul class="nac-price-card__list">
                        <li><i class="fa-solid fa-check"></i> Latihan intensif harian</li>
                        <li><i class="fa-solid fa-check"></i> Program menuju kejuaraan</li>
                        <li><i class="fa-solid fa-check"></i> Akses ruang fitness &amp; recovery</li>
                    </ul>
                    <a href="{{ route('join.create', ['category' => 'NAC Elite']) }}" class="btn nac-btn nac-btn--outline-dark w-100">Daftar Sekarang</a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============ JADWAL ============ --}}
<section class="nac-section nac-section--photo-bg" id="jadwal" style="background-image: linear-gradient(180deg, rgba(10, 14, 20, 0.82), rgba(10, 14, 20, 0.88)), url('{{ $setting->classes_section_photo_url ?? 'https://picsum.photos/seed/nac-classes-bg/1920/1080' }}');">
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
                                <td data-label="Kategori">
                                    <span class="nac-schedule-table__cat">
                                        <span class="nac-schedule-table__icon">
                                            <i class="fa-solid {{ $scheduleIcon($schedule->category) }}"></i>
                                        </span>
                                        {{ $schedule->category }}
                                    </span>
                                </td>
                                <td data-label="Hari">
                                    <div class="nac-schedule-table__days">
                                        @foreach($days as $day)
                                            <span class="nac-schedule-table__day">{{ $day }}</span>
                                        @endforeach
                                    </div>
                                </td>
                                <td data-label="Jam">
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