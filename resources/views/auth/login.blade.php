@extends('layouts.games')

@section('title', 'Masuk')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endpush

@section('content')
<section class="auth">
    <div class="auth__bingkai">

        @include('auth._visual', ['gambar' => 'login.jpg'])

        <div class="auth__form">
            <h1 class="auth__judul">Selamat Datang Kembali</h1>
            <p class="auth__sub">Masuk untuk membuat ruang tunggu, mengajak teman bertanding, dan membagikan foto eksplorasimu.</p>

            @if (session('status'))
                <p class="auth__status">{{ session('status') }}</p>
            @endif

            {{-- Muncul kalau tamu mencoba membuka ruang tunggu multiplayer --}}
            @if (str_contains(session('url.intended', ''), '/games/'))
                <p class="auth__info">Masuk dulu untuk bermain bersama temanmu di ruang tunggu.</p>
            @endif

            <form method="POST" action="{{ route('login') }}" novalidate>
                @csrf

                <div class="auth__field">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}"
                           required autofocus autocomplete="email">
                    @error('email') <p class="auth__error">{{ $message }}</p> @enderror
                </div>

                <div class="auth__field">
                    <label for="password">Kata sandi</label>
                    <input id="password" type="password" name="password"
                           required autocomplete="current-password">
                    @error('password') <p class="auth__error">{{ $message }}</p> @enderror
                </div>

                <div class="auth__baris">
                    <label class="auth__ingat">
                        <input type="checkbox" name="remember"> Ingat saya
                    </label>
                    <a class="auth__lupa" href="{{ route('password.request') }}">Lupa kata sandi?</a>
                </div>

                <button class="auth__tombol" type="submit">Masuk</button>
            </form>

            <p class="auth__bawah">Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a></p>
        </div>
    </div>
</section>
@endsection

@push('scripts')
    <script src="{{ asset('js/auth.js') }}"></script>
@endpush