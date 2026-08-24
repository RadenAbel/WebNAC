@php
    $isCoach   = $member->role === 'pelatih';
    $roleLabel = $isCoach ? 'Pelatih' : 'Atlet';

    // Mengarah ke route('team.show', ...) — sesuai routes/web.php kamu
    // (path: /our-team/{teamMember}). Route model binding pakai id, jadi
    // $member->id selalu aman dipakai di sini.
    $detailUrl = $member->url ?? route('team.show', $member->id);
@endphp

<a href="{{ $detailUrl }}" class="nac-team-card" aria-label="Lihat profil {{ $member->name }} ({{ $roleLabel }})">
    <div class="nac-team-card__photo">
        <img src="{{ $member->photo_url }}" alt="Foto {{ $member->name }}" loading="lazy">
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