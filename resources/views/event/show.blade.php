@extends('layouts.app')

@section('title', $event->title . ' — ' . 'Hasil Pertandingan Nugroho Aquatic Club')
@section('meta_description', 'Hasil lengkap' . ' ' . $event->title . ($event->event_date_label ? ' (' . $event->event_date_label . ')' : '') . ' — ' . 'per nomor lomba, kelompok umur, dan jenis kelamin. Nugroho Aquatic Club, Sangatta, Kutai Timur.')
@if ($event->photo_url)
    @section('og_image', $event->photo_url)
@endif

@section('content')

<section class="nac-page-header @if($event->photo_url) nac-page-header--photo @endif"
    @if($event->photo_url) style="background-image: url('{{ $event->photo_url }}');" @endif>
    <div class="container" data-aos="fade-up">
        <h1 class="nac-page-header__title">{{ $event->title }}</h1>
        @if ($event->event_date_label)
            <p class="nac-result-date">
                <i class="fa-regular fa-calendar"></i> {{ $event->event_date_label }}
            </p>
        @endif
    </div>
</section>

<section class="nac-section nac-section--tint nac-result-section">
    <div class="container">

        @if ($event->description)
            <p class="nac-result-desc" data-aos="fade-up">{{ $event->description }}</p>
        @endif

        @if ($groups->isEmpty())
            <div class="nac-result-empty" data-aos="fade-up">
                <i class="fa-solid fa-stopwatch"></i>
                <p>Hasil kejuaraan ini belum tersedia.</p>
            </div>
        @else

            <div class="nac-result-filter" data-result-filter data-aos="fade-up">
                <div class="nac-result-filter__field">
                    <label for="filterAge">Kelompok Umur</label>
                    <select id="filterAge" data-filter-age>
                        <option value="">Semua Kelompok Umur</option>
                        @foreach ($filters['age_groups'] as $ag)
                            <option value="{{ $ag }}">{{ $ag }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="nac-result-filter__field">
                    <label for="filterGender">Jenis Kelamin</label>
                    <select id="filterGender" data-filter-gender>
                        <option value="">Semua</option>
                        @foreach ($filters['genders'] as $gKey => $gLabel)
                            <option value="{{ $gKey }}">{{ $gLabel }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="nac-result-filter__field">
                    <label for="filterEvent">Nomor Lomba</label>
                    <select id="filterEvent" data-filter-event>
                        <option value="">Semua Nomor Lomba</option>
                        @foreach ($filters['swim_events'] as $se)
                            <option value="{{ $se }}">{{ $se }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="nac-result-filter__field nac-result-filter__field--search">
                    <label for="filterSearch">Cari Atlet</label>
                    <div class="nac-result-filter__search">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input type="search" id="filterSearch" placeholder="Ketik nama atlet..." data-filter-search autocomplete="off">
                    </div>
                </div>
            </div>

            <p class="nac-result-count" data-result-count></p>

            <div class="nac-result-groups">
                @foreach ($groups as $group)
                    <div class="nac-result-group"
                        data-result-group
                        data-age="{{ $group->age_group }}"
                        data-gender="{{ $group->gender }}"
                        data-event="{{ $group->swim_event }}">

                        @php $groupId = 'grp-' . $loop->index; @endphp
                        <button type="button" class="nac-result-group__head" data-result-toggle
                            aria-expanded="false" aria-controls="{{ $groupId }}">
                            <span class="nac-result-group__title">{{ $group->swim_event }}</span>
                            <span class="nac-result-group__tags">
                                @if ($group->age_group)
                                    <span class="nac-result-tag">{{ $group->age_group }}</span>
                                @endif
                                <span class="nac-result-tag nac-result-tag--{{ $group->gender }}">{{ $group->gender_label }}</span>
                                <span class="nac-result-group__count">{{ $group->rows->count() }} atlet</span>
                                <span class="nac-result-group__chevron" aria-hidden="true"><i class="fa-solid fa-chevron-down"></i></span>
                            </span>
                        </button>

                        <div class="table-responsive nac-result-group__body" id="{{ $groupId }}" hidden>
                            <table class="nac-result-table nac-result-table--fixed">
                                <colgroup>
                                    <col style="width:80px;">
                                    <col style="width:64px;">
                                    <col style="width:88px;">
                                    <col style="width:28%;">
                                    <col>
                                    <col style="width:150px;">
                                    <col style="width:140px;">
                                </colgroup>
                                <thead>
                                    <tr>
                                        <th class="nac-result-table__rank">Rank</th>
                                        <th class="nac-result-table__num">Seri</th>
                                        <th class="nac-result-table__num">Lintasan</th>
                                        <th>Nama</th>
                                        <th>Asal Sekolah</th>
                                        <th class="nac-result-table__time">Waktu</th>
                                        <th class="nac-result-table__gap">Gap</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($group->rows as $row)
                                        <tr data-result-row data-name="{{ Str::lower($row->athlete_name) }}"
                                            class="{{ $row->team_member_id ? 'is-nac' : '' }}">
                                            <td class="nac-result-table__rank">
                                                @if ($row->medal)
                                                    <span class="nac-rank-medal nac-rank-medal--{{ $row->medal }}" title="Peringkat {{ $row->rank }}">{{ $row->rank }}</span>
                                                @else
                                                    <span class="nac-rank-plain">{{ $row->rank ?? '-' }}</span>
                                                @endif
                                            </td>
                                            <td class="nac-result-table__num">{{ $row->heat !== null ? 'S' . $row->heat : '-' }}</td>
                                            <td class="nac-result-table__num">{{ $row->lane !== null ? 'L' . $row->lane : '-' }}</td>
                                            <td class="nac-result-table__athlete">
                                                @if ($row->profile_url)
                                                    <a href="{{ $row->profile_url }}">{{ $row->athlete_name }}</a>
                                                @else
                                                    {{ $row->athlete_name }}
                                                @endif
                                            </td>
                                            <td class="nac-result-table__school">{{ $row->school_label ?? '-' }}</td>
                                            <td class="nac-result-table__time">
                                                @if ($row->note)
                                                    <span class="nac-result-note">{{ $row->note }}</span>
                                                @else
                                                    {{ $row->time_label ?? '-' }}
                                                @endif
                                            </td>
                                            <td class="nac-result-table__gap">{{ $row->gap_label ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="nac-result-empty d-none" data-result-empty>
                <i class="fa-solid fa-filter-circle-xmark"></i>
                <p>Tidak ada hasil yang cocok dengan filter ini.</p>
            </div>
        @endif
    </div>
</section>

@if ($groups->isNotEmpty())
<script>
(function () {
    var ageSel    = document.querySelector('[data-filter-age]');
    var eventSel  = document.querySelector('[data-filter-event]');
    var search    = document.querySelector('[data-filter-search]');
    var genderSel = document.querySelector('[data-filter-gender]');
    var groups    = document.querySelectorAll('[data-result-group]');
    var emptyBox  = document.querySelector('[data-result-empty]');
    var countEl   = document.querySelector('[data-result-count]');

    function apply() {
        var age = ageSel.value, gender = genderSel.value, ev = eventSel.value, q = search.value.trim().toLowerCase();
        var shownGroups = 0, shownRows = 0;

        groups.forEach(function (g) {
            var match = (!age || g.dataset.age === age)
                && (!gender || g.dataset.gender === gender)
                && (!ev || g.dataset.event === ev);

            var rowsVisible = 0;
            g.querySelectorAll('[data-result-row]').forEach(function (r) {
                var ok = match && (!q || r.dataset.name.indexOf(q) !== -1);
                r.classList.toggle('d-none', !ok);
                if (ok) rowsVisible++;
            });

            var showGroup = match && rowsVisible > 0;
            g.classList.toggle('d-none', !showGroup);
            if (q && showGroup) setOpen(g, true);
            if (showGroup) { shownGroups++; shownRows += rowsVisible; }
        });

        emptyBox.classList.toggle('d-none', shownGroups > 0);
        countEl.textContent = shownGroups > 0
            ? @json('Menampilkan :rows hasil dari :groups nomor lomba').replace(':rows', shownRows).replace(':groups', shownGroups)
            : '';
    }

    function setOpen(g, open) {
        var btn = g.querySelector('[data-result-toggle]');
        var body = g.querySelector('.nac-result-group__body');
        g.classList.toggle('is-open', open);
        btn.setAttribute('aria-expanded', open ? 'true' : 'false');
        body.hidden = !open;
    }
    groups.forEach(function (g) {
        g.querySelector('[data-result-toggle]').addEventListener('click', function () {
            setOpen(g, !g.classList.contains('is-open'));
        });
    });

    ageSel.addEventListener('change', apply);
    eventSel.addEventListener('change', apply);
    search.addEventListener('input', apply);
    genderSel.addEventListener('change', apply);

    apply();
})();
</script>
@endif

@endsection
