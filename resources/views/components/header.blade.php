{{-- =========================================================
     NAVBAR UTAMA (dipakai SEMUA halaman)
     Isi menu dari Yudha, desain & animasi Musiverse
     CSS: public/css/navbar.css  |  JS: public/js/app.js
     ========================================================= --}}
<header class="navbar">
    <div class="navbar__inner">
        <a href="{{ route('home') }}" class="logo">
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
            {{-- Badge POLSRI (dari navbar Yudha) --}}
            <div class="nav-badge" title="Politeknik Negeri Sriwijaya • Heritage Lab">
                <span class="nav-badge__dot" aria-hidden="true"></span>
                <span class="nav-badge__main">POLSRI</span>
                <span class="nav-badge__sep" aria-hidden="true">&bull;</span>
                <span>HERITAGE LAB</span>
            </div>

            @auth
                {{-- Sudah login: foto/inisial + menu keluar --}}
                <details class="nav-profile">
                    <summary aria-label="Menu akun">
                        @if (auth()->user()->avatar)
                            <img src="{{ auth()->user()->avatar }}" alt="" class="nav-profile__avatar">
                        @else
                            <span class="nav-profile__avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                        @endif
                        <span class="nav-profile__name">{{ \Illuminate\Support\Str::limit(auth()->user()->name, 12) }}</span>
                    </summary>
                    <div class="nav-profile__menu">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit">Keluar</button>
                        </form>
                    </div>
                </details>
            @else
                {{-- Belum login --}}
                <a href="{{ route('login') }}" class="btn-login">Login Now <span aria-hidden="true">&rarr;</span></a>
            @endauth
        </div>
    </div>
</header>
