@props(['type' => null, 'message' => null])

@php
    if (!$message) {
        if (session()->has('success')) {
            $type = 'success';
            $message = session('success');
        } elseif (session()->has('error')) {
            $type = 'error';
            $message = session('error');
        } elseif (session()->has('warning')) {
            $type = 'warning';
            $message = session('warning');
        } elseif (session()->has('info')) {
            $type = 'info';
            $message = session('info');
        }
    }
@endphp

@if($message)
    <div id="toast" @class([
        'fixed top-5 right-5 z-50 text-white px-4 py-3 rounded shadow-lg transition-opacity duration-500',
        'bg-green-500' => $type === 'success',
        'bg-red-500' => $type === 'error',
        'bg-yellow-500 text-black' => $type === 'warning',
        'bg-blue-500' => $type === 'info',
    ])>
        {{ $message }}
    </div>

    <script>
        setTimeout(() => {
            const toast = document.getElementById('toast');
            if (toast) {
                toast.style.opacity = '0';
                setTimeout(() => toast.remove(), 500);
            }
        }, 5000);
    </script>
@endif