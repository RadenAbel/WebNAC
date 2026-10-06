@extends('admin.layouts.app')

@section('admin_title', 'Edit Kejuaraan')

@section('admin_content')

    <div class="mb-4">
        <a href="{{ route('admin.events.index') }}" class="nac-admin-back-btn">
            <span class="nac-admin-back-btn__icon"><i class="bi bi-arrow-left"></i></span> Kembali ke daftar acara
        </a>
        <h1 class="h4 mt-3 mb-1">Edit Kejuaraan</h1>
    </div>

    <div class="bg-white border rounded-3 p-4">
        <form action="{{ route('admin.events.update', $event) }}" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @include('admin.event.partials.form')

            <div class="mt-4 pt-3 border-top">
                <button type="submit" class="btn nac-admin-btn"><i class="bi bi-check-lg"></i> Simpan Perubahan</button>
            </div>
        </form>
    </div>

    <div class="bg-white border rounded-3 p-4 mt-4" id="hasil">
        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
            <div>
                <h2 class="h6 fw-bold mb-1"><i class="bi bi-list-ol me-1"></i> Hasil per Nomor Lomba</h2>
            </div>
            <span class="badge bg-light text-dark border">{{ $event->results->count() }} hasil</span>
        </div>

        <div class="border rounded-3 p-3 mb-4" style="background:#fafbfc;">
            <p class="fw-bold mb-2" style="font-size:0.82rem; text-transform:uppercase; letter-spacing:.04em;">Tambah Hasil</p>

            @if ($errors->any() && old('_form') === 'result')
                <div class="alert alert-danger py-2 px-3 mb-2" style="font-size:0.82rem;">{{ $errors->first() }}</div>
            @endif

            @php
                $oldSwim = old('swim_event');
                $allSwimEvents = collect(config('swim_events'))->flatten()->all();
                $oldIsCustom = $oldSwim && ! in_array($oldSwim, $allSwimEvents, true);
            @endphp

            <form action="{{ route('admin.events.results.store', $event) }}" method="POST">
                @csrf
                <input type="hidden" name="_form" value="result">
                <div class="row g-2">
                    <div class="col-md-4">
                        <label class="form-label small mb-1">Nomor Lomba <span class="text-danger">*</span></label>
                        <select class="form-select form-select-sm" data-result-swim-select>
                            <option value="">— Pilih Nomor —</option>
                            @foreach (config('swim_events') as $group => $swimEvents)
                                <optgroup label="{{ $group }}">
                                    @foreach ($swimEvents as $swimOption)
                                        <option value="{{ $swimOption }}" {{ $oldSwim === $swimOption ? 'selected' : '' }}>{{ $swimOption }}</option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                            <option value="__custom__" {{ $oldIsCustom ? 'selected' : '' }}>Lainnya (ketik manual)</option>
                        </select>
                        <input type="text" class="form-control form-control-sm mt-1 {{ $oldIsCustom ? '' : 'd-none' }}" data-result-swim-custom
                            value="{{ $oldIsCustom ? $oldSwim : '' }}" placeholder="Ketik nomor lomba">
                        <input type="hidden" name="swim_event" value="{{ $oldSwim }}" data-result-swim-value>
                    </div>
                    <div class="col-6 col-md-2">
                        <label class="form-label small mb-1">Kelompok Umur</label>
                        <input type="text" name="age_group" class="form-control form-control-sm" list="ageGroupOptions"
                            value="{{ old('age_group') }}" placeholder="mis. KU 3">
                        <datalist id="ageGroupOptions">
                            @foreach ($ageGroups as $ag)
                                <option value="{{ $ag }}">
                            @endforeach
                        </datalist>
                    </div>
                    <div class="col-6 col-md-2">
                        <label class="form-label small mb-1">Jenis Kelamin <span class="text-danger">*</span></label>
                        <select name="gender" class="form-select form-select-sm" required>
                            @foreach (\App\Models\EventResult::GENDERS as $gKey => $gLabel)
                                <option value="{{ $gKey }}" {{ old('gender', 'putra') === $gKey ? 'selected' : '' }}>{{ $gLabel }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small mb-1">Atlet <span class="text-danger">*</span></label>
                        <select name="team_member_id" class="form-select form-select-sm" data-result-athlete-select>
                            <option value="">— Atlet klub lain (ketik manual) —</option>
                            @foreach ($athletes as $athlete)
                                <option value="{{ $athlete->id }}">{{ $athlete->name }}</option>
                            @endforeach
                        </select>
                        <input type="text" name="athlete_name" class="form-control form-control-sm mt-1" data-result-athlete-name
                            placeholder="Nama atlet">
                    </div>

                    <div class="col-6 col-md-3" data-result-manual-only>
                        <label class="form-label small mb-1">Tanggal Lahir</label>
                        <input type="date" name="birth_date" class="form-control form-control-sm">
                    </div>
                    <div class="col-6 col-md-3" data-result-manual-only>
                        <label class="form-label small mb-1">Klub</label>
                        <input type="text" name="club" class="form-control form-control-sm" placeholder="Nama klub">
                    </div>
                    <div class="col-md-6" data-result-manual-only>
                        <label class="form-label small mb-1">Asal Sekolah</label>
                        <input type="text" name="school_name" class="form-control form-control-sm" placeholder="Opsional">
                    </div>
                    <div class="col-6 col-md-2">
                        <label class="form-label small mb-1">Seri</label>
                        <input type="number" name="heat" min="1" max="999" class="form-control form-control-sm" placeholder="1">
                    </div>
                    <div class="col-6 col-md-2">
                        <label class="form-label small mb-1">Lintasan</label>
                        <input type="number" name="lane" min="0" max="20" class="form-control form-control-sm" placeholder="4">
                    </div>
                    <div class="col-6 col-md-2">
                        <label class="form-label small mb-1">Peringkat</label>
                        <input type="number" name="rank" min="1" max="999" class="form-control form-control-sm" placeholder="1">
                    </div>
                    <div class="col-6 col-md-3">
                        <label class="form-label small mb-1">Waktu</label>
                        <input type="text" name="time" class="form-control form-control-sm" placeholder="00:32.45">
                        <small class="text-secondary" style="font-size:0.72rem;">Format menit:detik.perseratus. Gap dihitung otomatis.</small>
                    </div>
                    <div class="col-6 col-md-3">
                        <label class="form-label small mb-1">Keterangan</label>
                        <select name="note" class="form-select form-select-sm">
                            <option value="">—</option>
                            <option value="DQ">DQ (diskualifikasi)</option>
                            <option value="DNS">DNS (tidak start)</option>
                            <option value="DNF">DNF (tidak finish)</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-sm nac-admin-btn mt-1">
                            <i class="bi bi-plus-lg"></i> Tambah Hasil
                        </button>
                        <small class="text-secondary ms-2">Nomor, kelompok umur &amp; jenis kelamin tetap terpilih setelah menyimpan, jadi bisa langsung input atlet berikutnya.</small>
                    </div>
                </div>
            </form>
        </div>

        @if ($errors->any() && old('_form') === 'result_edit')
            <div class="alert alert-danger py-2 px-3 mb-3" style="font-size:0.82rem;">Gagal menyimpan perubahan: {{ $errors->first() }}</div>
        @endif

        @php
            $resultGroups = $event->results->groupBy(fn ($r) => $r->swim_event . ' · ' . ($r->age_group ?: 'Tanpa KU') . ' · ' . $r->gender_label);
        @endphp

        @forelse ($resultGroups as $groupLabel => $rows)
            @php
                $first = $rows->first();
                \App\Models\EventResult::assignGapLabels($rows);
                $isActiveGroup = old('swim_event') === $first->swim_event
                    && (string) old('age_group') === (string) $first->age_group
                    && old('gender') === $first->gender;
            @endphp
            <details class="nac-admin-result-group mb-2" {{ $isActiveGroup ? 'open' : '' }}>
                <summary class="nac-admin-result-group__head">
                    <span class="fw-bold">{{ $first->swim_event }}</span>
                    <span class="d-flex align-items-center gap-2 ms-auto">
                        <span class="badge bg-light text-dark border">{{ $first->age_group ?: 'Tanpa KU' }}</span>
                        <span class="badge bg-light text-dark border">{{ $first->gender_label }}</span>
                        <span class="text-secondary" style="font-size:0.78rem;">{{ $rows->count() }} atlet</span>
                        <i class="bi bi-chevron-down nac-admin-result-group__chevron"></i>
                    </span>
                </summary>
                <div class="table-responsive border-top">
                    <table class="table table-sm align-middle mb-0" style="font-size:0.84rem;">
                        <thead>
                            <tr>
                                <th style="width:60px;">Rank</th>
                                <th style="width:50px;">Seri</th>
                                <th style="width:70px;">Lintasan</th>
                                <th>Atlet</th>
                                <th>Asal Sekolah</th>
                                <th>Tgl Lahir</th>
                                <th>Klub</th>
                                <th>Waktu</th>
                                <th>Gap</th>
                                <th class="text-end" style="width:100px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rows as $row)
                                <tr>
                                    <td class="fw-bold">{{ $row->rank ?? '-' }}</td>
                                    <td>{{ $row->heat !== null ? 'S' . $row->heat : '-' }}</td>
                                    <td>{{ $row->lane !== null ? 'L' . $row->lane : '-' }}</td>
                                    <td>
                                        {{ $row->athlete_name }}
                                        @if ($row->team_member_id)
                                            <span class="badge bg-info-subtle text-info-emphasis ms-1">NAC</span>
                                        @endif
                                    </td>
                                    <td>{{ $row->school_name ?: '-' }}</td>
                                    <td>{{ $row->birth_date_label ?? '-' }}</td>
                                    <td>{{ $row->club ?? '-' }}</td>
                                    <td class="fw-bold">{{ $row->note ?: ($row->time_label ?? '-') }}</td>
                                    <td>{{ $row->gap_label ?? '-' }}</td>
                                    <td class="text-end text-nowrap">
                                        <button type="button" class="btn btn-sm btn-outline-secondary" title="Edit hasil"
                                            data-result-edit="{{ json_encode([
                                                'action'         => route('admin.events.results.update', [$event, $row]),
                                                'swim_event'     => $row->swim_event,
                                                'age_group'      => $row->age_group,
                                                'gender'         => $row->gender,
                                                'team_member_id' => $row->team_member_id,
                                                'athlete_name'   => $row->athlete_name,
                                                'school_name'    => $row->school_name,
                                                'birth_date'     => $row->birth_date?->format('Y-m-d'),
                                                'club'           => $row->club,
                                                'heat'           => $row->heat,
                                                'lane'           => $row->lane,
                                                'rank'           => $row->rank,
                                                'time'           => $row->time_label,
                                                'note'           => $row->note,
                                            ]) }}">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <form action="{{ route('admin.events.results.destroy', [$event, $row]) }}" method="POST" class="d-inline nac-confirm-delete-form"
                                            data-confirm-title="Hapus hasil ini?"
                                            data-confirm-text="Hasil {{ $row->athlete_name }} di nomor {{ $row->swim_event }} akan dihapus.">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </details>
        @empty
            <p class="text-secondary mb-0" style="font-size:0.85rem;">Belum ada hasil. Tambahkan lewat form di atas.</p>
        @endforelse
    </div>

    <div class="modal fade" id="editResultModal" tabindex="-1" aria-labelledby="editResultModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <form method="POST" action="" data-edit-result-form>
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="_form" value="result_edit">
                    <div class="modal-header">
                        <h5 class="modal-title h6 fw-bold" id="editResultModalLabel"><i class="bi bi-pencil me-1"></i> Edit Hasil</h5>
                        <button type="button" class="btn-close" data-edit-modal-close aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-2">
                            <div class="col-md-6">
                                <label class="form-label small mb-1">Nomor Lomba <span class="text-danger">*</span></label>
                                <input type="text" name="swim_event" class="form-control form-control-sm" list="swimEventOptions" required>
                                <datalist id="swimEventOptions">
                                    @foreach (collect(config('swim_events'))->flatten() as $swimOption)
                                        <option value="{{ $swimOption }}">
                                    @endforeach
                                </datalist>
                            </div>
                            <div class="col-6 col-md-3">
                                <label class="form-label small mb-1">Kelompok Umur</label>
                                <input type="text" name="age_group" class="form-control form-control-sm" list="ageGroupOptions">
                            </div>
                            <div class="col-6 col-md-3">
                                <label class="form-label small mb-1">Jenis Kelamin <span class="text-danger">*</span></label>
                                <select name="gender" class="form-select form-select-sm" required>
                                    @foreach (\App\Models\EventResult::GENDERS as $gKey => $gLabel)
                                        <option value="{{ $gKey }}">{{ $gLabel }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small mb-1">Atlet <span class="text-danger">*</span></label>
                                <select name="team_member_id" class="form-select form-select-sm" data-edit-athlete-select>
                                    <option value="">— Atlet klub lain (ketik manual) —</option>
                                    @foreach ($athletes as $athlete)
                                        <option value="{{ $athlete->id }}">{{ $athlete->name }}</option>
                                    @endforeach
                                </select>
                                <input type="text" name="athlete_name" class="form-control form-control-sm mt-1" placeholder="Nama atlet" data-edit-athlete-name>
                            </div>
                            <div class="col-6 col-md-3" data-edit-manual-only>
                                <label class="form-label small mb-1">Tanggal Lahir</label>
                                <input type="date" name="birth_date" class="form-control form-control-sm">
                            </div>
                            <div class="col-6 col-md-3" data-edit-manual-only>
                                <label class="form-label small mb-1">Klub</label>
                                <input type="text" name="club" class="form-control form-control-sm">
                            </div>
                            <div class="col-md-6" data-edit-manual-only>
                                <label class="form-label small mb-1">Asal Sekolah</label>
                                <input type="text" name="school_name" class="form-control form-control-sm" placeholder="Opsional">
                            </div>
                            <div class="col-6 col-md-3">
                                <label class="form-label small mb-1">Seri</label>
                                <input type="number" name="heat" min="1" max="999" class="form-control form-control-sm">
                            </div>
                            <div class="col-6 col-md-3">
                                <label class="form-label small mb-1">Lintasan</label>
                                <input type="number" name="lane" min="0" max="20" class="form-control form-control-sm">
                            </div>
                            <div class="col-6 col-md-3">
                                <label class="form-label small mb-1">Peringkat</label>
                                <input type="number" name="rank" min="1" max="999" class="form-control form-control-sm">
                            </div>
                            <div class="col-6 col-md-3">
                                <label class="form-label small mb-1">Waktu</label>
                                <input type="text" name="time" class="form-control form-control-sm" placeholder="00:32.45">
                            </div>
                            <div class="col-6 col-md-3">
                                <label class="form-label small mb-1">Keterangan</label>
                                <select name="note" class="form-select form-select-sm">
                                    <option value="">—</option>
                                    <option value="DQ">DQ (diskualifikasi)</option>
                                    <option value="DNS">DNS (tidak start)</option>
                                    <option value="DNF">DNF (tidak finish)</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-outline-secondary" data-edit-modal-close>Batal</button>
                        <button type="submit" class="btn btn-sm nac-admin-btn"><i class="bi bi-check-lg"></i> Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('styles')
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
    <style>
        .ts-wrapper.form-select-sm .ts-control { font-size: 0.875rem; min-height: calc(1.5em + .5rem + 2px); padding-top: .25rem; padding-bottom: .25rem; }
        .ts-dropdown { font-size: 0.85rem; }
        .ts-dropdown .ts-dropdown-content { max-height: 280px; }
        .ts-dropdown .optgroup-header { font-weight: 700; color: #64748B; }
    </style>
    @endpush

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
    <script>
    (function () {
        var swimSelect = document.querySelector('[data-result-swim-select]');
        var swimCustom = document.querySelector('[data-result-swim-custom]');
        var swimValue  = document.querySelector('[data-result-swim-value]');
        function syncSwim() {
            var custom = swimSelect.value === '__custom__';
            swimCustom.classList.toggle('d-none', !custom);
            swimValue.value = custom ? swimCustom.value : swimSelect.value;
        }
        if (swimSelect && window.TomSelect) {
            // Select bawaan browser bisa membuka ke atas; Tom Select selalu ke bawah.
            new TomSelect(swimSelect, {
                allowEmptyOption: true,
                maxOptions: null,
                placeholder: '— Pilih Nomor —',
            });
        }
        if (swimSelect && swimCustom && swimValue) {
            swimSelect.addEventListener('change', function () { syncSwim(); if (swimSelect.value === '__custom__') swimCustom.focus(); });
            swimCustom.addEventListener('input', syncSwim);
            syncSwim();
        }

        var athleteSelect = document.querySelector('[data-result-athlete-select]');
        var athleteName   = document.querySelector('[data-result-athlete-name]');
        var manualOnly    = document.querySelectorAll('[data-result-manual-only]');
        function syncAthlete() {
            var isMember = athleteSelect.value !== '';
            athleteName.classList.toggle('d-none', isMember);
            athleteName.required = !isMember;
            if (isMember) athleteName.value = '';
            manualOnly.forEach(function (el) { el.classList.toggle('d-none', isMember); });
        }
        if (athleteSelect && athleteName) {
            athleteSelect.addEventListener('change', syncAthlete);
            syncAthlete();
        }

        var editForm = document.querySelector('[data-edit-result-form]');
        if (editForm) {
            var editAthleteSelect = editForm.querySelector('[data-edit-athlete-select]');
            var editAthleteName   = editForm.querySelector('[data-edit-athlete-name]');
            var editManualOnly    = editForm.querySelectorAll('[data-edit-manual-only]');

            function syncEditAthlete() {
                var isMember = editAthleteSelect.value !== '';
                editAthleteName.classList.toggle('d-none', isMember);
                editAthleteName.required = !isMember;
                editManualOnly.forEach(function (el) { el.classList.toggle('d-none', isMember); });
            }
            editAthleteSelect.addEventListener('change', syncEditAthlete);

            document.querySelectorAll('[data-result-edit]').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    var data = JSON.parse(btn.getAttribute('data-result-edit'));
                    editForm.action = data.action;
                    ['swim_event', 'age_group', 'gender', 'team_member_id', 'athlete_name', 'school_name', 'birth_date', 'club', 'heat', 'lane', 'rank', 'time', 'note']
                        .forEach(function (field) {
                            var input = editForm.elements[field];
                            if (input) input.value = data[field] == null ? '' : data[field];
                        });
                    syncEditAthlete();
                    openEditModal();
                });
            });

            var editModal = document.getElementById('editResultModal');
            var editBackdrop = null;
            function openEditModal() {
                editModal.style.display = 'block';
                editModal.removeAttribute('aria-hidden');
                editModal.setAttribute('aria-modal', 'true');
                document.body.classList.add('modal-open');
                editBackdrop = document.createElement('div');
                editBackdrop.className = 'modal-backdrop fade';
                document.body.appendChild(editBackdrop);
                void editModal.offsetWidth;
                editModal.classList.add('show');
                editBackdrop.classList.add('show');
                var first = editForm.elements['swim_event'];
                if (first) first.focus();
            }
            function closeEditModal() {
                editModal.classList.remove('show');
                editModal.setAttribute('aria-hidden', 'true');
                editModal.removeAttribute('aria-modal');
                document.body.classList.remove('modal-open');
                if (editBackdrop) { editBackdrop.remove(); editBackdrop = null; }
                window.setTimeout(function () { editModal.style.display = 'none'; }, 150);
            }
            editModal.querySelectorAll('[data-edit-modal-close]').forEach(function (b) {
                b.addEventListener('click', closeEditModal);
            });
            editModal.addEventListener('click', function (e) {
                if (e.target === editModal) closeEditModal();
            });
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape' && editModal.classList.contains('show')) closeEditModal();
            });
        }
    })();
    </script>
    @endpush

@endsection
