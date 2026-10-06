@php $isPastDeadline = false; @endphp
<div class="nac-admin-grid-card">
    <img src="{{ $event->photo_url ?? asset('images/default-avatar.jpg') }}" alt="{{ $event->title }}"
        class="nac-admin-grid-card__img" style="aspect-ratio:4/3;">
    <div class="nac-admin-grid-card__body">
        <div class="nac-admin-grid-card__title">{{ $event->title }}</div>
        <div class="text-secondary" style="font-size:0.76rem;">
            <i class="bi bi-calendar3 me-1"></i>{{ $event->event_date_label ?? '-' }}
        </div>
        <div class="nac-admin-grid-card__footer">
            @if ($event->is_active)
                <span class="badge bg-success">Aktif</span>
            @else
                <span class="badge bg-secondary">Nonaktif</span>
            @endif
            <div>
                <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-pencil"></i>
                </a>
                <form action="{{ route('admin.events.destroy', $event) }}" method="POST" class="d-inline nac-confirm-delete-form"
                    data-confirm-title="Hapus Hasil Pertandingan ini?"
                    data-confirm-text="Kejuaraan beserta seluruh hasil per nomor lombanya akan terhapus secara permanen.">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                </form>
            </div>
        </div>
    </div>
</div>
