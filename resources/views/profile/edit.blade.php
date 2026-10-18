@extends('layouts.games')

@section('title', 'Profil Saya')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endpush

@section('content')
@php
    // Tab yang terbuka saat halaman dimuat: kalau habis ubah kata sandi (atau gagal), buka tab sandi
    $tabAktif = ($errors->getBag('password')->isNotEmpty() || session('status_password')) ? 'password' : 'akun';
@endphp
<section class="auth auth--profil">
    <div class="auth__bingkai auth__bingkai--profil">

        {{-- ========== KOLOM KIRI: kembali, identitas, pilih avatar ========== --}}
        <div class="profil__kolom profil__kiri">

            {{-- Tombol kembali --}}
            <a href="{{ route('games.index') }}" class="profil__kembali">
                <span aria-hidden="true">&larr;</span> Kembali
            </a>

            {{-- Kepala profil --}}
            <div class="profil__kepala">
                @if ($user->avatar_url)
                    <img class="profil__avatar" src="{{ $user->avatar_url }}" alt="Avatar kamu">
                @else
                    <span class="profil__avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                @endif
                <h1 class="auth__judul">{{ $user->name }}</h1>
                <p class="auth__sub">
                    {{ $user->email }}<br>
                    Bergabung sejak {{ $user->created_at->locale('id')->translatedFormat('d F Y') }}
                </p>
            </div>

            {{-- Pilih avatar --}}
            <h2 class="profil__judul">Pilih Avatar</h2>

            @if (session('status_avatar'))
                <p class="auth__status">{{ session('status_avatar') }}</p>
            @endif

            <form method="POST" action="{{ route('profile.avatar') }}" novalidate>
                @csrf
                @method('PUT')

                <div class="avatar-pilih">
                    @for ($i = 1; $i <= 10; $i++)
                        <label class="avatar-pilih__item">
                            <input type="radio" name="avatar" value="{{ $i }}"
                                   @checked((int) $user->avatar === $i)>
                            <img src="{{ asset('images/games/avatar/'.$i.'.svg') }}" alt="Avatar {{ $i }}">
                        </label>
                    @endfor
                </div>
                @error('avatar') <p class="auth__error">{{ $message }}</p> @enderror

                <button class="auth__tombol" type="submit">Simpan Avatar</button>
            </form>
        </div>

        {{-- ========== KOLOM KANAN: tab Data Akun / Kata Sandi ========== --}}
        <div class="profil__kolom profil__kanan">

            <div class="profil__tab" role="tablist">
                <button type="button" role="tab" data-tab="akun"
                        class="{{ $tabAktif === 'akun' ? 'is-aktif' : '' }}"
                        aria-selected="{{ $tabAktif === 'akun' ? 'true' : 'false' }}">Data Akun</button>
                <button type="button" role="tab" data-tab="password"
                        class="{{ $tabAktif === 'password' ? 'is-aktif' : '' }}"
                        aria-selected="{{ $tabAktif === 'password' ? 'true' : 'false' }}">
                    {{ $user->password ? 'Ubah Kata Sandi' : 'Buat Kata Sandi' }}
                </button>
            </div>

            {{-- Panel Data Akun --}}
            <div data-panel="akun" @if ($tabAktif !== 'akun') hidden @endif>
                @if (session('status_profil'))
                    <p class="auth__status">{{ session('status_profil') }}</p>
                @endif

                <form method="POST" action="{{ route('profile.update') }}" novalidate>
                    @csrf
                    @method('PUT')

                    <div class="auth__field">
                        <label for="name">Nama</label>
                        <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}"
                               required maxlength="60" autocomplete="name">
                        @error('name') <p class="auth__error">{{ $message }}</p> @enderror
                    </div>

                    <div class="auth__field">
                        <label for="email">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}"
                               required autocomplete="email">
                        @error('email') <p class="auth__error">{{ $message }}</p> @enderror
                    </div>

                    <button class="auth__tombol" type="submit">Simpan Perubahan</button>
                </form>
            </div>

            {{-- Panel Kata Sandi --}}
            <div data-panel="password" @if ($tabAktif !== 'password') hidden @endif>
                @if (session('status_password'))
                    <p class="auth__status">{{ session('status_password') }}</p>
                @endif

                <form method="POST" action="{{ route('profile.password') }}" novalidate>
                    @csrf
                    @method('PUT')

                    @if ($user->password)
                        <div class="auth__field">
                            <label for="current_password">Kata sandi saat ini</label>
                            <input id="current_password" type="password" name="current_password"
                                   required autocomplete="current-password">
                            @error('current_password', 'password') <p class="auth__error">{{ $message }}</p> @enderror
                        </div>
                    @endif

                    <div class="auth__field">
                        <label for="password">Kata sandi baru (minimal 8 karakter)</label>
                        <input id="password" type="password" name="password"
                               required autocomplete="new-password">
                        @error('password', 'password') <p class="auth__error">{{ $message }}</p> @enderror
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
    </div>
</section>
@endsection

@push('scripts')
    <script src="{{ asset('js/auth.js') }}"></script>
    <script>
        // Pindah tab Data Akun <-> Kata Sandi tanpa memuat ulang halaman
        document.querySelectorAll('[data-tab]').forEach((tombol) => {
            tombol.addEventListener('click', () => {
                const tujuan = tombol.dataset.tab;
                document.querySelectorAll('[data-tab]').forEach((t) => {
                    const aktif = t === tombol;
                    t.classList.toggle('is-aktif', aktif);
                    t.setAttribute('aria-selected', aktif ? 'true' : 'false');
                });
                document.querySelectorAll('[data-panel]').forEach((p) => {
                    p.hidden = p.dataset.panel !== tujuan;
                });
            });
        });
    </script>
@endpush