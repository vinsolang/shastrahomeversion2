@php
    $toastType = session()->has('success') ? 'success' : (session()->has('error') ? 'error' : null);
    $toastMessage = $toastType ? session($toastType) : null;
@endphp

@if ($toastType && is_string($toastMessage) && $toastMessage !== '')
    <script>
        (() => {
            if (!window.Swal) {
                return;
            }

            const closeToast = () => {
                Swal.close();
            };

            window.addEventListener('pagehide', closeToast, {
                once: true
            });
            window.addEventListener('beforeunload', closeToast, {
                once: true
            });
            window.addEventListener('pageshow', (event) => {
                if (event.persisted) {
                    closeToast();
                }
            });

            const toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (alert) => {
                    alert.onmouseenter = Swal.stopTimer;
                    alert.onmouseleave = Swal.resumeTimer;
                }
            });

            toast.fire({
                icon: @json($toastType),
                title: @json($toastMessage)
            });
        })();
    </script>
{{-- @elseif ($errors->any())
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });

        @foreach ($errors->all() as $error)
            Toast.fire({
                icon: "error",
                title: "{{ $error }}"
            });
        @endforeach
    </script> --}}
@endif
