@extends('admin.layouts.app')

@section('admin_title', 'Jadwal')

@section('admin_content')

    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-4">
        <div>
            <h1 class="h4 fw-bold mb-1">Jadwal Latihan</h1>
            <p class="text-secondary mb-0" style="font-size:0.9rem;">Kelola jadwal latihan per kategori.</p>
        </div>
        <a href="{{ route('admin.schedules.create') }}" class="btn nac-admin-btn">
            <i class="bi bi-plus-lg me-1"></i> Tambah Jadwal
        </a>
    </div>

    @if (session('status'))
        <div class="alert alert-success py-2 px-3 mb-3" style="font-size:0.9rem;">{{ session('status') }}</div>
    @endif

    <div class="bg-white border rounded-3 overflow-hidden">
        <table class="table align-middle mb-0">
            <thead style="background:#f8f9fb;">
                <tr style="font-size:0.8rem; text-transform:uppercase; letter-spacing:.04em; color:#6b7a8a;">
                    <th>Kategori</th>
                    <th>Hari</th>
                    <th>Jam</th>
                    <th class="text-center">Status</th>
                    <th class="text-end" style="width:160px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($schedules as $schedule)
                    <tr>
                        <td class="fw-bold">{{ $schedule->category }}</td>
                        <td>{{ $schedule->days_label }}</td>
                        <td>{{ $schedule->time_label }}</td>
                        <td class="text-center">
                            @if ($schedule->is_active)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary">Nonaktif</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.schedules.edit', $schedule) }}" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            <form action="{{ route('admin.schedules.destroy', $schedule) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Yakin hapus jadwal ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-secondary py-4">
                            Belum ada jadwal. Klik "Tambah Jadwal" untuk mulai.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection