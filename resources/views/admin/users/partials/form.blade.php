@csrf

<div class="row g-4">
    <div class="col-md-6">
        <label class="form-label">Nama <span class="text-danger">*</span></label>
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
            value="{{ old('name', $user->name) }}" required>
        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">Email <span class="text-danger">*</span></label>
        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
            value="{{ old('email', $user->email) }}" required>
        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">
            Password
            @if($user->exists) <span class="text-secondary fw-normal">(kosongkan kalau tidak diubah)</span> @else <span class="text-danger">*</span> @endif
        </label>
        <div class="input-group has-validation">
            <input type="password" name="password" id="userPassword" class="form-control @error('password') is-invalid @enderror" autocomplete="new-password">
            <button type="button" class="btn btn-outline-secondary" data-toggle-password="userPassword" aria-label="Tampilkan/sembunyikan password"><i class="bi bi-eye"></i></button>
            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
    </div>

    <div class="col-md-6">
        <label class="form-label">
            Konfirmasi Password
            @if(!$user->exists) <span class="text-danger">*</span> @endif
        </label>
        <div class="input-group">
            <input type="password" name="password_confirmation" id="userPasswordConfirm" class="form-control" autocomplete="new-password">
            <button type="button" class="btn btn-outline-secondary" data-toggle-password="userPasswordConfirm" aria-label="Tampilkan/sembunyikan konfirmasi password"><i class="bi bi-eye"></i></button>
        </div>
    </div>

    <div class="col-md-6">
        <label class="form-label">Role <span class="text-danger">*</span></label>
        <select name="role" id="roleSelect" class="form-select @error('role') is-invalid @enderror" required>
            <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
            <option value="super_admin" {{ old('role', $user->role) === 'super_admin' ? 'selected' : '' }}>Super Admin</option>
        </select>
        @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
        <small class="text-secondary">
            <strong>Admin</strong>: bisa kelola konten (Slider, Galeri, Tim, dst) sesuai izin yang dicentang di bawah.
            <strong>Super Admin</strong>: semua akses Admin + Pengaturan Situs + Kelola Akun Admin (izin di bawah diabaikan, selalu akses semua).
        </small>
    </div>
</div>

@php
    $selectedPermissions = old('permissions', $user->permissions ?? array_keys(config('admin_sections')));
@endphp
<div id="permissionsBlock" class="mt-4 @if(old('role', $user->role) === 'super_admin') d-none @endif">
    <label class="form-label fw-bold">Izin Akses Menu</label>
    <p class="text-secondary mb-2" style="font-size:0.82rem;">Centang menu yang boleh diakses akun ini. Menu yang tidak dicentang akan disembunyikan dari sidebar dan ditolak (403) kalau diakses lewat URL langsung.</p>
    <div class="row g-2 border rounded-3 p-3" style="background:#fafbfc;">
        @foreach (config('admin_sections') as $key => $label)
            <div class="col-md-6">
                <div class="form-check">
                    <input type="checkbox" name="permissions[]" value="{{ $key }}" class="form-check-input" id="perm-{{ $key }}"
                        {{ in_array($key, $selectedPermissions) ? 'checked' : '' }}>
                    <label class="form-check-label" for="perm-{{ $key }}" style="font-size:0.88rem;">{{ $label }}</label>
                </div>
            </div>
        @endforeach
    </div>
</div>

<div class="mt-4">
    <button type="submit" class="btn nac-admin-btn">
        <i class="bi bi-check-lg"></i> {{ $user->exists ? 'Simpan Perubahan' : 'Buat Akun' }}
    </button>
    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Batal</a>
</div>

@push('scripts')
<script>
    (function () {
        var roleSelect = document.getElementById('roleSelect');
        var permBlock = document.getElementById('permissionsBlock');
        if (!roleSelect || !permBlock) return;

        function sync() {
            permBlock.classList.toggle('d-none', roleSelect.value === 'super_admin');
        }
        roleSelect.addEventListener('change', sync);
        sync();
    })();
</script>
@endpush