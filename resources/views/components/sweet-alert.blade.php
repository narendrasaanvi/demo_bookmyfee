<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if ($message)
    <script>
        Swal.fire({
            icon: "{{ $type }}", // 'success', 'error', 'warning', etc.
            title: "{{ ucfirst($type) }}",
            text: "{{ $message }}",
            confirmButtonText: 'OK',
            timer: 7000
        });
    </script>
@endif
