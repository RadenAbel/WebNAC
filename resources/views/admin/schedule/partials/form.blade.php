@csrf

@php
    $allDays = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
    $selectedDays = old('days', $schedule->days ?? []);
@endphp

<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label fw-bold">Kategori <span class="text-danger">*</span></label>
        <input type="text" name="category" class="form-control @error('category') is-invalid @enderror"
            value="{{ old('category', $schedule->category) }}" placeholder="Junior / Senior / Swim Class A, dst." required>
        @error('category') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-3">
        <label class="form-label fw-bold">Jam Mulai <span class="text-danger">*</span></label>
        <input type="time" name="time_start" class="form-control @error('time_start') is-invalid @enderror"
            value="{{ old('time_start', $schedule->time_start ? substr($schedule->time_start, 0, 5) : '') }}" required>
        @error('time_start') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-3">
        <label class="form-label fw-bold">Jam Selesai <span class="text-danger">*</span></label>
        <input type="time" name="time_end" class="form-control @error('time_end') is-invalid @enderror"
            value="{{ old('time_end', $schedule->time_end ? substr($schedule->time_end, 0, 5) : '') }}" required>
        @error('time_end') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-12">
        <label class="form-label fw-bold">Hari Latihan <span class="text-danger">*</span></label>
        <div class="d-flex flex-wrap gap-3 border rounded-3 p-3 @error('days') is-invalid @enderror">
            @foreach ($allDays as $day)
                <div class="form-check">
                    <input type="checkbox" name="days[]" value="{{ $day }}" class="form-check-input" id="day{{ $day }}"
                        {{ in_array($day, $selectedDays) ? 'checked' : '' }}>
                    <label class="form-check-label" for="day{{ $day }}">{{ $day }}</label>
                </div>
            @endforeach
        </div>
        @error('days') <div class="text-danger" style="font-size:0.8rem;">{{ $message }}</div> @enderror
        @error('days.*') <div class="text-danger" style="font-size:0.8rem;">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label fw-bold">Urutan Tampil</label>
        <input type="number" name="sort_order" min="0" class="form-control @error('sort_order') is-invalid @enderror"
            value="{{ old('sort_order', $schedule->sort_order ?? 0) }}">
        <small class="text-secondary" style="font-size:0.78rem;">Angka lebih kecil tampil lebih dulu.</small>
    </div>

    <div class="col-md-6 d-flex align-items-center">
        <div class="form-check mt-4">
            <input type="checkbox" name="is_active" value="1" class="form-check-input" id="isActive"
                {{ old('is_active', $schedule->is_active ?? true) ? 'checked' : '' }}>
            <label class="form-check-label fw-bold" for="isActive">Aktif (tampil di website)</label>
        </div>
    </div>
</div>