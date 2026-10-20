@extends('layouts.games')

@section('title', 'Musiverse | Cagar Budaya Palembang')

@section('content')

    {{-- ===== HERO LANDING ===== --}}
    <section class="hero landing-hero" data-navbar-gelap>
        {{-- Background Image Layer --}}
        <div class="hero__art landing-hero__bg">
            <img src="{{ asset('images/ampera.jpg') }}" alt="Jembatan Ampera Palembang" loading="eager" fetchpriority="high">
        </div>

        {{-- Partikel debu emas --}}
        <div class="hero__sparkles" aria-hidden="true">
            @for ($i = 0; $i < 22; $i++)
                <span style="--x: {{ rand(35, 98) }}%; --s: {{ rand(2, 5) }}px; --t: {{ rand(70, 140) / 10 }}s; --d: {{ rand(0, 90) / 10 }}s;"></span>
            @endfor
        </div>

        {{-- Content --}}
        <div class="hero__content landing-hero__content">
            <div class="gb-wadah">
                <p class="gb-eyebrow">Museum Digital & Pelestarian Warisan</p>

                <span class="hero__quote" aria-hidden="true">&#8220;</span>
                <p class="hero__tagline">Budaya Kito, Kebanggaan Galo-Galo!</p>

                <h1 class="hero__title landing-hero__title">Musiverse</h1>

                <h2 class="landing-hero__subtitle">Cagar Budaya Palembang</h2>

                <div class="divider"><span>Warisan Tak Terhingga</span></div>

                <p class="hero__desc landing-hero__desc">
                    Jelajahi kekayaan sejarah dan budaya Palembang melalui warisan-warisan yang tak ternilai harganya.
                    Sebuah perjalanan untuk memahami masa lalu, merayakan masa kini, dan melestarikan masa depan.
                </p>
            </div>
        </div>
    </section>

    {{-- ===== STATS BAR ===== --}}
    <div class="gb-wadah" style="margin-top: -48px; margin-bottom: 48px;">
        <ul class="badges badges--center" aria-label="Statistik Cagar Budaya">
            <li><span class="stat-value">{{ $totalSites ?? 6 }}+</span> Situs Sejarah</li>
            <li><span class="stat-value">{{ $totalAudioTours ?? 6 }}+</span> Audio Tour</li>
            <li><span class="stat-value">3</span> Game Edukatif</li>
        </ul>
    </div>

    {{-- ===== FOOTER SPACER ===== --}}
    <div class="gb-akhir"></div>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const hero = document.querySelector('.landing-hero');
            const bgImg = document.querySelector('.landing-hero__bg img');

            if (bgImg) {
                if (bgImg.complete) {
                    hero?.classList.add('is-loaded');
                } else {
                    bgImg.addEventListener('load', () => hero?.classList.add('is-loaded'));
                }
            }

            window.addEventListener('scroll', () => {
                const scrolled = window.scrollY;
                if (scrolled < window.innerHeight && hero) {
                    hero.style.setProperty('--parallax-y', `${scrolled * 0.3}px`);
                    if (bgImg) {
                        bgImg.style.transform = `scale(1) translateY(${scrolled * 0.3}px)`;
                    }
                }
            }, { passive: true });
        });
    </script>
@endpush

@push('styles')
<style>
    /* ===== LANDING HERO ===== */
    .landing-hero {
        position: relative;
        overflow: hidden;
        min-height: 100vh;
        padding-top: 80px;
        display: flex;
        align-items: center;
        background: radial-gradient(ellipse 60% 70% at 20% 45%, rgba(70, 14, 30, .55), transparent 70%);
    }

    /* Aura emas berdenyut */
    .landing-hero::before {
        content: ""; position: absolute; z-index: 1; pointer-events: none;
        mix-blend-mode: screen;
        top: 10%; right: 12%; width: 46vw; height: 46vw; max-width: 720px; max-height: 720px;
        background: radial-gradient(circle, rgba(232, 190, 100, .22) 0%, rgba(200, 36, 58, .10) 40%, transparent 70%);
        animation: aura 6s ease-in-out infinite;
    }
    @keyframes aura {
        0%, 100% { opacity: .6; scale: 1; }
        50%      { opacity: 1;  scale: 1.08; }
    }

    .landing-hero__bg {
        position: absolute; top: 0; right: 0; bottom: 0; width: 66%;
        z-index: 0;
        -webkit-mask-image:
            radial-gradient(ellipse 100% 135% at 100% 32%,
                #000 0%, #000 40%, rgba(0,0,0,.93) 50%, rgba(0,0,0,.74) 60%,
                rgba(0,0,0,.48) 70%, rgba(0,0,0,.24) 81%, rgba(0,0,0,.08) 91%, transparent 100%),
            linear-gradient(0deg, transparent 0%, rgba(0,0,0,.2) 7%, rgba(0,0,0,.5) 15%,
                rgba(0,0,0,.8) 25%, rgba(0,0,0,.95) 34%, #000 42%);
        -webkit-mask-composite: source-in;
        mask-image:
            radial-gradient(ellipse 100% 135% at 100% 32%,
                #000 0%, #000 40%, rgba(0,0,0,.93) 50%, rgba(0,0,0,.74) 60%,
                rgba(0,0,0,.48) 70%, rgba(0,0,0,.24) 81%, rgba(0,0,0,.08) 91%, transparent 100%),
            linear-gradient(0deg, transparent 0%, rgba(0,0,0,.2) 7%, rgba(0,0,0,.5) 15%,
                rgba(0,0,0,.8) 25%, rgba(0,0,0,.95) 34%, #000 42%);
        mask-composite: intersect;
    }
    .landing-hero__bg img {
        width: 100%; height: 100%; object-fit: cover;
        transform: scale(1.08); transition: transform 6s ease-out;
        animation: fadeIn 1.4s ease both, sinematik 22s ease-in-out 1.4s infinite alternate;
    }
    @keyframes sinematik {
        from { scale: 1; }
        to   { scale: 1.07; }
    }
    .landing-hero.is-loaded .landing-hero__bg img { transform: scale(1); }

    .landing-hero__content {
        position: relative; z-index: 2;
        width: 100%; max-width: 620px;
        margin-left: max(24px, calc((100vw - 1280px) / 2 + 24px));
        padding: 64px 0;
    }
    .landing-hero__content > * { animation: fadeUp .9s cubic-bezier(.2, .7, .2, 1) both; }
    .landing-hero__content > *:nth-child(2) { animation-delay: .08s; }
    .landing-hero__content > *:nth-child(3) { animation-delay: .16s; }
    .landing-hero__content > *:nth-child(4) { animation-delay: .24s; }
    .landing-hero__content > *:nth-child(5) { animation-delay: .32s; }
    .landing-hero__content > *:nth-child(6) { animation-delay: .40s; }

    .landing-hero__title {
        font-family: var(--font-title); font-style: italic; font-weight: 800;
        font-size: clamp(2.4rem, 5vw, 4rem); line-height: 1.1;
        background: linear-gradient(110deg, var(--text) 38%, #fff6d8 46%, #e8c56f 50%, #fff6d8 54%, var(--text) 62%);
        background-size: 260% 100%;
        background-position: 100% 0;
        -webkit-background-clip: text; background-clip: text; color: transparent;
        filter: drop-shadow(0 4px 18px rgba(0, 0, 0, .55));
        animation: fadeUp .9s cubic-bezier(.2, .7, .2, 1) both, kilauJudul 5s ease-in-out 1.2s infinite;
    }
    @keyframes kilauJudul {
        0%        { background-position: 100% 0; }
        45%, 100% { background-position: -60% 0; }
    }

    .landing-hero__subtitle {
        font-family: var(--font-title); font-weight: 700;
        font-size: clamp(1.4rem, 3vw, 2.2rem);
        color: var(--gb-gold); margin-top: 12px;
    }
    .landing-hero__desc { color: var(--text); margin: 24px 0; max-width: 560px; font-size: 1.05rem; line-height: 1.7; }

    /* Divider berkilau */
    .divider::before, .divider::after {
        background: linear-gradient(90deg, var(--gold-dark), #fff1c4, var(--gold-dark));
        background-size: 200% 100%;
        animation: kilauGaris 4s linear infinite;
    }
    @keyframes kilauGaris {
        from { background-position: 200% 0; }
        to   { background-position: 0 0; }
    }

    /* ===== STATS BADGES ===== */
    .stat-value {
        font-family: var(--font-title); font-style: italic; font-weight: 800;
        font-size: clamp(1.8rem, 4vw, 2.4rem);
        background: linear-gradient(180deg, var(--gb-gold-l), var(--gb-gold));
        -webkit-background-clip: text; background-clip: text; color: transparent;
        margin-right: 6px;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 900px) {
        .landing-hero__bg { width: 100%; opacity: .35; }
        .landing-hero__content { margin-left: 24px; max-width: none; }
        .landing-hero::before { width: 90vw; height: 90vw; right: -10%; }
        .hero__sparkles span:nth-child(n + 12) { display: none; }
    }
    @media (max-width: 720px) {
        .gb-wadah { padding: 0 14px; }
    }
    @media (prefers-reduced-motion: reduce) {
        .landing-hero__content > *,
        .landing-hero__bg,
        .landing-hero::before,
        .hero__sparkles span,
        .landing-hero__title { animation: none; transition: none; }
    }
</style>
@endpush