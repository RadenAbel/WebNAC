@extends('layouts.app')

@section('title', 'Tentang Kami — Nugroho Aquatic Club')
@section('meta_description', 'Kenali lebih dekat Nugroho Aquatic Club: profil klub, fasilitas kolam, dan kelas-kelas NAC Swim School.')

@section('content')

{{-- ============ HEADER HALAMAN ============ --}}
<section class="nac-page-header">
    <div class="container text-center" data-aos="fade-up">
        <span class="nac-page-header__icon"><i class="fa-solid fa-water"></i></span>
        <span class="nac-eyebrow">Tentang Kami</span>
        <h1 class="nac-page-header__title">Lebih dari sekadar tempat berenang.</h1>
        <p class="nac-page-header__desc">
            Kenali lebih dekat profil, fasilitas, dan program latihan di Nugroho Aquatic Club.
        </p>
    </div>
</section>

{{-- ============ PROFIL KLUB ============ --}}
<section class="nac-section" id="profil">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6" data-aos="fade-right">
                <div class="nac-about-photo">
                    <img src="{{ $setting->about_photo_url ?? 'https://picsum.photos/seed/nac-about/700/560' }}"
                        alt="Suasana latihan di Nugroho Aquatic Club" loading="lazy">
                    <div class="nac-about-photo__badge">
                        <span>Sejak</span>
                        <strong>{{ $setting->since_year ?? '2010' }}</strong>
                    </div>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <span class="nac-eyebrow">Profil Kami</span>
                <h2 class="nac-section__title">{{ $setting->about_title ?? 'Lebih dari sekadar tempat berenang.' }}</h2>
                <p class="nac-lead">
                    {{ $setting->about_description ?? 'Sejak berdiri, Nugroho Aquatic Club menjadi tempat lahirnya atlet renang dari tingkat daerah hingga nasional. Kami percaya setiap perenang — dari yang baru mengenal air hingga yang mengejar rekor pribadi — berhak mendapat bimbingan yang sama seriusnya.' }}
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
    <span class="nac-divider__icon"><i class="fa-solid fa-person-swimming"></i></span>
    <span class="nac-divider__line"></span>
</div>

{{-- ============ FASILITAS ============ --}}
<section class="nac-section nac-section--tint" id="fasilitas">
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
    <span class="nac-divider__icon"><i class="fa-solid fa-layer-group"></i></span>
    <span class="nac-divider__line"></span>
</div>

{{-- ============ KELAS & CATATAN NAC SWIM SCHOOL (dipindah dari Join Us) ============ --}}
<section class="nac-section nac-about-classes-section" id="kelas">
    <div class="container">
        <div class="nac-join-info" data-aos="fade-up">
            <span class="nac-eyebrow">Kelas NAC Swim School</span>
            <h2 class="nac-join-info__title">Kelas Apa Aja Sih yang Ada di Nugroho Swim School?</h2>
            <p class="nac-join-info__lead">
                Nugroho Aquatic Club Swimming School — atau yang dapat disingkat <strong>NAC Swim School</strong> —
                adalah sekolah renang yang berlokasi di Kecamatan Sangatta Utara, Kutai Timur, dengan tempat
                latihan di Everglade Aquatic Center. NAC Swim School memiliki beberapa kelas yang tersedia:
            </p>

            <div class="nac-join-classes">
                <div class="nac-join-class">
                    <span class="nac-join-class__badge">Swim School A</span>
                    <h5>Untuk Pemula</h5>
                    <p>Dikhususkan bagi yang belum pernah belajar renang. Tersedia 2 kelas untuk pemula: A1 dan A2.</p>
                </div>
                <div class="nac-join-class">
                    <span class="nac-join-class__badge">Swim School B</span>
                    <h5>Tingkat Lanjutan</h5>
                    <p>Bagi murid dari Swim School A atau calon murid yang sudah menguasai 1-2 gaya renang. B1 untuk mengasah kemampuan lebih lanjut, B2 sebagai persiapan masuk klub.</p>
                </div>
                <div class="nac-join-class">
                    <span class="nac-join-class__badge">NAC Junior</span>
                    <h5>Menuju Atlet</h5>
                    <p>Bagi murid dari Swim School B atau calon murid yang sudah menguasai 3-4 gaya renang. Pada tingkat ini, murid mulai dilatih menjadi atlet.</p>
                </div>
                <div class="nac-join-class">
                    <span class="nac-join-class__badge">NAC Elite</span>
                    <h5>Tingkat Akhir</h5>
                    <p>Calon atlet yang kemampuannya sudah diasah di NAC Junior akan dinaikkan ke tingkat ini.</p>
                </div>
            </div>

            <div class="nac-join-notes">
                <h6><i class="fa-solid fa-circle-exclamation"></i> Catatan Penting</h6>
                <p class="nac-join-notes__intro">Perlu diperhatikan bagi Bapak/Ibu yang akan mendaftarkan anaknya di NAC Swim School:</p>
                <ul>
                    <li>NAC saat ini belum bisa menerima murid anak luar biasa (ALS), hal ini karena keterbatasan baik dalam jumlah pelatih ataupun pengalaman dalam menangani murid ALS.</li>
                    <li>Cepat atau lambatnya murid dalam menguasai suatu gaya renang dipengaruhi oleh antusias dan fokus murid dalam latihan — pelatih tidak bisa menentukan dengan pasti waktu yang dibutuhkan untuk menguasai gaya renang. Semakin fokus dan antusias murid saat latihan, akan mempercepat penguasaan gaya renang.</li>
                    <li>Usia minimal murid adalah <strong>6 tahun</strong>.</li>
                </ul>
            </div>
        </div>
    </div>
</section>

@endsection