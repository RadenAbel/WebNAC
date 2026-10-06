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
