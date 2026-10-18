<section class="hero" data-parallax>
    <div class="hero__art" style="background-image: url('{{ asset('images/games/hero.webp') }}')"></div>

    {{-- Partikel debu emas yang melayang naik (posisi & kecepatan diacak oleh PHP) --}}
    <div class="hero__sparkles" aria-hidden="true">
        @for ($i = 0; $i < 22; $i++)
            <span style="--x: {{ rand(35, 98) }}%; --s: {{ rand(2, 5) }}px; --t: {{ rand(70, 140) / 10 }}s; --d: {{ rand(0, 90) / 10 }}s;"></span>
        @endfor
    </div>

    <div class="hero__content">
        <span class="hero__quote" aria-hidden="true">&#8221;</span>
        <p class="hero__tagline">Budaya Kito, Kebanggaan Galo-Galo!</p>

        <h1 class="hero__title">Musiverse Games</h1>

        <div class="divider">
            <span>Culture Never Fades</span>
        </div>

        <p class="hero__desc">
            Cocokkan kartu budaya, jawab tantangan seputar Palembang, dan tebak kata
            dari teka-teki gambar. Main sendiri atau ajak temanmu lewat kode ruangan,
            lalu buktikan siapa yang paling kenal budaya Palembang!
        </p>

        @auth
            <button type="button" class="btn-outline" data-open="modal-gabung">
                <span class="dot" aria-hidden="true"></span> Masuk Ruangan
            </button>
        @else
            {{-- Belum login: tampilkan popup ajakan masuk/daftar --}}
            <button type="button" class="btn-outline" data-open="modal-login"
                    data-kembali="{{ route('games.index', [], false) }}">
                <span class="dot" aria-hidden="true"></span> Masuk Ruangan
            </button>
        @endauth
    </div>
</section>
