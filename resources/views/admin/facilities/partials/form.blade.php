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
                <textarea name="highlights" rows="4" id="facilityHighlights" class="form-control @error('highlights') is-invalid @enderror"
                    placeholder="[kolam] Standar Olimpiade | Panjang 50 meter dengan 10 lintasan&#10;[air] Air Selalu Bersih | Air disaring setiap hari">{{ old('highlights', $facility->highlights) }}</textarea>
                @error('highlights') <div class="invalid-feedback">{{ $message }}</div> @enderror
                <small class="text-secondary d-block">
                    1 baris = 1 poin. Format: <code>[ikon] Subjudul | Penjelasan</code> (ikon &amp; penjelasan opsional, default ikon centang).
                </small>

                <div class="facility-icon-picker mt-2" data-icon-picker>
                    <button type="button" class="btn btn-sm btn-outline-secondary facility-icon-picker__toggle"
                        data-icon-picker-toggle aria-expanded="false" aria-haspopup="true">
                        <i class="fa-solid fa-icons"></i> Pilih ikon <i class="bi bi-chevron-down small"></i>
                    </button>
                    <small class="text-secondary ms-2">Dipasang di baris tempat kursor berada.</small>

                    <div class="facility-icon-picker__menu" data-icon-picker-menu hidden>
                        @foreach (\App\Models\Facility::HIGHLIGHT_ICONS as $key => [$iconClass, $label])
                            <button type="button" class="facility-icon-picker__item" data-icon-key="{{ $key }}" title="[{{ $key }}]">
                                <i class="{{ $iconClass }}"></i>
                                <span>{{ $label }}</span>
                            </button>
                        @endforeach
                    </div>
                </div>
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

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.2/css/all.min.css">
<style>
    .facility-icon-picker { position: relative; }
    .facility-icon-picker__menu {
        position: absolute; top: calc(100% + .35rem); left: 0; z-index: 20;
        width: min(420px, 100%);
        max-height: 260px; overflow-y: auto;
        display: grid; grid-template-columns: repeat(auto-fill, minmax(120px, 1fr)); gap: .25rem;
        padding: .5rem; background: #fff;
        border: 1px solid #dee2e6; border-radius: 10px;
        box-shadow: 0 10px 28px rgba(15, 30, 45, .12);
    }
    .facility-icon-picker__menu[hidden] { display: none; }
    .facility-icon-picker__item {
        display: flex; align-items: center; gap: .5rem;
        padding: .4rem .55rem; border: 0; border-radius: 7px;
        background: transparent; font-size: .82rem; color: #495057; text-align: left; cursor: pointer;
    }
    .facility-icon-picker__item i { width: 1.1rem; text-align: center; color: #0d7c8c; }
    .facility-icon-picker__item:hover,
    .facility-icon-picker__item:focus-visible { background: #eef9fa; outline: none; }
</style>
@endpush

@push('scripts')
<script>
    (function () {
        var textarea = document.getElementById('facilityHighlights');
        var picker = document.querySelector('[data-icon-picker]');
        if (!textarea || !picker) return;

        var toggle = picker.querySelector('[data-icon-picker-toggle]');
        var menu = picker.querySelector('[data-icon-picker-menu]');

        function setOpen(open) {
            menu.hidden = !open;
            toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
        }

        toggle.addEventListener('click', function () { setOpen(menu.hidden); });
        document.addEventListener('click', function (e) {
            if (!picker.contains(e.target)) setOpen(false);
        });
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && !menu.hidden) { setOpen(false); toggle.focus(); }
        });

        menu.querySelectorAll('.facility-icon-picker__item').forEach(function (btn) {
            btn.addEventListener('click', function () {
                setOpen(false);
                var value = textarea.value;
                var pos = textarea.selectionStart;
                var start = value.lastIndexOf('\n', pos - 1) + 1;
                var end = value.indexOf('\n', pos);
                if (end === -1) end = value.length;

                // Ganti tag ikon yang sudah ada di baris ini, atau tambahkan di depan.
                var line = value.slice(start, end).replace(/^\s*\[[\w-]+\]\s*/, '');
                var newLine = '[' + btn.dataset.iconKey + '] ' + line;

                textarea.value = value.slice(0, start) + newLine + value.slice(end);
                textarea.focus();
                var caret = start + newLine.length;
                textarea.setSelectionRange(caret, caret);
            });
        });
    })();
</script>
@endpush
