<!DOCTYPE html>
<html lang="en">

<head>
    {{-- Meta and title --}}
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>

    {{-- Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/style.css'])

    {{-- Font Inter --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet">

    {{-- CDN with Alpine.js --}}
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/persist@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- Adding style css --}}
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

{{-- Layout for auth --}}
<body class="min-h-screen flex flex-col items-center justify-center black-primary">
    @yield('content')
</body>

</html>
