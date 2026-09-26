@extends('admin.layouts.app')

@section('admin_title', 'Pengaturan Situs')

@section('admin_content')

    <div class="mb-4">
        <h1 class="h4 fw-bold mb-1">Pengaturan Situs</h1>
        <p class="text-secondary mb-0" style="font-size:0.9rem;">
            Data perusahaan: logo, kontak, sosial media, lokasi, dan About Us.
        </p>
    </div>

    @include('admin.partials.toast')

    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- ============ IDENTITAS ============ --}}
        <div class="bg-white border rounded-3 p-4 mb-4">
            <h2 class="h6 fw-bold mb-3">Identitas</h2>

            <div class="row g-3">
                <div class="col-lg-3">
                    <label class="form-label fw-bold">Logo</label>
                    <div class="border rounded-3 p-3 text-center" style="background:#fafbfc;">
                        <img
                            src="{{ $setting->logo ? $setting->logo_url : asset('images/default-avatar.jpg') }}"
                            alt="Preview logo"
                            id="logoPreview"
                            class="rounded-3 mb-2"
                            style="width:100%; aspect-ratio:1/1; object-fit:contain; background:#fff;">
                        <input
                            type="file"
                            name="logo"
                            accept="image/png, image/jpeg, image/webp, image/svg+xml"
                            class="form-control form-control-sm @error('logo') is-invalid @enderror"
                            onchange="document.getElementById('logoPreview').src = window.URL.createObjectURL(this.files[0])">
                        @error('logo') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        <small class="text-secondary d-block mt-1" style="font-size:0.76rem;">
                            Persegi disarankan. Maks 4MB.
                        </small>
                    </div>
                </div>

                <div class="col-lg-9">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label fw-bold">Nama Situs <span class="text-danger">*</span></label>
                            <input type="text" name="site_name" class="form-control @error('site_name') is-invalid @enderror"
                                value="{{ old('site_name', $setting->site_name) }}" required>
                            @error('site_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Berdiri Sejak (tahun)</label>
                            <input type="text" name="since_year" maxlength="4"
                                class="form-control @error('since_year') is-invalid @enderror"
                                value="{{ old('since_year', $setting->since_year) }}" placeholder="2010">
                            @error('since_year') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <small class="text-secondary" style="font-size:0.76rem;">Dipakai di badge "Sejak 2010" pada section Tentang Kami.</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ============ KONTAK PERUSAHAAN ============ --}}
        <div class="bg-white border rounded-3 p-4 mb-4">
            <h2 class="h6 fw-bold mb-3">Kontak Perusahaan</h2>

            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-bold">Nomor WhatsApp</label>
                    <input type="text" name="whatsapp" class="form-control @error('whatsapp') is-invalid @enderror"
                        value="{{ old('whatsapp', $setting->whatsapp) }}" placeholder="6281234567890">
                    @error('whatsapp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Nomor Telepon</label>
                    <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                        value="{{ old('phone', $setting->phone) }}">
                    @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Email</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email', $setting->email) }}">
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>

        {{-- ============ SOSIAL MEDIA PERUSAHAAN ============ --}}
        <div class="bg-white border rounded-3 p-4 mb-4">
            <h2 class="h6 fw-bold mb-3">Sosial Media Perusahaan</h2>

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Instagram</label>
                    <div class="input-group">
                        <span class="input-group-text" style="font-size:0.8rem; color:var(--adm-steel, #64748B);">instagram.com/</span>
                        <input type="text" name="instagram_url" class="form-control @error('instagram_url') is-invalid @enderror"
                            value="{{ old('instagram_url', \App\Support\SocialLinkHelper::extractUsername($setting->instagram_url)) }}"
                            placeholder="nugrohoaquatic">
                    </div>
                    @error('instagram_url') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Facebook</label>
                    <div class="input-group">
                        <span class="input-group-text" style="font-size:0.8rem; color:var(--adm-steel, #64748B);">facebook.com/</span>
                        <input type="text" name="facebook_url" class="form-control @error('facebook_url') is-invalid @enderror"
                            value="{{ old('facebook_url', \App\Support\SocialLinkHelper::extractUsername($setting->facebook_url)) }}"
                            placeholder="username">
                    </div>
                    @error('facebook_url') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">YouTube</label>
                    <div class="input-group">
                        <span class="input-group-text" style="font-size:0.8rem; color:var(--adm-steel, #64748B);">youtube.com/@</span>
                        <input type="text" name="youtube_url" class="form-control @error('youtube_url') is-invalid @enderror"
                            value="{{ old('youtube_url', \App\Support\SocialLinkHelper::extractUsername($setting->youtube_url)) }}"
                            placeholder="username">
                    </div>
                    @error('youtube_url') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">TikTok</label>
                    <div class="input-group">
                        <span class="input-group-text" style="font-size:0.8rem; color:var(--adm-steel, #64748B);">tiktok.com/@</span>
                        <input type="text" name="tiktok_url" class="form-control @error('tiktok_url') is-invalid @enderror"
                            value="{{ old('tiktok_url', \App\Support\SocialLinkHelper::extractUsername($setting->tiktok_url)) }}"
                            placeholder="username">
                    </div>
                    @error('tiktok_url') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>

        {{-- ============ LOKASI & JAM OPERASIONAL ============ --}}
        <div class="bg-white border rounded-3 p-4 mb-4">
            <h2 class="h6 fw-bold mb-3">Lokasi &amp; Jam Operasional</h2>

            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label fw-bold">Alamat</label>
                    <input type="text" name="address" class="form-control @error('address') is-invalid @enderror"
                        value="{{ old('address', $setting->address) }}" placeholder="Jl. Aquatic Raya No. 1, Surabaya, Jawa Timur">
                    @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-12">
                    <label class="form-label fw-bold">Link Embed Google Maps</label>
                    <input type="url" name="map_embed_url" class="form-control @error('map_embed_url') is-invalid @enderror"
                        value="{{ old('map_embed_url', $setting->map_embed_url) }}"
                        placeholder="https://www.google.com/maps?q=...&output=embed">
                    @error('map_embed_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    <small class="text-secondary" style="font-size:0.78rem;">
                        Buka Google Maps → cari lokasi → Bagikan → Sematkan peta → salin link di dalam atribut src="...".
                    </small>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">Jam Buka (Senin–Jumat)</label>
                    <input type="text" name="opening_hours_weekday"
                        class="form-control @error('opening_hours_weekday') is-invalid @enderror"
                        value="{{ old('opening_hours_weekday', $setting->opening_hours_weekday) }}" placeholder="06.00 - 21.00">
                    @error('opening_hours_weekday') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Jam Buka (Sabtu–Minggu)</label>
                    <input type="text" name="opening_hours_weekend"
                        class="form-control @error('opening_hours_weekend') is-invalid @enderror"
                        value="{{ old('opening_hours_weekend', $setting->opening_hours_weekend) }}" placeholder="07.00 - 20.00">
                    @error('opening_hours_weekend') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>

        {{-- ============ ABOUT US ============ --}}
        <div class="bg-white border rounded-3 p-4 mb-4">
            <h2 class="h6 fw-bold mb-3">About Us (Section "Tentang Kami")</h2>

            <div class="row g-3">
                <div class="col-lg-4">
                    <label class="form-label fw-bold">Foto</label>
                    <div class="border rounded-3 p-3 text-center" style="background:#fafbfc;">
                        <img
                            src="{{ $setting->about_photo ? $setting->about_photo_url : asset('images/default-avatar.jpg') }}"
                            alt="Preview foto About Us"
                            id="aboutPhotoPreview"
                            class="rounded-3 mb-2"
                            style="width:100%; aspect-ratio:5/4; object-fit:cover;">
                        <input
                            type="file"
                            name="about_photo"
                            accept="image/png, image/jpeg, image/webp"
                            class="form-control form-control-sm @error('about_photo') is-invalid @enderror"
                            onchange="document.getElementById('aboutPhotoPreview').src = window.URL.createObjectURL(this.files[0])">
                        @error('about_photo') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Judul</label>
                        <input type="text" name="about_title" class="form-control @error('about_title') is-invalid @enderror"
                            value="{{ old('about_title', $setting->about_title) }}"
                            placeholder="Lebih dari sekadar tempat berenang.">
                        @error('about_title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div>
                        <label class="form-label fw-bold">Deskripsi</label>
                        <div id="aboutDescriptionEditor" style="height:220px; background:#fff;" class="@error('about_description') is-invalid @enderror"></div>
                        {{-- Textarea asli disembunyikan — dipakai buat nyimpen hasil HTML dari
                             editor, ini yang beneran dikirim ke server saat form disubmit. --}}
                        <textarea name="about_description" id="aboutDescriptionInput" class="d-none">{{ old('about_description', $setting->about_description) }}</textarea>
                        @error('about_description') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        <small class="text-secondary">Di halaman Beranda, cuma 3 paragraf pertama yang ditampilkan (ringkas). Halaman Tentang Kami menampilkan semuanya.</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- ============ FOTO BACKGROUND — SECTION KELAS (halaman Tentang Kami) ============ --}}
        <div class="bg-white border rounded-3 p-4 mb-4">
            <h2 class="h6 fw-bold mb-1">Foto Background — Section "Kelas NAC Swim School"</h2>
            <p class="text-secondary mb-3" style="font-size:0.85rem;">
                Muncul di halaman Tentang Kami, sebagai foto latar gelap di belakang tulisan
                "Kelas Apa Aja Sih yang Ada di Nugroho Swim School?".
            </p>
            <div class="row g-3">
                <div class="col-lg-4">
                    <div class="border rounded-3 p-3 text-center" style="background:#fafbfc;">
                        <img
                            src="{{ $setting->classes_section_photo ? $setting->classes_section_photo_url : asset('images/default-avatar.jpg') }}"
                            alt="Preview foto background section Kelas"
                            id="classesSectionPhotoPreview"
                            class="rounded-3 mb-2"
                            style="width:100%; aspect-ratio:16/9; object-fit:cover;">
                        <input
                            type="file"
                            name="classes_section_photo"
                            accept="image/png, image/jpeg, image/webp"
                            class="form-control form-control-sm @error('classes_section_photo') is-invalid @enderror"
                            onchange="document.getElementById('classesSectionPhotoPreview').src = window.URL.createObjectURL(this.files[0])">
                        @error('classes_section_photo') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        <p class="text-secondary mt-2 mb-0" style="font-size:0.78rem;">
                            Disarankan foto yang cukup gelap/kontras, karena tulisan di atasnya berwarna putih.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- ============ FOTO BACKGROUND — SECTION EVERGLADE AQUATIC CENTER ============ --}}
        <div class="bg-white border rounded-3 p-4 mb-4">
            <h2 class="h6 fw-bold mb-1">Foto Background — Section "Everglade Aquatic Center"</h2>
            <p class="text-secondary mb-3" style="font-size:0.85rem;">
                Muncul di halaman Tentang Kami, sebagai foto latar section yang menjelaskan
                kolam Everglade Aquatic Center tempat NAC berlatih.
            </p>
            <div class="row g-3">
                <div class="col-lg-4">
                    <div class="border rounded-3 p-3 text-center" style="background:#fafbfc;">
                        <img
                            src="{{ $setting->pool_section_photo ? $setting->pool_section_photo_url : asset('images/default-avatar.jpg') }}"
                            alt="Preview foto background section kolam"
                            id="poolSectionPhotoPreview"
                            class="rounded-3 mb-2"
                            style="width:100%; aspect-ratio:16/9; object-fit:cover;">
                        <input
                            type="file"
                            name="pool_section_photo"
                            accept="image/png, image/jpeg, image/webp"
                            class="form-control form-control-sm @error('pool_section_photo') is-invalid @enderror"
                            onchange="document.getElementById('poolSectionPhotoPreview').src = window.URL.createObjectURL(this.files[0])">
                        @error('pool_section_photo') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        <p class="text-secondary mt-2 mb-0" style="font-size:0.78rem;">
                            Disarankan foto asli kolam Everglade Aquatic Center (kalau sudah ada dokumentasinya).
                        </p>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Judul</label>
                        <input type="text" name="pool_section_title" class="form-control @error('pool_section_title') is-invalid @enderror"
                            value="{{ old('pool_section_title', $setting->pool_section_title) }}"
                            placeholder="Berlatih di Everglade Aquatic Center">
                        @error('pool_section_title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div>
                        <label class="form-label fw-bold">Deskripsi</label>
                        <textarea name="pool_section_description" rows="5"
                            class="form-control @error('pool_section_description') is-invalid @enderror"
                            placeholder="Nugroho Aquatic Club menjalankan seluruh program latihannya di Everglade Aquatic Center...">{{ old('pool_section_description', $setting->pool_section_description) }}</textarea>
                        @error('pool_section_description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- ============ BACKGROUND — HEADER HALAMAN GALERI ============ --}}
        <div class="bg-white border rounded-3 p-4 mb-4">
            <h2 class="h6 fw-bold mb-1">Background — Header Halaman Galeri</h2>
            <p class="text-secondary mb-3" style="font-size:0.85rem;">
                Muncul di bagian paling atas halaman <code>/galeri</code>, di belakang judul "Momen di Nugroho Aquatic Club."
            </p>

            @php $isGalleryHeaderVideo = old('gallery_header_type', $setting->gallery_header_type ?? 'photo') === 'video'; @endphp

            <div class="btn-group mb-3" role="group">
                <input type="radio" class="btn-check" name="gallery_header_type" id="galleryHeaderTypePhoto" value="photo" autocomplete="off" {{ $isGalleryHeaderVideo ? '' : 'checked' }}>
                <label class="btn btn-outline-secondary" for="galleryHeaderTypePhoto"><i class="bi bi-image"></i> Foto</label>

                <input type="radio" class="btn-check" name="gallery_header_type" id="galleryHeaderTypeVideo" value="video" autocomplete="off" {{ $isGalleryHeaderVideo ? 'checked' : '' }}>
                <label class="btn btn-outline-secondary" for="galleryHeaderTypeVideo"><i class="bi bi-youtube"></i> Video</label>
            </div>
            @error('gallery_header_type') <div class="text-danger mb-2" style="font-size:0.8rem;">{{ $message }}</div> @enderror

            <div class="row g-3">
                <div class="col-lg-6" id="galleryHeaderPhotoPanel" style="{{ $isGalleryHeaderVideo ? 'display:none;' : '' }}">
                    <div class="border rounded-3 p-3 text-center" style="background:#fafbfc;">
                        <img
                            src="{{ $setting->gallery_header_photo ? $setting->gallery_header_photo_url : asset('images/default-avatar.jpg') }}"
                            alt="Preview foto header Galeri"
                            id="galleryHeaderPhotoPreview"
                            class="rounded-3 mb-2"
                            style="width:100%; aspect-ratio:16/9; object-fit:cover;">
                        <input
                            type="file"
                            name="gallery_header_photo"
                            accept="image/png, image/jpeg, image/webp"
                            class="form-control form-control-sm @error('gallery_header_photo') is-invalid @enderror"
                            onchange="document.getElementById('galleryHeaderPhotoPreview').src = window.URL.createObjectURL(this.files[0])">
                        @error('gallery_header_photo') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="col-lg-6" id="galleryHeaderVideoPanel" style="{{ $isGalleryHeaderVideo ? '' : 'display:none;' }}">
                    <label class="form-label">Link YouTube</label>
                    <input type="text" name="gallery_header_youtube_url" class="form-control @error('gallery_header_youtube_url') is-invalid @enderror"
                        value="{{ old('gallery_header_youtube_url', $setting->gallery_header_youtube_url) }}" placeholder="https://www.youtube.com/watch?v=...">
                    @error('gallery_header_youtube_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    <small class="text-secondary">Video diputar otomatis (tanpa suara) sebagai background header.</small>
                </div>
            </div>
        </div>

        {{-- ============ BACKGROUND — HEADER HALAMAN ACARA ============ --}}
        <div class="bg-white border rounded-3 p-4 mb-4">
            <h2 class="h6 fw-bold mb-1">Background — Header Halaman Acara</h2>
            <p class="text-secondary mb-3" style="font-size:0.85rem;">
                Muncul di bagian paling atas halaman <code>/acara</code>, di belakang judul "Acara &amp; Kegiatan Kami."
            </p>

            @php $isEventHeaderVideo = old('event_header_type', $setting->event_header_type ?? 'photo') === 'video'; @endphp

            <div class="btn-group mb-3" role="group">
                <input type="radio" class="btn-check" name="event_header_type" id="eventHeaderTypePhoto" value="photo" autocomplete="off" {{ $isEventHeaderVideo ? '' : 'checked' }}>
                <label class="btn btn-outline-secondary" for="eventHeaderTypePhoto"><i class="bi bi-image"></i> Foto</label>

                <input type="radio" class="btn-check" name="event_header_type" id="eventHeaderTypeVideo" value="video" autocomplete="off" {{ $isEventHeaderVideo ? 'checked' : '' }}>
                <label class="btn btn-outline-secondary" for="eventHeaderTypeVideo"><i class="bi bi-youtube"></i> Video</label>
            </div>
            @error('event_header_type') <div class="text-danger mb-2" style="font-size:0.8rem;">{{ $message }}</div> @enderror

            <div class="row g-3">
                <div class="col-lg-6" id="eventHeaderPhotoPanel" style="{{ $isEventHeaderVideo ? 'display:none;' : '' }}">
                    <div class="border rounded-3 p-3 text-center" style="background:#fafbfc;">
                        <img
                            src="{{ $setting->event_header_photo ? $setting->event_header_photo_url : asset('images/default-avatar.jpg') }}"
                            alt="Preview foto header Acara"
                            id="eventHeaderPhotoPreview"
                            class="rounded-3 mb-2"
                            style="width:100%; aspect-ratio:16/9; object-fit:cover;">
                        <input
                            type="file"
                            name="event_header_photo"
                            accept="image/png, image/jpeg, image/webp"
                            class="form-control form-control-sm @error('event_header_photo') is-invalid @enderror"
                            onchange="document.getElementById('eventHeaderPhotoPreview').src = window.URL.createObjectURL(this.files[0])">
                        @error('event_header_photo') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="col-lg-6" id="eventHeaderVideoPanel" style="{{ $isEventHeaderVideo ? '' : 'display:none;' }}">
                    <label class="form-label">Link YouTube</label>
                    <input type="text" name="event_header_youtube_url" class="form-control @error('event_header_youtube_url') is-invalid @enderror"
                        value="{{ old('event_header_youtube_url', $setting->event_header_youtube_url) }}" placeholder="https://www.youtube.com/watch?v=...">
                    @error('event_header_youtube_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    <small class="text-secondary">Video diputar otomatis (tanpa suara) sebagai background header.</small>
                </div>
            </div>
        </div>

        {{-- ============ BACKGROUND — HEADER HALAMAN ATLET & PELATIH ============ --}}
        <div class="bg-white border rounded-3 p-4 mb-4">
            <h2 class="h6 fw-bold mb-1">Background — Header Halaman Atlet &amp; Pelatih</h2>
            <p class="text-secondary mb-3" style="font-size:0.85rem;">
                Satu setting yang sama dipakai bersama untuk halaman <code>/our-team/atlet</code> dan <code>/our-team/pelatih</code> — tidak perlu diatur terpisah.
            </p>

            @php $isTeamHeaderVideo = old('team_header_type', $setting->team_header_type ?? 'photo') === 'video'; @endphp

            <div class="btn-group mb-3" role="group">
                <input type="radio" class="btn-check" name="team_header_type" id="teamHeaderTypePhoto" value="photo" autocomplete="off" {{ $isTeamHeaderVideo ? '' : 'checked' }}>
                <label class="btn btn-outline-secondary" for="teamHeaderTypePhoto"><i class="bi bi-image"></i> Foto</label>

                <input type="radio" class="btn-check" name="team_header_type" id="teamHeaderTypeVideo" value="video" autocomplete="off" {{ $isTeamHeaderVideo ? 'checked' : '' }}>
                <label class="btn btn-outline-secondary" for="teamHeaderTypeVideo"><i class="bi bi-youtube"></i> Video</label>
            </div>
            @error('team_header_type') <div class="text-danger mb-2" style="font-size:0.8rem;">{{ $message }}</div> @enderror

            <div class="row g-3">
                <div class="col-lg-6" id="teamHeaderPhotoPanel" style="{{ $isTeamHeaderVideo ? 'display:none;' : '' }}">
                    <div class="border rounded-3 p-3 text-center" style="background:#fafbfc;">
                        <img
                            src="{{ $setting->team_header_photo ? $setting->team_header_photo_url : asset('images/default-avatar.jpg') }}"
                            alt="Preview foto header Atlet/Pelatih"
                            id="teamHeaderPhotoPreview"
                            class="rounded-3 mb-2"
                            style="width:100%; aspect-ratio:16/9; object-fit:cover;">
                        <input
                            type="file"
                            name="team_header_photo"
                            accept="image/png, image/jpeg, image/webp"
                            class="form-control form-control-sm @error('team_header_photo') is-invalid @enderror"
                            onchange="document.getElementById('teamHeaderPhotoPreview').src = window.URL.createObjectURL(this.files[0])">
                        @error('team_header_photo') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="col-lg-6" id="teamHeaderVideoPanel" style="{{ $isTeamHeaderVideo ? '' : 'display:none;' }}">
                    <label class="form-label">Link YouTube</label>
                    <input type="text" name="team_header_youtube_url" class="form-control @error('team_header_youtube_url') is-invalid @enderror"
                        value="{{ old('team_header_youtube_url', $setting->team_header_youtube_url) }}" placeholder="https://www.youtube.com/watch?v=...">
                    @error('team_header_youtube_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    <small class="text-secondary">Video diputar otomatis (tanpa suara) sebagai background header.</small>
                </div>
            </div>
        </div>

        {{-- ============ BACKGROUND — HEADER HALAMAN JOIN US ============ --}}
        <div class="bg-white border rounded-3 p-4 mb-4">
            <h2 class="h6 fw-bold mb-1">Background — Header Halaman Join Us</h2>
            <p class="text-secondary mb-3" style="font-size:0.85rem;">
                Muncul di bagian paling atas halaman <code>/join</code>, di belakang judul "Mulai perjalanan renangmu bersama kami."
            </p>

            @php $isJoinHeaderVideo = old('join_header_type', $setting->join_header_type ?? 'photo') === 'video'; @endphp

            <div class="btn-group mb-3" role="group">
                <input type="radio" class="btn-check" name="join_header_type" id="joinHeaderTypePhoto" value="photo" autocomplete="off" {{ $isJoinHeaderVideo ? '' : 'checked' }}>
                <label class="btn btn-outline-secondary" for="joinHeaderTypePhoto"><i class="bi bi-image"></i> Foto</label>

                <input type="radio" class="btn-check" name="join_header_type" id="joinHeaderTypeVideo" value="video" autocomplete="off" {{ $isJoinHeaderVideo ? 'checked' : '' }}>
                <label class="btn btn-outline-secondary" for="joinHeaderTypeVideo"><i class="bi bi-youtube"></i> Video</label>
            </div>
            @error('join_header_type') <div class="text-danger mb-2" style="font-size:0.8rem;">{{ $message }}</div> @enderror

            <div class="row g-3">
                <div class="col-lg-6" id="joinHeaderPhotoPanel" style="{{ $isJoinHeaderVideo ? 'display:none;' : '' }}">
                    <div class="border rounded-3 p-3 text-center" style="background:#fafbfc;">
                        <img
                            src="{{ $setting->join_header_photo ? $setting->join_header_photo_url : asset('images/default-avatar.jpg') }}"
                            alt="Preview foto header Join Us"
                            id="joinHeaderPhotoPreview"
                            class="rounded-3 mb-2"
                            style="width:100%; aspect-ratio:16/9; object-fit:cover;">
                        <input
                            type="file"
                            name="join_header_photo"
                            accept="image/png, image/jpeg, image/webp"
                            class="form-control form-control-sm @error('join_header_photo') is-invalid @enderror"
                            onchange="document.getElementById('joinHeaderPhotoPreview').src = window.URL.createObjectURL(this.files[0])">
                        @error('join_header_photo') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="col-lg-6" id="joinHeaderVideoPanel" style="{{ $isJoinHeaderVideo ? '' : 'display:none;' }}">
                    <label class="form-label">Link YouTube</label>
                    <input type="text" name="join_header_youtube_url" class="form-control @error('join_header_youtube_url') is-invalid @enderror"
                        value="{{ old('join_header_youtube_url', $setting->join_header_youtube_url) }}" placeholder="https://www.youtube.com/watch?v=...">
                    @error('join_header_youtube_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    <small class="text-secondary">Video diputar otomatis (tanpa suara) sebagai background header.</small>
                </div>
            </div>
        </div>

        <button type="submit" class="btn nac-admin-btn">
            <i class="bi bi-check-lg me-1"></i> Simpan Semua Pengaturan
        </button>
    </form>

    @push('scripts')
    <script>
        function nacSetupHeaderToggle(prefix) {
            var typePhoto = document.getElementById(prefix + 'TypePhoto');
            var typeVideo = document.getElementById(prefix + 'TypeVideo');
            var photoPanel = document.getElementById(prefix + 'PhotoPanel');
            var videoPanel = document.getElementById(prefix + 'VideoPanel');
            if (!typePhoto || !typeVideo) return;

            function sync() {
                var isVideo = typeVideo.checked;
                photoPanel.style.display = isVideo ? 'none' : '';
                videoPanel.style.display = isVideo ? '' : 'none';
            }
            typePhoto.addEventListener('change', sync);
            typeVideo.addEventListener('change', sync);
        }
        nacSetupHeaderToggle('galleryHeader');
        nacSetupHeaderToggle('eventHeader');
        nacSetupHeaderToggle('teamHeader');
        nacSetupHeaderToggle('joinHeader');
    </script>
    @endpush

    @push('styles')
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet">
    @endpush

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
    <script>
        (function () {
            var editorEl = document.getElementById('aboutDescriptionEditor');
            var hiddenInput = document.getElementById('aboutDescriptionInput');
            if (!editorEl || !hiddenInput) return;

            // Toolbar lebih lengkap dari yang di Tim Manajemen — ada heading,
            // warna teks & warna background, dan perataan (align).
            var quill = new Quill(editorEl, {
                theme: 'snow',
                placeholder: 'Tulis deskripsi tentang klub di sini...',
                modules: {
                    toolbar: [
                        [{ header: [2, 3, false] }],
                        ['bold', 'italic', 'underline', 'strike'],
                        [{ color: [] }, { background: [] }],
                        [{ list: 'ordered' }, { list: 'bullet' }],
                        [{ align: [] }],
                        ['link'],
                        ['clean'],
                    ],
                },
            });

            // Mode edit: isi editor dengan HTML yang sudah tersimpan sebelumnya
            if (hiddenInput.value.trim() !== '') {
                quill.clipboard.dangerouslyPasteHTML(hiddenInput.value);
            }

            // Begitu form mau dikirim, salin HTML dari editor ke textarea
            // tersembunyi dulu — supaya yang benar-benar terkirim ke server
            // adalah hasil format lengkapnya, bukan textarea yang kosong.
            var form = hiddenInput.closest('form');
            if (form) {
                form.addEventListener('submit', function () {
                    hiddenInput.value = quill.root.innerHTML;
                });
            }
        })();
    </script>
    @endpush

@endsection