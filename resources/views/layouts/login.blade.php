<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    @vite('resources/css/app.css')
</head>

<body>
    <div
        class="bg-gradient-to-r from-red-800 via-red-700 to-red-600 text-gray-900 h-screen flex items-center justify-center">
        @yield('content')
    </div>
</body>

</html>