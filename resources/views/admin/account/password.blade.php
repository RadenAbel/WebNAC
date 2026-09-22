@extends('admin.layouts.app')

@section('admin_title', 'Ganti Password')

@section('admin_content')

    <div class="mb-4">
        <h1 class="h4 mb-1">Ganti Password</h1>
        <p class="text-secondary mb-0" style="font-size:0.9rem;">
            Akun: <strong>{{ auth()->user()->name }}</strong> ({{ auth()->user()->email }})
        </p>
    </div>

    @include('admin.partials.toast')

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="bg-white border rounded-3 p-4">
                <form action="{{ route('admin.password.update') }}" method="POST" novalidate>
                    @csrf
                    @method('PUT')

                    @foreach ([
                        ['name' => 'current_password',      'label' => 'Password Lama',              'autocomplete' => 'current-password'],
                        ['name' => 'password',              'label' => 'Password Baru',              'autocomplete' => 'new-password'],
                        ['name' => 'password_confirmation', 'label' => 'Konfirmasi Password Baru',   'autocomplete' => 'new-password'],
                    ] as $field)
                        <div class="mb-3">
                            <label for="{{ $field['name'] }}" class="form-label">
                                {{ $field['label'] }} <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <input
                                    type="password"
                                    name="{{ $field['name'] }}"
                                    id="{{ $field['name'] }}"
                                    class="form-control @error($field['name']) is-invalid @enderror"
                                    autocomplete="{{ $field['autocomplete'] }}"
                                    required>
                                <button type="button" class="btn btn-outline-secondary" data-toggle-password="{{ $field['name'] }}"
                                    aria-label="Tampilkan/sembunyikan {{ strtolower($field['label']) }}">
                                    <i class="bi bi-eye"></i>
                                </button>
                                @error($field['name'])
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    @endforeach

                    <button type="submit" class="btn nac-admin-btn mt-2">
                        <i class="bi bi-shield-check"></i> Simpan Password Baru
                    </button>
                </form>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="bg-white border rounded-3 p-4">
                <p class="fw-bold mb-2" style="font-size:0.9rem;"><i class="bi bi-info-circle me-1"></i> Ketentuan password baru</p>
                <ul class="text-secondary mb-3" style="font-size:0.85rem; padding-left:1.1rem;">
                    <li>Minimal 8 karakter</li>
                    <li>Mengandung huruf dan angka</li>
                    <li>Berbeda dari password lama</li>
                </ul>
                <p class="fw-bold mb-2" style="font-size:0.9rem;"><i class="bi bi-phone me-1"></i> Setelah password diganti</p>
                <p class="text-secondary mb-0" style="font-size:0.85rem;">
                    Perangkat ini tetap login. Perangkat lain yang sedang memakai akun ini
                    (misalnya laptop atau HP lain) akan otomatis ter-logout dan perlu login
                    ulang dengan password baru.
                </p>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    document.querySelectorAll('[data-toggle-password]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var input = document.getElementById(btn.getAttribute('data-toggle-password'));
            var icon = btn.querySelector('i');
            if (!input) return;
            var show = input.type === 'password';
            input.type = show ? 'text' : 'password';
            icon.className = show ? 'bi bi-eye-slash' : 'bi bi-eye';
        });
    });
</script>
@endpush