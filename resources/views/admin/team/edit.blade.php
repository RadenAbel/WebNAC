@extends('admin.layouts.app')

@section('admin_title', 'Edit ' . $member->name)

@section('admin_content')

    <div class="mb-4">
        <a href="{{ route('admin.team.index') }}" class="nac-admin-back-btn">
            <span class="nac-admin-back-btn__icon"><i class="bi bi-arrow-left"></i></span> Kembali ke daftar tim
        </a>
        <h1 class="h4 fw-bold mt-2 mb-1">Edit: {{ $member->name }}</h1>
    </div>

    @include('admin.partials.toast')

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

    @if ($member->role === 'atlet')
    <div class="row g-4">
        {{-- ============ REKOR WAKTU TERBAIK ============ --}}
        <div class="col-lg-6">
            <div class="bg-white border rounded-3 p-4 h-100">
                <h2 class="h6 fw-bold mb-3">
                    <i class="bi bi-stopwatch me-1"></i> Rekor Waktu Terbaik
                </h2>

                @php
                    // Daftar flat semua nomor renang (dari config/swim_events.php,
                    // dikelompokkan per gaya) — dipakai untuk cek apakah event yang
                    // tersimpan termasuk preset atau custom (ketik manual).
                    $allSwimEvents = collect(config('swim_events'))->flatten()->all();
                @endphp

                @forelse ($member->records as $record)
                    @php $isCustomEvent = !in_array($record->event, $allSwimEvents); @endphp
                    <div class="border rounded-3 p-3 mb-2" data-item style="font-size:0.85rem;">

                        {{-- ---------- MODE LIHAT ---------- --}}
                        <div class="d-flex justify-content-between align-items-start" data-view-mode>
                            <div>
                                <div class="fw-bold">{{ $record->event }} — {{ $record->time }}</div>
                                <div class="text-secondary">
                                    @if ($record->medal) {{ $record->medal }} · @endif
                                    @if ($record->pool_length) Kolam {{ $record->pool_length }}m · @endif
                                    @if ($record->age_at_record) Usia {{ $record->age_at_record }} th · @endif
                                    @if ($record->competition) {{ $record->competition }} @endif
                                    @if ($record->country) (<span class="fi fi-{{ strtolower($record->country) }} nac-flag-icon" style="margin:0 2px;"></span> {{ $record->country_name }}) @endif
                                    @if ($record->record_date) · {{ $record->record_date->format('d M Y') }} @endif
                                </div>
                            </div>
                            <div class="d-flex gap-1 flex-shrink-0">
                                <button type="button" class="btn btn-sm btn-outline-secondary" data-toggle-edit title="Edit rekor">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <form action="{{ route('admin.team.records.destroy', [$member, $record]) }}" method="POST"
                                    class="nac-confirm-delete-form"
                                    data-confirm-title="Hapus rekor ini?"
                                    data-confirm-text="Rekor waktu ini akan terhapus secara permanen.">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus rekor">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                        {{-- ---------- MODE EDIT (tersembunyi sampai tombol pensil diklik) ---------- --}}
                        <form action="{{ route('admin.team.records.update', [$member, $record]) }}" method="POST"
                            class="d-none mt-1" data-edit-mode>
                            @csrf
                            @method('PUT')
                            <div class="row g-2">
                                <div class="col-6">
                                    <select class="form-select form-select-sm" data-event-select
                                        data-event-custom="eventCustom{{ $record->id }}">
                                        <option value="">— Pilih Nomor —</option>
                                        @foreach (config('swim_events') as $group => $events)
                                            <optgroup label="{{ $group }}">
                                                @foreach ($events as $eventOption)
                                                    <option value="{{ $eventOption }}" {{ $record->event === $eventOption ? 'selected' : '' }}>{{ $eventOption }}</option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                        <option value="__custom__" {{ $isCustomEvent ? 'selected' : '' }}>Lainnya (ketik manual)</option>
                                    </select>
                                    <input type="text" id="eventCustom{{ $record->id }}"
                                        class="form-control form-control-sm mt-1 {{ $isCustomEvent ? '' : 'd-none' }}"
                                        placeholder="Ketik nomor renang" value="{{ $isCustomEvent ? $record->event : '' }}">
                                </div>
                                <div class="col-6">
                                    <input type="text" name="time" class="form-control form-control-sm" value="{{ $record->time }}" required>
                                </div>
                                <div class="col-6">
                                    <select name="medal" class="form-select form-select-sm">
                                        <option value="">Medali (opsional)</option>
                                        <option value="Emas" {{ $record->medal === 'Emas' ? 'selected' : '' }}>Emas</option>
                                        <option value="Perak" {{ $record->medal === 'Perak' ? 'selected' : '' }}>Perak</option>
                                        <option value="Perunggu" {{ $record->medal === 'Perunggu' ? 'selected' : '' }}>Perunggu</option>
                                    </select>
                                </div>
                                <div class="col-6">
                                    <select name="pool_length" class="form-select form-select-sm">
                                        <option value="">Panjang kolam</option>
                                        <option value="25" {{ (string) $record->pool_length === '25' ? 'selected' : '' }}>25 meter</option>
                                        <option value="50" {{ (string) $record->pool_length === '50' ? 'selected' : '' }}>50 meter</option>
                                    </select>
                                </div>
                                <div class="col-6">
                                    <input type="number" name="age_at_record" id="ageAtRecord{{ $record->id }}"
                                        class="form-control form-control-sm" placeholder="Usia saat itu" min="1" max="100"
                                        value="{{ $record->age_at_record }}">
                                </div>
                                <div class="col-6">
                                    <input type="date" name="record_date" class="form-control form-control-sm"
                                        value="{{ $record->record_date?->format('Y-m-d') }}"
                                        data-record-date-input
                                        data-birthdate="{{ $member->birth_date?->format('Y-m-d') }}"
                                        data-age-target="ageAtRecord{{ $record->id }}">
                                </div>
                                <div class="col-6">
                                    <input type="text" name="competition" class="form-control form-control-sm" value="{{ $record->competition }}">
                                </div>
                                <div class="col-6">
                                    <select name="country" class="form-select form-select-sm">
                                        <option value="">Negara (opsional)</option>
                                        @foreach (config('countries') as $code => $name)
                                            <option value="{{ $code }}" {{ strtoupper((string) $record->country) === $code ? 'selected' : '' }}>{{ $name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12 d-flex gap-2 mt-1">
                                    <button type="submit" class="btn btn-sm nac-admin-btn flex-grow-1">
                                        <i class="bi bi-check-lg"></i> Simpan
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" data-cancel-edit>Batal</button>
                                </div>
                            </div>
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
                            <select class="form-select form-select-sm" data-event-select data-event-custom="eventCustomNew">
                                <option value="">— Pilih Nomor —</option>
                                @foreach (config('swim_events') as $group => $events)
                                    <optgroup label="{{ $group }}">
                                        @foreach ($events as $eventOption)
                                            <option value="{{ $eventOption }}">{{ $eventOption }}</option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                                <option value="__custom__">Lainnya (ketik manual)</option>
                            </select>
                            <input type="text" id="eventCustomNew" class="form-control form-control-sm mt-1 d-none" placeholder="Ketik nomor renang">
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
                            <input type="number" name="age_at_record" id="ageAtRecordNew" class="form-control form-control-sm" placeholder="Usia saat itu" min="1" max="100">
                        </div>
                        <div class="col-6">
                            <input type="date" name="record_date" class="form-control form-control-sm"
                                data-record-date-input
                                data-birthdate="{{ $member->birth_date?->format('Y-m-d') }}"
                                data-age-target="ageAtRecordNew">
                        </div>
                        <div class="col-6">
                            <input type="text" name="competition" class="form-control form-control-sm" placeholder="Nama kompetisi">
                        </div>
                        <div class="col-6">
                            <select name="country" class="form-select form-select-sm">
                                <option value="">Negara (opsional)</option>
                                @foreach (config('countries') as $code => $name)
                                    <option value="{{ $code }}">{{ $name }}</option>
                                @endforeach
                            </select>
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
                    <div class="border rounded-3 p-3 mb-2" data-item style="font-size:0.85rem;">

                        {{-- ---------- MODE LIHAT ---------- --}}
                        <div class="d-flex justify-content-between align-items-start" data-view-mode>
                            <div>
                                <div class="fw-bold">
                                    @if ($achievement->country) <span class="fi fi-{{ strtolower($achievement->country) }} nac-flag-icon" title="{{ $achievement->country_name }}" style="margin-right:0.3rem;"></span> @endif
                                    {{ $achievement->title }}
                                    @if ($achievement->year) <span class="text-secondary fw-normal">({{ $achievement->year }})</span> @endif
                                </div>
                                @if ($achievement->description)
                                    <div class="text-secondary">{{ $achievement->description }}</div>
                                @endif
                                @if ($achievement->event_date_label)
                                    <div class="text-secondary" style="font-size:0.78rem;">
                                        <i class="bi bi-calendar3 me-1"></i>{{ $achievement->event_date_label }}
                                    </div>
                                @endif
                                @if (($achievement->total_gold ?? 0) > 0 || ($achievement->total_silver ?? 0) > 0 || ($achievement->total_bronze ?? 0) > 0)
                                    <div class="mt-1" style="font-size:0.78rem;">
                                        @if ($achievement->total_gold > 0) <span class="me-2">🥇 {{ $achievement->total_gold }}</span> @endif
                                        @if ($achievement->total_silver > 0) <span class="me-2">🥈 {{ $achievement->total_silver }}</span> @endif
                                        @if ($achievement->total_bronze > 0) <span>🥉 {{ $achievement->total_bronze }}</span> @endif
                                    </div>
                                @endif
                            </div>
                            <div class="d-flex gap-1 flex-shrink-0">
                                <button type="button" class="btn btn-sm btn-outline-secondary" data-toggle-edit title="Edit pencapaian">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <form action="{{ route('admin.team.achievements.destroy', [$member, $achievement]) }}" method="POST"
                                    class="nac-confirm-delete-form"
                                    data-confirm-title="Hapus pencapaian ini?"
                                    data-confirm-text="Data pencapaian ini akan terhapus secara permanen.">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus pencapaian">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                        {{-- ---------- MODE EDIT ---------- --}}
                        <form action="{{ route('admin.team.achievements.update', [$member, $achievement]) }}" method="POST"
                            class="d-none mt-1" data-edit-mode>
                            @csrf
                            @method('PUT')
                            <div class="row g-2">
                                <div class="col-8">
                                    <input type="text" name="title" class="form-control form-control-sm" value="{{ $achievement->title }}" required>
                                </div>
                                <div class="col-4">
                                    <input type="text" name="year" class="form-control form-control-sm" value="{{ $achievement->year }}" maxlength="4">
                                </div>
                                <div class="col-6">
                                    <label class="text-secondary d-block mb-1" style="font-size:0.72rem;">Tanggal Pertandingan</label>
                                    <input type="date" name="event_date" class="form-control form-control-sm"
                                        value="{{ $achievement->event_date?->format('Y-m-d') }}" max="{{ now()->format('Y-m-d') }}">
                                </div>
                                <div class="col-6">
                                    <label class="text-secondary d-block mb-1" style="font-size:0.72rem;">Negara</label>
                                    <select name="country" class="form-select form-select-sm">
                                        <option value="">Negara (opsional)</option>
                                        @foreach (config('countries') as $code => $name)
                                            <option value="{{ $code }}" {{ strtoupper((string) $achievement->country) === $code ? 'selected' : '' }}>{{ $name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-4">
                                    <label class="text-secondary d-block mb-1" style="font-size:0.72rem;">🥇 Emas</label>
                                    <input type="number" name="total_gold" class="form-control form-control-sm" min="0" value="{{ $achievement->total_gold ?? 0 }}">
                                </div>
                                <div class="col-4">
                                    <label class="text-secondary d-block mb-1" style="font-size:0.72rem;">🥈 Perak</label>
                                    <input type="number" name="total_silver" class="form-control form-control-sm" min="0" value="{{ $achievement->total_silver ?? 0 }}">
                                </div>
                                <div class="col-4">
                                    <label class="text-secondary d-block mb-1" style="font-size:0.72rem;">🥉 Perunggu</label>
                                    <input type="number" name="total_bronze" class="form-control form-control-sm" min="0" value="{{ $achievement->total_bronze ?? 0 }}">
                                </div>
                                <div class="col-12">
                                    <textarea name="description" rows="2" class="form-control form-control-sm">{{ $achievement->description }}</textarea>
                                </div>
                                <div class="col-12 d-flex gap-2 mt-1">
                                    <button type="submit" class="btn btn-sm nac-admin-btn flex-grow-1">
                                        <i class="bi bi-check-lg"></i> Simpan
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" data-cancel-edit>Batal</button>
                                </div>
                            </div>
                        </form>
                    </div>
                @empty
                    <p class="text-secondary" style="font-size:0.85rem;">Belum ada pencapaian.</p>
                @endforelse

                <hr>

                <p class="fw-bold mb-2" style="font-size:0.82rem; text-transform:uppercase; letter-spacing:.04em;">
                    Tambah Pencapaian Baru
                </p>

                @if ($errors->hasAny(['title', 'year', 'event_date', 'country', 'description']) && old('_form') === 'achievement')
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
                        <div class="col-6">
                            <label class="text-secondary d-block mb-1" style="font-size:0.72rem;">Tanggal Pertandingan</label>
                            <input type="date" name="event_date" class="form-control form-control-sm" max="{{ now()->format('Y-m-d') }}">
                        </div>
                        <div class="col-6">
                            <label class="text-secondary d-block mb-1" style="font-size:0.72rem;">Negara</label>
                            <select name="country" class="form-select form-select-sm">
                                <option value="">Negara (opsional)</option>
                                @foreach (config('countries') as $code => $name)
                                    <option value="{{ $code }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-4">
                            <label class="text-secondary d-block mb-1" style="font-size:0.72rem;">🥇 Emas</label>
                            <input type="number" name="total_gold" class="form-control form-control-sm" min="0" placeholder="0">
                        </div>
                        <div class="col-4">
                            <label class="text-secondary d-block mb-1" style="font-size:0.72rem;">🥈 Perak</label>
                            <input type="number" name="total_silver" class="form-control form-control-sm" min="0" placeholder="0">
                        </div>
                        <div class="col-4">
                            <label class="text-secondary d-block mb-1" style="font-size:0.72rem;">🥉 Perunggu</label>
                            <input type="number" name="total_bronze" class="form-control form-control-sm" min="0" placeholder="0">
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
    @endif

    @if ($member->role === 'pelatih')
    <div class="row g-4">
        {{-- ============ LISENSI KEPELATIHAN ============ --}}
        <div class="col-12">
            <div class="bg-white border rounded-3 p-4">
                <h2 class="h6 fw-bold mb-3">
                    <i class="bi bi-patch-check me-1"></i> Lisensi &amp; Sertifikasi
                </h2>

                @forelse ($member->licenses as $license)
                    <div class="border rounded-3 p-3 mb-2" data-item style="font-size:0.85rem;">

                        {{-- ---------- MODE LIHAT ---------- --}}
                        <div class="d-flex justify-content-between align-items-start" data-view-mode>
                            <div>
                                <div class="fw-bold">
                                    {{ $license->title }}
                                    @if ($license->is_expired)
                                        <span class="badge bg-danger ms-1" style="font-size:0.68rem;">Kedaluwarsa</span>
                                    @endif
                                </div>
                                <div class="text-secondary">
                                    @if ($license->issuer) {{ $license->issuer }} · @endif
                                    @if ($license->license_number) No. {{ $license->license_number }} · @endif
                                    @if ($license->issued_date_label) Terbit {{ $license->issued_date_label }} @endif
                                    @if ($license->expiry_date_label) · Berlaku s.d. {{ $license->expiry_date_label }} @endif
                                </div>
                                @if ($license->certificate_url)
                                    <a href="{{ $license->certificate_url }}" target="_blank" class="d-inline-block mt-1" style="font-size:0.8rem;">
                                        <i class="bi bi-file-earmark-check me-1"></i>Lihat Sertifikat
                                    </a>
                                @endif
                            </div>
                            <div class="d-flex gap-1 flex-shrink-0">
                                <button type="button" class="btn btn-sm btn-outline-secondary" data-toggle-edit title="Edit lisensi">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <form action="{{ route('admin.team.licenses.destroy', [$member, $license]) }}" method="POST"
                                    class="nac-confirm-delete-form"
                                    data-confirm-title="Hapus lisensi ini?"
                                    data-confirm-text="Data lisensi ini akan terhapus secara permanen.">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus lisensi">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                        {{-- ---------- MODE EDIT ---------- --}}
                        <form action="{{ route('admin.team.licenses.update', [$member, $license]) }}" method="POST"
                            enctype="multipart/form-data" class="d-none mt-1" data-edit-mode>
                            @csrf
                            @method('PUT')
                            <div class="row g-2">
                                <div class="col-12">
                                    <input type="text" name="title" class="form-control form-control-sm" value="{{ $license->title }}" placeholder="Nama lisensi" required>
                                </div>
                                <div class="col-6">
                                    <input type="text" name="issuer" class="form-control form-control-sm" value="{{ $license->issuer }}" placeholder="Lembaga penerbit">
                                </div>
                                <div class="col-6">
                                    <input type="text" name="license_number" class="form-control form-control-sm" value="{{ $license->license_number }}" placeholder="Nomor lisensi">
                                </div>
                                <div class="col-6">
                                    <label class="text-secondary d-block mb-1" style="font-size:0.72rem;">Tanggal Terbit</label>
                                    <input type="date" name="issued_date" class="form-control form-control-sm" value="{{ $license->issued_date?->format('Y-m-d') }}">
                                </div>
                                <div class="col-6">
                                    <label class="text-secondary d-block mb-1" style="font-size:0.72rem;">Berlaku Sampai</label>
                                    <input type="date" name="expiry_date" class="form-control form-control-sm" value="{{ $license->expiry_date?->format('Y-m-d') }}">
                                </div>
                                <div class="col-12">
                                    <label class="text-secondary d-block mb-1" style="font-size:0.72rem;">Ganti Sertifikat (kosongkan kalau tidak ganti)</label>
                                    <input type="file" name="certificate_file" class="form-control form-control-sm" accept=".pdf,.jpg,.jpeg,.png">
                                </div>
                                <div class="col-12 d-flex gap-2 mt-1">
                                    <button type="submit" class="btn btn-sm nac-admin-btn flex-grow-1">
                                        <i class="bi bi-check-lg"></i> Simpan
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" data-cancel-edit>Batal</button>
                                </div>
                            </div>
                        </form>
                    </div>
                @empty
                    <p class="text-secondary" style="font-size:0.85rem;">Belum ada lisensi yang diinput.</p>
                @endforelse

                <hr>

                <p class="fw-bold mb-2" style="font-size:0.82rem; text-transform:uppercase; letter-spacing:.04em;">
                    Tambah Lisensi Baru
                </p>

                @if ($errors->hasAny(['title', 'issuer', 'license_number', 'issued_date', 'expiry_date', 'certificate_file']) && old('_form') === 'license')
                    <div class="alert alert-danger py-2 px-3 mb-2" style="font-size:0.82rem;">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form action="{{ route('admin.team.licenses.store', $member) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_form" value="license">
                    <div class="row g-2">
                        <div class="col-12">
                            <input type="text" name="title" class="form-control form-control-sm" placeholder="Nama lisensi, mis. Pelatih Renang Level 1" required>
                        </div>
                        <div class="col-6">
                            <input type="text" name="issuer" class="form-control form-control-sm" placeholder="Lembaga penerbit, mis. PRSI">
                        </div>
                        <div class="col-6">
                            <input type="text" name="license_number" class="form-control form-control-sm" placeholder="Nomor lisensi">
                        </div>
                        <div class="col-6">
                            <label class="text-secondary d-block mb-1" style="font-size:0.72rem;">Tanggal Terbit</label>
                            <input type="date" name="issued_date" class="form-control form-control-sm">
                        </div>
                        <div class="col-6">
                            <label class="text-secondary d-block mb-1" style="font-size:0.72rem;">Berlaku Sampai</label>
                            <input type="date" name="expiry_date" class="form-control form-control-sm">
                        </div>
                        <div class="col-12">
                            <label class="text-secondary d-block mb-1" style="font-size:0.72rem;">Upload Sertifikat (PDF/JPG/PNG, opsional)</label>
                            <input type="file" name="certificate_file" class="form-control form-control-sm" accept=".pdf,.jpg,.jpeg,.png">
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-sm nac-admin-btn w-100 mt-1">
                                <i class="bi bi-plus-lg"></i> Tambah Lisensi
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

@endsection