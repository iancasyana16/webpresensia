<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100">
    <div class="flex h-screen overflow-hidden">
        <div class="flex-1 h-full sticky top-0 z-50">
            @include('components.sidebar')
        </div>
        <div class="flex-4 overflow-y-auto">
            @yield('content')
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toast = document.getElementById('successToast');
            if (toast) {
                setTimeout(() => {
                    toast.classList.add('opacity-0');
                    toast.addEventListener('transitionend', () => {
                        toast.remove();
                    });
                }, 5000);
            }
        });
    </script>
</body>

</html>