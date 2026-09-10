<div class="nac-admin-grid-card">
    <img src="{{ $gallery->image_url }}" alt="{{ $gallery->caption }}"
        class="nac-admin-grid-card__img" style="aspect-ratio:4/5;">
    <div class="nac-admin-grid-card__body">
        <div class="nac-admin-grid-card__title">{{ $gallery->caption ?? '(tanpa caption)' }}</div>
        <div class="nac-admin-grid-card__footer">
            @if ($gallery->is_active)
                <span class="badge bg-success">Aktif</span>
            @else
                <span class="badge bg-secondary">Nonaktif</span>
            @endif
            <div>
                <a href="{{ route('admin.galleries.edit', $gallery) }}" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-pencil"></i>
                </a>
                <form action="{{ route('admin.galleries.destroy', $gallery) }}" method="POST" class="d-inline nac-confirm-delete-form"
                    data-confirm-title="Hapus foto ini?"
                    data-confirm-text="{{ $gallery->caption ?? 'Foto ini' }} akan dihapus secara permanen dari galeri.">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                </form>
            </div>
        </div>
    </div>
</div>