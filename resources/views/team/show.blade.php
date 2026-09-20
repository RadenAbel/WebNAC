@extends('layouts.app')

@php
    $roleLabel = $member->role === 'pelatih' ? 'Pelatih' : 'Atlet';

    // Route halaman "Our Team" sesuai routes/web.php kamu.
    $teamUrl    = route('team.index');
    $sectionUrl = $teamUrl . ($member->role === 'pelatih' ? '#pelatih' : '#atlet');

    // ============================================================
    // DUMMY / FALLBACK DATA
    // ------------------------------------------------------------
    // Semua field di bawah pakai pola: $member->field ?? dummy.
    // Begitu kolomnya sudah tersedia di tabel/model (mis. lewat
    // migration & controller), blade ini otomatis pakai data asli
    // tanpa perlu diutak-atik lagi.
    // ============================================================

    // Nama dipecah supaya bisa ditampilkan gaya "Nama kecil / BELAKANG besar"
    $nameParts = preg_split('/\s+/', trim($member->name));
    $firstName = $nameParts[0] ?? $member->name;
    $lastName  = count($nameParts) > 1 ? implode(' ', array_slice($nameParts, 1)) : null;

    $origin         = $member->hometown ?? 'Surabaya, Jawa Timur';
    $specialization = $member->category ?? ($member->role === 'pelatih' ? 'Pelatih Kepala' : 'Gaya Bebas');

    // Tabel "Rekor Waktu Terbaik"
    $personalBests = $member->personal_bests ?? [
        ['event' => '50m Gaya Bebas',      'time' => '25.10',   'pool_length' => '50m', 'age' => 17, 'competition' => 'Kejurnas Renang 2024', 'country_code' => 'id', 'country' => 'Indonesia', 'date' => '12/08/2024'],
        ['event' => '100m Gaya Bebas',     'time' => '54.32',   'pool_length' => '50m', 'age' => 17, 'competition' => 'Kejurnas Renang 2024', 'country_code' => 'id', 'country' => 'Indonesia', 'date' => '12/08/2024'],
        ['event' => '50m Gaya Punggung',   'time' => '27.85',   'pool_length' => '25m', 'age' => 16, 'competition' => 'POPDA Jawa Timur 2023', 'country_code' => 'id', 'country' => 'Indonesia', 'date' => '05/03/2023'],
        ['event' => '100m Gaya Kupu-Kupu', 'time' => '59.40',   'pool_length' => '25m', 'age' => 16, 'competition' => 'POPDA Jawa Timur 2023', 'country_code' => 'id', 'country' => 'Indonesia', 'date' => '05/03/2023'],
        ['event' => '200m Gaya Ganti',     'time' => '2:12.67', 'pool_length' => '50m', 'age' => 15, 'competition' => 'Kejurda Jawa Timur 2022', 'country_code' => 'id', 'country' => 'Indonesia', 'date' => '20/11/2022'],
    ];
@endphp

@section('title', $member->name . ' — ' . $roleLabel . ' Nugroho Aquatic Club')
@section('meta_description', 'Profil ' . $roleLabel . ' ' . $member->name . ' di Nugroho Aquatic Club.')

@section('content')

{{-- ============ TOPBAR (breadcrumb, tetap gelap sesuai brand) ============ --}}
<section class="nac-profile-topbar">
    <div class="container">
        <!-- <nav class="nac-breadcrumb" aria-label="Breadcrumb" data-aos="fade-right">
            <a href="{{ url('/') }}">Beranda</a>
            <i class="fa-solid fa-chevron-right"></i>
            <a href="{{ $teamUrl }}">Our Team</a>
            <i class="fa-solid fa-chevron-right"></i>
            <a href="{{ $sectionUrl }}">{{ $roleLabel }}</a>
            <i class="fa-solid fa-chevron-right"></i>
            <span aria-current="page">{{ $member->name }}</span>
        </nav> -->
    </div>
</section>

{{-- ============ KARTU PROFIL (terang, gaya "athlete profile") ============ --}}
<section class="nac-profile-card-wrap">
    <div class="container">
        <div class="nac-profile-card nac-profile-card--v2" data-aos="fade-up">
            <span class="nac-profile-card__accent" aria-hidden="true"></span>

            <div class="nac-profile-card__row">
                @if(!empty($member->photo_url) && $member->photo_is_cutout)
                    {{-- Foto sudah background transparan (PNG cutout) — tampil "3D"
                         mengambang keluar dari batas kartu, tanpa bingkai kotak. --}}
                    <div class="nac-profile-card__photo-cutout">
                        <img src="{{ $member->photo_url }}"
                             alt="Foto {{ $member->name }}"
                             fetchpriority="high">
                    </div>
                @else
                    <div class="nac-profile-card__photo-side">
                        <div class="nac-profile-card__photo-side-frame @if(empty($member->photo_url)) is-empty @endif">
                            @if(!empty($member->photo_url))
                                <img src="{{ $member->photo_url }}"
                                     alt="Foto {{ $member->name }}"
                                     width="220" height="280"
                                     fetchpriority="high"
                                     onload="this.parentElement.classList.add('is-loaded')">
                            @else
                                <div class="nac-photo-placeholder">
                                    <i class="fa-solid fa-image"></i>
                                    <span>Foto belum tersedia</span>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                <div class="nac-profile-card__col">
                    <div class="nac-profile-detail-item">
                        <span class="nac-profile-detail-item__label">Nama {{ $roleLabel }}</span>
                        <span class="nac-profile-detail-item__value">{{ $member->name }}</span>
                    </div>
                    <div class="nac-profile-detail-item">
                        <span class="nac-profile-detail-item__label">Tempat, Tanggal Lahir</span>
                        <span class="nac-profile-detail-item__value">
                            {{ $member->birth_place ?? '-' }}{{ $member->birth_date_label ? ', ' . $member->birth_date_label : '' }}
                        </span>
                    </div>
                    <div class="nac-profile-detail-item-pair">
                        <div class="nac-profile-detail-item">
                            <span class="nac-profile-detail-item__label">Umur</span>
                            <span class="nac-profile-detail-item__value">{{ $member->age ? $member->age . ' Tahun' : '-' }}</span>
                        </div>
                        <div class="nac-profile-detail-item">
                            <span class="nac-profile-detail-item__label">Gender</span>
                            <span class="nac-profile-detail-item__value">{{ $member->gender ?? '-' }}</span>
                        </div>
                    </div>
                    @if($member->swim_style)
                        <div class="nac-profile-detail-item">
                            <span class="nac-profile-detail-item__label">Spesialis Gaya</span>
                            <div class="nac-profile-style-tags">
                                @foreach($member->swim_style_array as $style)
                                    <span class="nac-profile-style-tag">{{ $style }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if(!empty($member->bio))
                        <button type="button" class="btn nac-btn nac-btn--outline-dark nac-profile-desc-btn" data-bs-toggle="offcanvas" data-bs-target="#atletDescOffcanvas" aria-controls="atletDescOffcanvas">
                            <i class="fa-solid fa-circle-info"></i> Lihat Deskripsi {{ $roleLabel }}
                        </button>
                    @endif
                </div>

                <div class="nac-profile-card__col">
                    <div class="nac-profile-detail-item-pair">
                        <div class="nac-profile-detail-item">
                            <span class="nac-profile-detail-item__label">Tinggi Badan</span>
                            <span class="nac-profile-detail-item__value">{{ $member->height_cm ? $member->height_cm . ' cm' : '-' }}</span>
                        </div>
                        <div class="nac-profile-detail-item">
                            <span class="nac-profile-detail-item__label">Berat Badan</span>
                            <span class="nac-profile-detail-item__value">{{ $member->weight_kg ? $member->weight_kg . ' kg' : '-' }}</span>
                        </div>
                    </div>
                    <div class="nac-profile-detail-item">
                        <span class="nac-profile-detail-item__label">Tanggal Bergabung</span>
                        <span class="nac-profile-detail-item__value">{{ $member->join_date_label ?? '-' }}</span>
                    </div>
                    <div class="nac-profile-detail-item">
                        <span class="nac-profile-detail-item__label">Status di Klub</span>
                        <span class="nac-profile-detail-item__value">{{ $specialization }}</span>
                    </div>

                    @if(!empty($member->whatsapp) || !empty($member->instagram_url) || !empty($member->facebook_url) || !empty($member->tiktok_url) || !empty($member->email))
                        <div class="nac-profile-detail-item">
                            <span class="nac-profile-detail-item__label">Sosial Media Saya</span>
                            <div class="nac-profile-actions nac-profile-actions--light" style="margin-top: 0.4rem;">
                                @if(!empty($member->whatsapp))
                                    <a href="https://wa.me/{{ preg_replace('/\D/', '', $member->whatsapp) }}" target="_blank" rel="noopener" class="nac-profile-contact-btn" title="Hubungi via WhatsApp" aria-label="Hubungi {{ $member->name }} via WhatsApp">
                                        <i class="fa-brands fa-whatsapp"></i>
                                    </a>
                                @endif

                                @if(!empty($member->instagram_url) || !empty($member->facebook_url) || !empty($member->tiktok_url) || !empty($member->email))
                                    <div class="nac-profile-social nac-profile-social--light">
                                        @if(!empty($member->instagram_url))
                                            <a href="{{ $member->instagram_url }}" target="_blank" rel="noopener" aria-label="Instagram {{ $member->name }}">
                                                <i class="fa-brands fa-instagram"></i>
                                            </a>
                                        @endif
                                    @if(!empty($member->facebook_url))
                                        <a href="{{ $member->facebook_url }}" target="_blank" rel="noopener" aria-label="Facebook {{ $member->name }}">
                                            <i class="fa-brands fa-facebook-f"></i>
                                        </a>
                                    @endif
                                    @if(!empty($member->tiktok_url))
                                        <a href="{{ $member->tiktok_url }}" target="_blank" rel="noopener" aria-label="TikTok {{ $member->name }}">
                                            <i class="fa-brands fa-tiktok"></i>
                                        </a>
                                    @endif
                                    @if(!empty($member->email))
                                        <a href="mailto:{{ $member->email }}" aria-label="Email {{ $member->name }}">
                                            <i class="fa-solid fa-envelope"></i>
                                        </a>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
            </div>

            <ul class="nav nac-profile-tabs" id="profileTab" role="tablist">
                @if($member->role === 'atlet')
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="tab-rekor-btn" data-bs-toggle="tab" data-bs-target="#tab-rekor" type="button" role="tab" aria-controls="tab-rekor" aria-selected="true">Rekor</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="tab-prestasi-btn" data-bs-toggle="tab" data-bs-target="#tab-prestasi" type="button" role="tab" aria-controls="tab-prestasi" aria-selected="false">Prestasi</button>
                    </li>
                @else
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="tab-lisensi-btn" data-bs-toggle="tab" data-bs-target="#tab-lisensi" type="button" role="tab" aria-controls="tab-lisensi" aria-selected="true">Lisensi</button>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</section>

{{-- ============ PANEL GESER: DESKRIPSI ATLET/PELATIH (dari kiri layar) ============ --}}
<div class="offcanvas offcanvas-start nac-desc-offcanvas" tabindex="-1" id="atletDescOffcanvas" aria-labelledby="atletDescOffcanvasLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="atletDescOffcanvasLabel">Mengenal {{ $member->name }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Tutup"></button>
    </div>
    <div class="offcanvas-body">
        <p class="nac-lead">
            {{ $member->bio ?? ($member->name . ' bergabung bersama Nugroho Aquatic Club dan aktif berlatih serta berkompetisi di berbagai ajang renang tingkat daerah maupun nasional. Profil lengkap akan diperbarui secara berkala.') }}
        </p>
        @if(!empty($member->tagline))
            <p class="nac-profile-card__tagline">&ldquo;{{ $member->tagline }}&rdquo;</p>
        @endif
    </div>
</div>

{{-- ============ ISI TAB ============ --}}
<section class="nac-section nac-section--tint nac-profile-tabsection">
    <div class="container">
        <div class="tab-content" id="profileTabContent">

            @if($member->role === 'atlet')
            {{-- ---------- TAB: REKOR WAKTU TERBAIK ---------- --}}
            <div class="tab-pane fade show active" id="tab-rekor" role="tabpanel" aria-labelledby="tab-rekor-btn">
                <h2 class="nac-section__title mb-4" data-aos="fade-up">Rekor Waktu Terbaik</h2>

                <div class="nac-rekor-table-wrap" data-aos="fade-up" data-aos-delay="80">
                    <table class="nac-rekor-table">
                        <thead>
                            <tr>
                                <th>Nomor</th>
                                <th>Waktu</th>
                                <th>Panjang Kolam</th>
                                <th>Usia*</th>
                                <th>Kompetisi</th>
                                <th>Negara</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($personalBests as $best)
                                <tr>
                                    <td data-label="Nomor">{{ $best['event'] }}</td>
                                    <td data-label="Waktu" class="nac-rekor-table__time">{{ $best['time'] }}</td>
                                    <td data-label="Panjang Kolam">{{ $best['pool_length'] }}</td>
                                    <td data-label="Usia*">{{ $best['age'] }}</td>
                                    <td data-label="Kompetisi">{{ $best['competition'] }}</td>
                                    <td data-label="Negara">
                                        @if(!empty($best['country_code']))
                                            <span class="nac-country-badge" title="{{ $best['country'] }}">
                                                <span class="fi fi-{{ $best['country_code'] }} nac-flag-icon"></span> {{ $best['country'] }}
                                            </span>
                                        @else
                                            <span class="nac-rekor-table__dash">&ndash;</span>
                                        @endif
                                    </td>
                                    <td data-label="Tanggal">{{ $best['date'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <p class="nac-rekor-table__note">*Usia atlet pada saat kompetisi berlangsung.</p>
                </div>
            </div>

            {{-- ---------- TAB: PRESTASI ---------- --}}
            <div class="tab-pane fade" id="tab-prestasi" role="tabpanel" aria-labelledby="tab-prestasi-btn">
                <h2 class="nac-section__title mb-4" data-aos="fade-up">Pencapaian &amp; Penghargaan</h2>

                @php
                    $achievements = (!empty($member->achievements) && count($member->achievements)) ? $member->achievements : [
                        ['title' => 'Juara 1 Kejurnas Renang', 'year' => '2024', 'event_date' => null, 'description' => null, 'country_code' => 'id', 'country' => 'Indonesia'],
                        ['title' => 'Juara 2 POPDA Jawa Timur', 'year' => '2023', 'event_date' => null, 'description' => null, 'country_code' => 'id', 'country' => 'Indonesia'],
                        ['title' => 'Juara 3 Kejurda Jawa Timur', 'year' => '2022', 'event_date' => null, 'description' => null, 'country_code' => 'id', 'country' => 'Indonesia'],
                        ['title' => 'Atlet Terbaik Klub', 'year' => '2022', 'event_date' => null, 'description' => null, 'country_code' => null, 'country' => null],
                    ];
                @endphp

                <div class="nac-achievement-table-wrap" data-aos="fade-up">
                    <table class="nac-achievement-table">
                        <thead>
                            <tr>
                                <th style="width:56px;">No</th>
                                <th>Prestasi &amp; Penghargaan</th>
                                <th style="width:110px;">Tanggal</th>
                                <th style="width:130px;">Negara</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($achievements as $i => $achievement)
                                @php
                                    $title       = is_array($achievement) ? ($achievement['title'] ?? '') : $achievement;
                                    $year        = is_array($achievement) ? ($achievement['year'] ?? null) : null;
                                    $eventDate   = is_array($achievement) ? ($achievement['event_date'] ?? null) : null;
                                    $desc        = is_array($achievement) ? ($achievement['description'] ?? null) : null;
                                    $countryCode = is_array($achievement) ? ($achievement['country_code'] ?? null) : null;
                                    $countryName = is_array($achievement) ? ($achievement['country'] ?? null) : null;
                                @endphp
                                <tr>
                                    <td data-label="No" class="nac-achievement-table__no">{{ $i + 1 }}</td>
                                    <td data-label="Prestasi">
                                        <span class="nac-achievement-table__title">
                                            <span class="nac-achievement-table__icon"><i class="fa-solid fa-medal"></i></span>
                                            {{ $title }}
                                        </span>
                                    </td>
                                    <td data-label="Tanggal" class="nac-achievement-table__year">{{ $eventDate ?? $year ?? '–' }}</td>
                                    <td data-label="Negara">
                                        @if($countryCode)
                                            <span class="nac-achievement-table__flag" title="{{ $countryName }}">
                                                <span class="fi fi-{{ $countryCode }} nac-flag-icon"></span> {{ $countryName }}
                                            </span>
                                        @else
                                            <span class="nac-rekor-table__dash">–</span>
                                        @endif
                                    </td>
                                    <td data-label="Keterangan" class="nac-achievement-table__desc">{{ $desc ?: '–' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            @if($member->role === 'pelatih')
            {{-- ---------- TAB: LISENSI & SERTIFIKASI ---------- --}}
            <div class="tab-pane fade show active" id="tab-lisensi" role="tabpanel" aria-labelledby="tab-lisensi-btn">
                <h2 class="nac-section__title mb-4" data-aos="fade-up">Lisensi &amp; Sertifikasi</h2>

                @if($member->licenses->count())
                    <div class="nac-achievement-table-wrap" data-aos="fade-up">
                        <table class="nac-achievement-table">
                            <thead>
                                <tr>
                                    <th style="width:56px;">No</th>
                                    <th>Nama Lisensi</th>
                                    <th>Lembaga</th>
                                    <th>Nomor</th>
                                    <th style="width:110px;">Terbit</th>
                                    <th style="width:120px;">Berlaku Sampai</th>
                                    <th style="width:90px;">Sertifikat</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($member->licenses as $i => $license)
                                    <tr>
                                        <td data-label="No" class="nac-achievement-table__no">{{ $i + 1 }}</td>
                                        <td data-label="Nama Lisensi">
                                            <span class="nac-achievement-table__title">
                                                <span class="nac-achievement-table__icon"><i class="fa-solid fa-certificate"></i></span>
                                                {{ $license->title }}
                                                @if($license->is_expired)
                                                    <span class="badge bg-danger ms-1" style="font-size:0.62rem; vertical-align:middle;">Kedaluwarsa</span>
                                                @endif
                                            </span>
                                        </td>
                                        <td data-label="Lembaga">{{ $license->issuer ?? '–' }}</td>
                                        <td data-label="Nomor">{{ $license->license_number ?? '–' }}</td>
                                        <td data-label="Terbit" class="nac-achievement-table__year">{{ $license->issued_date_label ?? '–' }}</td>
                                        <td data-label="Berlaku Sampai" class="nac-achievement-table__year">{{ $license->expiry_date_label ?? '–' }}</td>
                                        <td data-label="Sertifikat">
                                            @if($license->certificate_url)
                                                <a href="{{ $license->certificate_url }}" target="_blank" rel="noopener" title="Lihat sertifikat">
                                                    <i class="fa-solid fa-file-arrow-down"></i>
                                                </a>
                                            @else
                                                <span class="nac-rekor-table__dash">–</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="nac-muted text-center py-5">Belum ada lisensi yang diinput untuk pelatih ini.</p>
                @endif
            </div>
            @endif

            {{-- ---------- TAB: PROFIL ---------- --}}
        </div>
    </div>
</section>

@endsection