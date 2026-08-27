@csrf

<div class="row g-4">
    <div class="col-lg-4">
        <label class="form-label fw-bold">Foto @if(!$gallery->exists)<span class="text-danger">*</span>@endif</label>

        <div class="border rounded-3 p-3 text-center mb-2" style="background:#fafbfc;">
            <img
                src="{{ $gallery->exists && $gallery->image ? $gallery->image_url : asset('images/default-avatar.jpg') }}"
                alt="Preview foto"
                id="photoPreview"
                class="rounded-3 mb-2"
                style="width:100%; aspect-ratio:4/5; object-fit:cover;">

            <input
                type="file"
                name="image"
                accept="image/png, image/jpeg, image/webp"
                class="form-control form-control-sm @error('image') is-invalid @enderror"
                onchange="document.getElementById('photoPreview').src = window.URL.createObjectURL(this.files[0])"
                {{ $gallery->exists ? '' : 'required' }}>

            @error('image')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror

            <small class="text-secondary d-block mt-1" style="font-size:0.78rem;">
                JPG/PNG/WEBP, maks 3MB.
            </small>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="row g-3">
            <div class="col-12">
                <label class="form-label fw-bold">Caption</label>
                <input type="text" name="caption" class="form-control @error('caption') is-invalid @enderror"
                    value="{{ old('caption', $gallery->caption) }}" placeholder="Latihan Pagi">
                @error('caption') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">Urutan Tampil</label>
                <input type="number" name="sort_order" min="0" class="form-control @error('sort_order') is-invalid @enderror"
                    value="{{ old('sort_order', $gallery->sort_order ?? 0) }}">
                <small class="text-secondary" style="font-size:0.78rem;">Angka lebih kecil tampil lebih dulu.</small>
            </div>

            <div class="col-md-6 d-flex align-items-center">
                <div class="form-check mt-4">
                    <input type="checkbox" name="is_active" value="1" class="form-check-input" id="isActive"
                        {{ old('is_active', $gallery->is_active ?? true) ? 'checked' : '' }}>
                    <label class="form-check-label fw-bold" for="isActive">Aktif (tampil di website)</label>
                </div>
            </div>
        </div>
    </div>
</div>