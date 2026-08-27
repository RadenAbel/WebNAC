@csrf

<div class="row g-4">
    {{-- ============ KOLOM KIRI: FOTO ============ --}}
    <div class="col-lg-4">
        <label class="form-label fw-bold">Foto</label>

        <div class="border rounded-3 p-3 text-center mb-2" style="background:#fafbfc;">
            <img
                src="{{ $member->exists ? $member->photo_url : asset('images/default-avatar.jpg') }}"
                alt="Preview foto"
                id="photoPreview"
                class="rounded-3 mb-2"
                style="width:100%; aspect-ratio:3/4; object-fit:cover;">

            <input
                type="file"
                name="photo"
                accept="image/png, image/jpeg, image/webp"
                class="form-control form-control-sm @error('photo') is-invalid @enderror"
                onchange="document.getElementById('photoPreview').src = window.URL.createObjectURL(this.files[0])">

            @error('photo')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror

            <small class="text-secondary d-block mt-1" style="font-size:0.78rem;">
                JPG/PNG/WEBP, maks 2MB. Kosongkan kalau tidak ingin mengubah foto.
            </small>
        </div>
    </div>

    {{-- ============ KOLOM KANAN: DATA ============ --}}
    <div class="col-lg-8">
        <div class="row g-3">
            <div class="col-md-8">
                <label class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name', $member->name) }}" required>
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-4">
                <label class="form-label fw-bold">Umur</label>
                <input type="number" name="age" min="1" max="100" class="form-control @error('age') is-invalid @enderror"
                    value="{{ old('age', $member->age) }}">
                @error('age') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">Peran <span class="text-danger">*</span></label>
                <select name="role" class="form-select @error('role') is-invalid @enderror" required>
                    <option value="">— Pilih —</option>
                    <option value="pelatih" {{ old('role', $member->role) === 'pelatih' ? 'selected' : '' }}>Pelatih</option>
                    <option value="atlet" {{ old('role', $member->role) === 'atlet' ? 'selected' : '' }}>Atlet</option>
                </select>
                @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">Kategori</label>
                <input type="text" name="category" class="form-control @error('category') is-invalid @enderror"
                    value="{{ old('category', $member->category) }}"
                    placeholder="Junior / Senior / Swim Class A / Head Coach, dst.">
                @error('category') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">Asal Kota</label>
                <input type="text" name="origin_city" class="form-control @error('origin_city') is-invalid @enderror"
                    value="{{ old('origin_city', $member->origin_city) }}" placeholder="Surabaya">
                @error('origin_city') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">Lama Pengalaman (tahun)</label>
                <input type="number" name="years_experience" min="0" max="80"
                    class="form-control @error('years_experience') is-invalid @enderror"
                    value="{{ old('years_experience', $member->years_experience) }}">
                @error('years_experience') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">Total Medali</label>
                <input type="number" name="total_medals" min="0"
                    class="form-control @error('total_medals') is-invalid @enderror"
                    value="{{ old('total_medals', $member->total_medals ?? 0) }}">
                @error('total_medals') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">Total Prestasi</label>
                <input type="number" name="total_achievements" min="0"
                    class="form-control @error('total_achievements') is-invalid @enderror"
                    value="{{ old('total_achievements', $member->total_achievements ?? 0) }}">
                @error('total_achievements') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-12">
                <hr class="my-1">
                <p class="text-secondary fw-bold mb-2" style="font-size:0.82rem; text-transform:uppercase; letter-spacing:.04em;">
                    Kontak &amp; Sosial Media Pribadi
                </p>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">Nomor WhatsApp</label>
                <input type="text" name="whatsapp" class="form-control @error('whatsapp') is-invalid @enderror"
                    value="{{ old('whatsapp', $member->whatsapp) }}" placeholder="6281234567890">
                @error('whatsapp') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">Instagram</label>
                <input type="url" name="instagram_url" class="form-control @error('instagram_url') is-invalid @enderror"
                    value="{{ old('instagram_url', $member->instagram_url) }}" placeholder="https://instagram.com/username">
                @error('instagram_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">Facebook</label>
                <input type="url" name="facebook_url" class="form-control @error('facebook_url') is-invalid @enderror"
                    value="{{ old('facebook_url', $member->facebook_url) }}" placeholder="https://facebook.com/username">
                @error('facebook_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">TikTok</label>
                <input type="url" name="tiktok_url" class="form-control @error('tiktok_url') is-invalid @enderror"
                    value="{{ old('tiktok_url', $member->tiktok_url) }}" placeholder="https://tiktok.com/@username">
                @error('tiktok_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-12">
                <hr class="my-1">
            </div>

            <div class="col-12">
                <label class="form-label fw-bold">Deskripsi / Bio</label>
                <textarea name="bio" rows="4" class="form-control @error('bio') is-invalid @enderror"
                    placeholder="Ceritakan sedikit tentang atlet/pelatih ini...">{{ old('bio', $member->bio) }}</textarea>
                @error('bio') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">Urutan Tampil</label>
                <input type="number" name="sort_order" min="0" class="form-control @error('sort_order') is-invalid @enderror"
                    value="{{ old('sort_order', $member->sort_order ?? 0) }}">
                <small class="text-secondary" style="font-size:0.78rem;">Angka lebih kecil tampil lebih dulu.</small>
            </div>

            <div class="col-md-6 d-flex align-items-center">
                <div class="form-check mt-4">
                    <input type="checkbox" name="is_active" value="1" class="form-check-input" id="isActive"
                        {{ old('is_active', $member->is_active ?? true) ? 'checked' : '' }}>
                    <label class="form-check-label fw-bold" for="isActive">
                        Aktif (tampil di website)
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>