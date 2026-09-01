@extends('admin.layouts.app')

@section('admin_title', 'Edit ' . $member->name)

@section('admin_content')

    <div class="mb-4">
        <a href="{{ route('admin.team.index') }}" class="nac-admin-back-btn">
            <span class="nac-admin-back-btn__icon"><i class="bi bi-arrow-left"></i></span> Kembali ke daftar tim
        </a>
        <h1 class="h4 fw-bold mt-2 mb-1">Edit: {{ $member->name }}</h1>
    </div>

    @if (session('status'))
        <div class="alert alert-success py-2 px-3 mb-3" style="font-size:0.9rem;">
            {{ session('status') }}
        </div>
    @endif

    {{-- ============ FORM PROFIL ============ --}}
    <div class="bg-white border rounded-3 p-4 mb-4">
        <form action="{{ route('admin.team.update', $member) }}" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @include('admin.team.partials.form')

            <div class="mt-4 pt-3 border-top">
                <button type="submit" class="btn nac-admin-btn">
                    <i class="bi bi-check-lg me-1"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

    <div class="row g-4">
        {{-- ============ REKOR WAKTU TERBAIK ============ --}}
        <div class="col-lg-6">
            <div class="bg-white border rounded-3 p-4 h-100">
                <h2 class="h6 fw-bold mb-3">
                    <i class="bi bi-stopwatch me-1"></i> Rekor Waktu Terbaik
                </h2>

                @forelse ($member->records as $record)
                    <div class="border rounded-3 p-3 mb-2 d-flex justify-content-between align-items-start" style="font-size:0.85rem;">
                        <div>
                            <div class="fw-bold">{{ $record->event }} — {{ $record->time }}</div>
                            <div class="text-secondary">
                                @if ($record->medal) {{ $record->medal }} · @endif
                                @if ($record->pool_length) Kolam {{ $record->pool_length }}m · @endif
                                @if ($record->age_at_record) Usia {{ $record->age_at_record }} th · @endif
                                @if ($record->competition) {{ $record->competition }} @endif
                                @if ($record->country) ({{ $record->country }}) @endif
                                @if ($record->record_date) · {{ $record->record_date->format('d M Y') }} @endif
                            </div>
                        </div>
                        <form action="{{ route('admin.team.records.destroy', [$member, $record]) }}" method="POST"
                            onsubmit="return confirm('Hapus rekor ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </div>
                @empty
                    <p class="text-secondary" style="font-size:0.85rem;">Belum ada rekor waktu.</p>
                @endforelse

                <hr>

                <p class="fw-bold mb-2" style="font-size:0.82rem; text-transform:uppercase; letter-spacing:.04em;">
                    Tambah Rekor Baru
                </p>

                @if ($errors->hasAny(['event', 'time', 'medal', 'pool_length', 'age_at_record', 'competition', 'country', 'record_date']) && old('_form') === 'record')
                    <div class="alert alert-danger py-2 px-3 mb-2" style="font-size:0.82rem;">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form action="{{ route('admin.team.records.store', $member) }}" method="POST">
                    @csrf
                    <input type="hidden" name="_form" value="record">
                    <div class="row g-2">
                        <div class="col-6">
                            <input type="text" name="event" class="form-control form-control-sm" placeholder="Nomor, mis. 50m Gaya Bebas" required>
                        </div>
                        <div class="col-6">
                            <input type="text" name="time" class="form-control form-control-sm" placeholder="Waktu, mis. 24.50" required>
                        </div>
                        <div class="col-6">
                            <select name="medal" class="form-select form-select-sm">
                                <option value="">Medali (opsional)</option>
                                <option value="Emas">Emas</option>
                                <option value="Perak">Perak</option>
                                <option value="Perunggu">Perunggu</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <select name="pool_length" class="form-select form-select-sm">
                                <option value="">Panjang kolam</option>
                                <option value="25">25 meter</option>
                                <option value="50">50 meter</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <input type="number" name="age_at_record" class="form-control form-control-sm" placeholder="Usia saat itu" min="1" max="100">
                        </div>
                        <div class="col-6">
                            <input type="date" name="record_date" class="form-control form-control-sm">
                        </div>
                        <div class="col-6">
                            <input type="text" name="competition" class="form-control form-control-sm" placeholder="Nama kompetisi">
                        </div>
                        <div class="col-6">
                            <input type="text" name="country" class="form-control form-control-sm" placeholder="Negara">
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-sm nac-admin-btn w-100 mt-1">
                                <i class="bi bi-plus-lg"></i> Tambah Rekor
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- ============ PENCAPAIAN & PENGHARGAAN ============ --}}
        <div class="col-lg-6">
            <div class="bg-white border rounded-3 p-4 h-100">
                <h2 class="h6 fw-bold mb-3">
                    <i class="bi bi-trophy me-1"></i> Pencapaian &amp; Penghargaan
                </h2>

                @forelse ($member->achievements as $achievement)
                    <div class="border rounded-3 p-3 mb-2 d-flex justify-content-between align-items-start" style="font-size:0.85rem;">
                        <div>
                            <div class="fw-bold">
                                {{ $achievement->title }}
                                @if ($achievement->year) <span class="text-secondary fw-normal">({{ $achievement->year }})</span> @endif
                            </div>
                            @if ($achievement->description)
                                <div class="text-secondary">{{ $achievement->description }}</div>
                            @endif
                        </div>
                        <form action="{{ route('admin.team.achievements.destroy', [$member, $achievement]) }}" method="POST"
                            onsubmit="return confirm('Hapus pencapaian ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </div>
                @empty
                    <p class="text-secondary" style="font-size:0.85rem;">Belum ada pencapaian.</p>
                @endforelse

                <hr>

                <p class="fw-bold mb-2" style="font-size:0.82rem; text-transform:uppercase; letter-spacing:.04em;">
                    Tambah Pencapaian Baru
                </p>

                @if ($errors->hasAny(['title', 'year', 'description']) && old('_form') === 'achievement')
                    <div class="alert alert-danger py-2 px-3 mb-2" style="font-size:0.82rem;">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form action="{{ route('admin.team.achievements.store', $member) }}" method="POST">
                    @csrf
                    <input type="hidden" name="_form" value="achievement">
                    <div class="row g-2">
                        <div class="col-8">
                            <input type="text" name="title" class="form-control form-control-sm" placeholder="Judul, mis. Juara 1 PORPROV 2024" required>
                        </div>
                        <div class="col-4">
                            <input type="text" name="year" class="form-control form-control-sm" placeholder="Tahun" maxlength="4">
                        </div>
                        <div class="col-12">
                            <textarea name="description" rows="2" class="form-control form-control-sm" placeholder="Deskripsi singkat (opsional)"></textarea>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-sm nac-admin-btn w-100 mt-1">
                                <i class="bi bi-plus-lg"></i> Tambah Pencapaian
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection