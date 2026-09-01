@extends('admin.layouts.app')

@section('admin_title', 'Jadwal')

@section('admin_content')

    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-4">
        <div>
            <h1 class="h4 mb-1">Jadwal Latihan</h1>
            <p class="text-secondary mb-0" style="font-size:0.9rem;">Kelola jadwal latihan per kategori.</p>
        </div>
        <a href="{{ route('admin.schedules.create') }}" class="btn nac-admin-btn">
            <i class="bi bi-plus-lg"></i> Tambah Jadwal
        </a>
    </div>

    @if (session('status'))
        <div class="alert alert-success py-2 px-3 mb-3" style="font-size:0.9rem;">{{ session('status') }}</div>
    @endif

    <div class="bg-white border rounded-3 overflow-hidden">
        @if ($schedules->isEmpty())
            <div class="nac-admin-empty">
                <div class="nac-admin-empty__icon"><i class="bi bi-calendar-week"></i></div>
                <p class="nac-admin-empty__title">Belum ada jadwal</p>
                <p class="nac-admin-empty__desc">Tambahkan jadwal latihan pertama untuk website.</p>
                <a href="{{ route('admin.schedules.create') }}" class="btn nac-admin-btn">
                    <i class="bi bi-plus-lg"></i> Tambah Jadwal
                </a>
            </div>
        @else
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Kategori</th>
                        <th>Hari</th>
                        <th>Jam</th>
                        <th class="text-center">Status</th>
                        <th class="text-end" style="width:160px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($schedules as $schedule)
                        <tr>
                            <td class="fw-bold">{{ $schedule->category }}</td>
                            <td>
                                @foreach ($schedule->days ?? [] as $day)
                                    <span class="nac-day-chip">{{ substr($day, 0, 3) }}</span>
                                @endforeach
                            </td>
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
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

@endsection