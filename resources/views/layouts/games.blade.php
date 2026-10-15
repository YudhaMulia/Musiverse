<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Musiverse') | Budaya Palembang</title>

    {{-- Tandai bahwa JavaScript aktif (dipakai animasi fade-up) --}}
    <script>document.documentElement.classList.add('js');</script>

    {{-- Font dari Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,700;0,800;1,700;1,800&family=Nunito+Sans:ital,wght@0,400;0,600;0,700;1,600&display=swap" rel="stylesheet">

    {{-- CSS halaman Games, lalu CSS navbar (dipakai bersama semua halaman) --}}
    <link rel="stylesheet" href="{{ asset('css/musiverse.css') }}">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
</head>
<body>

    {{-- Navbar yang sama dengan halaman lain --}}
    @include('components.header')

    <main>
        @yield('content')
    </main>

    @include('games.partials.footer')

    @include('components.musik')

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/musik.js') }}"></script>
    @stack('scripts')
</body>
</html>
