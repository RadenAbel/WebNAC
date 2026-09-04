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

    // Ringkasan medali/prestasi (tampil di kanan atas kartu)
    $medalStats = $member->medal_stats ?? [
        'gold'   => 8,
        'silver' => 5,
        'bronze' => 3,
    ];
    $medalMax   = max(1, max($medalStats));
    $medalTotal = array_sum($medalStats);

    // Tabel "Rekor Waktu Terbaik"
    $personalBests = $member->personal_bests ?? [
        ['event' => '50m Gaya Bebas',      'time' => '25.10',   'medal' => 'gold',   'pool_length' => '50m', 'age' => 17, 'competition' => 'Kejurnas Renang 2024', 'country_code' => 'id', 'country' => 'Indonesia', 'date' => '12/08/2024'],
        ['event' => '100m Gaya Bebas',     'time' => '54.32',   'medal' => null,     'pool_length' => '50m', 'age' => 17, 'competition' => 'Kejurnas Renang 2024', 'country_code' => 'id', 'country' => 'Indonesia', 'date' => '12/08/2024'],
        ['event' => '50m Gaya Punggung',   'time' => '27.85',   'medal' => 'silver', 'pool_length' => '25m', 'age' => 16, 'competition' => 'POPDA Jawa Timur 2023', 'country_code' => 'id', 'country' => 'Indonesia', 'date' => '05/03/2023'],
        ['event' => '100m Gaya Kupu-Kupu', 'time' => '59.40',   'medal' => 'bronze', 'pool_length' => '25m', 'age' => 16, 'competition' => 'POPDA Jawa Timur 2023', 'country_code' => 'id', 'country' => 'Indonesia', 'date' => '05/03/2023'],
        ['event' => '200m Gaya Ganti',     'time' => '2:12.67', 'medal' => null,     'pool_length' => '50m', 'age' => 15, 'competition' => 'Kejurda Jawa Timur 2022', 'country_code' => 'id', 'country' => 'Indonesia', 'date' => '20/11/2022'],
    ];

    $medalDotClass = [
        'gold'   => 'nac-medal-dot--gold',
        'silver' => 'nac-medal-dot--silver',
        'bronze' => 'nac-medal-dot--bronze',
    ];
@endphp

@section('title', $member->name . ' — ' . $roleLabel . ' Nugroho Aquatic Club')
@section('meta_description', 'Profil ' . $roleLabel . ' ' . $member->name . ' di Nugroho Aquatic Club.')

@section('content')

{{-- ============ TOPBAR (breadcrumb, tetap gelap sesuai brand) ============ --}}
<section class="nac-profile-topbar">
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
    </div>
</section>

{{-- ============ KARTU PROFIL (terang, gaya "athlete profile") ============ --}}
<section class="nac-profile-card-wrap">
    <div class="container">
        <div class="nac-profile-card" data-aos="fade-up">
            <span class="nac-profile-card__accent" aria-hidden="true"></span>

            <div class="nac-profile-card__top">
                <div class="nac-profile-card__info">
                    <span class="nac-eyebrow">{{ $roleLabel }} &middot; Nugroho Aquatic Club</span>
                    <h1 class="nac-profile-card__name">
                        {{ $firstName }}
                        @if($lastName)
                            <span>{{ $lastName }}</span>
                        @endif
                    </h1>

                    <div class="nac-profile-card__tags">
                        <div class="nac-profile-card__tag">
                            <span class="nac-profile-card__tag-label">Asal</span>
                            <span class="nac-profile-card__tag-value">
                                <span class="nac-country-badge__flag">ID</span> {{ $origin }}
                            </span>
                        </div>
                        <div class="nac-profile-card__tag">
                            <span class="nac-profile-card__tag-label">Spesialisasi</span>
                            <span class="nac-profile-card__tag-value">
                                <i class="fa-solid fa-water"></i> {{ $specialization }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="nac-profile-card__photo">
                    <div class="nac-profile-card__photo-frame @if(empty($member->photo_url)) is-empty @endif">
                        @if(!empty($member->photo_url))
                            <img src="{{ $member->photo_url }}"
                                 alt="Foto {{ $member->name }}"
                                 width="360" height="450"
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

                <div class="nac-profile-card__medals">
                    <span class="nac-medal-total-label">Total Prestasi &amp; Medali</span>
                    <span class="nac-medal-total-num">{{ $medalTotal }}</span>

                    <div class="nac-medal-bars">
                        <div class="nac-medal-bar nac-medal-bar--gold">
                            <span class="nac-medal-bar__count">{{ $medalStats['gold'] }}</span>
                            <span class="nac-medal-bar__fill">
                                <span style="height: {{ round(($medalStats['gold'] / $medalMax) * 100) }}%"></span>
                            </span>
                            <span class="nac-medal-bar__label">Emas</span>
                        </div>
                        <div class="nac-medal-bar nac-medal-bar--silver">
                            <span class="nac-medal-bar__count">{{ $medalStats['silver'] }}</span>
                            <span class="nac-medal-bar__fill">
                                <span style="height: {{ round(($medalStats['silver'] / $medalMax) * 100) }}%"></span>
                            </span>
                            <span class="nac-medal-bar__label">Perak</span>
                        </div>
                        <div class="nac-medal-bar nac-medal-bar--bronze">
                            <span class="nac-medal-bar__count">{{ $medalStats['bronze'] }}</span>
                            <span class="nac-medal-bar__fill">
                                <span style="height: {{ round(($medalStats['bronze'] / $medalMax) * 100) }}%"></span>
                            </span>
                            <span class="nac-medal-bar__label">Perunggu</span>
                        </div>
                    </div>
                </div>
            </div>

            <ul class="nav nac-profile-tabs" id="profileTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="tab-rekor-btn" data-bs-toggle="tab" data-bs-target="#tab-rekor" type="button" role="tab" aria-controls="tab-rekor" aria-selected="true">Rekor</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="tab-prestasi-btn" data-bs-toggle="tab" data-bs-target="#tab-prestasi" type="button" role="tab" aria-controls="tab-prestasi" aria-selected="false">Prestasi</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="tab-profil-btn" data-bs-toggle="tab" data-bs-target="#tab-profil" type="button" role="tab" aria-controls="tab-profil" aria-selected="false">Profil</button>
                </li>
            </ul>
        </div>
    </div>
</section>

{{-- ============ ISI TAB ============ --}}
<section class="nac-section nac-section--tint nac-profile-tabsection">
    <div class="container">
        <div class="tab-content" id="profileTabContent">

            {{-- ---------- TAB: REKOR WAKTU TERBAIK ---------- --}}
            <div class="tab-pane fade show active" id="tab-rekor" role="tabpanel" aria-labelledby="tab-rekor-btn">
                <h2 class="nac-section__title mb-4" data-aos="fade-up">Rekor Waktu Terbaik</h2>

                <div class="nac-rekor-table-wrap" data-aos="fade-up" data-aos-delay="80">
                    <table class="nac-rekor-table">
                        <thead>
                            <tr>
                                <th>Nomor</th>
                                <th>Waktu</th>
                                <th>Medali</th>
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
                                    <td>{{ $best['event'] }}</td>
                                    <td class="nac-rekor-table__time">{{ $best['time'] }}</td>
                                    <td>
                                        @if(!empty($best['medal']))
                                            <span class="nac-medal-dot {{ $medalDotClass[$best['medal']] ?? '' }}" title="{{ ucfirst($best['medal']) }}"></span>
                                        @else
                                            <span class="nac-rekor-table__dash">&ndash;</span>
                                        @endif
                                    </td>
                                    <td>{{ $best['pool_length'] }}</td>
                                    <td>{{ $best['age'] }}</td>
                                    <td>{{ $best['competition'] }}</td>
                                    <td>
                                        @if(!empty($best['country_code']))
                                            <span class="nac-country-badge" title="{{ $best['country'] }}">
                                                <span class="fi fi-{{ $best['country_code'] }} nac-flag-icon"></span> {{ $best['country'] }}
                                            </span>
                                        @else
                                            <span class="nac-rekor-table__dash">&ndash;</span>
                                        @endif
                                    </td>
                                    <td>{{ $best['date'] }}</td>
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
                        ['title' => 'Juara 1 Kejurnas Renang', 'year' => '2024', 'description' => null, 'country_code' => 'id', 'country' => 'Indonesia'],
                        ['title' => 'Juara 2 POPDA Jawa Timur', 'year' => '2023', 'description' => null, 'country_code' => 'id', 'country' => 'Indonesia'],
                        ['title' => 'Juara 3 Kejurda Jawa Timur', 'year' => '2022', 'description' => null, 'country_code' => 'id', 'country' => 'Indonesia'],
                        ['title' => 'Atlet Terbaik Klub', 'year' => '2022', 'description' => null, 'country_code' => null, 'country' => null],
                    ];
                @endphp

                <div class="nac-achievement-table-wrap" data-aos="fade-up">
                    <table class="nac-achievement-table">
                        <thead>
                            <tr>
                                <th style="width:56px;">No</th>
                                <th>Prestasi &amp; Penghargaan</th>
                                <th style="width:100px;">Tahun</th>
                                <th style="width:130px;">Negara</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($achievements as $i => $achievement)
                                @php
                                    $title       = is_array($achievement) ? ($achievement['title'] ?? '') : $achievement;
                                    $year        = is_array($achievement) ? ($achievement['year'] ?? null) : null;
                                    $desc        = is_array($achievement) ? ($achievement['description'] ?? null) : null;
                                    $countryCode = is_array($achievement) ? ($achievement['country_code'] ?? null) : null;
                                    $countryName = is_array($achievement) ? ($achievement['country'] ?? null) : null;
                                @endphp
                                <tr>
                                    <td class="nac-achievement-table__no">{{ $i + 1 }}</td>
                                    <td>
                                        <span class="nac-achievement-table__title">
                                            <span class="nac-achievement-table__icon"><i class="fa-solid fa-medal"></i></span>
                                            {{ $title }}
                                        </span>
                                    </td>
                                    <td class="nac-achievement-table__year">{{ $year ?? '–' }}</td>
                                    <td>
                                        @if($countryCode)
                                            <span class="nac-achievement-table__flag" title="{{ $countryName }}">
                                                <span class="fi fi-{{ $countryCode }} nac-flag-icon"></span> {{ $countryName }}
                                            </span>
                                        @else
                                            <span class="nac-rekor-table__dash">–</span>
                                        @endif
                                    </td>
                                    <td class="nac-achievement-table__desc">{{ $desc ?: '–' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- ---------- TAB: PROFIL ---------- --}}
            <div class="tab-pane fade" id="tab-profil" role="tabpanel" aria-labelledby="tab-profil-btn">
                <div class="row g-5">
                    <div class="col-lg-7" data-aos="fade-up">
                        <h2 class="nac-section__title mb-3">Mengenal {{ $member->name }}</h2>
                        <p class="nac-lead">
                            {{ $member->bio ?? ($member->name . ' bergabung bersama Nugroho Aquatic Club dan aktif berlatih serta berkompetisi di berbagai ajang renang tingkat daerah maupun nasional. Profil lengkap akan diperbarui secara berkala.') }}
                        </p>

                        @if(!empty($member->tagline))
                            <p class="nac-profile-card__tagline">&ldquo;{{ $member->tagline }}&rdquo;</p>
                        @endif
                    </div>

                    <div class="col-lg-5" data-aos="fade-up" data-aos-delay="80">
                        <div class="nac-profile-stats nac-profile-stats--light">
                            <div class="nac-profile-stats__item">
                                <i class="fa-solid fa-cake-candles"></i>
                                <div>
                                    <span class="nac-profile-stats__num">{{ $member->age ?? 17 }}</span>
                                    <span class="nac-profile-stats__label">Tahun</span>
                                </div>
                            </div>
                            <div class="nac-profile-stats__item">
                                <i class="fa-solid fa-medal"></i>
                                <div>
                                    <span class="nac-profile-stats__num nac-profile-stats__num--text">{{ $specialization }}</span>
                                    <span class="nac-profile-stats__label">Kategori</span>
                                </div>
                            </div>
                            <div class="nac-profile-stats__item">
                                <i class="fa-solid fa-timeline"></i>
                                <div>
                                    <span class="nac-profile-stats__num">{{ $member->experience_years ?? 4 }}+</span>
                                    <span class="nac-profile-stats__label">Tahun Pengalaman</span>
                                </div>
                            </div>
                        </div>

                        @if(!empty($member->phone) || !empty($member->instagram) || !empty($member->email))
                            <div class="nac-profile-actions nac-profile-actions--light">
                                @if(!empty($member->phone))
                                    <a href="https://wa.me/{{ preg_replace('/\D/', '', $member->phone) }}" target="_blank" rel="noopener" class="nac-btn nac-btn--primary">
                                        <i class="fa-brands fa-whatsapp"></i> Hubungi Saya
                                    </a>
                                @endif

                                @if(!empty($member->instagram) || !empty($member->email))
                                    <div class="nac-profile-social nac-profile-social--light">
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
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection