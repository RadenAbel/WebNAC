@csrf

<div class="row g-4">
    <div class="col-lg-5">
        <label class="form-label">Foto Fasilitas</label>
        <div class="border rounded-3 p-3 text-center" style="background:#fafbfc;">
            <img src="{{ $facility->photo_url }}" alt="Preview foto fasilitas" id="facilityPhotoPreview"
                class="rounded-3 mb-2" style="width:100%; aspect-ratio:4/3; object-fit:cover; {{ $facility->photo_url ? '' : 'display:none;' }}">
            <input type="file" name="photo" accept="image/png, image/jpeg, image/webp"
                data-photo-input="facilityPhotoPreview"
                class="form-control form-control-sm @error('photo') is-invalid @enderror">
            @error('photo') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
            <small class="text-secondary d-block mt-1">JPG/PNG/WEBP, maks 8MB. Otomatis dikompres. Disarankan foto mendatar (landscape).</small>
        </div>
    </div>

    <div class="col-lg-7">
        <div class="row g-3">
            <div class="col-md-8">
                <label class="form-label">Nama Fasilitas <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name', $facility->name) }}" placeholder="Kolam 50 Meter" required>
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-4">
                <label class="form-label">Urutan Tampil</label>
                <input type="number" name="sort_order" min="0" class="form-control @error('sort_order') is-invalid @enderror"
                    value="{{ old('sort_order', $facility->sort_order ?? 0) }}">
                @error('sort_order') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-12">
                <label class="form-label">Penjelasan</label>
                <textarea name="description" rows="4" class="form-control @error('description') is-invalid @enderror"
                    placeholder="Jelaskan fasilitas ini secara singkat.">{{ old('description', $facility->description) }}</textarea>
                @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-12">
                <label class="form-label">Poin Keunggulan <span class="text-secondary fw-normal">(opsional)</span></label>
                <textarea name="highlights" rows="3" class="form-control @error('highlights') is-invalid @enderror"
                    placeholder="Panjang 50 meter&#10;Air disaring setiap hari">{{ old('highlights', $facility->highlights) }}</textarea>
                @error('highlights') <div class="invalid-feedback">{{ $message }}</div> @enderror
                <small class="text-secondary">1 baris = 1 poin (tekan Enter untuk poin baru).</small>
            </div>

            <div class="col-12">
                <div class="form-check">
                    <input type="checkbox" name="is_active" value="1" class="form-check-input" id="facilityActive"
                        {{ old('is_active', $facility->exists ? $facility->is_active : true) ? 'checked' : '' }}>
                    <label class="form-check-label" for="facilityActive">Tampilkan di halaman Tentang Kami</label>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mt-4">
    <button type="submit" class="btn nac-admin-btn">
        <i class="bi bi-check-lg"></i> {{ $facility->exists ? 'Simpan Perubahan' : 'Tambah Fasilitas' }}
    </button>
    <a href="{{ route('admin.facilities.index') }}" class="btn btn-outline-secondary">Batal</a>
</div>