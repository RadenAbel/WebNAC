@php
    $isCoach   = $member->role === 'pelatih';
    $roleLabel = $isCoach ? 'Pelatih' : 'Atlet';

    // Alamat profil berbentuk nama (slug), mis. /our-team/javiero-jesaya-lengkong.
    // Cadangan ke id cuma untuk jaga-jaga kalau slug belum terisi — alamat
    // berbentuk angka itu otomatis dialihkan ke alamat nama oleh TeamController.
    $detailUrl = $member->url ?? route('team.show', $member->slug ?: $member->id);
@endphp

<a href="{{ $detailUrl }}" class="nac-team-card" aria-label="Lihat profil {{ $member->name }} ({{ $roleLabel }})">
    <div class="nac-team-card__photo @if(empty($member->photo_url)) is-empty @endif">
        @if(!empty($member->photo_url))
            <img src="{{ $member->photo_url }}"
                 alt="Foto {{ $member->name }}"
                 loading="lazy"
                 onload="this.parentElement.classList.add('is-loaded')">
        @else
            <div class="nac-photo-placeholder">
                <i class="fa-solid fa-image"></i>
                <span>Foto belum tersedia</span>
            </div>
        @endif
    </div>

    <span class="nac-team-card__shine" aria-hidden="true"></span>

    <div class="nac-team-card__overlay">
        <span class="nac-team-card__role">{{ $roleLabel }}</span>
        <h5 class="nac-team-card__name">{{ $member->name }}</h5>
        <div class="nac-team-card__meta">
            @if($member->age)
                <span class="nac-team-card__age">{{ $member->age }} th</span>
            @endif
            @if($member->category)
                <span class="nac-team-card__badge">{{ $member->category }}</span>
            @endif
        </div>
    </div>

    <div class="nac-team-card__label">
        <span class="nac-team-card__label-text">{{ $member->name }}</span>
        <i class="fa-solid fa-chevron-right nac-team-card__label-arrow"></i>
    </div>
</a>