@extends('admin.layouts.app')

@section('admin_title', 'Biaya Pendaftaran')

@section('admin_content')

    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-4">
        <div>
            <h1 class="h4 mb-1">Biaya Pendaftaran</h1>
            <p class="text-secondary mb-0" style="font-size:0.9rem;">
                Paket harga yang tampil di halaman Beranda, bagian "Biaya Pendaftaran".
            </p>
        </div>
        <a href="{{ route('admin.pricing.create') }}" class="btn nac-admin-btn">
            <i class="bi bi-plus-lg"></i> Tambah Paket
        </a>
    </div>

    @include('admin.partials.toast')

    <div class="bg-white border rounded-3 overflow-hidden d-none d-md-block">
        @if ($plans->isEmpty())
            <div class="nac-admin-empty">
                <div class="nac-admin-empty__icon"><i class="bi bi-tag"></i></div>
                <p class="nac-admin-empty__title">Belum ada paket harga</p>
                <p class="nac-admin-empty__desc">Klik "Tambah Paket" untuk membuat paket harga pertama.</p>
            </div>
        @else
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Nama Paket</th>
                        <th>Harga</th>
                        <th class="text-center" style="width:90px;">Diskon</th>
                        <th class="text-center" style="width:110px;">Unggulan</th>
                        <th class="text-center" style="width:100px;">Status</th>
                        <th class="text-end" style="width:120px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($plans as $plan)
                        <tr>
                            <td class="fw-bold">{{ $plan->title }}</td>
                            <td style="font-size:0.85rem;">
                                @if ($plan->has_discount)
                                    <span class="text-decoration-line-through text-secondary">{{ $plan->price_label }}</span>
                                    <span class="fw-bold text-success">{{ $plan->discounted_price_label }}</span>
                                @else
                                    {{ $plan->price_label }}
                                @endif
                            </td>
                            <td class="text-center">
                                @if ($plan->has_discount)
                                    <span class="badge bg-danger">{{ $plan->discount_percent }}%</span>
                                @else
                                    <span class="text-secondary">–</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if ($plan->is_highlighted)
                                    <span class="badge bg-warning text-dark">Ya</span>
                                @else
                                    <span class="text-secondary">–</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if ($plan->is_active)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Nonaktif</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.pricing.edit', $plan) }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.pricing.destroy', $plan) }}" method="POST" class="d-inline nac-confirm-delete-form"
                                    data-confirm-title="Hapus paket {{ $plan->title }}?"
                                    data-confirm-text="Paket ini akan terhapus secara permanen.">
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

    {{-- ============ VERSI KARTU (mobile) ============ --}}
    <div class="d-md-none">
        @if ($plans->isEmpty())
            <div class="bg-white border rounded-3">
                <div class="nac-admin-empty">
                    <div class="nac-admin-empty__icon"><i class="bi bi-tag"></i></div>
                    <p class="nac-admin-empty__title">Belum ada paket harga</p>
                    <p class="nac-admin-empty__desc">Klik "Tambah Paket" untuk membuat paket harga pertama.</p>
                </div>
            </div>
        @else
            <div class="d-flex flex-column gap-2">
                @foreach ($plans as $plan)
                    <div class="nac-admin-member-card">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="nac-admin-member-card__name">{{ $plan->title }}</div>
                                <div style="font-size:0.85rem;">
                                    @if ($plan->has_discount)
                                        <span class="text-decoration-line-through text-secondary">{{ $plan->price_label }}</span>
                                        <span class="fw-bold text-success">{{ $plan->discounted_price_label }}</span>
                                        <span class="badge bg-danger ms-1">{{ $plan->discount_percent }}%</span>
                                    @else
                                        {{ $plan->price_label }}
                                    @endif
                                </div>
                                <div class="mt-1 d-flex gap-1">
                                    @if ($plan->is_highlighted)
                                        <span class="badge bg-warning text-dark">Unggulan</span>
                                    @endif
                                    @if ($plan->is_active)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-secondary">Nonaktif</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="nac-admin-member-card__actions">
                            <a href="{{ route('admin.pricing.edit', $plan) }}" class="btn btn-sm btn-outline-secondary flex-grow-1">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            <form action="{{ route('admin.pricing.destroy', $plan) }}" method="POST" class="flex-grow-1 nac-confirm-delete-form"
                                data-confirm-title="Hapus paket {{ $plan->title }}?"
                                data-confirm-text="Paket ini akan terhapus secara permanen.">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger w-100"><i class="bi bi-trash"></i> Hapus</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

@endsection