@csrf

<div class="row g-4">
    <div class="col-lg-5">
        <div class="nac-admin-form-section h-100 mb-0">
            <div class="nac-admin-form-section__head">
                <span class="nac-admin-form-section__icon"><i class="bi bi-image"></i></span>
                <div>
                    <p class="nac-admin-form-section__title">Foto Hasil Pertandingan @if(!$event->exists)<span class="text-danger">*</span>@endif</p>
                    <p class="nac-admin-form-section__desc">JPG/PNG/WEBP, maks 8MB (otomatis dikompres)</p>
                </div>
            </div>

            <div class="nac-admin-dropzone" data-dropzone>
                <img
                    src="{{ $event->exists && $event->photo_url ? $event->photo_url : '' }}"
                    alt="Preview foto acara"
                    id="photoPreview"
                    class="nac-admin-dropzone__preview"
                    style="aspect-ratio:4/3; {{ $event->exists && $event->photo_url ? '' : 'display:none;' }}">

                <label class="nac-admin-dropzone__overlay" style="{{ $event->exists && $event->photo_url ? '' : 'aspect-ratio:4/3; border-top:none; flex-direction:column;' }}">
                    <i class="bi bi-cloud-arrow-up"></i>
                    <span>{{ $event->exists && $event->photo_url ? 'Ganti Foto' : 'Klik untuk upload foto' }}</span>
                    <input type="file" name="photo" accept="image/png, image/jpeg, image/webp"
                        data-photo-input="photoPreview" {{ $event->exists ? '' : 'required' }}>
                </label>
            </div>
            @error('photo')
                <div class="text-danger mt-2" style="font-size:0.8rem;">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-lg-7">
        <div class="nac-admin-form-section">
            <div class="nac-admin-form-section__head">
                <span class="nac-admin-form-section__icon"><i class="bi bi-card-text"></i></span>
                <div>
                    <p class="nac-admin-form-section__title">Detail Hasil Pertandingan</p>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label">Nama Kejuaraan <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                        value="{{ old('title', $event->title) }}" placeholder="Kejuaraan Renang Antar Klub 2026" required>
                    @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Tanggal Kejuaraan <span class="text-danger">*</span></label>
                    <input type="date" name="event_date" class="form-control @error('event_date') is-invalid @enderror"
                        value="{{ old('event_date', $event->event_date ? $event->event_date->format('Y-m-d') : '') }}" required>
                    @error('event_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Lokasi / Venue</label>
                    <input type="text" name="location" class="form-control @error('location') is-invalid @enderror"
                        value="{{ old('location', $event->location) }}" placeholder="Everglade Aquatic Center, Sangatta">
                    @error('location') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-12">
                    <label class="form-label">Deskripsi Singkat</label>
                    <textarea name="description" rows="4" class="form-control @error('description') is-invalid @enderror"
                        placeholder="Ceritakan sedikit tentang acara ini...">{{ old('description', $event->description) }}</textarea>
                    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
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
                        value="{{ old('sort_order', $event->sort_order ?? 0) }}">
                    <small class="text-secondary">Angka lebih kecil tampil lebih dulu.</small>
                </div>
                <div class="col-md-6 d-flex align-items-end">
                    <div class="form-check form-switch">
                        <input type="checkbox" name="is_active" value="1" class="form-check-input" id="isActive" role="switch"
                            {{ old('is_active', $event->is_active ?? true) ? 'checked' : '' }}>
                        <label class="form-check-label fw-bold" for="isActive">Aktif (tampil di website)</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
