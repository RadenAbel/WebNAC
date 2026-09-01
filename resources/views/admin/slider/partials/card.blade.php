<div class="nac-admin-grid-card">
    <img src="{{ $slider->image_url }}" alt="{{ $slider->title }}"
        class="nac-admin-grid-card__img" style="aspect-ratio:16/9;">
    <div class="nac-admin-grid-card__body">
        <div class="nac-admin-grid-card__title">{{ $slider->title ?? '(tanpa judul)' }}</div>
        <div class="nac-admin-grid-card__footer">
            @if ($slider->is_active)
                <span class="badge bg-success">Aktif</span>
            @else
                <span class="badge bg-secondary">Nonaktif</span>
            @endif
            <div>
                <a href="{{ route('admin.sliders.edit', $slider) }}" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-pencil"></i>
                </a>
                <form action="{{ route('admin.sliders.destroy', $slider) }}" method="POST" class="d-inline"
                    onsubmit="return confirm('Yakin hapus slider ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                </form>
            </div>
        </div>
    </div>
</div>