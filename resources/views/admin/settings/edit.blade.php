@extends('admin.layouts.app')

@section('admin_title', 'Pengaturan Situs')

@section('admin_content')

    <div class="mb-4">
        <h1 class="h4 fw-bold mb-1">Pengaturan Situs</h1>
        <p class="text-secondary mb-0" style="font-size:0.9rem;">
            Data perusahaan: logo, kontak, sosial media, lokasi, dan About Us.
        </p>
    </div>

    @if (session('status'))
        <div class="alert alert-success py-2 px-3 mb-3" style="font-size:0.9rem;">{{ session('status') }}</div>
    @endif

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
                            Persegi disarankan. Maks 1MB.
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
                    <input type="url" name="instagram_url" class="form-control @error('instagram_url') is-invalid @enderror"
                        value="{{ old('instagram_url', $setting->instagram_url) }}" placeholder="https://instagram.com/nugrohoaquatic">
                    @error('instagram_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Facebook</label>
                    <input type="url" name="facebook_url" class="form-control @error('facebook_url') is-invalid @enderror"
                        value="{{ old('facebook_url', $setting->facebook_url) }}">
                    @error('facebook_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">YouTube</label>
                    <input type="url" name="youtube_url" class="form-control @error('youtube_url') is-invalid @enderror"
                        value="{{ old('youtube_url', $setting->youtube_url) }}">
                    @error('youtube_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">TikTok</label>
                    <input type="url" name="tiktok_url" class="form-control @error('tiktok_url') is-invalid @enderror"
                        value="{{ old('tiktok_url', $setting->tiktok_url) }}">
                    @error('tiktok_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
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
                        <textarea name="about_description" rows="5"
                            class="form-control @error('about_description') is-invalid @enderror"
                            placeholder="Sejak 2010, Nugroho Aquatic Center menjadi tempat lahirnya atlet renang...">{{ old('about_description', $setting->about_description) }}</textarea>
                        @error('about_description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>
        </div>

        <button type="submit" class="btn nac-admin-btn">
            <i class="bi bi-check-lg me-1"></i> Simpan Semua Pengaturan
        </button>
    </form>

@endsection