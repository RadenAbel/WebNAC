@extends('layouts.app')

@section('title', 'Join Us — NAC Swim School')
@section('meta_description', 'Formulir pendaftaran NAC Swim School — sekolah renang Nugroho Aquatic Club di Sangatta Utara, Kutai Timur.')

@section('content')

<section class="nac-page-header">
    <div class="container text-center" data-aos="fade-up">
        <span class="nac-page-header__icon"><i class="fa-solid fa-user-plus"></i></span>
        <span class="nac-eyebrow">Join Us</span>
        <h1 class="nac-page-header__title">Mulai perjalanan renangmu bersama kami.</h1>
        <p class="nac-page-header__desc">
            Isi formulir pendaftaran di bawah ini — tim kami akan segera menghubungi Anda.
        </p>
    </div>
</section>

<section class="nac-section nac-join-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">

                {{-- ============ FORM PENDAFTARAN ============ --}}
                @if (session('status'))
                    <div class="nac-join-alert nac-join-alert--success" data-aos="fade-up">
                        <i class="fa-solid fa-circle-check"></i>
                        <span>{{ session('status') }}</span>
                    </div>
                @endif

                <div class="nac-join-card" data-aos="fade-up">
                    <span class="nac-eyebrow">Formulir Pendaftaran</span>
                    <h3 class="nac-join-card__title">Data Calon Murid</h3>

                    <form action="{{ route('join.store') }}" method="POST" enctype="multipart/form-data" novalidate class="mt-4">
                        @csrf
                        <div class="row g-5">

                            {{-- ---- Kolom foto ---- --}}
                            <div class="col-lg-4 text-center nac-join-photo-col">
                                <label class="nac-join-label d-block">Pas Foto Murid</label>
                                <div class="nac-join-photo-upload nac-join-photo-upload--lg" id="joinPhotoDrop">
                                    <img id="joinPhotoPreview" alt="Preview foto" class="nac-join-photo-upload__preview" style="display:none;">
                                    <div class="nac-join-photo-upload__empty" id="joinPhotoEmpty">
                                        <i class="fa-solid fa-camera"></i>
                                        <span>Klik untuk unggah foto</span>
                                    </div>
                                    <input type="file" name="photo" id="joinPhotoInput" accept="image/png, image/jpeg, image/webp"
                                           class="nac-join-photo-upload__input @error('photo') is-invalid @enderror"
                                           onchange="nacPreviewJoinPhoto(this)">
                                </div>
                                <small class="nac-join-hint d-block">JPG/PNG/WEBP, maks 2MB (opsional — boleh menyusul).</small>
                                @error('photo') <div class="nac-join-error">{{ $message }}</div> @enderror
                            </div>

                            {{-- ---- Kolom field ---- --}}
                            <div class="col-lg-8">
                                <div class="row g-4">

                                    <div class="col-md-6">
                                        <label class="nac-join-label">Nama Lengkap <span class="text-danger">*</span></label>
                                        <input type="text" name="name" class="nac-join-input @error('name') is-invalid @enderror"
                                               value="{{ old('name') }}" required>
                                        @error('name') <div class="nac-join-error">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="nac-join-label">Nama Panggilan</label>
                                        <input type="text" name="nickname" class="nac-join-input @error('nickname') is-invalid @enderror"
                                               value="{{ old('nickname') }}" placeholder="Opsional">
                                        @error('nickname') <div class="nac-join-error">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="nac-join-label">Tanggal Lahir <span class="text-danger">*</span></label>
                                        <input type="date" name="birth_date" class="nac-join-input @error('birth_date') is-invalid @enderror"
                                               value="{{ old('birth_date') }}" max="{{ now()->toDateString() }}" required>
                                        @error('birth_date') <div class="nac-join-error">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="nac-join-label">No. WhatsApp <span class="text-danger">*</span></label>
                                        <input type="text" name="whatsapp" placeholder="08xxxxxxxxxx"
                                               class="nac-join-input @error('whatsapp') is-invalid @enderror" value="{{ old('whatsapp') }}" required>
                                        @error('whatsapp') <div class="nac-join-error">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-12">
                                        <label class="nac-join-label">Kategori yang Diminati <span class="text-danger">*</span></label>
                                        <select name="category" class="nac-join-input @error('category') is-invalid @enderror" required>
                                            <option value="">— Pilih Kategori —</option>
                                            <option value="Swim School A1 - Pemula" {{ old('category') === 'Swim School A1 - Pemula' ? 'selected' : '' }}>Swim School A1 — Pemula</option>
                                            <option value="Swim School A2 - Pemula" {{ old('category') === 'Swim School A2 - Pemula' ? 'selected' : '' }}>Swim School A2 — Pemula</option>
                                            <option value="Swim School B1 - Intermediate" {{ old('category') === 'Swim School B1 - Intermediate' ? 'selected' : '' }}>Swim School B1 — Intermediate</option>
                                            <option value="Swim School B2 - Intermediate" {{ old('category') === 'Swim School B2 - Intermediate' ? 'selected' : '' }}>Swim School B2 — Intermediate</option>
                                            <option value="NAC Junior - Advanced" {{ old('category') === 'NAC Junior - Advanced' ? 'selected' : '' }}>NAC Junior — Advanced</option>
                                            <option value="NAC Elite" {{ old('category') === 'NAC Elite' ? 'selected' : '' }}>NAC Elite</option>
                                        </select>
                                        @error('category') <div class="nac-join-error">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-12">
                                        <button type="submit" class="nac-btn nac-btn--primary nac-join-submit">
                                            <i class="fa-solid fa-paper-plane"></i> Kirim Pendaftaran
                                        </button>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</section>

<script>
function nacPreviewJoinPhoto(input) {
    var preview = document.getElementById('joinPhotoPreview');
    var empty = document.getElementById('joinPhotoEmpty');
    if (input.files && input.files[0]) {
        preview.src = URL.createObjectURL(input.files[0]);
        preview.style.display = 'block';
        empty.style.display = 'none';
    }
}
</script>

@endsection