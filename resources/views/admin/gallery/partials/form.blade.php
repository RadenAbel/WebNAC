@csrf

<div class="row g-4">
    <div class="col-lg-4">
        <div class="nac-admin-form-section h-100 mb-0">
            <div class="nac-admin-form-section__head">
                <span class="nac-admin-form-section__icon"><i class="bi bi-image"></i></span>
                <div>
                    <p class="nac-admin-form-section__title">Foto @if(!$gallery->exists)<span class="text-danger">*</span>@endif</p>
                    <p class="nac-admin-form-section__desc">JPG/PNG/WEBP, maks 3MB</p>
                </div>
            </div>

            <div class="nac-admin-dropzone" data-dropzone>
                <img
                    src="{{ $gallery->exists && $gallery->image ? $gallery->image_url : '' }}"
                    alt="Preview foto"
                    id="photoPreview"
                    class="nac-admin-dropzone__preview"
                    style="aspect-ratio:4/5; {{ $gallery->exists && $gallery->image ? '' : 'display:none;' }}">

                <label class="nac-admin-dropzone__overlay" style="{{ $gallery->exists && $gallery->image ? '' : 'aspect-ratio:4/5; border-top:none; flex-direction:column;' }}">
                    <i class="bi bi-cloud-arrow-up"></i>
                    <span>{{ $gallery->exists && $gallery->image ? 'Ganti Foto' : 'Klik untuk upload foto' }}</span>
                    <input type="file" name="image" accept="image/png, image/jpeg, image/webp"
                        data-photo-input="photoPreview" {{ $gallery->exists ? '' : 'required' }}>
                </label>
            </div>
            @error('image')
                <div class="text-danger mt-2" style="font-size:0.8rem;">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-lg-8">
        <div class="nac-admin-form-section mb-0">
            <div class="nac-admin-form-section__head">
                <span class="nac-admin-form-section__icon"><i class="bi bi-card-text"></i></span>
                <div>
                    <p class="nac-admin-form-section__title">Detail Foto</p>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label">Caption</label>
                    <input type="text" name="caption" class="form-control @error('caption') is-invalid @enderror"
                        value="{{ old('caption', $gallery->caption) }}" placeholder="Latihan Pagi">
                    @error('caption') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Urutan Tampil</label>
                    <input type="number" name="sort_order" min="0" class="form-control @error('sort_order') is-invalid @enderror"
                        value="{{ old('sort_order', $gallery->sort_order ?? 0) }}">
                    <small class="text-secondary">Angka lebih kecil tampil lebih dulu.</small>
                </div>

                <div class="col-md-6 d-flex align-items-end">
                    <div class="form-check form-switch">
                        <input type="checkbox" name="is_active" value="1" class="form-check-input" id="isActive" role="switch"
                            {{ old('is_active', $gallery->is_active ?? true) ? 'checked' : '' }}>
                        <label class="form-check-label fw-bold" for="isActive">Aktif (tampil di website)</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>