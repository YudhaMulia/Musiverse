@extends('layouts.app')

@section('title', 'Beranda')

@section('latar_main', '')
@section('jarak_atas', 'pt-0')

@section('content')

    {{-- ===== CAROUSEL BERANDA: 4 slide penjelasan ===== --}}
    @php
        $fotoCadangan = asset('images/ampera.webp');
        // Pakai gambar buatan sendiri jika file-nya ada di public/images, kalau belum ada pakai cadangan
        $gambar = fn ($nama, $cadangan) => file_exists(public_path('images/' . $nama)) ? asset('images/' . $nama) : $cadangan;

        $slidesBeranda = [
            [
                'judul'  => 'Musiverse',
                'sub'    => 'Tiga Cara Mengenal Budaya Palembang',
                'isi'    => 'Musiverse menyatukan museum digital, penjelajahan situs dengan kenangan, dan permainan edukatif dalam satu tempat. Cara baru untuk mengenal, merasakan, dan menjaga warisan Palembang.',
                'chips'  => [['account_balance', 'Museum Digital'], ['photo_camera', 'Jejak Kenangan'], ['sports_esports', 'Permainan Budaya']],
                'foto'   => $gambar('carousel-musiverse.webp', $fotoCadangan),
                'tombol' => null,
                'link'   => null,
            ],
            [
                'judul'  => 'Galeri Budaya',
                'sub'    => 'Koleksi Budaya di Genggaman Anda',
                'isi'    => 'Telusuri koleksi budaya Palembang kapan saja, dikelompokkan per kategori seperti kuliner dan kain, lengkap dengan cerita di balik setiap koleksinya.',
                'chips'  => [['star', 'Budaya Unggulan'], ['category', 'Koleksi per Kategori'], ['auto_stories', 'Cerita Tiap Koleksi']],
                'foto'   => $gambar('carousel-galeri.webp', data_get($carouselSites, '1.site.image_url') ?: $fotoCadangan),
                'tombol' => 'Buka Galeri Budaya',
                'link'   => route('galeri-budaya.index'),
            ],
            [
                'judul'  => 'Cagar Budaya',
                'sub'    => 'Jelajahi, Dengarkan, Abadikan',
                'isi'    => 'Temukan situs cagar budaya Palembang lewat peta, dengarkan audio tour di setiap lokasi, lalu simpan kenangan kunjungan Anda lewat ulasan dan foto.',
                'chips'  => [['map', 'Peta & Rute'], ['headphones', 'Audio Tour'], ['favorite', 'Simpan Kenangan']],
                'foto'   => $gambar('carousel-cagar.webp', data_get($carouselSites, '2.site.image_url') ?: $fotoCadangan),
                'tombol' => 'Jelajahi Cagar Budaya',
                'link'   => route('cagar-budaya.index'),
            ],
            [
                'judul'  => 'Games',
                'sub'    => 'Budaya Jadi Lebih Seru',
                'isi'    => 'Uji dan asah pengetahuan budaya lewat tiga permainan, lalu mainkan bersama teman di ruang permainan.',
                'chips'  => [['style', 'Musiverse Match'], ['quiz', 'Musiverse Quiz'], ['extension', 'Musiverse Puzzle']],
                'foto'   => $gambar('carousel-games.webp', data_get($carouselSites, '3.site.image_url') ?: $fotoCadangan),
                'tombol' => 'Mulai Bermain',
                'link'   => route('games.index'),
            ],
        ];
    @endphp

    <section class="mv-hero" data-mv-hero data-navbar-gelap aria-label="Keunggulan Musiverse">
        <div class="mv-stage">
            @foreach ($slidesBeranda as $slide)
                <article class="mv-slide {{ $loop->first ? 'is-active' : '' }}">
                    <img class="mv-slide__img" src="{{ $slide['foto'] }}" alt="" decoding="async" loading="{{ $loop->first ? 'eager' : 'lazy' }}">
                    <div class="mv-slide__shade"></div>

                    <div class="mv-slide__body">
                        <h1 class="mv-judul">{{ $slide['judul'] }}</h1>
                        <p class="mv-sub">{{ $slide['sub'] }}</p>
                        <p class="mv-isi">{{ $slide['isi'] }}</p>

                        <div class="mv-chips">
                            @foreach ($slide['chips'] as [$ikon, $teks])
                                <span class="mv-chip">
                                    <i class="material-symbols-outlined">{{ $ikon }}</i>{{ $teks }}
                                </span>
                            @endforeach
                        </div>

                        @if ($slide['link'])
                            <a href="{{ $slide['link'] }}" class="mv-tombol">
                                <span>{{ $slide['tombol'] }}</span>
                                <i class="material-symbols-outlined">arrow_forward</i>
                            </a>
                        @endif
                    </div>
                </article>
            @endforeach
        </div>

        <div class="mv-dots">
            @foreach ($slidesBeranda as $slide)
                <button type="button" class="mv-dot {{ $loop->first ? 'is-active' : '' }}" aria-label="Slide {{ $loop->iteration }}"></button>
            @endforeach
        </div>
    </section>

    <div class="bh">

        {{-- ===== 1. ANGKA: kartu melayang di tepi bawah carousel ===== --}}
        <section class="bh-angka" aria-label="Ringkasan Musiverse">
            <div class="bh-wadah">
                <div class="bh-angka__kartu rv" data-hitung-wadah>
                    @foreach ($stats as $stat)
                        <div class="bh-angka__item">
                            <span class="bh-angka__ikon"><i class="material-symbols-outlined">{{ $stat['icon'] }}</i></span>
                            <div>
                                <div class="bh-angka__nilai"><span data-hitung="{{ $stat['number'] }}">{{ $stat['number'] }}</span>{{ $stat['suffix'] ?? '' }}</div>
                                <div class="bh-angka__label">{{ $stat['label'] }}</div>
                                <div class="bh-angka__ket">{{ $stat['description'] }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- ===== 2. ALUR: kenali, kunjungi, abadikan, mainkan ===== --}}
        <section class="bh-seksi">
            <div class="bh-wadah">
                <header class="bh-kepala rv">
                    <span class="bh-eyebrow">Mulai Petualangan</span>
                    <h2 class="bh-judul">Empat Langkah Menyelami Budaya</h2>
                    <div class="bh-ornamen" aria-hidden="true"><span></span></div>
                    <p>Dari mengenal, mengunjungi, mengabadikan, sampai menguji ingatan, semuanya berjalan beriringan.</p>
                </header>

                <div class="bh-jalur">
                    <a href="{{ route('galeri-budaya.index') }}" class="bh-langkah rv">
                        <span class="bh-langkah__lingkar">
                            <i class="material-symbols-outlined">museum</i>
                            <b class="bh-langkah__no">1</b>
                        </span>
                        <h3>Kenali</h3>
                        <p>Pelajari kuliner, kain, dan budaya Palembang lewat museum digital Galeri Budaya.</p>
                        <span class="bh-langkah__tautan">Buka Galeri <i class="material-symbols-outlined">arrow_forward</i></span>
                    </a>

                    <a href="{{ route('cagar-budaya.index') }}" class="bh-langkah rv">
                        <span class="bh-langkah__lingkar">
                            <i class="material-symbols-outlined">explore</i>
                            <b class="bh-langkah__no">2</b>
                        </span>
                        <h3>Kunjungi</h3>
                        <p>Temukan situs di peta, ikuti rutenya, dan dengarkan audio tour di lokasinya.</p>
                        <span class="bh-langkah__tautan">Lihat Situs <i class="material-symbols-outlined">arrow_forward</i></span>
                    </a>

                    <a href="{{ route('cagar-budaya.index') }}" class="bh-langkah rv">
                        <span class="bh-langkah__lingkar">
                            <i class="material-symbols-outlined">photo_camera</i>
                            <b class="bh-langkah__no">3</b>
                        </span>
                        <h3>Abadikan</h3>
                        <p>Simpan kenangan kunjunganmu lewat ulasan dan foto di setiap situs yang didatangi.</p>
                        <span class="bh-langkah__tautan">Mulai Menyimpan <i class="material-symbols-outlined">arrow_forward</i></span>
                    </a>

                    <a href="{{ route('games.index') }}" class="bh-langkah rv">
                        <span class="bh-langkah__lingkar">
                            <i class="material-symbols-outlined">sports_esports</i>
                            <b class="bh-langkah__no">4</b>
                        </span>
                        <h3>Mainkan</h3>
                        <p>Uji ingatan dan pengetahuanmu lewat Match, Quiz, dan Puzzle, sendiri atau bersama teman.</p>
                        <span class="bh-langkah__tautan">Main Sekarang <i class="material-symbols-outlined">arrow_forward</i></span>
                    </a>
                </div>
            </div>
        </section>

        {{-- ===== 3. CAGAR BUDAYA PILIHAN ===== --}}
        @if ($featuredSites->isNotEmpty())
            <section class="bh-seksi">
                <div class="bh-wadah">
                    <header class="bh-kepala rv">
                        <span class="bh-eyebrow">Sorotan Pilihan</span>
                        <h2 class="bh-judul">Cagar Budaya yang Wajib Dikunjungi</h2>
                        <div class="bh-ornamen" aria-hidden="true"><span></span></div>
                        <p>Situs-situs bersejarah Palembang yang paling layak dijelajahi lebih dulu.</p>
                    </header>

                    <div class="bh-pilihan {{ $featuredSites->count() >= 3 ? '' : 'bh-pilihan--rata' }}">
                        @foreach ($featuredSites as $site)
                            <article class="bh-kartu rv">
                                <img src="{{ $site->map_foto ?: ($site->image_url ?: $fotoCadangan) }}" alt="{{ $site->name }}" loading="lazy" decoding="async"
                                        onerror="this.onerror=null;this.src='{{ $fotoCadangan }}'">
                                <div class="bh-kartu__isi">
                                    <span class="bh-kartu__lencana">{{ $site->era->name ?? 'Cagar Budaya' }}{{ $site->year_built ? ' · ' . $site->year_built : '' }}</span>
                                    <h3>{{ $site->name }}</h3>
                                    <p>{{ $site->short_description }}</p>
                                    <a href="{{ $site->map_slug ? route('cagar-budaya.index', ['lokasi' => $site->map_slug]) : route('cagar-budaya.show', $site->slug) }}"
                                       class="bh-kartu__tombol">
                                        <i class="material-symbols-outlined">location_on</i>
                                        <span>Tinjau Lokasi</span>
                                    </a>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

                {{-- ===== 4. PETA: semua lokasi, bisa diklik langsung ke tempatnya ===== --}}
        @php
            $semuaLokasi = collect(config('heritage_map.sites'));
            $grupLokasi = [
                'keraton'   => ['Keraton & Kesultanan',      '#D4AF37'],
                'arkeologi' => ['Situs Arkeologi Sriwijaya', '#F0A58B'],
                'museum'    => ['Museum',                    '#9ED0BE'],
                'religi'    => ['Religi & Tempat Ibadah',    '#F6E3A1'],
                'kolonial'  => ['Bangunan Kolonial',         '#D9A066'],
                'kampung'   => ['Kampung Budaya',            '#D3A0C8'],
                'monumen'   => ['Monumen & Ikon Kota',       '#8EC3E6'],
            ];
        @endphp

        <section class="bh-seksi bh-seksi--akhir">
            <div class="bh-wadah">
                <div class="bh-peta rv">
                    <div class="bh-peta__teks">
                        <span class="bh-eyebrow bh-eyebrow--terang">Peta Interaktif</span>
                        <h2>Satu Peta, {{ $semuaLokasi->count() }} Lokasi Bersejarah</h2>
                        <p>Pilih tempat mana pun di samping untuk langsung melihat letaknya di peta, lengkap dengan rute menuju lokasinya.</p>

                        <div class="bh-peta__tombol">
                            <a href="{{ route('cagar-budaya.index') }}" class="mv-tombol">
                                <span>Buka Peta</span>
                                <i class="material-symbols-outlined">map</i>
                            </a>
                            <a href="{{ route('games.index') }}" class="mv-tombol mv-tombol--garis">
                                <span>Coba Games</span>
                                <i class="material-symbols-outlined">sports_esports</i>
                            </a>
                        </div>

                        @guest
                            <p class="bh-peta__daftar-akun">Belum punya akun? <a href="{{ route('register') }}">Daftar gratis</a></p>
                        @endguest
                    </div>

                    <div class="bh-peta__daftar">
                        @foreach ($grupLokasi as $kode => [$namaGrup, $warna])
                            @php $anggota = $semuaLokasi->where('category', $kode); @endphp
                            @if ($anggota->isNotEmpty())
                                <div>
                                    <div class="bh-grup__judul">{{ $namaGrup }}</div>
                                    <div class="bh-grup__pil">
                                        @foreach ($anggota as $lokasi)
                                            <a href="{{ route('cagar-budaya.index', ['lokasi' => $lokasi['slug']]) }}" class="bh-pil">
                                                <span class="bh-pil__titik" style="background: {{ $warna }}"></span>{{ $lokasi['name'] }}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection

@push('styles')
<style>
    /* =========================================================
       CAROUSEL BERANDA
       ========================================================= */
    .mv-hero {
        position: relative; height: 100vh; min-height: 640px; overflow: hidden;
        background: transparent; contain: layout paint;
    }

    /* Foto memudar halus ke bawah sampai transparan (satu pembungkus saja, lebih ringan) */
    .mv-stage {
        position: absolute; inset: 0;
        -webkit-mask-image: linear-gradient(180deg,
            #000 0, #000 calc(100% - 170px),
            rgba(0, 0, 0, .8) calc(100% - 130px),
            rgba(0, 0, 0, .5) calc(100% - 85px),
            rgba(0, 0, 0, .2) calc(100% - 42px),
            transparent 100%);
        mask-image: linear-gradient(180deg,
            #000 0, #000 calc(100% - 170px),
            rgba(0, 0, 0, .8) calc(100% - 130px),
            rgba(0, 0, 0, .5) calc(100% - 85px),
            rgba(0, 0, 0, .2) calc(100% - 42px),
            transparent 100%);
    }

    .mv-slide {
        position: absolute; inset: 0;
        opacity: 0; visibility: hidden;
        transition: opacity 1.2s ease, visibility 1.2s;
    }
    .mv-slide.is-active { opacity: 1; visibility: visible; }

    /* Cahaya emas berdenyut: hanya jalan di slide yang aktif */
    .mv-slide::before {
        content: ""; position: absolute; z-index: 1; pointer-events: none;
        top: 50%; left: 50%; translate: -50% -50%;
        width: 60vw; height: 60vw; max-width: 900px; max-height: 900px;
        background: radial-gradient(circle, rgba(232, 190, 100, .26) 0%, rgba(200, 36, 58, .10) 40%, transparent 70%);
        opacity: .6;
    }
    .mv-slide.is-active::before { animation: mvAura 6s ease-in-out infinite; }
    @keyframes mvAura {
        0%, 100% { opacity: .6; scale: 1; }
        50%      { opacity: 1;  scale: 1.08; }
    }

    /* Foto: muncul perlahan + zoom sinematik */
    .mv-slide__img {
        position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; display: block;
        transform: scale(1.08); transition: transform 6s ease-out;
    }
    .mv-slide.is-active .mv-slide__img {
        transform: scale(1);
        animation: mvMuncul 1.4s ease both, mvSinematik 22s ease-in-out 1.4s infinite alternate;
    }
    @keyframes mvMuncul { from { opacity: 0; } to { opacity: 1; } }
    @keyframes mvSinematik { from { scale: 1; } to { scale: 1.07; } }

    /* Lapisan gelap supaya teks di tengah terbaca */
    .mv-slide__shade {
        position: absolute; inset: 0;
        background:
            radial-gradient(ellipse 75% 65% at 50% 50%, rgba(20, 6, 12, .55), rgba(20, 6, 12, .32) 75%),
            rgba(20, 6, 12, .18);
    }

    .mv-slide__body {
        position: relative; z-index: 2; height: 100%;
        max-width: 880px; margin: 0 auto; padding: 96px 24px 120px;
        display: flex; flex-direction: column; align-items: center; justify-content: center;
        text-align: center; color: #fff6e8;
    }
    .mv-slide.is-active .mv-slide__body > * { animation: mvNaik .9s cubic-bezier(.2, .7, .2, 1) both; }
    .mv-slide.is-active .mv-slide__body > *:nth-child(2) { animation-delay: .10s; }
    .mv-slide.is-active .mv-slide__body > *:nth-child(3) { animation-delay: .20s; }
    .mv-slide.is-active .mv-slide__body > *:nth-child(4) { animation-delay: .30s; }
    .mv-slide.is-active .mv-slide__body > *:nth-child(5) { animation-delay: .40s; }
    @keyframes mvNaik { from { opacity: 0; transform: translateY(22px); } to { opacity: 1; transform: none; } }

    /* Judul dengan kilau emas berjalan */
    .mv-judul {
        font-family: 'Montserrat', Arial, sans-serif; font-style: italic; font-weight: 800;
        font-size: clamp(2.8rem, 8vw, 5.5rem); line-height: 1.1;
        background: linear-gradient(110deg, #ffffff 38%, #fff6d8 46%, #e8c56f 50%, #fff6d8 54%, #ffffff 62%);
        background-size: 260% 100%; background-position: 100% 0;
        -webkit-background-clip: text; background-clip: text; color: transparent;
    }
    .mv-slide.is-active .mv-slide__body > .mv-judul {
        animation: mvNaik .9s cubic-bezier(.2, .7, .2, 1) both, mvKilau 5s ease-in-out 1.2s infinite;
    }
    @keyframes mvKilau {
        0%        { background-position: 100% 0; }
        45%, 100% { background-position: -60% 0; }
    }

    .mv-sub {
        font-weight: 700; font-size: clamp(.95rem, 2vw, 1.25rem); letter-spacing: .16em;
        text-transform: uppercase; color: #f3d98a; margin-top: 12px;
        text-shadow: 0 2px 10px rgba(0, 0, 0, .6);
    }
    .mv-isi {
        max-width: 680px; margin-top: 20px; font-size: 1.1rem; line-height: 1.75;
        text-shadow: 0 2px 12px rgba(0, 0, 0, .6);
    }

    /* Tiga badge fitur */
    .mv-chips { display: flex; flex-wrap: wrap; justify-content: center; gap: 12px; margin-top: 28px; }
    .mv-chip {
        display: inline-flex; align-items: center; gap: 10px;
        padding: 7px 20px 7px 8px; border-radius: 999px;
        font-size: .9rem; font-weight: 700; letter-spacing: .02em; color: #fff6e8;
        background: linear-gradient(135deg, rgba(48, 14, 22, .62), rgba(48, 14, 22, .42));
        border: 1px solid rgba(240, 223, 160, .55);
        box-shadow: 0 6px 18px rgba(0, 0, 0, .28), inset 0 1px 0 rgba(255, 255, 255, .20);
        transition: transform .25s, border-color .25s;
    }
    .mv-chip:hover { transform: translateY(-3px); border-color: #F0DFA0; }
    .mv-chip .material-symbols-outlined {
        width: 30px; height: 30px; border-radius: 50%; flex-shrink: 0;
        display: grid; place-items: center; font-size: 18px; font-style: normal;
        color: #4A1010; background: linear-gradient(135deg, #f6e3a1, #D4AF37);
        box-shadow: 0 2px 8px rgba(0, 0, 0, .3);
    }

    /* Tombol emas (dipakai juga di bagian bawah beranda) */
    .mv-tombol {
        position: relative; overflow: hidden;
        display: inline-flex; align-items: center; gap: 10px;
        margin-top: 34px; padding: 14px 30px 14px 34px; border-radius: 999px;
        font-weight: 800; letter-spacing: .04em; text-decoration: none; color: #4A1010;
        background: linear-gradient(135deg, #f6e3a1 0%, #D4AF37 50%, #b38b2d 100%);
        border: 1px solid rgba(255, 246, 216, .65);
        box-shadow: 0 10px 28px rgba(0, 0, 0, .38), 0 0 0 5px rgba(212, 175, 55, .16);
        transition: transform .25s, box-shadow .25s;
    }
    .mv-tombol::before {
        content: ""; position: absolute; top: 0; left: -60%; width: 40%; height: 100%;
        background: linear-gradient(100deg, transparent, rgba(255, 255, 255, .6), transparent);
        transform: skewX(-20deg); transition: left .7s;
    }
    .mv-tombol:hover { transform: translateY(-3px); box-shadow: 0 14px 34px rgba(0, 0, 0, .45), 0 0 0 7px rgba(212, 175, 55, .22); }
    .mv-tombol:hover::before { left: 130%; }
    .mv-tombol .material-symbols-outlined { font-size: 20px; font-style: normal; transition: transform .25s; }
    .mv-tombol:hover .material-symbols-outlined { transform: translateX(5px); }
    /* varian garis (tombol kedua) */
    .mv-tombol--garis {
        color: #fff6e8; background: rgba(255, 255, 255, .06);
        border: 1.5px solid rgba(240, 223, 160, .75); box-shadow: none;
    }
    .mv-tombol--garis:hover { background: rgba(240, 223, 160, .16); box-shadow: 0 10px 26px rgba(0, 0, 0, .3); }

    /* Titik indikator */
    .mv-dots {
        position: absolute; left: 50%; bottom: 36px; translate: -50% 0; z-index: 5;
        display: flex; gap: 10px; padding: 8px 14px; border-radius: 999px;
        background: rgba(20, 6, 12, .55); border: 1px solid rgba(240, 223, 160, .35);
    }
    .mv-dot {
        width: 10px; height: 10px; border-radius: 999px; border: 0; cursor: pointer;
        background: rgba(240, 223, 160, .5); transition: width .3s, background .3s;
    }
    .mv-dot.is-active { width: 32px; background: #D4AF37; }

    /* Saat carousel di luar layar: semua animasi dijeda (kunci kelancaran scroll) */
    .mv-hero.is-offscreen *,
    .mv-hero.is-offscreen *::before,
    .mv-hero.is-offscreen *::after { animation-play-state: paused !important; }

    @media (max-width: 700px) {
        .mv-slide__body { padding: 88px 20px 110px; }
        .mv-isi { font-size: 1rem; }
        .mv-chip { font-size: .8rem; padding-right: 14px; }
    }

    /* =========================================================
       BAGIAN BAWAH BERANDA
       ========================================================= */
    .bh { font-family: 'Nunito Sans', 'Manrope', Arial, sans-serif; color: #4A1010; padding-bottom: 96px; }
    .bh-wadah { width: 100%; max-width: 1180px; margin: 0 auto; padding: 0 24px; }
    .bh-seksi { padding-top: 96px; }
    .bh-seksi--akhir { padding-top: 88px; }

    /* Kepala seksi */
    .bh-kepala { text-align: center; max-width: 680px; margin: 0 auto 52px; }
    .bh-eyebrow { font-size: .78rem; font-weight: 800; letter-spacing: .3em; text-transform: uppercase; color: #B38B2D; }
    .bh-eyebrow--terang { color: #f3d98a; }
    .bh-judul {
        font-family: 'Montserrat', Arial, sans-serif; font-style: italic; font-weight: 800;
        font-size: clamp(1.9rem, 4vw, 2.7rem); line-height: 1.15; color: #7A1C1C; margin-top: 8px;
    }
    .bh-ornamen { display: flex; align-items: center; justify-content: center; gap: 12px; margin: 16px 0; }
    .bh-ornamen::before, .bh-ornamen::after {
        content: ""; width: 80px; height: 1px; background: linear-gradient(90deg, transparent, #D4AF37);
    }
    .bh-ornamen::after { transform: scaleX(-1); }
    .bh-ornamen span {
        width: 10px; height: 10px; border: 1px solid #D4AF37; transform: rotate(45deg);
        box-shadow: 0 0 0 4px rgba(212, 175, 55, .14);
    }
    .bh-kepala p { color: #783838; line-height: 1.7; }

    /* ----- 1. Angka (kartu melayang) ----- */
    .bh-angka { position: relative; z-index: 6; margin-top: -78px; }
    .bh-angka__kartu {
        display: grid; grid-template-columns: repeat(3, 1fr);
        background: rgba(255, 253, 248, .97); border: 1px solid rgba(212, 175, 55, .6); border-radius: 22px;
        box-shadow: 0 24px 50px rgba(74, 16, 16, .14), 0 0 0 6px rgba(212, 175, 55, .10);
    }
    .bh-angka__item { position: relative; display: flex; align-items: center; gap: 16px; padding: 28px 30px; }
    .bh-angka__item + .bh-angka__item::before {
        content: ""; position: absolute; left: 0; top: 22%; bottom: 22%; width: 1px;
        background: linear-gradient(180deg, transparent, #D4AF37, transparent);
    }
    .bh-angka__ikon {
        width: 54px; height: 54px; border-radius: 50%; flex-shrink: 0; display: grid; place-items: center;
        color: #F0DFA0; background: linear-gradient(145deg, #8f2323, #5a1414);
        box-shadow: 0 0 0 2px #D4AF37, 0 8px 18px rgba(74, 16, 16, .25);
    }
    .bh-angka__ikon .material-symbols-outlined { font-size: 26px; }
    .bh-angka__nilai { font-family: 'Montserrat', Arial, sans-serif; font-weight: 800; font-size: 2.1rem; line-height: 1; color: #7A1C1C; }
    .bh-angka__label { margin-top: 6px; font-size: .76rem; font-weight: 800; letter-spacing: .14em; text-transform: uppercase; color: #B38B2D; }
    .bh-angka__ket { margin-top: 2px; font-size: .86rem; color: #783838; }

    /* ----- 2. Alur empat langkah ----- */
    .bh-jalur { position: relative; display: grid; grid-template-columns: repeat(4, 1fr); gap: 22px; }
    .bh-jalur::before {
        content: ""; position: absolute; top: 42px; left: 12.5%; right: 12.5%; height: 2px;
        background: linear-gradient(90deg, transparent, #D4AF37 14%, #D4AF37 86%, transparent);
    }
    .bh-langkah { position: relative; display: block; text-align: center; padding: 0 6px; color: inherit; text-decoration: none; }
    .bh-langkah__lingkar {
        position: relative; z-index: 1; width: 84px; height: 84px; margin: 0 auto; border-radius: 50%;
        display: grid; place-items: center; color: #F0DFA0;
        background: linear-gradient(145deg, #8f2323, #5a1414); border: 3px solid #FFFDF8;
        box-shadow: 0 0 0 2px #D4AF37, 0 12px 26px rgba(74, 16, 16, .28);
        transition: transform .3s;
    }
    .bh-langkah__lingkar .material-symbols-outlined { font-size: 34px; }
    .bh-langkah:hover .bh-langkah__lingkar { transform: translateY(-6px); }
    .bh-langkah__no {
        position: absolute; top: -8px; right: -8px; width: 28px; height: 28px; border-radius: 50%;
        display: grid; place-items: center; font-size: .78rem; font-weight: 800; color: #4A1010;
        background: linear-gradient(135deg, #f6e3a1, #D4AF37); border: 2px solid #FFFDF8;
    }
    .bh-langkah h3 { margin-top: 20px; font-family: 'Montserrat', Arial, sans-serif; font-weight: 800; font-size: 1.15rem; color: #7A1C1C; }
    .bh-langkah p { margin-top: 8px; font-size: .93rem; line-height: 1.65; color: #783838; }
    .bh-langkah__tautan {
        margin-top: 12px; display: inline-flex; align-items: center; gap: 4px;
        font-size: .76rem; font-weight: 800; letter-spacing: .1em; text-transform: uppercase; color: #B38B2D;
    }
    .bh-langkah__tautan .material-symbols-outlined { font-size: 16px; transition: transform .25s; }
    .bh-langkah:hover .bh-langkah__tautan .material-symbols-outlined { transform: translateX(4px); }

    /* ----- 3. Cagar budaya pilihan (bento) ----- */
    .bh-pilihan { display: grid; grid-template-columns: 1.35fr 1fr; grid-template-rows: 1fr 1fr; gap: 22px; min-height: 540px; }
    .bh-kartu {
        position: relative; display: block; overflow: hidden; isolation: isolate; min-height: 250px;
        border-radius: 22px; border: 1px solid rgba(212, 175, 55, .55); color: #fff6e8; text-decoration: none;
        box-shadow: 0 16px 36px rgba(74, 16, 16, .18); background: #2c0a14;
    }
    .bh-kartu:first-child { grid-row: span 2; }
    .bh-kartu img {
        position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; z-index: -2;
        transition: transform .8s ease;
    }
    .bh-kartu::after {
        content: ""; position: absolute; inset: 0; z-index: -1;
        background: linear-gradient(180deg, rgba(20, 6, 12, .04) 30%, rgba(20, 6, 12, .9) 100%);
    }
    .bh-kartu:hover img { transform: scale(1.06); }
    .bh-kartu__isi { position: absolute; left: 0; right: 0; bottom: 0; padding: 26px 28px; }
    .bh-kartu__lencana {
        display: inline-block; padding: 5px 14px; border-radius: 999px;
        font-size: .72rem; font-weight: 800; letter-spacing: .1em; text-transform: uppercase; color: #4A1010;
        background: linear-gradient(135deg, #f6e3a1, #D4AF37);
    }
    .bh-kartu h3 { margin-top: 12px; font-family: 'Montserrat', Arial, sans-serif; font-weight: 800; font-size: clamp(1.2rem, 2vw, 1.6rem); line-height: 1.2; }
    .bh-kartu:first-child h3 { font-size: clamp(1.5rem, 3vw, 2.1rem); }
    .bh-kartu p {
        margin-top: 8px; font-size: .92rem; line-height: 1.6; color: #f1e4cf;
        display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
    }
    .bh-kartu__tombol {
        margin-top: 16px; display: inline-flex; align-items: center; gap: 8px;
        padding: 10px 22px 10px 16px; border-radius: 999px;
        font-size: .85rem; font-weight: 800; letter-spacing: .04em; text-decoration: none; color: #4A1010;
        background: linear-gradient(135deg, #f6e3a1 0%, #D4AF37 55%, #b38b2d 100%);
        border: 1px solid rgba(255, 246, 216, .65);
        box-shadow: 0 8px 20px rgba(0, 0, 0, .35);
        transition: transform .25s, box-shadow .25s;
    }
    .bh-kartu__tombol:hover { transform: translateY(-2px); box-shadow: 0 12px 26px rgba(0, 0, 0, .45); }
    .bh-kartu__tombol .material-symbols-outlined { font-size: 19px; }

    .bh-pilihan--rata { grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); grid-template-rows: auto; min-height: 0; }
    .bh-pilihan--rata .bh-kartu { min-height: 360px; }
    .bh-pilihan--rata .bh-kartu:first-child { grid-row: auto; }

    /* ----- 4. Peta 18 lokasi ----- */
    .bh-peta {
        position: relative; overflow: hidden; color: #fff6e8; border-radius: 28px;
        display: grid; grid-template-columns: .85fr 1.15fr; gap: 44px; align-items: center;
        padding: 58px 52px;
        background:
            radial-gradient(ellipse 70% 90% at 15% 0%, rgba(212, 175, 55, .24), transparent 70%),
            url('data:image/svg+xml,%3Csvg xmlns=%27http://www.w3.org/2000/svg%27 width=%2756%27 height=%2756%27 viewBox=%270 0 56 56%27%3E%3Cg fill=%27none%27 stroke=%27%23D4AF37%27 stroke-opacity=%27.16%27%3E%3Cpath d=%27M28 3 53 28 28 53 3 28Z%27/%3E%3Cpath d=%27M28 17 39 28 28 39 17 28Z%27/%3E%3C/g%3E%3C/svg%3E'),
            linear-gradient(145deg, #6b1919, #3a0c0c);
        border: 1px solid rgba(212, 175, 55, .65);
        box-shadow: 0 24px 54px rgba(58, 12, 12, .3), inset 0 0 0 6px rgba(212, 175, 55, .08);
    }
    .bh-peta__teks h2 {
        margin-top: 10px; font-family: 'Montserrat', Arial, sans-serif; font-style: italic; font-weight: 800;
        font-size: clamp(1.8rem, 3.6vw, 2.6rem); line-height: 1.18;
    }
    .bh-peta__teks > p { margin-top: 16px; line-height: 1.75; color: #f1e4cf; }
    .bh-peta__tombol { display: flex; flex-wrap: wrap; gap: 14px; margin-top: 30px; }
    .bh-peta__tombol .mv-tombol { margin-top: 0; }
    .bh-peta__daftar-akun { margin-top: 22px; font-size: .92rem; color: #e6d6bd; }
    .bh-peta__daftar-akun a { color: #f3d98a; font-weight: 800; text-decoration: underline; text-underline-offset: 3px; }

    .bh-peta__daftar { display: grid; gap: 20px; }
    .bh-grup__judul {
        display: flex; align-items: center; gap: 10px; margin-bottom: 10px;
        font-size: .72rem; font-weight: 800; letter-spacing: .18em; text-transform: uppercase; color: #f3d98a;
    }
    .bh-grup__judul::after { content: ""; flex: 1; height: 1px; background: linear-gradient(90deg, rgba(240, 223, 160, .5), transparent); }
    .bh-grup__pil { display: flex; flex-wrap: wrap; gap: 8px; }
    .bh-pil {
        display: inline-flex; align-items: center; gap: 8px; padding: 7px 14px; border-radius: 999px;
        font-size: .84rem; font-weight: 700; color: #fff6e8; text-decoration: none;
        background: rgba(255, 255, 255, .07); border: 1px solid rgba(240, 223, 160, .4);
        transition: transform .2s, background .2s, border-color .2s;
    }
    .bh-pil:hover { transform: translateY(-2px); background: rgba(240, 223, 160, .18); border-color: #F0DFA0; }
    .bh-pil__titik { width: 9px; height: 9px; border-radius: 50%; flex-shrink: 0; box-shadow: 0 0 0 3px rgba(255, 255, 255, .12); }

    @media (max-width: 960px) {
        .bh-peta { grid-template-columns: 1fr; gap: 32px; padding: 44px 24px; }
    }

    /* ----- Animasi muncul saat di-scroll (ringan) ----- */
    .rv-aktif .rv { opacity: 0; translate: 0 26px; transition: opacity .7s ease, translate .7s cubic-bezier(.2, .7, .2, 1); }
    .rv-aktif .rv.is-in { opacity: 1; translate: 0 0; }
    .rv-aktif .bh-jalur .rv:nth-child(2) { transition-delay: .08s; }
    .rv-aktif .bh-jalur .rv:nth-child(3) { transition-delay: .16s; }
    .rv-aktif .bh-jalur .rv:nth-child(4) { transition-delay: .24s; }
    .rv-aktif .bh-pilihan .rv:nth-child(2) { transition-delay: .10s; }
    .rv-aktif .bh-pilihan .rv:nth-child(3) { transition-delay: .20s; }

    /* ----- Responsif ----- */
    @media (max-width: 960px) {
        .bh-angka__kartu { grid-template-columns: 1fr; }
        .bh-angka__item + .bh-angka__item::before { left: 8%; right: 8%; top: 0; bottom: auto; width: auto; height: 1px; background: linear-gradient(90deg, transparent, #D4AF37, transparent); }
        .bh-jalur { grid-template-columns: repeat(2, 1fr); row-gap: 40px; }
        .bh-jalur::before { display: none; }
        .bh-pilihan { grid-template-columns: 1fr; grid-template-rows: auto; min-height: 0; }
        .bh-kartu:first-child { grid-row: auto; min-height: 360px; }
    }
    @media (max-width: 560px) {
        .bh-seksi { padding-top: 72px; }
        .bh-jalur { grid-template-columns: 1fr; }
        .bh-ajakan { padding: 52px 20px; }
    }

    @media (prefers-reduced-motion: reduce) {
        .mv-slide, .mv-slide__img, .mv-tombol, .mv-chip { transition: none; }
        .mv-slide.is-active::before, .mv-slide.is-active .mv-slide__img,
        .mv-slide.is-active .mv-slide__body > *,
        .mv-slide.is-active .mv-slide__body > .mv-judul { animation: none; }
        .rv-aktif .rv { opacity: 1; translate: 0 0; transition: none; }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const kurangiGerak = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        /* ===== Carousel ===== */
        const hero = document.querySelector('[data-mv-hero]');
        if (hero) {
            const slides = [...hero.querySelectorAll('.mv-slide')];
            const dots = [...hero.querySelectorAll('.mv-dot')];
            let i = 0;
            let timer = null;
            let terlihat = true;

            const tampil = (n) => {
                i = (n + slides.length) % slides.length;
                slides.forEach((s, k) => s.classList.toggle('is-active', k === i));
                dots.forEach((d, k) => d.classList.toggle('is-active', k === i));
            };
            const berhenti = () => { clearInterval(timer); timer = null; };
            const mulai = () => {
                berhenti();
                if (terlihat && !document.hidden) timer = setInterval(() => tampil(i + 1), 7000);
            };

            dots.forEach((d, k) => d.addEventListener('click', () => { tampil(k); mulai(); }));
            // Jeda hanya saat kursor mouse di atas tombol/titik; di layar sentuh carousel tidak pernah "mati"
            hero.querySelectorAll('.mv-tombol, .mv-dots').forEach((el) => {
                el.addEventListener('pointerenter', (e) => { if (e.pointerType === 'mouse') berhenti(); });
                el.addEventListener('pointerleave', (e) => { if (e.pointerType === 'mouse') mulai(); });
            });

            // geser di layar sentuh
            let awalX = 0;
            hero.addEventListener('touchstart', (e) => { awalX = e.touches[0].clientX; }, { passive: true });
            hero.addEventListener('touchend', (e) => {
                const selisih = e.changedTouches[0].clientX - awalX;
                if (Math.abs(selisih) > 50) { tampil(selisih < 0 ? i + 1 : i - 1); mulai(); }
            }, { passive: true });

            // panah keyboard (hanya saat carousel terlihat)
            document.addEventListener('keydown', (e) => {
                if (!terlihat) return;
                if (e.key === 'ArrowLeft') { tampil(i - 1); mulai(); }
                if (e.key === 'ArrowRight') { tampil(i + 1); mulai(); }
            });

            // Jeda animasi + autoplay saat carousel di luar layar atau tab tidak aktif
            new IntersectionObserver(([entri]) => {
                terlihat = entri.isIntersecting;
                hero.classList.toggle('is-offscreen', !terlihat);
                terlihat ? mulai() : berhenti();
            }).observe(hero);
            document.addEventListener('visibilitychange', () => (document.hidden ? berhenti() : mulai()));

            tampil(0);
            mulai();
        }

        /* ===== Animasi muncul saat di-scroll ===== */
        const elemenRv = document.querySelectorAll('.rv');
        if (!kurangiGerak && 'IntersectionObserver' in window) {
            document.documentElement.classList.add('rv-aktif');
            const pengamat = new IntersectionObserver((daftar) => {
                daftar.forEach((entri) => {
                    if (entri.isIntersecting) {
                        entri.target.classList.add('is-in');
                        pengamat.unobserve(entri.target);
                    }
                });
            }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });
            elemenRv.forEach((el) => pengamat.observe(el));
        }

        /* ===== Hitung naik pada angka ===== */
        const wadahAngka = document.querySelector('[data-hitung-wadah]');
        if (wadahAngka && !kurangiGerak && 'IntersectionObserver' in window) {
            const angka = [...wadahAngka.querySelectorAll('[data-hitung]')];
            angka.forEach((el) => { el.textContent = '0'; });

            const jalankan = () => {
                angka.forEach((el) => {
                    const target = parseInt(el.dataset.hitung, 10) || 0;
                    const awal = performance.now();
                    const langkah = (t) => {
                        const p = Math.min((t - awal) / 1200, 1);
                        el.textContent = Math.round(target * (1 - Math.pow(1 - p, 3)));
                        if (p < 1) requestAnimationFrame(langkah);
                    };
                    requestAnimationFrame(langkah);
                });
            };
            const pengamatAngka = new IntersectionObserver(([entri]) => {
                if (entri.isIntersecting) { jalankan(); pengamatAngka.disconnect(); }
            }, { threshold: 0.4 });
            pengamatAngka.observe(wadahAngka);
        }
    });
</script>
@endpush