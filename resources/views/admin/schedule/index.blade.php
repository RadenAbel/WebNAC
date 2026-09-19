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

    @include('admin.partials.toast')

    <div class="bg-white border rounded-3 overflow-hidden d-none d-md-block">
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
                                <form action="{{ route('admin.schedules.destroy', $schedule) }}" method="POST" class="d-inline nac-confirm-delete-form"
                                    data-confirm-title="Hapus jadwal ini?"
                                    data-confirm-text="Jadwal ini akan terhapus secara permanen.">
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

    {{-- ============ VERSI KARTU (khusus mobile) ============ --}}
    <div class="d-md-none">
        @if ($schedules->isEmpty())
            <div class="bg-white border rounded-3">
                <div class="nac-admin-empty">
                    <div class="nac-admin-empty__icon"><i class="bi bi-calendar-week"></i></div>
                    <p class="nac-admin-empty__title">Belum ada jadwal</p>
                    <p class="nac-admin-empty__desc">Tambahkan jadwal latihan pertama untuk website.</p>
                    <a href="{{ route('admin.schedules.create') }}" class="btn nac-admin-btn">
                        <i class="bi bi-plus-lg"></i> Tambah Jadwal
                    </a>
                </div>
            </div>
        @else
            <div class="d-flex flex-column gap-2">
                @foreach ($schedules as $schedule)
                    <div class="nac-admin-member-card">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div class="fw-bold" style="font-size:0.95rem;">{{ $schedule->category }}</div>
                            @if ($schedule->is_active)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary">Nonaktif</span>
                            @endif
                        </div>
                        <div class="mb-1">
                            @foreach ($schedule->days ?? [] as $day)
                                <span class="nac-day-chip">{{ substr($day, 0, 3) }}</span>
                            @endforeach
                        </div>
                        <div class="text-secondary mb-3" style="font-size:0.85rem;">
                            <i class="bi bi-clock me-1"></i>{{ $schedule->time_label }}
                        </div>
                        <div class="nac-admin-member-card__actions" style="border-top:1px solid var(--adm-mist); padding-top:0.75rem;">
                            <a href="{{ route('admin.schedules.edit', $schedule) }}" class="btn btn-sm btn-outline-secondary flex-grow-1">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            <form action="{{ route('admin.schedules.destroy', $schedule) }}" method="POST" class="flex-grow-1 nac-confirm-delete-form"
                                data-confirm-title="Hapus jadwal ini?"
                                data-confirm-text="Jadwal ini akan terhapus secara permanen.">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger w-100">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

@endsection