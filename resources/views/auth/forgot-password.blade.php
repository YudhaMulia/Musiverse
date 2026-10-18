@extends('layouts.games')

@section('title', 'Lupa Kata Sandi')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endpush

@section('content')
<section class="auth">
    <div class="auth__bingkai auth__bingkai--kanan">

        <div class="auth__form">
            <h1 class="auth__judul">Lupa Kata Sandi?</h1>
            <p class="auth__sub">Masukkan email akunmu. Kami kirimkan tautan untuk membuat kata sandi baru.</p>

            @if (session('status'))
                <p class="auth__status">{{ session('status') }}</p>
            @endif

            <form method="POST" action="{{ route('password.email') }}" novalidate>
                @csrf

                <div class="auth__field">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}"
                           required autofocus autocomplete="email">
                    @error('email') <p class="auth__error">{{ $message }}</p> @enderror
                </div>

                <button class="auth__tombol" type="submit">Kirim Tautan</button>
            </form>

            <p class="auth__bawah"><a href="{{ route('login') }}">Kembali ke halaman masuk</a></p>
        </div>

        @include('auth._visual', ['gambar' => 'forgot.jpg'])
    </div>
</section>
@endsection