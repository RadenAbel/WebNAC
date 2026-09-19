{{--
    Toast notifikasi sukses (SweetAlert2) — dipakai bersama di semua halaman
    admin (Slider, Galeri, Jadwal, Hasil Pertandingan, Tim, Tim Manajemen,
    Pengaturan Situs, Pendaftaran) supaya gayanya konsisten satu sama lain.

    Cara pakai: taruh {{ '@include(\'admin.partials.toast\')' }} di mana saja
    dalam halaman yang membaca session('status') — biasanya cukup sekali di
    bagian atas, menggantikan <div class="alert alert-success">...</div>
    yang lama.
--}}
@if (session('status'))
    @push('scripts')
    <script>
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: @json(session('status')),
            showConfirmButton: false,
            timer: 3500,
            timerProgressBar: true,
        });
    </script>
    @endpush
@endif