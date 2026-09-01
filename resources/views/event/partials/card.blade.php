@php
    $hasPdf    = !empty($event->pdf_url);
    $detailUrl = $hasPdf ? $event->pdf_url : route('event.show', $event);
@endphp

<article class="nac-event-card">
    <a href="{{ $detailUrl }}"
       @if($hasPdf) target="_blank" rel="noopener" @endif
       class="nac-event-card__link" aria-label="Lihat detail acara {{ $event->title }}">
        <div class="nac-event-card__photo">
            @if ($event->photo_url)
                <img src="{{ $event->photo_url }}" alt="Foto {{ $event->title }}" loading="lazy">
            @else
                <div class="nac-event-card__no-photo">
                    <i class="fa-solid fa-image"></i>
                    <span>No Image</span>
                </div>
            @endif
        </div>

        <span class="nac-event-card__shine" aria-hidden="true"></span>

        <div class="nac-event-card__overlay">
            <h5 class="nac-event-card__name">{{ $event->title }}</h5>
            @if ($event->event_date_label)
                <span class="nac-event-card__date">
                    <i class="fa-solid fa-calendar-days"></i> {{ $event->event_date_label }}
                </span>
            @endif
        </div>
    </a>

    <div class="nac-event-card__footer nac-event-card__footer--center">
        <a href="{{ $detailUrl }}"
           @if($hasPdf) target="_blank" rel="noopener" @endif
           class="nac-event-card__detail-btn">
            View Detail <i class="fa-solid fa-arrow-right"></i>
        </a>
    </div>
</article>