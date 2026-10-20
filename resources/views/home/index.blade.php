@extends('layouts.app')

@section('title', 'Home - Rediscover Heritage Palembang')

@section('latar_main', '')

@push('styles')
<style>
    /* ===== GAMES PAGE STYLES (musiverse.css) ===== */
    :root {
        --gold: #c9a24a;
        --gold-light: #ead39a;
        --gold-dark: #9c7a33;
        --maroon-950: #120307;
        --maroon-900: #1d060c;
        --maroon-800: #2c0a14;
        --maroon-700: #44101d;
        --red: #c8243a;
        --text: #f6ecdc;
        --text-muted: #d9c7b0;
        --font-title: 'Montserrat', Arial, sans-serif;
        --font-body: 'Nunito Sans', Arial, sans-serif;
        --radius: 24px;
    }

    /* Section head */
    .section-head { text-align: center; max-width: 640px; margin: 0 auto 12px; }
    .section-head__eyebrow {
        display: inline-block; font-size: .8rem; font-weight: 700; letter-spacing: .3em;
        text-transform: uppercase; color: var(--red);
    }
    .section-head__title {
        font-family: var(--font-title); font-style: italic; font-weight: 800;
        font-size: clamp(2rem, 4vw, 2.8rem); line-height: 1.15; margin-top: 6px;
        color: var(--text);
    }
    .section-head p { color: var(--text-muted); }

    /* Ornament */
    .ornament { display: flex; align-items: center; justify-content: center; gap: 12px; margin: 14px 0 16px; }
    .ornament::before, .ornament::after {
        content: ""; width: 80px; height: 1px;
        background: linear-gradient(90deg, transparent, var(--gold));
    }
    .ornament::after { transform: scaleX(-1); }
    .ornament span {
        width: 10px; height: 10px; border: 1px solid var(--gold); transform: rotate(45deg);
        box-shadow: 0 0 0 4px rgba(201, 162, 74, .12);
    }

    /* Game card */
    .game-card, .quiz {
        border: 1px solid rgba(201, 162, 74, .22);
        box-shadow: 0 24px 50px rgba(0, 0, 0, .45), inset 0 0 0 1px rgba(255, 255, 255, .02);
    }
    .game-card {
        position: relative; overflow: hidden;
        min-height: 340px; border-radius: var(--radius);
        background: var(--maroon-900);
        display: flex; align-items: center;
    }
    .game-card__art { transition: transform 1.2s cubic-bezier(.2, .7, .2, 1); }
    .game-card:hover .game-card__art { transform: scale(1.03); }
    .game-card__art {
        position: absolute; inset: 0;
        background-size: cover; background-repeat: no-repeat;
    }
    .game-card__art::after { content: ""; position: absolute; inset: 0; }
    .game-card--art-right .game-card__art { background-position: right center; left: 25%; }
    .game-card--art-right .game-card__art::after {
        background: linear-gradient(90deg, var(--maroon-900) 0%, rgba(29, 6, 12, .75) 22%, rgba(29, 6, 12, 0) 55%);
    }
    .game-card--art-right .game-card__content { padding: 36px 44px; width: 52%; position: relative; }

    /* Game title */
    .game-title {
        font-family: var(--font-title); font-style: italic; font-weight: 800;
        font-size: clamp(1.8rem, 3.2vw, 2.7rem); line-height: 1.05; text-transform: uppercase;
        background: linear-gradient(180deg, var(--gold-light), var(--gold) 70%, var(--gold-dark));
        -webkit-background-clip: text; background-clip: text; color: transparent;
    }
    .game-desc { color: var(--text); margin: 10px 0 20px; max-width: 520px; font-size: .95rem; }

    /* Buttons */
    .btn-row, .game-card--art-left .btn-row { display: flex; flex-wrap: nowrap; gap: 14px; }

    .btn-play {
        display: inline-flex; align-items: center; gap: 10px;
        padding: 10px 20px 10px 22px; border-radius: 999px;
        font-family: var(--font-title); font-weight: 800; font-style: italic;
        font-size: .85rem; letter-spacing: .04em; text-transform: uppercase; white-space: nowrap;
        border: 2px solid transparent;
        background:
            linear-gradient(var(--maroon-950), var(--maroon-950)) padding-box,
            linear-gradient(90deg, #f3dc9a, var(--gold) 45%, var(--red)) border-box;
        box-shadow: 0 6px 14px rgba(0, 0, 0, .45);
        transition: box-shadow .4s, transform .4s, background .4s;
    }
    .btn-play__text {
        background: linear-gradient(90deg, #f6e3a8, var(--gold) 55%, #e0566a);
        -webkit-background-clip: text; background-clip: text; color: transparent;
    }
    .btn-play__arrow { width: 18px; height: 12px; overflow: visible; transition: margin .4s; }
    .btn-play__arrow path { fill: var(--gold-light); transition: transform .4s; }
    .btn-play__arrow .one { transform: translateX(-60%); }
    .btn-play__arrow .two { transform: translateX(-30%); }
    .btn-play__arrow .three { transform: translateX(0); }

    .btn-play:hover, .btn-play:focus-visible {
        outline: none;
        transform: translateY(-2px);
        background:
            linear-gradient(#2a0a14, #2a0a14) padding-box,
            linear-gradient(90deg, #f3dc9a, var(--gold) 45%, var(--red)) border-box;
        box-shadow: 6px 6px 0 rgba(201, 162, 74, .55), 0 0 22px rgba(200, 36, 58, .35);
    }
    .btn-play:hover .btn-play__arrow { margin-right: 14px; }
    .btn-play:hover .btn-play__arrow .one,
    .btn-play:hover .btn-play__arrow .two { transform: translateX(0); }
    .btn-play:hover .btn-play__arrow .three { animation: warnaPanah 1s infinite .2s; }
    .btn-play:hover .btn-play__arrow .two   { animation: warnaPanah 1s infinite .4s; }
    .btn-play:hover .btn-play__arrow .one   { animation: warnaPanah 1s infinite .6s; }
    @keyframes warnaPanah {
        0%, 100% { fill: var(--gold-light); }
        50%      { fill: var(--red); }
    }

    .btn-block { width: 100%; justify-content: center; }

    /* Badges */
    .badges { list-style: none; display: flex; flex-wrap: nowrap; gap: 18px; margin-top: 18px; }
    .badges li {
        position: relative; padding: 4px 16px;
        font-style: italic; font-weight: 700; font-size: .78rem; color: var(--gold-light);
        background: var(--maroon-800);
        border: 1px solid var(--gold); border-radius: 999px;
        white-space: nowrap;
    }
    .badges li::before, .badges li::after {
        content: ""; position: absolute; top: 50%; width: 7px; height: 7px;
        background: var(--maroon-800); border: 1px solid var(--gold);
        transform: translateY(-50%) rotate(45deg);
    }
    .badges li::before { left: -4px; }
    .badges li::after  { right: -4px; }

    /* 3D border & hologram effect */
    .game-card {
        border: 3px solid transparent;
        background:
            linear-gradient(var(--maroon-900), var(--maroon-900)) padding-box,
            linear-gradient(145deg, #fff1c4 0%, #d9b45c 18%, #7a5620 40%, #e9cd7e 60%, #8a6424 82%, #f5dd99 100%) border-box;
        box-shadow:
            0 0 0 1px rgba(0, 0, 0, .7),
            0 20px 45px rgba(0, 0, 0, .55),
            0 0 30px rgba(201, 162, 74, .12);
    }
    .game-card::after {
        content: ""; position: absolute; inset: 0; border-radius: inherit; pointer-events: none; z-index: 3;
        box-shadow: inset 0 1px 0 rgba(255, 240, 200, .45), inset 0 0 0 1px rgba(255, 230, 170, .18),
                    inset 0 -10px 24px rgba(0, 0, 0, .35);
    }
    .game-card {
        transform-style: preserve-3d;
        transition: transform .6s cubic-bezier(.2, .7, .2, 1), box-shadow .4s;
    }
    .game-card.is-tilting { transition: transform .12s linear, box-shadow .4s; }
    .game-card:hover {
        box-shadow: 0 0 0 1px rgba(0, 0, 0, .7), 0 28px 60px rgba(0, 0, 0, .6), 0 0 40px rgba(201, 162, 74, .28);
    }
    .game-card::before {
        content: ""; position: absolute; top: -50%; left: -50%; width: 200%; height: 200%;
        z-index: 2; pointer-events: none; opacity: 0;
        background: linear-gradient(0deg, transparent 40%, rgba(255, 226, 150, .18) 50%, transparent 60%);
        transform: rotate(-45deg) translateY(-60%);
        transition: transform 1s ease, opacity .4s ease;
    }
    .game-card:hover::before { opacity: 1; transform: rotate(-45deg) translateY(60%); }
    .game-card__content { z-index: 4; }

    /* Reveal animation */
    .js .reveal { transform: none; translate: 0 48px; transition: opacity .9s cubic-bezier(.2, .7, .2, 1), translate .9s cubic-bezier(.2, .7, .2, 1); }
    .js .reveal.is-visible { translate: 0 0; }
    .js .game-card.reveal { transition: opacity .9s, translate .9s, transform .6s cubic-bezier(.2, .7, .2, 1), box-shadow .4s; }
    .js .game-card.reveal.is-tilting { transition: opacity .9s, translate .9s, transform .12s linear, box-shadow .4s; }

    /* Kartu situs terpilih: judul tidak terpotong, teks tidak tertutup gambar */
    .game-card--featured .game-card__art { left: 20%; }
    .game-card--featured .game-card__art::after {
        background: linear-gradient(90deg, var(--maroon-900) 0%, rgba(29, 6, 12, .92) 30%, rgba(29, 6, 12, .6) 58%, rgba(29, 6, 12, 0) 90%);
    }
    .game-card--featured .game-card__content { width: 72%; padding: 32px 24px 32px 28px; }
    .game-card--featured .game-title {
        display: block;
        padding: 0 .14em .1em 0;
        font-size: clamp(1.15rem, 1.7vw, 1.65rem);
        line-height: 1.12;
        overflow-wrap: anywhere;
    }
    .game-card--featured .game-desc {
        display: -webkit-box; -webkit-box-orient: vertical;
        -webkit-line-clamp: 3; line-clamp: 3; overflow: hidden;
        font-size: .9rem;
    }
    .game-card--featured .badges { flex-wrap: wrap; gap: 10px 18px; }
    @media (max-width: 1279px) {
        .game-card--featured .game-title { font-size: clamp(1.2rem, 2.2vw, 1.65rem); }
    }
    @media (max-width: 960px) {
        .game-card--featured .game-card__art { left: 0; }
        .game-card--featured .game-card__art::after {
            background: linear-gradient(90deg, rgba(29, 6, 12, .92) 0%, rgba(29, 6, 12, .7) 100%);
        }
        .game-card--featured .game-card__content { width: 100%; padding: 24px 20px 28px; }
        .game-card--featured .game-title { font-size: clamp(1.3rem, 4.5vw, 1.8rem); }
    }

    /* Responsive */
    @media (max-width: 960px) {
        .game-card, .game-card--art-left { min-height: 0; }
        .game-card--art-right .game-card__content,
        .game-card--art-left .game-card__content { width: 100%; padding: 20px 16px 28px; }
        .btn-row, .game-card--art-left .btn-row { flex-wrap: wrap; justify-content: center; }
        .btn-play { flex: 1 1 140px; justify-content: center; padding: 10px 14px; font-size: .78rem; }
        .badges, .game-card--art-left .badges { flex-wrap: wrap; justify-content: center; gap: 12px 18px; }
    }
</style>
@endpush

@section('content')
<div class="flex flex-col w-full">
    <!-- HERO SECTION dengan Image Carousel - Gambar Jelas, Teks di Kanan, Tanpa Tombol -->
    <div class="w-full relative overflow-hidden min-h-[85vh]">
        <!-- Carousel Images Background (Foto Asli Jelas Tanpa Blur/Overlay) -->
        <div class="absolute inset-0 z-0 overflow-hidden">
            @foreach($carouselSites as $index => $item)
            <div class="carousel-slide absolute inset-0 transition-opacity duration-1000 ease-in-out {{ $index === 0 ? 'opacity-100' : 'opacity-0' }}" data-index="{{ $index }}">
                @if($item['site']->image_url)
                <img class="w-full h-full object-cover transition-transform duration-1000"
                     style="transform: scale(1.02);"
                     src="{{ $item['site']->image_url }}" alt="{{ $item['site']->name }}" />
                @else
                <div class="w-full h-full bg-surface-container flex items-center justify-center">
                    <span class="material-symbols-outlined text-primary text-[96px] opacity-20">image</span>
                </div>
                @endif

                <!-- Subtle gradient overlay only on right side for text readability -->
                <div class="absolute inset-0 pointer-events-none"
                     style="background: linear-gradient(to right, transparent 40%, rgba(20, 3, 3, 0.6) 70%, rgba(15, 2, 2, 0.85) 100%);"></div>
            </div>
            @endforeach
        </div>

        {{-- Transisi Halus ke Bagian Bawah --}}
        <div class="absolute bottom-0 left-0 right-0 h-16 bg-gradient-to-t from-surface to-transparent z-10 pointer-events-none"></div>

        <!-- Content Overlay - Posisi Kanan (Single content, updated via JS) -->
        <div class="relative z-20 absolute right-0 top-1/2 -translate-y-1/2 w-full max-w-2xl px-8 md:px-16 py-8" id="hero-content">
            <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full border-2 border-secondary text-secondary font-label-md text-label-md uppercase tracking-widest font-bold drop-shadow-[0_2px_14px_rgba(20,3,3,0.95)] shadow-[0_2px_15px_rgba(212,175,55,0.3)]" id="hero-badge">
                <span class="w-2 h-2 rounded-full bg-secondary animate-ping"></span>
                {{ $carouselSites[0]['badge_text'] ?? 'Eksplorasi Cagar Budaya Palembang' }}
            </span>

            <!-- Main Headline -->
            <h1 class="font-display-lg text-3xl sm:text-4xl md:text-5xl lg:text-6xl text-[#F9F6F0] leading-tight tracking-tight font-extrabold mt-4"
                style="text-shadow: 0 2px 4px rgba(25, 4, 4, 0.9), 0 6px 18px rgba(25, 4, 4, 0.95), 0 14px 34px rgba(15, 2, 2, 0.98);"
                id="hero-title">
                {{ $carouselSites[0]['hero_title'] ?? 'Menghidupkan Kembali Jejak Sejarah Palembang yang Terlupakan' }}
            </h1>

            <!-- Sub-headline -->
            <p class="font-body-lg text-base sm:text-lg md:text-xl text-[#F9F6F0] max-w-xl leading-relaxed font-semibold mt-4"
               style="text-shadow: 0 1px 3px rgba(20, 3, 3, 0.92), 0 3px 12px rgba(20, 3, 3, 0.95);"
               id="hero-description">
                {{ $carouselSites[0]['hero_description'] ?? 'Jelajahi cagar budaya terbengkalai Palembang dengan dokumentasi visual foto asli lokasi. Memahami nilai sejarah yang tersembunyi secara interaktif dan edukatif.' }}
            </p>
        </div>

        <!-- Carousel Indicators (Dots) - Di tengah bawah -->
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 z-30 flex items-center gap-2 px-3 py-1.5 rounded-full bg-surface/90 backdrop-blur-md border border-secondary/40 shadow-md">
            @foreach($carouselSites as $index => $item)
            <button class="carousel-indicator w-2.5 h-2.5 rounded-full transition-all duration-300 {{ $index === 0 ? 'bg-primary w-8' : 'bg-secondary/60 hover:bg-secondary' }}" data-index="{{ $index }}" title="{{ $item['site']->name }}"></button>
            @endforeach
        </div>

            </div>

    <!-- Carousel Data untuk JS (hidden) -->
    <div id="carousel-data" class="hidden" data-slides='@json($carouselSites->map(function($item) { return ["badge_text" => $item["badge_text"], "hero_title" => $item["hero_title"], "hero_description" => $item["hero_description"]]; })->values()->all())'></div>

    <!-- STAT BANNER -->
    <div class="w-full px-margin py-space-lg flex flex-col gap-space-md">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-space-md">
            @foreach($stats as $stat)
            <div class="p-space-md rounded-xl bg-surface-container-lowest border border-secondary/35 hover:border-secondary hover:bg-surface-container-low transition-all flex flex-col items-center text-center gap-space-sm shadow-sm hover:shadow-md">
                <div class="w-14 h-14 rounded-lg bg-primary border border-secondary/40 flex items-center justify-center text-secondary shadow-sm">
                    <span class="material-symbols-outlined text-[28px]">{{ $stat['icon'] }}</span>
                </div>
                <div class="flex flex-col gap-1">
                    <span class="font-display-lg text-display-lg text-primary font-bold">{{ $stat['number'] }}{{ $stat['suffix'] ?? '+' }}</span>
                    <span class="font-label-lg text-label-lg text-secondary-container uppercase tracking-widest font-bold">{{ $stat['label'] }}</span>
                    <p class="font-body-sm text-body-sm text-on-surface-variant font-medium">{{ $stat['description'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- CORE FEATURES SECTION -->
    <div class="w-full px-margin py-space-lg flex flex-col gap-space-md">
        <div class="flex items-center justify-center mb-space-md">
            <h2 class="font-headline-lg text-headline-lg text-primary font-bold text-center">Fitur Unggulan Aplikasi</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-space-md">
            <!-- Feature 1: Map & Exploration -->
            <div class="rounded-xl bg-surface-container-lowest p-space-md border border-secondary/35 hover:border-secondary hover:bg-surface-container-low transition-all flex flex-col gap-space-md shadow-sm hover:shadow-md group">
                <div class="w-12 h-12 rounded-lg bg-primary border border-secondary/40 flex items-center justify-center text-secondary shadow-sm">
                    <span class="material-symbols-outlined text-[28px]">map</span>
                </div>
                <div class="flex flex-col gap-2">
                    <h3 class="font-title-lg text-title-lg text-primary font-bold">Peta & Rute Eksplorasi</h3>
                    <p class="font-body-sm text-body-sm text-on-surface-variant leading-relaxed">
                        Temukan lokasi situs cagar budaya terbengkalai di Palembang beserta rute perjalanan terdekat melalui peta interaktif.
                    </p>
                </div>
                <div class="mt-auto pt-space-md border-t border-secondary/20">
                    <a href="{{ route('cagar-budaya.index') }}" class="inline-flex items-center gap-1.5 text-primary font-label-md text-label-md uppercase tracking-wider font-bold">
                        <span>Jelajahi Peta</span>
                        <span class="material-symbols-outlined text-[16px] group-hover:translate-x-1 transition-transform text-secondary">arrow_forward</span>
                    </a>
                </div>
            </div>

            <!-- Feature 2: AI Storyteller -->
            <div class="rounded-xl bg-surface-container-lowest p-space-md border border-secondary/35 hover:border-secondary hover:bg-surface-container-low transition-all flex flex-col gap-space-md shadow-sm hover:shadow-md group">
                <div class="w-12 h-12 rounded-lg bg-primary border border-secondary/40 flex items-center justify-center text-secondary shadow-sm">
                    <span class="material-symbols-outlined text-[28px]">auto_stories</span>
                </div>
                <div class="flex flex-col gap-2">
                    <h3 class="font-title-lg text-title-lg text-primary font-bold">AI Storyteller & Rekonstruksi Visual</h3>
                    <p class="font-body-sm text-body-sm text-on-surface-variant leading-relaxed">
                        Pelajari cerita sejarah dengan bahasa yang mudah dicerna serta bayangan bentuk megah bangunan di masa lalu melalui AI.
                    </p>
                </div>
                <div class="mt-auto pt-space-md border-t border-secondary/20">
                    <a href="{{ route('audio-tour.show', 'benteng-kuto-besak') }}" class="inline-flex items-center gap-1.5 text-primary font-label-md text-label-md uppercase tracking-wider font-bold">
                        <span>Dengarkan Cerita</span>
                        <span class="material-symbols-outlined text-[16px] group-hover:translate-x-1 transition-transform text-secondary">arrow_forward</span>
                    </a>
                </div>
            </div>

            <!-- Feature 3: Gamification -->
            <div class="rounded-xl bg-surface-container-lowest p-space-md border border-secondary/35 hover:border-secondary hover:bg-surface-container-low transition-all flex flex-col gap-space-md shadow-sm hover:shadow-md group">
                <div class="w-12 h-12 rounded-lg bg-primary border border-secondary/40 flex items-center justify-center text-secondary shadow-sm">
                    <span class="material-symbols-outlined text-[28px]">gamepad</span>
                </div>
                <div class="flex flex-col gap-2">
                    <h3 class="font-title-lg text-title-lg text-primary font-bold">Gamifikasi</h3>
                    <p class="font-body-sm text-body-sm text-on-surface-variant leading-relaxed">
                        Uji pengetahuan sejarah melalui permainan edukatif dan kumpulkan poin serta lencana digital.
                    </p>
                </div>
                <div class="mt-auto pt-space-md border-t border-secondary/20">
                    <a href="{{ route('games.index') }}" class="inline-flex items-center gap-1.5 text-primary font-label-md text-label-md uppercase tracking-wider font-bold">
                        <span>Main Sekarang</span>
                        <span class="material-symbols-outlined text-[16px] group-hover:translate-x-1 transition-transform text-secondary">arrow_forward</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- FEATURED HERITAGE SITES PREVIEW (Style Games Page) -->
    <div class="w-full px-margin py-space-lg flex flex-col gap-space-md">
        <header class="section-head reveal text-center">
            <span class="section-head__eyebrow">Sorotan Cagar Budaya Pilihan</span>
            <h2 class="section-head__title">Jelajahi Situs Terpilih</h2>
            <div class="ornament" aria-hidden="true"><span></span></div>
            <p>Situs-situs bersejarah paling menarik yang telah dikurasi khusus untuk Anda</p>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-space-md">
            @foreach($featuredSites as $site)
            <article class="game-card game-card--art-right game-card--featured reveal" data-tilt>
                <div class="game-card__art" style="background-image: url('{{ $site->image_url }}')"></div>

                <div class="game-card__content">
                    <h2 class="game-title">{{ $site->name }}</h2>

                    <p class="game-desc">
                        {{ $site->short_description }}
                    </p>

                    <div class="btn-row">
                        <a href="{{ route('cagar-budaya.show', $site->slug) }}" class="btn-play">
                            <span class="btn-play__text">Tinjau Lokasi</span>
                            <svg class="btn-play__arrow" viewBox="0 0 48 16" fill="none" aria-hidden="true">
                                <path class="one" d="M4 8h36M4 8l10-6M4 8l10 6" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/>
                                <path class="two" d="M4 8h36M4 8l10-6M4 8l10 6" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/>
                                <path class="three" d="M4 8h36M4 8l10-6M4 8l10 6" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/>
                            </svg>
                        </a>
                    </div>

                    <ul class="badges">
                        <li>{{ $site->era->name }}</li>
                        <li>{{ $site->year_built ?? 'Tahun TBD' }}</li>
                    </ul>
                </div>
            </article>
            @endforeach
        </div>
    </div>

    <!-- HOW IT WORKS SECTION (Style Games Page) -->
    <div class="w-full px-margin py-space-lg flex flex-col gap-space-md">
        <header class="section-head reveal text-center">
            <span class="section-head__eyebrow">Cara Menggunakan</span>
            <h2 class="section-head__title">Panduan 3 Langkah Mudah</h2>
            <div class="ornament" aria-hidden="true"><span></span></div>
            <p>Ikuti langkah-langkah sederhana ini untuk memulai petualangan budaya Anda</p>
        </header>

        <div class="max-w-4xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-space-lg">
                <!-- Step 1 -->
                <div class="relative flex flex-col items-center text-center reveal">
                    <div class="w-16 h-16 rounded-full bg-primary shadow-md flex items-center justify-center text-[#F9F6F0] font-headline-lg font-bold mb-space-md border-4 border-surface">
                        1
                    </div>
                    <h3 class="font-title-lg text-title-lg text-primary font-bold mb-2">Pilih Situs</h3>
                    <p class="font-body-sm text-body-sm text-on-surface-variant leading-relaxed">
                        Buka peta dan pilih cagar budaya yang ingin kamu pelajari lebih lanjut.
                    </p>
                    <div class="hidden md:block absolute top-1/4 -right-1/2 w-1/2 h-1 bg-gradient-to-r from-secondary to-transparent"></div>
                </div>

                <!-- Step 2 -->
                <div class="relative flex flex-col items-center text-center reveal">
                    <div class="w-16 h-16 rounded-full bg-primary shadow-md flex items-center justify-center text-[#F9F6F0] font-headline-lg font-bold mb-space-md border-4 border-surface">
                        2
                    </div>
                    <h3 class="font-title-lg text-title-lg text-primary font-bold mb-2">Dengarkan Ceritanya</h3>
                    <p class="font-body-sm text-body-sm text-on-surface-variant leading-relaxed">
                        Pahami sejarahnya lewat penjelasan santai dan menarik dari Audio Tour kami.
                    </p>
                    <div class="hidden md:block absolute top-1/4 -right-1/2 w-1/2 h-1 bg-gradient-to-r from-secondary to-transparent"></div>
                </div>

                <!-- Step 3 -->
                <div class="relative flex flex-col items-center text-center reveal">
                    <div class="w-16 h-16 rounded-full bg-primary shadow-md flex items-center justify-center text-[#F9F6F0] font-headline-lg font-bold mb-space-md border-4 border-surface">
                        3
                    </div>
                    <h3 class="font-title-lg text-title-lg text-primary font-bold mb-2">Mainkan Gamenya</h3>
                    <p class="font-body-sm text-body-sm text-on-surface-variant leading-relaxed">
                        Uji ingatanmu di Musiverse Match dan klaim lencana digital kamu!
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section (Style Games Page) -->
    <div class="w-full px-margin py-space-xl flex flex-col gap-space-lg items-center justify-center text-center relative overflow-hidden">
        <div class="absolute -top-32 -right-32 w-64 h-64 bg-secondary/15 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col gap-space-md max-w-3xl reveal">
            <h2 class="font-headline-lg text-headline-lg text-primary font-bold">Siap Untuk Petualangan?</h2>
            <p class="font-body-lg text-body-lg text-on-surface-variant font-medium">
                Mulai jelajahi cagar budaya Palembang dan temukan cerita-cerita menakjubkan di balik setiap bangunan bersejarah.
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-space-md mt-space-md">
                <a href="{{ route('cagar-budaya.index') }}" class="btn-play btn-block">
                    <span class="btn-play__text">Mulai Eksplorasi</span>
                    <svg class="btn-play__arrow" viewBox="0 0 48 16" fill="none" aria-hidden="true">
                        <path class="one" d="M4 8h36M4 8l10-6M4 8l10 6" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/>
                        <path class="two" d="M4 8h36M4 8l10-6M4 8l10 6" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/>
                        <path class="three" d="M4 8h36M4 8l10-6M4 8l10 6" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/>
                    </svg>
                </a>
                <a href="{{ route('games.index') }}" class="btn-play btn-block">
                    <span class="btn-play__text">Coba Main Game</span>
                    <svg class="btn-play__arrow" viewBox="0 0 48 16" fill="none" aria-hidden="true">
                        <path class="one" d="M4 8h36M4 8l10-6M4 8l10 6" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/>
                        <path class="two" d="M4 8h36M4 8l10-6M4 8l10 6" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/>
                        <path class="three" d="M4 8h36M4 8l10-6M4 8l10 6" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Tilt effect for game cards
    document.addEventListener('DOMContentLoaded', () => {
        const cards = document.querySelectorAll('[data-tilt]');

        cards.forEach(card => {
            let rafId = null;

            card.addEventListener('mousemove', e => {
                if (rafId) return;
                rafId = requestAnimationFrame(() => {
                    const rect = card.getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const y = e.clientY - rect.top;
                    const centerX = rect.width / 2;
                    const centerY = rect.height / 2;
                    const rotateY = ((x - centerX) / centerX) * 8;
                    const rotateX = ((centerY - y) / centerY) * 8;

                    card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale3d(1.02, 1.02, 1.02)`;
                    card.classList.add('is-tilting');
                    rafId = null;
                });
            });

            card.addEventListener('mouseleave', () => {
                card.style.transform = '';
                card.classList.remove('is-tilting');
            });
        });
    });

    // Scroll reveal animation
    document.addEventListener('DOMContentLoaded', () => {
        // Add js class to html for CSS animations
        document.documentElement.classList.add('js');

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });

        document.querySelectorAll('.reveal').forEach(el => {
            observer.observe(el);
        });
    });
</script>
@endpush