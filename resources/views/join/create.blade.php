@extends('layouts.app')

@section('title', 'Join Us — Nugroho Aquatic Center')
@section('meta_description', 'Daftar untuk bergabung berlatih bersama Nugroho Aquatic Center.')

@section('content')

<section class="nac-page-header">
    <div class="container text-center" data-aos="fade-up">
        <span class="nac-eyebrow">Join Us</span>
        <h1 class="nac-page-header__title">Mulai perjalanan renangmu bersama kami.</h1>
        <p class="nac-page-header__desc">
            Isi formulir di bawah ini — tim kami akan segera menghubungi Anda untuk proses selanjutnya.
        </p>
    </div>

    <svg class="nac-hero__wave" viewBox="0 0 1440 120" preserveAspectRatio="none" aria-hidden="true">
        <path d="M0,64 C240,120 480,0 720,32 C960,64 1200,120 1440,64 L1440,120 L0,120 Z"></path>
    </svg>
</section>

<section class="nac-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                @if (session('status'))
                    <div class="nac-join-alert nac-join-alert--success" data-aos="fade-up">
                        <i class="fa-solid fa-circle-check"></i>
                        <span>{{ session('status') }}</span>
                    </div>
                @endif

                <div class="nac-join-card" data-aos="fade-up">
                    <form action="{{ route('join.store') }}" method="POST" novalidate>
                        @csrf
                        <div class="row g-4">
                            <div class="col-md-8">
                                <label class="nac-join-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="nac-join-input @error('name') is-invalid @enderror"
                                       value="{{ old('name') }}" required>
                                @error('name') <div class="nac-join-error">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="nac-join-label">Usia</label>
                                <input type="number" name="age" min="1" max="100"
                                       class="nac-join-input @error('age') is-invalid @enderror" value="{{ old('age') }}">
                                @error('age') <div class="nac-join-error">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="nac-join-label">Jenis Kelamin</label>
                                <select name="gender" class="nac-join-input @error('gender') is-invalid @enderror">
                                    <option value="">— Pilih —</option>
                                    <option value="Laki-laki" {{ old('gender') === 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Perempuan" {{ old('gender') === 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('gender') <div class="nac-join-error">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="nac-join-label">Kategori yang Diminati</label>
                                <select name="category" class="nac-join-input @error('category') is-invalid @enderror">
                                    <option value="">— Pilih —</option>
                                    <option value="Kelas Renang Junior" {{ old('category') === 'Kelas Renang Junior' ? 'selected' : '' }}>Kelas Renang Junior</option>
                                    <option value="Kelas Renang Senior" {{ old('category') === 'Kelas Renang Senior' ? 'selected' : '' }}>Kelas Renang Senior</option>
                                    <option value="Swim Class A" {{ old('category') === 'Swim Class A' ? 'selected' : '' }}>Swim Class A</option>
                                    <option value="Swim Class B" {{ old('category') === 'Swim Class B' ? 'selected' : '' }}>Swim Class B</option>
                                    <option value="Pelatih Pribadi" {{ old('category') === 'Pelatih Pribadi' ? 'selected' : '' }}>Pelatih Pribadi</option>
                                    <option value="Lainnya" {{ old('category') === 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                                @error('category') <div class="nac-join-error">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="nac-join-label">No. WhatsApp <span class="text-danger">*</span></label>
                                <input type="text" name="whatsapp" placeholder="08xxxxxxxxxx"
                                       class="nac-join-input @error('whatsapp') is-invalid @enderror" value="{{ old('whatsapp') }}" required>
                                @error('whatsapp') <div class="nac-join-error">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="nac-join-label">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="nac-join-input @error('email') is-invalid @enderror"
                                       value="{{ old('email') }}" required>
                                @error('email') <div class="nac-join-error">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12">
                                <label class="nac-join-label">Pesan / Catatan Tambahan</label>
                                <textarea name="message" rows="4" class="nac-join-input @error('message') is-invalid @enderror"
                                          placeholder="Ceritakan sedikit tujuan atau pertanyaanmu (opsional)">{{ old('message') }}</textarea>
                                @error('message') <div class="nac-join-error">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12">
                                <button type="submit" class="nac-btn nac-btn--primary nac-join-submit">
                                    <i class="fa-solid fa-paper-plane"></i> Kirim Pendaftaran
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</section>

@endsection