@php
    $collection   = collect($members);
    $total        = $collection->count();
    $gridId       = 'fan-' . $fanId . '-grid';
    $description  = $description ?? null;
    $icon         = $icon ?? 'fa-users';

    // Hanya 3 kartu teratas yang "mengintip" di preview — sisanya disembunyikan
    // biar tetap rapi dan tidak melebar berlebihan.
    $preview      = $collection->take(3)->values();
@endphp

<div class="nac-fan-group" data-fan-group>

    <div class="nac-section__head nac-section__head--fan" data-aos="fade-up">
        <div class="nac-section__head-main">
            <span class="nac-fan__icon"><i class="fa-solid {{ $icon }}"></i></span>
            <div>
                <span class="nac-eyebrow">{{ $eyebrow }}</span>
                <h2 class="nac-section__title">{{ $title }}</h2>
                @if($description)
                    <p class="nac-fan__desc">{{ $description }}</p>
                @endif
            </div>
        </div>

        @if($total > 1)
            <button type="button"
                    class="nac-fan__trigger"
                    data-fan-trigger
                    aria-expanded="false"
                    aria-controls="{{ $gridId }}"
                    data-label-closed="{{ $labelClosed }}"
                    data-label-open="{{ $labelOpen }}">
                <span data-fan-trigger-text>{{ $labelClosed }}</span>
                <span class="nac-fan__trigger-icon"><i class="fa-solid fa-arrow-right"></i></span>
            </button>
        @endif
    </div>

    @if($total === 0)

        <p class="text-center nac-muted mt-4">{{ $emptyText }}</p>

    @elseif($total === 1)

        {{-- Satu anggota saja: tampilkan sebagai kartu tunggal, tanpa efek kipas --}}
        <div class="nac-fan__single mt-4" data-aos="fade-up">
            @include('team.partials.card', ['member' => $collection->first()])
        </div>

    @else

        {{-- ============ PREVIEW: dek kartu tertutup, ringkas & terbingkai ============ --}}
        <div class="nac-fan__preview mt-4" data-fan-preview>
            <div class="nac-fan__deck">
                <div class="nac-fan__stack">
                    @foreach($preview as $i => $member)
                        @php
                            $y      = $i * -16;                   // px, tiap lapis "menumpuk" lurus ke atas (tanpa geser kiri/kanan)
                            $scale  = round(1 - $i * 0.07, 2);    // lapis belakang sedikit mengecil
                            $z      = 30 - $i * 10;                // lapis depan paling atas
                            $bright = round(1 - $i * 0.15, 2);    // lapis belakang sedikit meredup
                        @endphp
                        <div class="nac-fan__stack-card"
                             style="--y: {{ $y }}px; --scale: {{ $scale }}; --z: {{ $z }}; --bright: {{ $bright }}; --d: {{ $i * 100 }}ms;">
                            @include('team.partials.card', ['member' => $member])
                        </div>
                    @endforeach
                </div>

                <span class="nac-fan__count" title="Total {{ $roleLabel ?? $eyebrow }}">
                    <i class="fa-solid fa-users"></i> {{ $total }}
                </span>
            </div>

            <p class="nac-fan__hint">{{ $hintText }}</p>
        </div>

        {{-- ============ GRID: tampil penuh saat dibuka ============ --}}
        <div class="nac-fan__grid" id="{{ $gridId }}" data-fan-grid>
            @foreach($collection as $i => $member)
                <div class="nac-fan__grid-item" style="--d: {{ $i * 60 }}ms;">
                    @include('team.partials.card', ['member' => $member])
                </div>
            @endforeach
        </div>

    @endif

</div>{{-- .nac-fan-group --}}