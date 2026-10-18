@extends('layouts.games')

@section('title', 'Kata Sandi Baru')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endpush

@section('content')
<section class="auth">
    <div class="auth__bingkai">

        @include('auth._visual', ['gambar' => 'reset.jpg'])

        <div class="auth__form">
            <h1 class="auth__judul">Kata Sandi Baru</h1>
            <p class="auth__sub">Buat kata sandi baru untuk akunmu.</p>

            <form method="POST" action="{{ route('password.update') }}" novalidate>
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="auth__field">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email', $email) }}"
                           required autocomplete="email">
                    @error('email') <p class="auth__error">{{ $message }}</p> @enderror
                </div>

                <div class="auth__field">
                    <label for="password">Kata sandi baru (minimal 8 karakter)</label>
                    <input id="password" type="password" name="password"
                           required autofocus autocomplete="new-password">
                    @error('password') <p class="auth__error">{{ $message }}</p> @enderror
                </div>

                <div class="auth__field">
                    <label for="password_confirmation">Ulangi kata sandi baru</label>
                    <input id="password_confirmation" type="password" name="password_confirmation"
                           required autocomplete="new-password">
                </div>

                <button class="auth__tombol" type="submit">Simpan Kata Sandi</button>
            </form>
        </div>
    </div>
</section>
@endsection

@push('scripts')
    <script src="{{ asset('js/auth.js') }}"></script>
@endpush