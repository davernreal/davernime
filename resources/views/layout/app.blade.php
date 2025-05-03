<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="dim">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', '')</title> <!-- Tambahkan ini -->


    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    @yield('meta')

    @stack('style')
</head>

<body class="overflow-x-hidden">
    <div class="flex min-h-screen flex-col justify-between">
        <div>
            @yield('content')
        </div>
        <x-footer />
    </div>
    @stack('modal')
</body>

@stack('scripts')

</html>
