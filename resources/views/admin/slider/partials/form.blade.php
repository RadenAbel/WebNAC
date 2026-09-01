@csrf

<div class="row g-4">
    <div class="col-lg-5">
        <div class="nac-admin-form-section h-100 mb-0">
            <div class="nac-admin-form-section__head">
                <span class="nac-admin-form-section__icon"><i class="bi bi-image"></i></span>
                <div>
                    <p class="nac-admin-form-section__title">Foto Slider @if(!$slider->exists)<span class="text-danger">*</span>@endif</p>
                    <p class="nac-admin-form-section__desc">Rasio 16:9 disarankan, maks 3MB</p>
                </div>
            </div>

            <div class="nac-admin-dropzone" data-dropzone>
                <img
                    src="{{ $slider->exists && $slider->image ? $slider->image_url : '' }}"
                    alt="Preview foto slider"
                    id="photoPreview"
                    class="nac-admin-dropzone__preview"
                    style="aspect-ratio:16/9; {{ $slider->exists && $slider->image ? '' : 'display:none;' }}">

                <label class="nac-admin-dropzone__overlay" style="{{ $slider->exists && $slider->image ? '' : 'aspect-ratio:16/9; border-top:none; flex-direction:column;' }}">
                    <i class="bi bi-cloud-arrow-up"></i>
                    <span>{{ $slider->exists && $slider->image ? 'Ganti Foto' : 'Klik untuk upload foto' }}</span>
                    <input type="file" name="image" accept="image/png, image/jpeg, image/webp"
                        data-photo-input="photoPreview" {{ $slider->exists ? '' : 'required' }}>
                </label>
            </div>
            @error('image')
                <div class="text-danger mt-2" style="font-size:0.8rem;">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-lg-7">
        <div class="nac-admin-form-section">
            <div class="nac-admin-form-section__head">
                <span class="nac-admin-form-section__icon"><i class="bi bi-card-text"></i></span>
                <div>
                    <p class="nac-admin-form-section__title">Konten Slide</p>
                    <p class="nac-admin-form-section__desc">Teks yang tampil di atas foto</p>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label">Judul</label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                        value="{{ old('title', $slider->title) }}" placeholder="Setiap tarikan napas, setiap detik berarti.">
                    @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-12">
                    <label class="form-label">Subjudul</label>
                    <textarea name="subtitle" rows="2" class="form-control @error('subtitle') is-invalid @enderror"
                        placeholder="Kolam renang standar kompetisi dengan pelatih bersertifikat nasional.">{{ old('subtitle', $slider->subtitle) }}</textarea>
                    @error('subtitle') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Teks Tombol</label>
                    <input type="text" name="button_text" class="form-control @error('button_text') is-invalid @enderror"
                        value="{{ old('button_text', $slider->button_text) }}" placeholder="Daftar Latihan">
                    @error('button_text') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Link Tombol</label>
                    <input type="text" name="button_url" class="form-control @error('button_url') is-invalid @enderror"
                        value="{{ old('button_url', $slider->button_url) }}" placeholder="#biaya atau https://...">
                    @error('button_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>

        <div class="nac-admin-form-section mb-0">
            <div class="nac-admin-form-section__head">
                <span class="nac-admin-form-section__icon"><i class="bi bi-sliders"></i></span>
                <div>
                    <p class="nac-admin-form-section__title">Tampilan</p>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Urutan Tampil</label>
                    <input type="number" name="sort_order" min="0" class="form-control @error('sort_order') is-invalid @enderror"
                        value="{{ old('sort_order', $slider->sort_order ?? 0) }}">
                    <small class="text-secondary">Angka lebih kecil tampil lebih dulu.</small>
                </div>
                <div class="col-md-6 d-flex align-items-end">
                    <div class="form-check form-switch">
                        <input type="checkbox" name="is_active" value="1" class="form-check-input" id="isActive" role="switch"
                            {{ old('is_active', $slider->is_active ?? true) ? 'checked' : '' }}>
                        <label class="form-check-label fw-bold" for="isActive">Aktif (tampil di website)</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>