{{-- =========================================================
     LAYOUT HALAMAN PERMAINAN (layar penuh, tanpa navbar & footer)
     Dipakai oleh: games/match.blade.php (nanti juga quiz & puzzle)
     ========================================================= --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@hasSection('title')@yield('title') | Musiverse @else Musiverse | Budaya Palembang @endif</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-musiverse.png') }}">

    <script>document.documentElement.classList.add('js');</script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,700;0,800;1,700;1,800&family=Nunito+Sans:ital,wght@0,400;0,600;0,700;1,600&display=swap" rel="stylesheet">

    {{-- musiverse.css: warna & latar dasar | navbar.css: gaya tombol musik --}}
    <link rel="stylesheet" href="{{ asset('css/musiverse.css') }}">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    @stack('styles')
</head>
<body class="halaman-permainan tema-games">

    @yield('content')

    {{-- Musik latar tetap berlanjut --}}
    @include('components.musik')

    <script src="{{ asset('js/musik.js') }}"></script>
    <script src="{{ asset('js/suara.js') }}"></script>
    @stack('scripts')
</body>
</html>
