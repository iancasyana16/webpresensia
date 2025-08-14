<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100">
    <div class="container-fluid">
        @include('components.navbar')
    </div>
    <div class="container m-auto">
        @yield('content')
    </div>
</body>

<script src="https://js.pusher.com/7.2/pusher.min.js"></script>

@stack('scripts')

</html>