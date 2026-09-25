@extends('layouts.app')

@section('title', 'Tentang Kami — Nugroho Aquatic Club, Klub Renang Sangatta')
@section('meta_description', 'Profil Nugroho Aquatic Club: klub renang di Sangatta Utara, Kutai Timur, berlatih di Everglade Aquatic Center. Kenali kelas NAC Swim School dan tim kami.')

@section('content')

{{-- ============ HEADER HALAMAN ============ --}}
<section class="nac-page-header nac-page-header--photo"
    style="background-image: url('{{ $setting->about_photo_url ?? 'https://picsum.photos/seed/nac-swim-header/1600/700' }}');">
    <div class="container text-center" data-aos="fade-up">
        <h1 class="nac-page-header__title">Lebih dari sekadar tempat berenang.</h1>
        <p class="nac-page-header__desc">
            Kenali lebih dekat profil, fasilitas, dan program latihan di Nugroho Aquatic Club.
        </p>
    </div>
</section>

{{-- ============ PROFIL KLUB ============ --}}
<section class="nac-section nac-section--decorated nac-dot-pattern" id="profil">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6" data-aos="fade-right">
                <span class="nac-eyebrow">Profil Kami</span>
                <h2 class="nac-section__title">{{ $setting->about_title ?? 'Lebih dari sekadar tempat berenang.' }}</h2>
                <p class="nac-lead">
                    {!! $setting->about_description ?? '<p>Sejak berdiri, Nugroho Aquatic Club menjadi tempat lahirnya atlet renang dari tingkat daerah hingga nasional. Kami percaya setiap perenang — dari yang baru mengenal air hingga yang mengejar rekor pribadi — berhak mendapat bimbingan yang sama seriusnya.</p>' !!}
                </p>
                <ul class="nac-check-list">
                    <li><i class="fa-solid fa-certificate"></i> Pelatih bersertifikat nasional</li>
                    <li><i class="fa-solid fa-layer-group"></i> Kurikulum bertingkat: Novato, Avance, Campeo'n</li>
                    <li><i class="fa-solid fa-water"></i> Kolam, 2 lintasan</li>
                </ul>
            </div>

            <div class="col-lg-6" data-aos="fade-left" data-aos-delay="100">
                @php
                    $aboutStats = $aboutStats ?? [
                        ['num' => 20, 'label' => 'Atlet Aktif', 'icon' => 'fa-person-swimming'],
                        ['num' => 5,  'label' => 'Pelatih Bersertifikat', 'icon' => 'fa-user-graduate'],
                        ['num' => 120, 'label' => 'Total Medali', 'icon' => 'fa-medal'],
                    ];
                @endphp
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

{{-- ============ KOLAM LATIHAN — EVERGLADE AQUATIC CENTER ============ --}}
<section class="nac-section">
    <div class="container">
        <div class="nac-pool-highlight" data-aos="fade-up"
            style="background-image: linear-gradient(90deg, rgba(10, 14, 20, 0.85) 0%, rgba(10, 14, 20, 0.6) 45%, rgba(10, 14, 20, 0.25) 100%), url('{{ $setting->pool_section_photo_url ?? 'https://picsum.photos/seed/nac-everglade-pool/1600/900' }}');">
            <div class="nac-pool-highlight__content">
                <h2 class="nac-pool-highlight__title">{{ $setting->pool_section_title ?? 'Berlatih di Everglade Aquatic Center' }}</h2>
                <p class="nac-pool-highlight__desc">
                    {{ $setting->pool_section_description ?? 'Nugroho Aquatic Club menjalankan seluruh program latihannya di Everglade Aquatic Center — fasilitas yang memiliki dua kolam renang untuk mendukung latihan dari tingkat pemula Swim School hingga persiapan atlet menuju kejuaraan. Detail ukuran dan kedalaman tiap kolam akan segera kami lengkapi.' }}
                </p>
            </div>
            <span class="nac-pool-highlight__caption">Foto: Everglade Aquatic Center</span>
        </div>
    </div>
</section>

{{-- ============ TIM MANAJEMEN ============ --}}
<section class="nac-section nac-mgmt-section nac-section--decorated nac-dot-pattern" id="manajemen">
    <div class="container">
        <div class="nac-section__head" data-aos="fade-up">
            <span class="nac-eyebrow">Tim Manajemen</span>
            <h2 class="nac-section__title">Board of Commissioners</h2>
        </div>

        @php
            $managementTeam = $managementTeam ?? [
                [
                    'name'      => 'Bambang Nugroho',
                    'position'  => 'Ketua Umum & Pendiri',
                    'photo_url' => 'https://picsum.photos/seed/nac-mgmt-1/500/620',
                    'short_bio' => 'Bambang Nugroho mendirikan Nugroho Aquatic Club pada 2010 dengan visi mencetak atlet renang berkelas nasional dari Kutai Timur.',
                    'full_bio'  => '<p>Bambang Nugroho lahir di Surabaya, 12 Mei 1975. Ia mendirikan Nugroho Aquatic Club pada tahun 2010, berawal dari satu kolam latihan kecil dengan 15 murid, hingga kini berkembang menjadi salah satu klub renang terkemuka di Kutai Timur.</p><p>Sebelum mendirikan NAC, Bambang merupakan mantan atlet renang nasional yang aktif berkompetisi di berbagai kejuaraan tingkat <strong>PON</strong> dan <strong>SEA Games</strong> pada era 1995-2003, dengan spesialisasi nomor gaya bebas dan gaya ganti.</p><p>Di bawah kepemimpinannya, NAC telah melahirkan lebih dari 50 atlet yang berkompetisi di tingkat provinsi dan nasional, serta menjalin kerja sama dengan berbagai sekolah dan instansi olahraga daerah.</p>',
                ],
                [
                    'name'      => 'Siti Rahmawati',
                    'position'  => 'Direktur Program Latihan',
                    'photo_url' => 'https://picsum.photos/seed/nac-mgmt-2/500/620',
                    'short_bio' => 'Siti mengepalai penyusunan kurikulum latihan NAC, dari kelas pemula Swim School hingga program atlet Elite.',
                    'full_bio'  => '<p>Siti Rahmawati bergabung dengan Nugroho Aquatic Club sejak 2013 sebagai pelatih kepala, sebelum dipercaya menjabat Direktur Program Latihan pada 2019. Ia memegang lisensi pelatih renang tingkat nasional dari <strong>PRSI</strong>.</p><p>Siti bertanggung jawab merancang kurikulum bertingkat NAC — mulai dari Swim School A &amp; B untuk pemula, hingga program intensif Junior dan Elite bagi calon atlet kompetisi.</p><p>Ia juga aktif menjadi pembicara pada berbagai pelatihan pelatih renang tingkat daerah dan terlibat dalam penyusunan standar keselamatan kolam renang untuk klub-klub di Kutai Timur.</p>',
                ],
                [
                    'name'      => 'Andi Wijaya',
                    'position'  => 'Manajer Operasional & Fasilitas',
                    'photo_url' => 'https://picsum.photos/seed/nac-mgmt-3/500/620',
                    'short_bio' => 'Andi memastikan fasilitas kolam, peralatan, dan operasional harian NAC berjalan sesuai standar kompetisi.',
                    'full_bio'  => '<p>Andi Wijaya menangani seluruh aspek operasional Nugroho Aquatic Club sejak 2016, termasuk perawatan kolam, sistem sirkulasi air, dan kelengkapan alat timing elektronik.</p><p>Berlatar belakang teknik mesin, Andi memastikan setiap fasilitas NAC memenuhi standar keselamatan dan kompetisi yang berlaku, termasuk kalibrasi rutin sistem pencatatan waktu otomatis.</p><p>Ia juga mengoordinasikan jadwal penggunaan kolam antara kelas Swim School, latihan atlet, dan acara/kejuaraan yang diselenggarakan di lokasi NAC.</p>',
                ],
            ];
        @endphp

        <div class="nac-mgmt-list mt-4">
            @foreach($managementTeam as $i => $member)
                <div class="nac-mgmt-card" data-aos="fade-up" data-aos-delay="{{ $i * 80 }}">
                    <div class="nac-mgmt-card__photo">
                        <img src="{{ $member['photo_url'] }}" alt="{{ $member['name'] }}" loading="lazy">
                    </div>
                    <div class="nac-mgmt-card__body">
                        <h3 class="nac-mgmt-card__name">{{ $member['name'] }}</h3>
                        <span class="nac-mgmt-card__position">{{ $member['position'] }}</span>
                        <p class="nac-mgmt-card__bio">{{ $member['short_bio'] }}</p>
                        <button type="button" class="nac-mgmt-card__more" data-bs-toggle="modal" data-bs-target="#mgmtModal{{ $i }}">
                            Learn more <i class="fa-solid fa-arrow-right"></i>
                        </button>
                    </div>
                </div>

                {{-- ---------- Modal detail: foto diam, cuma teks yang di-scroll ---------- --}}
                <div class="modal fade nac-mgmt-modal" id="mgmtModal{{ $i }}" tabindex="-1" aria-labelledby="mgmtModal{{ $i }}Label" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <button type="button" class="nac-mgmt-modal__close" data-bs-dismiss="modal" aria-label="Tutup">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                            <div class="nac-mgmt-modal__body">
                                <div class="nac-mgmt-modal__photo">
                                    <img src="{{ $member['photo_url'] }}" alt="{{ $member['name'] }}">
                                </div>
                                <div class="nac-mgmt-modal__text">
                                    <h3 id="mgmtModal{{ $i }}Label">{{ $member['name'] }}</h3>
                                    <span class="nac-mgmt-modal__position">{{ $member['position'] }}</span>
                                    <div class="nac-mgmt-modal__scroll">
                                        {!! $member['full_bio'] ?? '' !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ============ FASILITAS ============ --}}
@if ($facilities->isNotEmpty())
<section class="nac-section" id="fasilitas">
    <div class="container">
        <div class="nac-section__head" data-aos="fade-up">
            <span class="nac-eyebrow">Fasilitas</span>
            <h2 class="nac-section__title">Fasilitas unggulan penunjang latihan</h2>
        </div>

        <div class="nac-facility-showcase mt-4" data-facility-showcase data-aos="fade-up">
            {{-- Kiri: daftar fasilitas --}}
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

            {{-- Tengah (foto) + kanan (penjelasan) --}}
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
                            @if (count($facility->highlight_list))
                                <ul class="nac-facility-showcase__points">
                                    @foreach ($facility->highlight_list as $point)
                                        <li><i class="fa-solid fa-check"></i> {{ $point }}</li>
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

<script>
(function () {
    document.querySelectorAll('[data-facility-showcase]').forEach(function (box) {
        var tabs = box.querySelectorAll('[data-facility-tab]');
        var panels = box.querySelectorAll('[data-facility-panel]');

        function show(index) {
            tabs.forEach(function (tab) {
                var active = tab.getAttribute('data-facility-tab') === String(index);
                tab.classList.toggle('is-active', active);
                tab.setAttribute('aria-selected', active ? 'true' : 'false');
                // Di HP daftar bisa digeser ke samping — pastikan tombol aktif terlihat
                if (active && tab.scrollIntoView && window.innerWidth < 992) {
                    tab.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
                }
            });
            panels.forEach(function (panel) {
                var active = panel.getAttribute('data-facility-panel') === String(index);
                panel.classList.toggle('is-active', active);
                panel.hidden = !active;
            });
        }

        tabs.forEach(function (tab) {
            tab.addEventListener('click', function () {
                show(tab.getAttribute('data-facility-tab'));
            });
        });
    });
})();
</script>
@endif

{{-- ============ KELAS & CATATAN NAC SWIM SCHOOL (dipindah dari Join Us) ============ --}}
<section class="nac-section nac-about-classes-section nac-section--photo-bg" id="kelas"
    style="background-image: linear-gradient(180deg, rgba(10, 14, 20, 0.82), rgba(10, 14, 20, 0.88)), url('{{ $setting->classes_section_photo_url ?? 'https://picsum.photos/seed/nac-classes-bg/1920/1080' }}');">
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
                    <span class="nac-join-class__badge">Novato</span>
                    <h5>Untuk Pemula</h5>
                    <p>Dikhususkan bagi yang belum pernah belajar renang atau baru mengenal air. Fokus pada pengenalan teknik dasar dan keamanan di kolam.</p>
                </div>
                <div class="nac-join-class">
                    <span class="nac-join-class__badge">Avance</span>
                    <h5>Tingkat Lanjutan</h5>
                    <p>Bagi murid dari Novato atau calon murid yang sudah menguasai 1-2 gaya renang. Fokus mengasah kemampuan lebih lanjut sebagai persiapan masuk klub.</p>
                </div>
                <div class="nac-join-class">
                    <span class="nac-join-class__badge">Campeón</span>
                    <h5>Menuju Atlet</h5>
                    <p>Bagi murid dari Avance atau calon murid yang sudah menguasai beberapa gaya renang. Pada tingkat ini, murid mulai dilatih menjadi atlet kompetisi.</p>
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