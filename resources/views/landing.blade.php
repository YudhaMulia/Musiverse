@extends('layouts.games')

@section('title', 'Landing Page')
@section('tanpa-footer', true)

@section('content')

    {{-- ===== HERO LANDING ===== --}}
    <section class="hero landing-hero" data-navbar-gelap>
        {{-- Gambar latar memenuhi layar --}}
        <div class="hero__art landing-hero__bg">
            <img src="{{ asset('images/ampera.webp') }}" alt="Jembatan Ampera Palembang" loading="eager" fetchpriority="high">
        </div>

        {{-- Partikel debu emas --}}
        <div class="hero__sparkles" aria-hidden="true">
            @for ($i = 0; $i < 22; $i++)
                <span style="--x: {{ rand(2, 98) }}%; --s: {{ rand(2, 5) }}px; --t: {{ rand(70, 140) / 10 }}s; --d: {{ rand(0, 90) / 10 }}s;"></span>
            @endfor
        </div>

        {{-- Konten di tengah --}}
        <div class="hero__content landing-hero__content">
            <h1 class="hero__title landing-hero__title">Musiverse</h1>

            <div class="divider"><span>Museum Digital · Jejak Kenangan · Permainan Budaya</span></div>

            <p class="hero__desc landing-hero__desc">
                Kenali warisan Palembang lewat museum digital, abadikan kenanganmu saat menjelajahi situs-situsnya,
                lalu asah pengetahuanmu lewat permainan. Tiga cara berbeda, satu tujuan: membuat budaya kita tetap hidup.
            </p>
        </div>
    </section>

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
        justify-content: center;
        background: #1a0910;
    }

    /* Aura emas berdenyut di tengah */
    .landing-hero::before {
        content: ""; position: absolute; z-index: 1; pointer-events: none;
        mix-blend-mode: screen;
        top: 50%; left: 50%; translate: -50% -50%;
        width: 60vw; height: 60vw; max-width: 900px; max-height: 900px;
        background: radial-gradient(circle, rgba(232, 190, 100, .20) 0%, rgba(200, 36, 58, .08) 40%, transparent 70%);
        animation: aura 6s ease-in-out infinite;
    }
    @keyframes aura {
        0%, 100% { opacity: .6; scale: 1; }
        50%      { opacity: 1;  scale: 1.08; }
    }

    /* Gambar penuh layar */
    .landing-hero .landing-hero__bg {
        position: absolute; inset: 0; width: 100%; height: 100%;
        z-index: 0; opacity: 1;
        -webkit-mask-image: none; mask-image: none;
    }
    .landing-hero .landing-hero__bg::after {
        content: ""; position: absolute; inset: 0;
        background:
            radial-gradient(ellipse 70% 60% at 50% 50%, rgba(20, 6, 12, .55), rgba(20, 6, 12, .30) 70%),
            rgba(20, 6, 12, .25);
    }
    .landing-hero__bg img {
        width: 100%; height: 100%; object-fit: cover; display: block;
        transform: scale(1.08); transition: transform 6s ease-out;
        animation: fadeIn 1.4s ease both, sinematik 22s ease-in-out 1.4s infinite alternate;
    }
    @keyframes sinematik {
        from { scale: 1; }
        to   { scale: 1.07; }
    }
    .landing-hero.is-loaded .landing-hero__bg img { transform: scale(1); }

    /* Konten rata tengah */
    .landing-hero .landing-hero__content {
        position: relative; z-index: 2;
        width: 100%; max-width: 900px;
        margin: 0 auto;
        padding: 64px 24px;
        text-align: center;
    }
    .landing-hero__content > * { animation: fadeUp .9s cubic-bezier(.2, .7, .2, 1) both; }
    .landing-hero__content > *:nth-child(2) { animation-delay: .12s; }
    .landing-hero__content > *:nth-child(3) { animation-delay: .24s; }

    .landing-hero__title {
        font-family: var(--font-title); font-style: italic; font-weight: 800;
        font-size: clamp(3rem, 9vw, 6rem); line-height: 1.1;
        background: linear-gradient(110deg, #ffffff 38%, #fff6d8 46%, #e8c56f 50%, #fff6d8 54%, #ffffff 62%);
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

    /* Garis + tulisan tiga fitur */
    .landing-hero .divider {
        justify-content: center;
        margin: 20px 0 24px;
        font-size: .85rem; letter-spacing: .22em;
        color: #f3d98a;
        text-shadow: 0 2px 10px rgba(0, 0, 0, .6);
    }
    .landing-hero .divider span { white-space: normal; text-align: center; }
    .divider::before, .divider::after {
        background: linear-gradient(90deg, var(--gold-dark), #fff1c4, var(--gold-dark));
        background-size: 200% 100%;
        animation: kilauGaris 4s linear infinite;
    }
    @keyframes kilauGaris {
        from { background-position: 200% 0; }
        to   { background-position: 0 0; }
    }

    .landing-hero .landing-hero__desc {
        color: #fff6e8; margin: 0 auto; max-width: 680px;
        font-size: 1.1rem; line-height: 1.75;
        text-shadow: 0 2px 12px rgba(0, 0, 0, .6);
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 900px) {
        .landing-hero .landing-hero__content { padding: 48px 20px; }
        .landing-hero .divider { letter-spacing: .12em; font-size: .75rem; }
        .hero__sparkles span:nth-child(n + 12) { display: none; }
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