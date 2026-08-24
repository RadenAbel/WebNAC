@extends('layouts.app')

@section('title', 'Nugroho Aquatic Center — Kolam Renang Premium')
@section('meta_description', 'Fasilitas renang premium di Surabaya dengan pelatih bersertifikat untuk atlet junior hingga senior.')

@section('content')

{{-- ============ HERO ============ --}}
<section class="nac-hero">
    <div class="container">
        <div class="row align-items-center min-vh-100 py-5 g-5">
            <div class="col-lg-7" data-aos="fade-up">
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

            <div class="col-lg-5" data-aos="fade-left" data-aos-delay="150">
                <div class="nac-hero-stats">
                    <div class="nac-hero-stats__item">
                        <i class="fa-solid fa-water"></i>
                        <div>
                            <div class="nac-hero-stats__num">8</div>
                            <div class="nac-hero-stats__label">Lintasan Kompetisi</div>
                        </div>
                    </div>
                    <div class="nac-hero-stats__item">
                        <i class="fa-solid fa-ruler-combined"></i>
                        <div>
                            <div class="nac-hero-stats__num">50<span>m</span></div>
                            <div class="nac-hero-stats__label">Panjang Kolam Utama</div>
                        </div>
                    </div>
                    <div class="nac-hero-stats__item">
                        <i class="fa-solid fa-certificate"></i>
                        <div>
                            <div class="nac-hero-stats__num">12+</div>
                            <div class="nac-hero-stats__label">Pelatih Bersertifikat</div>
                        </div>
                    </div>
                    <div class="nac-hero-stats__item">
                        <i class="fa-solid fa-users"></i>
                        <div>
                            <div class="nac-hero-stats__num">200+</div>
                            <div class="nac-hero-stats__label">Atlet Aktif Berlatih</div>
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
                    <img src="https://picsum.photos/seed/nac-about/700/560" alt="Suasana latihan di Nugroho Aquatic Center" loading="lazy">
                    <div class="nac-about-photo__badge">
                        <span>Sejak</span>
                        <strong>2010</strong>
                    </div>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <span class="nac-eyebrow">Tentang Kami</span>
                <h2 class="nac-section__title">Lebih dari sekadar tempat berenang.</h2>
                <p class="nac-lead">
                    Sejak 2010, Nugroho Aquatic Center menjadi tempat lahirnya atlet renang dari
                    tingkat daerah hingga nasional. Kami percaya setiap perenang — dari yang baru
                    mengenal air hingga yang mengejar rekor pribadi — berhak mendapat bimbingan
                    yang sama seriusnya.
                </p>
                <ul class="nac-check-list">
                    <li><i class="fa-solid fa-certificate"></i> Pelatih bersertifikat nasional</li>
                    <li><i class="fa-solid fa-layer-group"></i> Kurikulum bertingkat: Junior, Senior, Swim Class A &amp; B</li>
                    <li><i class="fa-solid fa-water"></i> Kolam standar kompetisi, 8 lintasan</li>
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

        {{-- Ganti src tiap gambar dengan foto asli kolam/atlet/pelatih Anda --}}
        <div class="nac-gallery__track" data-gallery-track data-aos="fade-up" data-aos-delay="100">
            <figure class="nac-gallery__item">
                <img src="https://picsum.photos/seed/nac-pool-1/640/800" alt="Latihan di kolam utama" loading="lazy">
                <figcaption>Latihan Pagi</figcaption>
            </figure>
            <figure class="nac-gallery__item">
                <img src="https://picsum.photos/seed/nac-pool-2/640/800" alt="Sesi latihan teknik start" loading="lazy">
                <figcaption>Teknik Start</figcaption>
            </figure>
            <figure class="nac-gallery__item">
                <img src="https://picsum.photos/seed/nac-pool-3/640/800" alt="Suasana kejuaraan renang" loading="lazy">
                <figcaption>Hari Kejuaraan</figcaption>
            </figure>
            <figure class="nac-gallery__item">
                <img src="https://picsum.photos/seed/nac-pool-4/640/800" alt="Pelatih membimbing atlet junior" loading="lazy">
                <figcaption>Bimbingan Pelatih</figcaption>
            </figure>
            <figure class="nac-gallery__item">
                <img src="https://picsum.photos/seed/nac-pool-5/640/800" alt="Fasilitas kolam dari atas" loading="lazy">
                <figcaption>Kolam Standar Kompetisi</figcaption>
            </figure>
            <figure class="nac-gallery__item">
                <img src="https://picsum.photos/seed/nac-pool-6/640/800" alt="Sesi latihan fisik di gym" loading="lazy">
                <figcaption>Fitness &amp; Recovery</figcaption>
            </figure>
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
                    <i class="bi bi-water"></i>
                    <h5>Kolam Standar Kompetisi</h5>
                    <p>8 lintasan sepanjang 50 meter dengan sistem sirkulasi air dan pencahayaan bawah air.</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="nac-facility-card">
                    <i class="bi bi-stopwatch"></i>
                    <h5>Sistem Timing Elektronik</h5>
                    <p>Pencatatan waktu otomatis untuk latihan interval dan simulasi kejuaraan.</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="nac-facility-card">
                    <i class="bi bi-heart-pulse"></i>
                    <h5>Ruang Fitness &amp; Recovery</h5>
                    <p>Area latihan kekuatan dan pemulihan otot khusus untuk atlet renang.</p>
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
                    <a href="#kontak" class="btn nac-btn nac-btn--outline-dark w-100">Daftar Sekarang</a>
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
                    <a href="#kontak" class="btn nac-btn nac-btn--outline-dark w-100">Daftar Sekarang</a>
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
                    <a href="#kontak" class="btn nac-btn nac-btn--primary w-100">Daftar Sekarang</a>
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
                    <a href="#kontak" class="btn nac-btn nac-btn--outline-dark w-100">Daftar Sekarang</a>
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
        <div class="nac-section__head" data-aos="fade-up">
            <span class="nac-eyebrow">Jadwal Latihan</span>
            <h2 class="nac-section__title">Atur waktu latihanmu.</h2>
        </div>

        <div class="table-responsive nac-schedule nac-schedule--light mt-4" data-aos="fade-up" data-aos-delay="100">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Kategori</th>
                        <th>Hari</th>
                        <th>Jam</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><span class="nac-schedule__cat">Junior</span></td>
                        <td>Selasa, Kamis</td>
                        <td>15.00 – 16.30</td>
                    </tr>
                    <tr>
                        <td><span class="nac-schedule__cat">Senior</span></td>
                        <td>Senin, Rabu, Jumat</td>
                        <td>16.00 – 18.00</td>
                    </tr>
                    <tr>
                        <td><span class="nac-schedule__cat">Swim Class A</span></td>
                        <td>Senin – Jumat</td>
                        <td>06.00 – 08.00</td>
                    </tr>
                    <tr>
                        <td><span class="nac-schedule__cat">Swim Class B</span></td>
                        <td>Sabtu, Minggu</td>
                        <td>07.00 – 09.00</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>

@endsection