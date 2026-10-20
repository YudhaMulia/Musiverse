@extends('layouts.games')

@section('title', 'Daftar')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endpush

@section('content')
<section class="auth">
    <div class="auth__bingkai auth__bingkai--kanan">

        <div class="auth__form">
            <h1 class="auth__judul">Buat Akun</h1>
            <p class="auth__sub">Daftar untuk bermain bersama dan membagikan keseruan eksplorasimu.</p>

            <form method="POST" action="{{ route('register') }}" novalidate>
                @csrf

                <div class="auth__field">
                    <label for="name">Nama</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}"
                           required autofocus autocomplete="name" maxlength="60">
                    @error('name') <p class="auth__error">{{ $message }}</p> @enderror
                </div>

                <div class="auth__field">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}"
                           required autocomplete="email">
                    @error('email') <p class="auth__error">{{ $message }}</p> @enderror
                </div>

                <div class="auth__field">
                    <label for="password">Kata sandi (minimal 8 karakter)</label>
                    <input id="password" type="password" name="password"
                           required autocomplete="new-password">
                    @error('password') <p class="auth__error">{{ $message }}</p> @enderror
                </div>

                <div class="auth__field">
                    <label for="password_confirmation">Ulangi kata sandi</label>
                    <input id="password_confirmation" type="password" name="password_confirmation"
                           required autocomplete="new-password">
                </div>

                <button class="auth__tombol" type="submit">Daftar</button>
            </form>

            <p class="auth__bawah">Sudah punya akun? <a href="{{ route('login') }}">Masuk</a></p>
        </div>

        @include('auth._visual', ['gambar' => 'register.webp'])
    </div>
</section>
@endsection

@push('scripts')
    <script src="{{ asset('js/auth.js') }}"></script>
@endpush