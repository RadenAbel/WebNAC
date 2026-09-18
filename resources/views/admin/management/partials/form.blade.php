@csrf

<div class="row g-3">
    <div class="col-lg-4">
        <label class="form-label">Foto @if(!$member->exists)<span class="text-danger">*</span>@endif</label>
        <div class="border rounded-3 p-3 text-center" style="background:#fafbfc;">
            <img
                src="{{ $member->photo_url ?? asset('images/default-avatar.jpg') }}"
                alt="Preview foto"
                id="managementPhotoPreview"
                class="rounded-3 mb-2"
                style="width:100%; aspect-ratio:4/5; object-fit:cover;">
            <input
                type="file"
                name="photo"
                accept="image/png, image/jpeg, image/webp"
                class="form-control form-control-sm @error('photo') is-invalid @enderror"
                onchange="document.getElementById('managementPhotoPreview').src = window.URL.createObjectURL(this.files[0])"
                @if(!$member->exists) required @endif>
            @error('photo') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
            @if($member->exists)
                <p class="text-secondary mt-2 mb-0" style="font-size:0.78rem;">Kosongkan kalau tidak ingin ganti foto.</p>
            @endif
        </div>
    </div>

    <div class="col-lg-8">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Nama <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name', $member->name) }}" required>
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">Jabatan <span class="text-danger">*</span></label>
                <input type="text" name="position" class="form-control @error('position') is-invalid @enderror"
                    value="{{ old('position', $member->position) }}" placeholder="Ketua Umum & Pendiri" required>
                @error('position') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-12">
                <label class="form-label">
                    Ringkasan Singkat
                    <i class="bi bi-info-circle text-secondary" title="Tampil di kartu daftar halaman Tentang Kami"></i>
                </label>
                <textarea name="short_bio" rows="2" class="form-control @error('short_bio') is-invalid @enderror"
                    placeholder="1-2 kalimat ringkas, tampil di kartu daftar.">{{ old('short_bio', $member->short_bio) }}</textarea>
                @error('short_bio') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-12">
                <label class="form-label">
                    Bio Lengkap
                    <i class="bi bi-info-circle text-secondary" title="Tampil di modal 'Learn more'. Bisa diformat: bold, italic, list, dst."></i>
                </label>
                <div id="fullBioEditor" style="height:260px; background:#fff;" class="@error('full_bio') is-invalid @enderror"></div>
                {{-- Textarea asli disembunyikan — dipakai buat nyimpen hasil HTML dari
                     editor, ini yang beneran dikirim ke server saat form disubmit. --}}
                <textarea name="full_bio" id="fullBioInput" class="d-none">{{ old('full_bio', $member->full_bio) }}</textarea>
                @error('full_bio') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                <small class="text-secondary">Pakai toolbar di atas buat bold, italic, list, dst. Tekan Enter untuk paragraf baru.</small>
            </div>
            <div class="col-md-6">
                <label class="form-label">Urutan Tampil</label>
                <input type="number" name="sort_order" min="0" class="form-control @error('sort_order') is-invalid @enderror"
                    value="{{ old('sort_order', $member->sort_order ?? 0) }}">
                @error('sort_order') <div class="invalid-feedback">{{ $message }}</div> @enderror
                <small class="text-secondary">Angka kecil tampil lebih dulu.</small>
            </div>
            <div class="col-md-6 d-flex align-items-end">
                <div class="form-check form-switch">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" id="isActiveSwitch" class="form-check-input"
                        {{ old('is_active', $member->is_active ?? true) ? 'checked' : '' }}>
                    <label for="isActiveSwitch" class="form-check-label">Tampilkan di halaman Tentang Kami</label>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet">
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
    <script>
        (function () {
            var editorEl = document.getElementById('fullBioEditor');
            var hiddenInput = document.getElementById('fullBioInput');
            if (!editorEl || !hiddenInput) return;

            var quill = new Quill(editorEl, {
                theme: 'snow',
                placeholder: 'Tulis bio lengkap di sini...',
                modules: {
                    toolbar: [
                        ['bold', 'italic', 'underline'],
                        [{ list: 'ordered' }, { list: 'bullet' }],
                        ['link'],
                        ['clean'],
                    ],
                },
            });

            // Mode edit: isi editor dengan HTML yang sudah tersimpan sebelumnya
            if (hiddenInput.value.trim() !== '') {
                quill.clipboard.dangerouslyPasteHTML(hiddenInput.value);
            }

            // Begitu form mau dikirim, salin HTML dari editor ke textarea
            // tersembunyi dulu — supaya yang benar-benar terkirim ke server
            // adalah hasil format lengkapnya (bold/italic/list/dst), bukan
            // textarea yang kosong.
            var form = hiddenInput.closest('form');
            if (form) {
                form.addEventListener('submit', function () {
                    hiddenInput.value = quill.root.innerHTML;
                });
            }
        })();
    </script>
@endpush