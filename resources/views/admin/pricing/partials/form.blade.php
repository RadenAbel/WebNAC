@csrf

<div class="row g-4">
    <div class="col-md-6">
        <label class="form-label">Nama Paket <span class="text-danger">*</span></label>
        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
            value="{{ old('title', $plan->title) }}" placeholder="Novato" required>
        @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">Urutan Tampil</label>
        <input type="number" name="sort_order" min="0" class="form-control @error('sort_order') is-invalid @enderror"
            value="{{ old('sort_order', $plan->sort_order ?? 0) }}">
        @error('sort_order') <div class="invalid-feedback">{{ $message }}</div> @enderror
        <small class="text-secondary">Angka lebih kecil tampil lebih dulu (dari kiri).</small>
    </div>

    <div class="col-12">
        <label class="form-label">Deskripsi Singkat</label>
        <input type="text" name="description" class="form-control @error('description') is-invalid @enderror"
            value="{{ old('description', $plan->description) }}" placeholder="Level pemula yang baru ingin belajar renang.">
        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">Harga per Bulan (Rp) <span class="text-danger">*</span></label>
        <input type="number" name="price" min="0" class="form-control @error('price') is-invalid @enderror"
            value="{{ old('price', $plan->price) }}" placeholder="460000" required>
        @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
        <small class="text-secondary">Angka saja, tanpa titik/koma (mis. 460000 untuk Rp460.000).</small>
    </div>

    <div class="col-md-6">
        <label class="form-label">Diskon (%)</label>
        <input type="number" name="discount_percent" min="1" max="100" class="form-control @error('discount_percent') is-invalid @enderror"
            value="{{ old('discount_percent', $plan->discount_percent) }}" placeholder="Kosongkan kalau tidak ada diskon">
        @error('discount_percent') <div class="invalid-feedback">{{ $message }}</div> @enderror
        <small class="text-secondary">Kalau diisi, harga asli akan dicoret dan harga diskon + persennya ikut tampil di halaman publik.</small>
    </div>

    <div class="col-12">
        <label class="form-label">Daftar Fitur</label>
        <textarea name="features" rows="4" class="form-control @error('features') is-invalid @enderror"
            placeholder="2x latihan per minggu&#10;Pengenalan teknik dasar&#10;Pendampingan pelatih junior">{{ old('features', $plan->features) }}</textarea>
        @error('features') <div class="invalid-feedback">{{ $message }}</div> @enderror
        <small class="text-secondary">1 baris = 1 poin fitur (tekan Enter untuk poin baru).</small>
    </div>

    <div class="col-md-6">
        <div class="form-check">
            <input type="checkbox" name="is_highlighted" value="1" class="form-check-input" id="isHighlighted"
                {{ old('is_highlighted', $plan->is_highlighted) ? 'checked' : '' }}>
            <label class="form-check-label" for="isHighlighted">
                Tandai "Paling Diminati" <span class="text-secondary">(badge di pojok kartu)</span>
            </label>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-check">
            <input type="checkbox" name="is_active" value="1" class="form-check-input" id="isActive"
                {{ old('is_active', $plan->exists ? $plan->is_active : true) ? 'checked' : '' }}>
            <label class="form-check-label" for="isActive">Tampilkan di halaman publik</label>
        </div>
    </div>
</div>

<div class="mt-4">
    <button type="submit" class="btn nac-admin-btn">
        <i class="bi bi-check-lg"></i> {{ $plan->exists ? 'Simpan Perubahan' : 'Tambah Paket' }}
    </button>
    <a href="{{ route('admin.pricing.index') }}" class="btn btn-outline-secondary">Batal</a>
</div>