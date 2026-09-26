@extends('layouts.app')

@section('title', 'Join Us — NAC Swim School')
@section('meta_description', 'Formulir pendaftaran NAC Swim School — sekolah renang Nugroho Aquatic Club di Sangatta Utara, Kutai Timur.')

@section('content')

<section class="nac-page-header @if($setting->join_header_type === 'photo' && $setting->join_header_photo_url) nac-page-header--photo @elseif($setting->join_header_type === 'video' && $setting->join_header_video_embed_url) nac-page-header--photo @endif"
    @if($setting->join_header_type === 'photo' && $setting->join_header_photo_url)
        style="background-image: url('{{ $setting->join_header_photo_url }}');"
    @endif>

    @if($setting->join_header_type === 'video' && $setting->join_header_video_embed_url)
        <div class="nac-page-header__bg-video-wrap">
            <iframe src="{{ $setting->join_header_video_embed_url }}"
                class="nac-page-header__bg-video"
                allow="autoplay; encrypted-media"
                title="Background video halaman Join Us"></iframe>
        </div>
    @endif

    <div class="container text-center" data-aos="fade-up">
        <h1 class="nac-page-header__title">Mulai perjalanan renangmu bersama kami.</h1>
        <p class="nac-page-header__desc">
            Isi formulir pendaftaran di bawah ini — tim kami akan segera menghubungi Anda.
        </p>
    </div>
</section>

<section class="nac-section nac-join-section nac-section--decorated nac-dot-pattern">
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

                    <form action="{{ route('join.store') }}" method="POST" enctype="multipart/form-data" novalidate class="mt-4" id="joinForm">
                        @csrf

                        {{-- Honeypot anti-bot — SENGAJA disembunyikan lewat CSS (bukan
                             type="hidden"), supaya bot spam yang cuma cek atribut type
                             tetap "tertipu" dan mengisinya. Manusia normal tidak akan
                             pernah melihat/mengisi field ini. Kalau terisi, validasi di
                             StoreJoinRequest (rule 'prohibited') otomatis menolaknya. --}}
                        <div style="position:absolute; left:-9999px; top:-9999px;" aria-hidden="true" tabindex="-1">
                            <label for="website">Jangan isi kolom ini</label>
                            <input type="text" name="website" id="website" autocomplete="off" tabindex="-1">
                        </div>

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
                                <small class="nac-join-hint d-block">JPG/PNG/WEBP, maks 8MB (opsional — boleh menyusul).</small>
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
                                        <label class="nac-join-label">No. WhatsApp Orang Tua/Murid <span class="text-danger">*</span></label>
                                        <input type="text" name="whatsapp" placeholder="08xxxxxxxxxx"
                                               class="nac-join-input @error('whatsapp') is-invalid @enderror" value="{{ old('whatsapp') }}" required>
                                        @error('whatsapp') <div class="nac-join-error">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-12">
                                        <label class="nac-join-label">Kategori yang Diminati <span class="text-danger">*</span></label>
                                        <select name="category" class="nac-join-input @error('category') is-invalid @enderror" required>
                                            <option value="">— Pilih Kategori —</option>
                                            <option value="Novato" {{ old('category', request('category')) === 'Novato' ? 'selected' : '' }}>Novato</option>
                                            <option value="Avance" {{ old('category', request('category')) === 'Avance' ? 'selected' : '' }}>Avance</option>
                                            <option value="Campeón" {{ old('category', request('category')) === 'Campeón' ? 'selected' : '' }}>Campeón</option>
                                        </select>
                                        @error('category') <div class="nac-join-error">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-12">
                                        <button type="submit" class="nac-btn nac-btn--primary nac-join-submit" id="joinSubmitBtn">
                                            <span class="nac-join-submit__label">
                                                <i class="fa-solid fa-paper-plane"></i> Kirim Pendaftaran
                                            </span>
                                            <span class="nac-join-submit__loading">
                                                <span class="nac-spinner" aria-hidden="true"></span> Mengirim, mohon tunggu...
                                            </span>
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