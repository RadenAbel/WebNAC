@csrf

@php $isVideo = old('type', $gallery->type ?? 'photo') === 'video'; @endphp

<div class="row g-4">
    <div class="col-lg-4">
        <div class="nac-admin-form-section h-100 mb-0">
            <div class="nac-admin-form-section__head">
                <span class="nac-admin-form-section__icon"><i class="bi bi-collection-play"></i></span>
                <div>
                    <p class="nac-admin-form-section__title">Jenis Konten</p>
                </div>
            </div>

            <div class="btn-group w-100 mb-3" role="group">
                <input type="radio" class="btn-check" name="type" id="typePhoto" value="photo" autocomplete="off" {{ $isVideo ? '' : 'checked' }}>
                <label class="btn btn-outline-secondary" for="typePhoto"><i class="bi bi-image"></i> Foto</label>

                <input type="radio" class="btn-check" name="type" id="typeVideo" value="video" autocomplete="off" {{ $isVideo ? 'checked' : '' }}>
                <label class="btn btn-outline-secondary" for="typeVideo"><i class="bi bi-youtube"></i> Video</label>
            </div>
            @error('type') <div class="text-danger mb-2" style="font-size:0.8rem;">{{ $message }}</div> @enderror

            {{-- ---------- Panel: Foto ---------- --}}
            <div id="photoPanel" style="{{ $isVideo ? 'display:none;' : '' }}">
                <p class="nac-admin-form-section__desc mb-2">JPG/PNG/WEBP, maks 3MB</p>
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
                        <input type="file" name="image" accept="image/png, image/jpeg, image/webp" data-photo-input="photoPreview">
                    </label>
                </div>
                @error('image') <div class="text-danger mt-2" style="font-size:0.8rem;">{{ $message }}</div> @enderror
            </div>

            {{-- ---------- Panel: Video ---------- --}}
            <div id="videoPanel" style="{{ $isVideo ? '' : 'display:none;' }}">
                <label class="form-label">Link YouTube</label>
                <input type="text" name="youtube_url" class="form-control @error('youtube_url') is-invalid @enderror"
                    value="{{ old('youtube_url', $gallery->youtube_url) }}" placeholder="https://www.youtube.com/watch?v=...">
                @error('youtube_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                <small class="text-secondary">Thumbnail diambil otomatis dari YouTube, tidak perlu upload gambar.</small>
                @if($gallery->exists && $gallery->type === 'video' && $gallery->youtube_thumbnail_url)
                    <img src="{{ $gallery->youtube_thumbnail_url }}" class="rounded-3 mt-2 w-100" alt="Thumbnail YouTube">
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="nac-admin-form-section mb-0">
            <div class="nac-admin-form-section__head">
                <span class="nac-admin-form-section__icon"><i class="bi bi-card-text"></i></span>
                <div>
                    <p class="nac-admin-form-section__title">Detail</p>
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

@push('scripts')
<script>
    (function () {
        var typePhoto = document.getElementById('typePhoto');
        var typeVideo = document.getElementById('typeVideo');
        var photoPanel = document.getElementById('photoPanel');
        var videoPanel = document.getElementById('videoPanel');
        if (!typePhoto || !typeVideo) return;

        function sync() {
            var isVideo = typeVideo.checked;
            photoPanel.style.display = isVideo ? 'none' : '';
            videoPanel.style.display = isVideo ? '' : 'none';
        }
        typePhoto.addEventListener('change', sync);
        typeVideo.addEventListener('change', sync);
    })();
</script>
@endpush