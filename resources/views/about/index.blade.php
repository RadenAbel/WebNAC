@extends('layouts.app')

@section('title', 'Tentang Kami — Nugroho Aquatic Club, Klub Renang Sangatta')
@section('meta_description', 'Profil Nugroho Aquatic Club: klub renang di Sangatta Utara, Kutai Timur, berlatih di Everglade Aquatic Center. Kenali kelas NAC Swim School dan tim kami.')

@section('content')

<section class="nac-page-header nac-page-header--photo"
    @if($setting->about_photo_url) style="background-image: url('{{ $setting->about_photo_url }}');"@endif>
    <div class="container text-center" data-aos="fade-up">
        <h1 class="nac-page-header__title">Lebih dari sekadar tempat berenang.</h1>
        <p class="nac-page-header__desc">
            Kenali lebih dekat profil, fasilitas, dan program latihan di Nugroho Aquatic Club.
        </p>
    </div>
</section>

<section class="nac-section nac-section--decorated nac-section--tint" id="profil">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6" data-aos="fade-right">
                <span class="nac-eyebrow">Profil Kami</span>
                <h2 class="nac-section__title">{{ $setting->about_title }}</h2>
                <p class="nac-lead">
                    {!! $setting->about_description !!}
                </p>
                <ul class="nac-check-list">
                    <li><i class="fa-solid fa-certificate"></i> Pelatih bersertifikat nasional</li>
                    <li><i class="fa-solid fa-layer-group"></i> Kurikulum bertingkat: Novato, Avance, Campeo'n</li>
                    <li><i class="fa-solid fa-water"></i> Kolam, 2 lintasan</li>
                </ul>
            </div>

            <div class="col-lg-6" data-aos="fade-left" data-aos-delay="100">
                <div class="nac-about-stats">
                    @foreach($aboutStats as $stat)
                        <div class="nac-about-stats__item">
                            <span class="nac-about-stats__icon"><i class="fa-solid {{ $stat['icon'] ?? 'fa-chart-simple' }}"></i></span>
                            <span class="nac-about-stats__num" data-counter="{{ $stat['num'] }}">0</span>
                            <span class="nac-about-stats__label">{{ $stat['label'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

<section class="nac-section">
    <div class="container">
        <div class="nac-pool-highlight" data-aos="fade-up"
            style="background-image: linear-gradient(90deg, rgba(10, 14, 20, 0.85) 0%, rgba(10, 14, 20, 0.6) 45%, rgba(10, 14, 20, 0.25) 100%)@if($setting->pool_section_photo_url), url('{{ $setting->pool_section_photo_url }}')@endif;">
            <div class="nac-pool-highlight__content">
                <h2 class="nac-pool-highlight__title">{{ $setting->pool_section_title }}</h2>
                <p class="nac-pool-highlight__desc">
                    {{ $setting->pool_section_description }}
                </p>
            </div>
            <span class="nac-pool-highlight__caption">Foto: Everglade Aquatic Center</span>
        </div>
    </div>
</section>

@if ($facilities->isNotEmpty())
<section class="nac-section nac-section--decorated nac-section--tint" id="fasilitas">
    <div class="container">
        <div class="nac-section__head" data-aos="fade-up">
            <span class="nac-eyebrow">Fasilitas</span>
            <h2 class="nac-section__title">Fasilitas unggulan</h2>
        </div>

        <div class="nac-facility-showcase mt-4" data-facility-showcase data-aos="fade-up">
            <div class="nac-facility-showcase__list" role="tablist" aria-label="Daftar fasilitas">
                @foreach ($facilities as $i => $facility)
                    <button type="button"
                        class="nac-facility-showcase__tab {{ $i === 0 ? 'is-active' : '' }}"
                        role="tab"
                        id="facility-tab-{{ $facility->id }}"
                        aria-controls="facility-panel-{{ $facility->id }}"
                        aria-selected="{{ $i === 0 ? 'true' : 'false' }}"
                        data-facility-tab="{{ $i }}">
                        <span class="nac-facility-showcase__thumb">
                            @if ($facility->photo_url)
                                <img src="{{ $facility->photo_url }}" alt="" loading="lazy">
                            @else
                                <i class="fa-solid fa-image"></i>
                            @endif
                        </span>
                        <span class="nac-facility-showcase__tab-name">{{ $facility->name }}</span>
                    </button>
                @endforeach
            </div>

            <div class="nac-facility-showcase__stage">
                @foreach ($facilities as $i => $facility)
                    <div class="nac-facility-showcase__panel {{ $i === 0 ? 'is-active' : '' }}"
                        role="tabpanel"
                        id="facility-panel-{{ $facility->id }}"
                        aria-labelledby="facility-tab-{{ $facility->id }}"
                        data-facility-panel="{{ $i }}"
                        @if ($i !== 0) hidden @endif>
                        <div class="nac-facility-showcase__photo">
                            @if ($facility->photo_url)
                                <img src="{{ $facility->photo_url }}" alt="{{ $facility->name }} — Nugroho Aquatic Club" loading="lazy">
                            @else
                                <div class="nac-facility-showcase__photo-empty">
                                    <i class="fa-solid fa-image"></i>
                                    <span>Foto belum tersedia</span>
                                </div>
                            @endif
                        </div>

                        <div class="nac-facility-showcase__info">
                            <h3 class="nac-facility-showcase__name">{{ $facility->name }}</h3>
                            @if ($facility->description)
                                <p class="nac-facility-showcase__desc">{!! nl2br(e($facility->description)) !!}</p>
                            @endif
                            @if (count($facility->highlight_items))
                                <ul class="nac-facility-showcase__points">
                                    @foreach ($facility->highlight_items as $point)
                                        <li>
                                            <span class="nac-facility-showcase__point-icon"><i class="{{ $point['icon'] }}"></i></span>
                                            <div>
                                                @if ($point['title'] !== '')
                                                    <h4 class="nac-facility-showcase__point-title">{{ $point['title'] }}</h4>
                                                @endif
                                                @if ($point['text'])
                                                    <p class="nac-facility-showcase__point-text">{{ $point['text'] }}</p>
                                                @endif
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif

@if($managementTeam->isNotEmpty())
<section class="nac-section nac-mgmt-section" id="manajemen">
    <div class="container">
        <div class="nac-section__head" data-aos="fade-up">
            <span class="nac-eyebrow">Tim Manajemen</span>
            <h2 class="nac-section__title">Leadership Teams</h2>
        </div>

        <div class="nac-board" data-board>
            @foreach($managementTeam as $i => $member)
                @php
                    $boardId = \Illuminate\Support\Str::slug($member['name']) ?: 'anggota-' . $i;
                @endphp

                <article class="nac-board-card" id="{{ $boardId }}" data-aos="fade-up" data-aos-delay="{{ ($i % 4) * 70 }}">
                    <div class="nac-board-card__photo">
                        @if (!empty($member['photo_url']))
                            <img src="{{ $member['photo_url'] }}" alt="{{ $member['name'] }}" loading="lazy">
                        @else
                            <span class="nac-board-photo-empty"><i class="fa-solid fa-user"></i></span>
                        @endif
                    </div>
                    <h3 class="nac-board-card__name">{{ $member['name'] }}</h3>
                    <p class="nac-board-card__position">{{ $member['position'] }}</p>
                    <button type="button" class="nac-board-card__more" data-board-open="{{ $boardId }}"
                        aria-controls="board-drawer-{{ $boardId }}" aria-expanded="false">
                        Selengkapnya
                    </button>
                </article>

                <div class="nac-board-drawer" id="board-drawer-{{ $boardId }}" data-board-drawer="{{ $boardId }}"
                    role="dialog" aria-modal="true" aria-labelledby="board-name-{{ $boardId }}" hidden>
                    <div class="nac-board-drawer__head">
                        <div class="nac-board-drawer__photo">
                            @if (!empty($member['photo_url']))
                                <img src="{{ $member['photo_url'] }}" alt="{{ $member['name'] }}" loading="lazy">
                            @else
                                <span class="nac-board-photo-empty"><i class="fa-solid fa-user"></i></span>
                            @endif
                        </div>
                        <div class="nac-board-drawer__heading">
                            <h3 class="nac-board-drawer__name" id="board-name-{{ $boardId }}">{{ $member['name'] }}</h3>
                            <p class="nac-board-drawer__position">{{ $member['position'] }}</p>
                        </div>
                        <button type="button" class="nac-board-drawer__close" data-board-close aria-label="Tutup">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                    <div class="nac-board-drawer__bio">
                        @if (!empty($member['full_bio']))
                            {!! $member['full_bio'] !!}
                        @elseif (!empty($member['short_bio']))
                            <p>{{ $member['short_bio'] }}</p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
        <div class="nac-board-backdrop" data-board-backdrop hidden></div>
    </div>
</section>
@endif

<section class="nac-section nac-about-classes-section nac-section--photo-bg" id="kelas"
    style="background-image: linear-gradient(180deg, rgba(10, 14, 20, 0.82), rgba(10, 14, 20, 0.88))@if($setting->classes_section_photo_url), url('{{ $setting->classes_section_photo_url }}')@endif;">
    <div class="container">
        <div class="nac-classes-stack">
            <div class="nac-classes-stack__intro" data-aos="fade-up">
                <span class="nac-eyebrow">Kelas NAC Swim School</span>
                <h2 class="nac-join-info__title">Kelas Apa Aja Sih yang Ada di Nugroho Swim School?</h2>
                <p class="nac-join-info__lead">
                    Nugroho Aquatic Club Swimming School — atau yang dapat disingkat <strong>NAC Swim School</strong> — adalah sekolah renang yang berlokasi di Kecamatan Sangatta Utara, Kutai Timur, dengan tempat latihan di Everglade Aquatic Center. NAC Swim School memiliki beberapa kelas yang tersedia:
                </p>
            </div>

            @php
                $nacClasses = [
                    ['badge' => 'Novato',  'title' => 'Untuk Pemula',
                     'desc'  => 'Dikhususkan bagi yang belum pernah belajar renang atau baru mengenal air. Fokus pada pengenalan teknik dasar dan keamanan di kolam.'],
                    ['badge' => 'Avance',  'title' => 'Tingkat Lanjutan',
                     'desc'  => 'Bagi murid dari Novato atau calon murid yang sudah menguasai 1-2 gaya renang. Fokus mengasah kemampuan lebih lanjut sebagai persiapan masuk klub.'],
                    ['badge' => 'Campeón', 'title' => 'Menuju Atlet',
                     'desc'  => 'Bagi murid dari Avance atau calon murid yang sudah menguasai beberapa gaya renang. Pada tingkat ini, murid mulai dilatih menjadi atlet kompetisi.'],
                ];
            @endphp

            <div class="nac-classes-stack__cards">
                @foreach ($nacClasses as $i => $class)
                    <article class="nac-classes-stack__card" style="--stack-index: {{ $i }};">
                        <div class="nac-classes-stack__card-head">
                            <span class="nac-classes-stack__step">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                            <span class="nac-join-class__badge">{{ $class['badge'] }}</span>
                        </div>
                        <h3 class="nac-classes-stack__title">{{ $class['title'] }}</h3>
                        <p class="nac-classes-stack__desc">{{ $class['desc'] }}</p>
                    </article>
                @endforeach

                <article class="nac-classes-stack__card nac-classes-stack__card--notes" style="--stack-index: {{ count($nacClasses) }};">
                    <div class="nac-classes-stack__card-head">
                        <span class="nac-classes-stack__notes-icon"><i class="fa-solid fa-circle-exclamation"></i></span>
                        <h3 class="nac-classes-stack__title mb-0">Catatan Penting</h3>
                    </div>
                    <p class="nac-classes-stack__desc">Perlu diperhatikan bagi Bapak/Ibu yang akan mendaftarkan anaknya di NAC Swim School:</p>
                    <ul class="nac-classes-stack__notes">
                        <li>NAC saat ini belum bisa menerima murid anak luar biasa (ALS), hal ini karena keterbatasan baik dalam jumlah pelatih ataupun pengalaman dalam menangani murid ALS.</li>
                        <li>Cepat atau lambatnya murid dalam menguasai suatu gaya renang dipengaruhi oleh antusias dan fokus murid dalam latihan — pelatih tidak bisa menentukan dengan pasti waktu yang dibutuhkan untuk menguasai gaya renang. Semakin fokus dan antusias murid saat latihan, akan mempercepat penguasaan gaya renang.</li>
                        <li>Usia minimal murid adalah <strong>6 tahun</strong>.</li>
                    </ul>
                </article>
            </div>
        </div>
    </div>
</section>

<section class="nac-section nac-section--decorated nac-section--tint" id="biaya">
    <div class="container">
        <div class="nac-section__head" data-aos="fade-up">
            <span class="nac-eyebrow">Biaya Pendaftaran</span>
            <h2 class="nac-section__title">Pilih program sesuai levelmu</h2>
        </div>

        <div class="row g-0 mt-4 nac-price-text-row">
            @forelse ($pricingPlans as $i => $plan)
                <div class="col-lg-4 nac-price-text-col" data-aos="fade-up" data-aos-delay="{{ $i * 75 }}">
                    <div class="nac-price-text">
                        @if($plan->is_highlighted)
                            <span class="nac-price-text__tag"><i class="fa-solid fa-star"></i> Paling Diminati</span>
                        @endif
                        <h5>{{ $plan->title }}</h5>
                        @if($plan->description)
                            <p class="nac-price-card__desc">{{ $plan->description }}</p>
                        @endif

                        @if($plan->has_discount)
                            <div class="nac-price-card__price-row">
                                <span class="nac-price-card__price-old">{{ $plan->price_label }}</span>
                                <span class="nac-price-card__discount-badge">-{{ $plan->discount_percent }}%</span>
                            </div>
                            <div class="nac-price-card__price">{{ $plan->discounted_price_label }}<span>/bulan</span></div>
                        @else
                            <div class="nac-price-card__price">{{ $plan->price_label }}<span>/bulan</span></div>
                        @endif

                        @if(count($plan->feature_list))
                            <ul class="nac-price-card__list">
                                @foreach($plan->feature_list as $feature)
                                    <li><i class="fa-solid fa-check"></i> {{ $feature }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            @empty
                <p class="text-center nac-muted">Belum ada paket harga yang ditampilkan.</p>
            @endforelse
        </div>
    </div>
</section>

<section class="nac-section nac-section--photo-bg nac-section--static-bg" id="jadwal" style="background-image: linear-gradient(180deg, rgba(10, 14, 20, 0.82), rgba(10, 14, 20, 0.88))@if($setting->pool_section_photo_url), url('{{ $setting->pool_section_photo_url }}')@endif;">
    <div class="container">
        <div class="nac-section__head nac-fade-in">
            <span class="nac-eyebrow">Jadwal Latihan</span>
            <h2 class="nac-section__title">Atur waktu latihanmu</h2>
            <p class="nac-lead">Pilih kategori sesuai levelmu, lalu catat hari dan jamnya</p>
        </div>

        @php
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
