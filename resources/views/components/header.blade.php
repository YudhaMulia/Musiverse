{{-- =========================================================
     NAVBAR UTAMA (dipakai SEMUA halaman)
     Isi menu dari Yudha, desain & animasi Musiverse
     CSS: public/css/navbar.css  |  JS: public/js/app.js
     ========================================================= --}}
<header class="navbar">
    <div class="navbar__inner">
        <a href="{{ route('welcome') }}" class="logo" aria-label="Musiverse - halaman awal">
            <span class="logo__icon" aria-hidden="true"></span>
            <span class="logo__text">Musiverse</span>
        </a>

        {{-- Tombol menu untuk layar HP --}}
        <button class="navbar__toggle" type="button" aria-label="Buka menu" data-toggle-menu>
            <span></span><span></span><span></span>
        </button>

        <nav class="navbar__menu" data-menu>
            <a href="{{ route('home') }}"
               class="{{ request()->routeIs('home') ? 'is-active' : '' }}">Home</a>
            <a href="{{ route('cagar-budaya.index') }}"
               class="{{ request()->routeIs('cagar-budaya.*') ? 'is-active' : '' }}">Cagar Budaya</a>
            <a href="{{ route('games.index') }}"
               class="{{ request()->routeIs('games.*') ? 'is-active' : '' }}">Games</a>
        </nav>

        <div class="navbar__right">

                @auth
                @php $pengguna = auth()->user(); @endphp
                {{-- Sudah login: avatar + nama, klik untuk membuka kartu menu --}}
                <details class="nav-profile" data-profil>
                    <summary class="nav-profile__btn" aria-label="Menu akun">
                        @if ($pengguna->avatar_url)
                            <img src="{{ $pengguna->avatar_url }}" alt="" class="nav-profile__avatar">
                        @else
                            <span class="nav-profile__avatar">{{ strtoupper(substr($pengguna->name, 0, 1)) }}</span>
                        @endif
                        <span class="nav-profile__name">{{ \Illuminate\Support\Str::limit($pengguna->name, 12) }}</span>
                        <svg class="nav-profile__panah" viewBox="0 0 12 8" aria-hidden="true"><path d="M1 1.5 6 6.5 11 1.5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </summary>

                    <div class="nav-profile__menu">
                        <div class="nav-profile__kepala">
                            @if ($pengguna->avatar_url)
                                <img src="{{ $pengguna->avatar_url }}" alt="" class="nav-profile__avatar nav-profile__avatar--besar">
                            @else
                                <span class="nav-profile__avatar nav-profile__avatar--besar">{{ strtoupper(substr($pengguna->name, 0, 1)) }}</span>
                            @endif
                            <div class="nav-profile__info">
                                <strong>{{ $pengguna->name }}</strong>
                                <small>{{ $pengguna->email }}</small>
                            </div>
                        </div>

                        <a href="{{ route('profile.edit') }}" class="nav-profile__item">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-4.4 3.6-7 8-7s8 2.6 8 7"/></svg>
                            Profil Saya
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="nav-profile__item nav-profile__item--keluar">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><path d="M16 17l5-5-5-5"/><path d="M21 12H9"/></svg>
                                Keluar
                            </button>
                        </form>
                    </div>
                </details>
            @else
                {{-- Belum login --}}
                <a href="{{ route('login') }}" class="btn-masuk">Masuk</a>
                <a href="{{ route('register') }}" class="btn-daftar">Daftar</a>
            @endauth
        </div>
    </div>
</header>
