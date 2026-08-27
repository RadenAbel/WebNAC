@csrf

<div class="row g-4">
    <div class="col-lg-4">
        <label class="form-label fw-bold">Foto Slider @if(!$slider->exists)<span class="text-danger">*</span>@endif</label>

        <div class="border rounded-3 p-3 text-center mb-2" style="background:#fafbfc;">
            <img
                src="{{ $slider->exists && $slider->image ? $slider->image_url : asset('images/default-avatar.jpg') }}"
                alt="Preview foto slider"
                id="photoPreview"
                class="rounded-3 mb-2"
                style="width:100%; aspect-ratio:16/9; object-fit:cover;">

            <input
                type="file"
                name="image"
                accept="image/png, image/jpeg, image/webp"
                class="form-control form-control-sm @error('image') is-invalid @enderror"
                onchange="document.getElementById('photoPreview').src = window.URL.createObjectURL(this.files[0])"
                {{ $slider->exists ? '' : 'required' }}>

            @error('image')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror

            <small class="text-secondary d-block mt-1" style="font-size:0.78rem;">
                Rasio 16:9 disarankan (mis. 1600x900px). JPG/PNG/WEBP, maks 3MB.
            </small>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="row g-3">
            <div class="col-12">
                <label class="form-label fw-bold">Judul</label>
                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                    value="{{ old('title', $slider->title) }}" placeholder="Setiap tarikan napas, setiap detik berarti.">
                @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-12">
                <label class="form-label fw-bold">Subjudul</label>
                <textarea name="subtitle" rows="2" class="form-control @error('subtitle') is-invalid @enderror"
                    placeholder="Kolam renang standar kompetisi dengan pelatih bersertifikat nasional.">{{ old('subtitle', $slider->subtitle) }}</textarea>
                @error('subtitle') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">Teks Tombol</label>
                <input type="text" name="button_text" class="form-control @error('button_text') is-invalid @enderror"
                    value="{{ old('button_text', $slider->button_text) }}" placeholder="Daftar Latihan">
                @error('button_text') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">Link Tombol</label>
                <input type="text" name="button_url" class="form-control @error('button_url') is-invalid @enderror"
                    value="{{ old('button_url', $slider->button_url) }}" placeholder="#biaya atau https://...">
                @error('button_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">Urutan Tampil</label>
                <input type="number" name="sort_order" min="0" class="form-control @error('sort_order') is-invalid @enderror"
                    value="{{ old('sort_order', $slider->sort_order ?? 0) }}">
                <small class="text-secondary" style="font-size:0.78rem;">Angka lebih kecil tampil lebih dulu.</small>
            </div>

            <div class="col-md-6 d-flex align-items-center">
                <div class="form-check mt-4">
                    <input type="checkbox" name="is_active" value="1" class="form-check-input" id="isActive"
                        {{ old('is_active', $slider->is_active ?? true) ? 'checked' : '' }}>
                    <label class="form-check-label fw-bold" for="isActive">Aktif (tampil di website)</label>
                </div>
            </div>
        </div>
    </div>
</div>