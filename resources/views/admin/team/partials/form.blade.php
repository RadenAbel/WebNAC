@php
    // Peran form ini: dari data yang sedang diedit, atau dari menu yang dibuka (?role=)
    $formRole = old('role', $member->role ?: (request('role') === 'pelatih' ? 'pelatih' : 'atlet'));
@endphp

@csrf

<div class="row g-4">
    {{-- ============ KOLOM KIRI: FOTO ============ --}}
    <div class="col-lg-4">
        <div class="nac-admin-form-section h-100 mb-0">
            <div class="nac-admin-form-section__head">
                <span class="nac-admin-form-section__icon"><i class="bi bi-image"></i></span>
                <div>
                    <p class="nac-admin-form-section__title">Foto Profil</p>
                    <p class="nac-admin-form-section__desc">JPG/PNG/WEBP, maks 2MB</p>
                </div>
            </div>

            <div class="nac-admin-dropzone" data-dropzone>
                <img
                    src="{{ $member->exists && $member->photo_url ? $member->photo_url : '' }}"
                    alt="Preview foto"
                    id="photoPreview"
                    class="nac-admin-dropzone__preview"
                    style="aspect-ratio:3/4; {{ $member->exists && $member->photo_url ? '' : 'display:none;' }}">

                <label class="nac-admin-dropzone__overlay" style="{{ $member->exists && $member->photo_url ? '' : 'aspect-ratio:3/4; border-top:none; flex-direction:column;' }}">
                    <i class="bi bi-cloud-arrow-up"></i>
                    <span>{{ $member->exists && $member->photo_url ? 'Ganti Foto' : 'Klik untuk upload foto' }}</span>
                    <input type="file" name="photo" accept="image/png, image/jpeg, image/webp"
                        data-photo-input="photoPreview">
                </label>
            </div>
            @error('photo')
                <div class="text-danger mt-2" style="font-size:0.8rem;">{{ $message }}</div>
            @enderror

            <div class="form-check mt-3">
                <input type="checkbox" name="photo_is_cutout" value="1" class="form-check-input" id="photoIsCutout"
                    {{ old('photo_is_cutout', $member->photo_is_cutout) ? 'checked' : '' }}>
                <label class="form-check-label" for="photoIsCutout" style="font-size:0.85rem;">
                    Foto ini sudah background transparan (PNG cutout)
                </label>
                <div class="text-secondary" style="font-size:0.78rem;">
                    Kalau dicentang, foto ditampilkan gaya "3D" mengambang keluar dari kartu profil di halaman publik — tanpa bingkai kotak, sesuai bentuk aslinya. Kalau tidak dicentang (foto biasa berlatar), tetap ditampilkan dalam bingkai kotak seperti biasa.
                </div>
            </div>
        </div>
    </div>

    {{-- ============ KOLOM KANAN: DATA ============ --}}
    <div class="col-lg-8">

        {{-- Data Utama --}}
        <div class="nac-admin-form-section">
            <div class="nac-admin-form-section__head">
                <span class="nac-admin-form-section__icon"><i class="bi bi-person-badge"></i></span>
                <div>
                    <p class="nac-admin-form-section__title">Data Utama</p>
                    <p class="nac-admin-form-section__desc">Identitas dasar anggota tim</p>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name', $member->name) }}" required>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Tanggal Lahir</label>
                    <input type="date" name="birth_date" id="birthDateInput"
                        class="form-control @error('birth_date') is-invalid @enderror"
                        value="{{ old('birth_date', $member->birth_date ? $member->birth_date->format('Y-m-d') : '') }}"
                        data-birthdate-input="ageOutput" max="{{ now()->format('Y-m-d') }}">
                    @error('birth_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Tempat Lahir</label>
                    <input type="text" name="birth_place" class="form-control @error('birth_place') is-invalid @enderror"
                        value="{{ old('birth_place', $member->birth_place) }}" placeholder="Surabaya">
                    @error('birth_place') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Gender</label>
                    <select name="gender" class="form-select @error('gender') is-invalid @enderror">
                        <option value="">— Pilih —</option>
                        <option value="Laki-Laki" {{ old('gender', $member->gender) === 'Laki-Laki' ? 'selected' : '' }}>Laki-Laki</option>
                        <option value="Perempuan" {{ old('gender', $member->gender) === 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('gender') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Tinggi Badan (cm)</label>
                    <input type="number" name="height_cm" min="0" max="250"
                        class="form-control @error('height_cm') is-invalid @enderror"
                        value="{{ old('height_cm', $member->height_cm) }}" placeholder="170">
                    @error('height_cm') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Berat Badan (kg)</label>
                    <input type="number" name="weight_kg" min="0" max="250"
                        class="form-control @error('weight_kg') is-invalid @enderror"
                        value="{{ old('weight_kg', $member->weight_kg) }}" placeholder="60">
                    @error('weight_kg') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">
                        Umur
                        <i class="bi bi-info-circle text-secondary" title="Otomatis dihitung dari Tanggal Lahir, ikut bertambah tiap tahun"></i>
                    </label>
                    <input type="number" name="age" id="ageOutput" min="1" max="100" readonly
                        class="form-control @error('age') is-invalid @enderror" style="background:var(--adm-mist, #F5F7FA);"
                        value="{{ old('age', $member->age) }}">
                    @error('age') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    <small class="text-secondary">Otomatis terisi begitu Tanggal Lahir diisi.</small>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Tanggal Bergabung</label>
                    <input type="date" name="join_date"
                        class="form-control @error('join_date') is-invalid @enderror"
                        value="{{ old('join_date', $member->join_date ? $member->join_date->format('Y-m-d') : '') }}"
                        max="{{ now()->format('Y-m-d') }}">
                    @error('join_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Peran ditentukan dari menu yang dibuka (Atlet / Pelatih), tidak dipilih manual --}}
                <input type="hidden" name="role" value="{{ $formRole }}">

                @if ($formRole === 'atlet')
                <div class="col-md-6">
                    <label class="form-label">Kategori</label>
                    <select name="category" class="form-select @error('category') is-invalid @enderror">
                        <option value="">— Pilih Kategori —</option>
                        <option value="Novato" {{ old('category', $member->category) === 'Novato' ? 'selected' : '' }}>Novato</option>
                        <option value="Avance" {{ old('category', $member->category) === 'Avance' ? 'selected' : '' }}>Avance</option>
                        <option value="Campeón" {{ old('category', $member->category) === 'Campeón' ? 'selected' : '' }}>Campeón</option>
                    </select>
                    @error('category') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Asal Sekolah</label>
                    <input type="text" name="school_name" class="form-control @error('school_name') is-invalid @enderror"
                        value="{{ old('school_name', $member->school_name) }}" placeholder="SD Negeri 001 Sangatta Utara">
                    @error('school_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    <small class="text-secondary">Tampil di halaman profil atlet, di bawah "Status di Klub".</small>
                </div>
                @endif

                <div class="col-md-6">
                    <label class="form-label">Gaya Spesialis</label>
                    <div class="border rounded-3 p-3" style="background:#fafbfc;">
                        @php $selectedStyles = old('swim_style', $member->swim_style_array ?? []); @endphp
                        @foreach (['Gaya Bebas', 'Gaya Dada', 'Gaya Punggung', 'Gaya Kupu-Kupu', 'Gaya Ganti (Individual Medley)', 'Serba Bisa (All-Round)'] as $style)
                            <div class="form-check">
                                <input type="checkbox" name="swim_style[]" value="{{ $style }}" class="form-check-input" id="style{{ $loop->index }}"
                                    {{ in_array($style, $selectedStyles) ? 'checked' : '' }}>
                                <label class="form-check-label" for="style{{ $loop->index }}" style="font-size:0.88rem;">{{ $style }}</label>
                            </div>
                        @endforeach
                    </div>
                    <small class="text-secondary">Bisa pilih lebih dari satu.</small>
                    @error('swim_style') <div class="text-danger" style="font-size:0.8rem;">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Asal Kota</label>
                    <input type="text" name="origin_city" class="form-control @error('origin_city') is-invalid @enderror"
                        value="{{ old('origin_city', $member->origin_city) }}" placeholder="Surabaya">
                    @error('origin_city') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Lama Pengalaman (tahun)</label>
                    <input type="number" name="years_experience" min="0" max="80"
                        class="form-control @error('years_experience') is-invalid @enderror"
                        value="{{ old('years_experience', $member->years_experience) }}">
                    @error('years_experience') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Total Medali</label>
                    <input type="number" name="total_medals" min="0"
                        class="form-control @error('total_medals') is-invalid @enderror"
                        value="{{ old('total_medals', $member->total_medals ?? 0) }}">
                    @error('total_medals') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

            </div>
        </div>

        {{-- Kontak & Sosial Media --}}
        <div class="nac-admin-form-section">
            <div class="nac-admin-form-section__head">
                <span class="nac-admin-form-section__icon"><i class="bi bi-share"></i></span>
                <div>
                    <p class="nac-admin-form-section__title">Kontak &amp; Sosial Media</p>
                    <p class="nac-admin-form-section__desc">Opsional, tampil di halaman profil publik</p>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label"><i class="bi bi-whatsapp text-success me-1"></i>Nomor WhatsApp</label>
                    <input type="text" name="whatsapp" class="form-control @error('whatsapp') is-invalid @enderror"
                        value="{{ old('whatsapp', $member->whatsapp) }}" placeholder="6281234567890">
                    @error('whatsapp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label"><i class="bi bi-instagram text-danger me-1"></i>Instagram</label>
                    <div class="input-group @error('instagram_url') is-invalid @enderror">
                        <span class="input-group-text" style="font-size:0.8rem; color:var(--adm-steel, #64748B);">instagram.com/</span>
                        <input type="text" name="instagram_url" class="form-control @error('instagram_url') is-invalid @enderror"
                            value="{{ old('instagram_url', \App\Support\SocialLinkHelper::extractUsername($member->instagram_url)) }}"
                            placeholder="username">
                    </div>
                    @error('instagram_url') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label"><i class="bi bi-facebook text-primary me-1"></i>Facebook</label>
                    <div class="input-group @error('facebook_url') is-invalid @enderror">
                        <span class="input-group-text" style="font-size:0.8rem; color:var(--adm-steel, #64748B);">facebook.com/</span>
                        <input type="text" name="facebook_url" class="form-control @error('facebook_url') is-invalid @enderror"
                            value="{{ old('facebook_url', \App\Support\SocialLinkHelper::extractUsername($member->facebook_url)) }}"
                            placeholder="username">
                    </div>
                    @error('facebook_url') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label"><i class="bi bi-tiktok me-1"></i>TikTok</label>
                    <div class="input-group @error('tiktok_url') is-invalid @enderror">
                        <span class="input-group-text" style="font-size:0.8rem; color:var(--adm-steel, #64748B);">tiktok.com/@</span>
                        <input type="text" name="tiktok_url" class="form-control @error('tiktok_url') is-invalid @enderror"
                            value="{{ old('tiktok_url', \App\Support\SocialLinkHelper::extractUsername($member->tiktok_url)) }}"
                            placeholder="username">
                    </div>
                    @error('tiktok_url') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>

        {{-- Bio & Pengaturan Tampil --}}
        <div class="nac-admin-form-section mb-0">
            <div class="nac-admin-form-section__head">
                <span class="nac-admin-form-section__icon"><i class="bi bi-card-text"></i></span>
                <div>
                    <p class="nac-admin-form-section__title">Bio &amp; Tampilan</p>
                    <p class="nac-admin-form-section__desc">Deskripsi dan pengaturan urutan tampil</p>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label">Deskripsi / Bio</label>
                    <textarea name="bio" rows="4" class="form-control @error('bio') is-invalid @enderror"
                        placeholder="Ceritakan sedikit tentang atlet/pelatih ini...">{{ old('bio', $member->bio) }}</textarea>
                    @error('bio') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Urutan Tampil</label>
                    <input type="number" name="sort_order" min="0" class="form-control @error('sort_order') is-invalid @enderror"
                        value="{{ old('sort_order', $member->sort_order ?? 0) }}">
                    <small class="text-secondary">Angka lebih kecil tampil lebih dulu.</small>
                </div>

                <div class="col-md-6 d-flex align-items-end">
                    <div class="form-check form-switch">
                        <input type="checkbox" name="is_active" value="1" class="form-check-input" id="isActive" role="switch"
                            {{ old('is_active', $member->is_active ?? true) ? 'checked' : '' }}>
                        <label class="form-check-label fw-bold" for="isActive">
                            Aktif (tampil di website)
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>