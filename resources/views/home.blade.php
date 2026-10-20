@extends('layouts.app')

@section('title', 'Rediscover Heritage — Cagar Budaya Palembang')
@section('meta_description', 'Menjelajahi jejak peninggalan bersejarah Kota Palembang melalui eksplorasi 3D interaktif, rekonstruksi visual bertenaga AI, dan gamifikasi edukatif.')

@section('content')
<div class="flex flex-col w-full relative overflow-hidden select-none bg-surface">

    {{-- Atmospheric Glow Layers (Warm Maroon & Pale Gold on Broken White) --}}
    <div class="pointer-events-none absolute -top-40 -left-32 w-[680px] h-[680px] rounded-full bg-primary/10 blur-[150px]"></div>
    <div class="pointer-events-none absolute top-1/4 right-0 w-[600px] h-[600px] rounded-full bg-secondary/15 blur-[170px]"></div>
    <div class="pointer-events-none absolute bottom-10 left-1/3 w-[500px] h-[500px] rounded-full bg-secondary-container/10 blur-[140px]"></div>

    {{-- Floating Embers --}}
    <div class="pointer-events-none absolute inset-0 z-10 overflow-hidden">
        <span class="absolute w-1.5 h-1.5 rounded-full bg-secondary shadow-[0_0_10px_#D4AF37] top-1/3 left-1/4 animate-pulse opacity-80"></span>
        <span class="absolute w-2 h-2 rounded-full bg-primary shadow-[0_0_14px_#7A1C1C] top-1/2 left-[16%] animate-ping opacity-50"></span>
        <span class="absolute w-1 h-1 rounded-full bg-secondary-fixed shadow-[0_0_8px_#E8CC6E] top-2/3 left-1/3 animate-pulse opacity-70"></span>
        <span class="absolute w-2.5 h-2.5 rounded-full bg-secondary shadow-[0_0_16px_#D4AF37] top-1/4 right-1/4 animate-bounce opacity-40"></span>
        <span class="absolute w-1.5 h-1.5 rounded-full bg-secondary-container top-[60%] right-1/3 animate-pulse opacity-80 shadow-[0_0_9px_#B38B2D]"></span>
        <span class="absolute w-2 h-2 rounded-full bg-primary shadow-[0_0_12px_#7A1C1C] top-3/4 right-[20%] animate-ping opacity-35"></span>
    </div>

    {{-- ═══════════════════════════════════════════════════════
         HERO SECTION
         ═══════════════════════════════════════════════════════ --}}
    <section class="relative z-20 w-full px-5 md:px-12 pt-6 md:pt-10 pb-6">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-center">

            {{-- Hero Left: Content --}}
            <div class="lg:col-span-7 flex flex-col items-start space-y-6">

                {{-- Heritage Pill Badge --}}
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full backdrop-blur-md bg-surface-container-lowest border border-secondary shadow-[0_2px_12px_rgba(212,175,55,0.2)]">
                    <span class="relative flex h-2.5 w-2.5">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-secondary opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-secondary"></span>
                    </span>
                    <span class="font-label text-[12px] leading-[16px] tracking-[0.22em] uppercase text-primary font-bold">
                        ✦ Cagar Budaya Palembang • Sriwijaya 1928
                    </span>
                    <span class="font-label text-[12px] text-secondary">•</span>
                    <span class="font-label text-[12px] leading-[16px] font-bold tracking-wider text-secondary-container">
                        SK WALIKOTA NO. 14/2018
                    </span>
                </div>

                {{-- Master Headline --}}
                <div class="flex flex-col">
                    <h1 class="font-serif text-[40px] leading-[50px] md:text-[56px] md:leading-[68px] md:tracking-[-0.02em] font-bold text-primary">
                        Menghidupkan
                        <span class="block italic font-bold my-1 text-gradient-gold" style="filter: drop-shadow(0 2px 15px rgba(212, 175, 55, 0.45));">
                            Cagar Budaya
                        </span>
                    </h1>
                    <p class="font-serif text-[22px] leading-[30px] md:text-[28px] md:leading-[36px] font-semibold tracking-wide mt-2 text-secondary-container">
                        Yang Terlupakan Melalui Kecerdasan Buatan
                    </p>
                </div>

                {{-- Description --}}
                <p class="font-body text-[18px] leading-[28px] text-on-surface-variant max-w-2xl font-normal">
                    Menjelajahi jejak peninggalan bersejarah Kota Palembang yang tersembunyi dan terabaikan. Melalui eksplorasi 3D interaktif, rekonstruksi visual bertenaga AI, dan gamifikasi edukatif untuk melestarikan memori kejayaan Sriwijaya hingga masa Hindia Belanda.
                </p>

                {{-- Academic Credits --}}
                <div class="w-full max-w-2xl p-4 rounded-xl backdrop-blur-xl shadow-md"
                     style="background: linear-gradient(135deg, #FFFFFF 0%, #FDFBF7 100%); border-width: 1px 1px 1px 4px; border-style: solid; border-color: rgba(212, 175, 55, 0.4) rgba(212, 175, 55, 0.3) rgba(212, 175, 55, 0.3) #7A1C1C; box-shadow: 0 4px 20px rgba(122, 28, 28, 0.08);">
                    <div class="flex items-center gap-2 mb-1.5">
                        <span class="material-symbols-outlined text-primary text-[18px]">school</span>
                        <span class="font-label text-[12px] leading-[16px] tracking-[0.18em] uppercase text-primary font-bold">Riset Vokasi Terapan POLSRI</span>
                    </div>
                    <p class="font-body text-[13px] leading-[20px] text-on-surface-variant">
                        <span class="text-primary font-bold">Tim Pengembang Mahasiswa:</span> Muhammad Fadli, Siti Nurhaliza, Rizky Pratama, Anisa Rahmawati
                        <span class="text-secondary mx-1">•</span>
                        <span class="text-primary font-bold">Dosen Pembimbing:</span> Dr. Hendra Wijaya, S.T., M.Kom.
                    </p>
                </div>

                {{-- CTA Buttons --}}
                <div class="flex flex-wrap items-center gap-4 pt-2">
                    {{-- Primary: Mulai Jelajah (Pale Gold) --}}
                    <button class="group relative inline-flex items-center justify-center gap-2 px-7 py-4 rounded-lg font-label text-[14px] leading-[18px] tracking-[0.08em] font-bold uppercase tracking-widest hover:scale-[1.03] active:scale-[0.98] transition-all duration-300 cursor-pointer"
                            id="btn-explore"
                            style="background: linear-gradient(135deg, #E8CC6E 0%, #D4AF37 45%, #B38B2D 100%); color: #4A1010; border: 1px solid #E8CC6E; box-shadow: 0 4px 20px rgba(212, 175, 55, 0.4), 0 1px 0 rgba(255, 255, 255, 0.45) inset;">
                        <span class="material-symbols-outlined text-[20px] transition-transform duration-300 group-hover:rotate-45" style="font-variation-settings: 'FILL' 1;">explore</span>
                        <span>Mulai Jelajah</span>
                    </button>

                    {{-- Secondary: Peta Interaktif (Broken White + Pale Gold Border) --}}
                    <a href="{{ route('cagar-budaya.index') }}"
                       class="inline-flex items-center justify-center gap-2 px-6 py-4 rounded-lg font-label text-[14px] leading-[18px] tracking-[0.08em] font-bold uppercase tracking-wider transition-all duration-200 hover:scale-[1.02] cursor-pointer"
                       style="background: #FFFFFF; color: #7A1C1C; border: 1.5px solid #D4AF37; box-shadow: 0 2px 10px rgba(122, 28, 28, 0.06);">
                        <span class="material-symbols-outlined text-[20px] text-secondary">map</span>
                        <span>Peta Interaktif</span>
                    </a>

                    {{-- Tertiary: Game Sejarah (Maroon) --}}
                    <a href="{{ route('games.index') }}" class="inline-flex items-center justify-center gap-2 px-5 py-4 rounded-lg font-label text-[14px] leading-[18px] tracking-[0.08em] font-bold uppercase tracking-wider transition-all duration-200 hover:bg-[#5A1414] cursor-pointer"
                            style="background: #7A1C1C; color: #F9F6F0; border: 1px solid #942626; box-shadow: 0 2px 10px rgba(122, 28, 28, 0.2);">
                        <span class="material-symbols-outlined text-secondary text-[20px]" style="font-variation-settings: 'FILL' 1;">sports_esports</span>
                        <span>Game Sejarah</span>
                    </a>
                </div>

                {{-- Quick Stats --}}
                <div class="grid grid-cols-3 gap-4 pt-4 w-full max-w-xl">
                    @php
                        $stats = [
                            ['value' => '14', 'suffix' => '+', 'label' => 'Situs Terdata', 'color' => '#7A1C1C'],
                            ['value' => '1928', 'suffix' => '', 'label' => 'Titik Awal Ledeng', 'color' => '#B38B2D'],
                            ['value' => '3', 'suffix' => '', 'label' => 'Game Edukatif', 'color' => '#7A1C1C'],
                        ];
                    @endphp
                    @foreach($stats as $stat)
                        <div class="flex flex-col p-3 rounded-lg shadow-sm"
                             style="background: linear-gradient(145deg, #FFFFFF 0%, #FDFBF7 100%); border: 1px solid rgba(212, 175, 55, 0.35); box-shadow: 0 2px 10px rgba(122, 28, 28, 0.06);">
                            <div class="flex items-center gap-1" style="color: {{ $stat['color'] }};">
                                <span class="font-serif text-[28px] leading-[36px] font-bold leading-none tracking-tight">{{ $stat['value'] }}</span>
                                @if($stat['suffix'])
                                    <span class="font-serif text-[22px] leading-[30px] leading-none">{{ $stat['suffix'] }}</span>
                                @endif
                            </div>
                            <span class="font-label text-[12px] leading-[16px] tracking-[0.06em] text-on-surface-variant uppercase tracking-wider mt-1 font-semibold">{{ $stat['label'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Hero Right: Visual Card --}}
            <div class="lg:col-span-5 relative flex items-center justify-center mt-8 lg:mt-0">

                {{-- Ambient Light Backplate --}}
                <div class="absolute -inset-4 rounded-full bg-gradient-to-t from-primary/15 via-secondary/20 to-transparent blur-3xl opacity-70"></div>

                {{-- Main Landmark Card --}}
                <div class="relative z-10 w-full rounded-2xl overflow-hidden bg-surface-container-lowest group"
                     style="border: 2px solid rgba(212, 175, 55, 0.6); box-shadow: 0 15px 40px rgba(122, 28, 28, 0.12), 0 0 25px rgba(212, 175, 55, 0.25);">

                    {{-- Photo Container (100% Bersih & Tidak Terhalang Box/Background) --}}
                    <div class="relative h-[360px] sm:h-[420px] md:h-[460px] w-full overflow-hidden bg-surface-container">
                        <img class="w-full h-full object-cover object-center transform scale-100 group-hover:scale-105 transition-transform duration-700 ease-out brightness-[0.98] contrast-[1.05]"
                             src="https://lh3.googleusercontent.com/aida/AEtjO1WYqbmGEFDYbetelwk_FE7lHtoFs6wZaiBkgz8Ll8AevzODcdlXp4yiuvioc_86EsKnGHFurFtfhDSpmhQQxrKdatdI2DCk5zOA4ppVhZkOC6TpofjgjBl2C80NlY4mP-59809xogyZ2bKEiXTGX3ZnVPUerb0dUjZBGUtarPXhE2B9RhSFvgp1iKZVEI0NIXAMBqG6WBmLA4OnLpA1QGJ7PXVzA9ph8FBy69Lzcsp5RNGE_N47uBi39-c"
                             alt="Menara Air Palembang 1928 — Kantor Ledeng bersejarah dengan arsitektur kolonial" />

                        {{-- Coordinate Tag --}}
                        <div class="absolute top-4 left-4 z-20 flex items-center gap-1 px-3 py-1.5 rounded-full shadow-sm"
                             style="background: rgba(255, 255, 255, 0.92); border: 1px solid rgba(212, 175, 55, 0.5);">
                            <span class="material-symbols-outlined text-primary text-[16px]">fmd_good</span>
                            <span class="font-label text-[12px] leading-[16px] tracking-[0.06em] text-primary tracking-widest font-mono font-bold">2°59'17.2"S 104°45'34.8"E</span>
                        </div>

                        {{-- AR/3D Badge --}}
                        <div class="absolute top-4 right-4 z-20 flex items-center gap-1 px-2.5 py-1.5 rounded-full shadow-sm"
                             style="background: linear-gradient(135deg, #7A1C1C 0%, #5A1414 100%); color: #F9F6F0; border: 1px solid rgba(212, 175, 55, 0.5);">
                            <span class="w-1.5 h-1.5 rounded-full bg-secondary animate-ping"></span>
                            <span class="font-label text-[12px] leading-[16px] tracking-[0.06em] uppercase tracking-wider font-bold">AR/3D Ready</span>
                        </div>
                    </div>

                    {{-- Audio Guide Console (Ditempatkan di Bawah Gambar, Gambar 100% Terlihat Jelas) --}}
                    <div class="p-5 flex flex-col gap-3 bg-surface-container-lowest border-t border-secondary/30">
                        <div class="flex items-start justify-between">
                            <div>
                                <div class="flex items-center gap-2">
                                    <span class="font-label text-[12px] leading-[16px] tracking-[0.06em] uppercase tracking-widest text-secondary-container font-bold">Objek Cagar Budaya #01</span>
                                    <span class="text-secondary text-xs">•</span>
                                    <span class="font-label text-[12px] leading-[16px] tracking-[0.06em] text-on-surface-variant font-medium">Arsitektur Kolonial</span>
                                </div>
                                <h3 class="font-serif text-[20px] leading-[28px] font-bold text-primary mt-0.5">Menara Air 1928 (Kantor Ledeng)</h3>
                            </div>
                            <button class="w-10 h-10 rounded-full flex items-center justify-center hover:scale-105 transition-transform shadow-sm cursor-pointer shrink-0"
                                    id="audio-toggle"
                                    title="Putar Narasi Audio Sejarah"
                                    style="background: linear-gradient(135deg, #E8CC6E 0%, #D4AF37 60%, #B38B2D 100%); color: #4A1010; border: 1px solid #E8CC6E; box-shadow: 0 2px 10px rgba(212, 175, 55, 0.4);">
                                <span class="material-symbols-outlined text-[20px]" id="audio-icon">volume_up</span>
                            </button>
                        </div>

                        {{-- Audio Wave Visualizer --}}
                        <div class="flex items-center justify-between gap-1 h-5 px-2 rounded-lg"
                             style="background: #F5EFE4; border: 1px solid rgba(212, 175, 55, 0.4);">
                            <span class="font-label text-[12px] text-secondary-container font-mono font-semibold">00:48</span>
                            <div class="flex items-end gap-1 h-3 flex-1 mx-3">
                                <span class="w-1 rounded-full h-2 animate-pulse" style="background: #D4AF37;"></span>
                                <span class="w-1 rounded-full h-3 animate-bounce" style="background: #7A1C1C;"></span>
                                <span class="w-1 rounded-full h-1" style="background: #B38B2D;"></span>
                                <span class="w-1 rounded-full h-2.5 animate-pulse" style="background: #D4AF37;"></span>
                                <span class="w-1 rounded-full h-1.5" style="background: #7A1C1C;"></span>
                                <span class="w-1 rounded-full h-3 animate-bounce" style="background: #B38B2D;"></span>
                                <span class="w-1 rounded-full h-2 animate-pulse" style="background: #7A1C1C;"></span>
                                <span class="w-1 rounded-full h-1" style="background: #D4AF37;"></span>
                                <span class="w-1 rounded-full h-2.5" style="background: #B38B2D;"></span>
                            </div>
                            <span class="font-label text-[12px] text-on-surface-variant font-mono">03:12</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════════
         HERITAGE SITES SECTION
         ═══════════════════════════════════════════════════════ --}}
    <section class="relative z-20 w-full px-5 md:px-12 mt-4 md:mt-8 pb-12" id="heritage-sites">
        <div class="flex flex-col space-y-4">

            {{-- Section Header --}}
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary text-[22px]">account_balance</span>
                    <h2 class="font-serif text-[22px] leading-[30px] font-bold text-primary tracking-tight">Koleksi Situs Warisan Unggulan</h2>
                </div>
                <a href="{{ route('cagar-budaya.index') }}" class="inline-flex items-center gap-1 font-label text-[14px] leading-[18px] tracking-[0.08em] font-bold uppercase tracking-wider transition-colors hover:text-primary"
                   style="color: #B38B2D;">
                    <span>Lihat Semua Arsip</span>
                    <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                </a>
            </div>

            {{-- Heritage Sites Cards (gaya thumbnail galeri, teks muncul saat hover) --}}
            @php
                $sites = [
                    [
                        'era' => '1780 Masehi',
                        'category' => 'Benteng Keraton',
                        'title' => 'Benteng Kuto Besak',
                        'description' => 'Satu-satunya benteng di Nusantara berdinding batu karya pribumi kesultanan.',
                        'image' => asset('images/cagar-budaya/benteng-kuto-besak.jpg'),
                        'alt' => 'Benteng Kuto Besak di tepi Sungai Musi Palembang',
                    ],
                    [
                        'era' => 'Kanal Bersejarah',
                        'category' => 'Pusat Perniagaan 1900',
                        'title' => 'Sekanak Sidogede',
                        'description' => 'Urat nadi perdagangan saudagar pribumi dan arsitektur gudang indisch.',
                        'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuDszdNbgNmJGnHwalryhEgKFBhHDL4jDRhfyzirt_Zs78fCmXGL0cBPHzqYwo5__q1N0sDTGFnil8pR8qqBm7wxYWO9RNYkUEmO3GOyCVKHG9PIC8J0Y5WzAUP-X6m9XCbaUOi8HZOZM___5csrYwwDtLH2AbSgCrNgCrrESOPkhvfgu_qy9LFuwGC_k-krrUQJi2yTMgGyWZI3jArMsgQGCIQTaYjrJCcGmuIjdYIwYOsOymlYhu8T',
                        'alt' => 'Kawasan Sekanak Sidogede bersejarah di Palembang',
                    ],
                    [
                        'era' => 'Abad VII Masehi',
                        'category' => 'Situs Sakral Maritim',
                        'title' => 'Bukit Siguntang',
                        'description' => 'Kompleks persemayaman raja-raja Melayu dan pusat peradaban Buddha Mahayana.',
                        'image' => asset('images/cagar-budaya/bukit-siguntang.jpg'),
                        'alt' => 'Bukit Siguntang situs sakral peninggalan Sriwijaya',
                    ],
                    [
                        'era' => '1823 Masehi',
                        'category' => 'Limas Arsitektur',
                        'title' => 'Museum SMB II',
                        'description' => 'Penyimpan manuskrip kuno, mata uang kesultanan, dan pusaka Songket Emas.',
                        'image' => asset('images/cagar-budaya/museum-smb-ii.jpeg'),
                        'alt' => 'Museum Sultan Mahmud Badaruddin II Palembang',
                    ],
                ];
            @endphp

            <style>
                .ws-card {
                    position: relative;
                    margin: 0;
                    aspect-ratio: 3 / 4;
                    overflow: hidden;
                    border-radius: 22px;
                    border: 2px solid rgba(212, 175, 55, 0.55);
                    box-shadow: 0 12px 24px rgba(122, 28, 28, 0.14);
                    cursor: pointer;
                    transition: transform .3s, box-shadow .3s, border-color .3s;
                }
                .ws-card:hover,
                .ws-card:focus {
                    transform: translateY(-6px);
                    border-color: #D4AF37;
                    box-shadow: 0 0 0 1px #D4AF37, 0 20px 36px rgba(122, 28, 28, 0.22);
                    outline: none;
                }
                .ws-card img {
                    display: block;
                    width: 100%;
                    height: 100%;
                    object-fit: cover;
                    object-position: center;
                    transition: transform .6s ease;
                }
                .ws-card:hover img,
                .ws-card:focus img {
                    transform: scale(1.05);
                }
                .ws-card__info {
                    position: absolute;
                    left: 0;
                    right: 0;
                    bottom: 0;
                    padding: 64px 18px 18px;
                    background: linear-gradient(0deg, rgba(58, 12, 12, 0.96) 0%, rgba(58, 12, 12, 0.65) 60%, transparent 100%);
                    opacity: 0;
                    transform: translateY(16px);
                    transition: opacity .35s ease, transform .35s ease;
                }
                .ws-card:hover .ws-card__info,
                .ws-card:focus .ws-card__info {
                    opacity: 1;
                    transform: translateY(0);
                }
                @media (max-width: 520px) {
                    .ws-card { aspect-ratio: 4 / 3; }
                }
                @media (prefers-reduced-motion: reduce) {
                    .ws-card, .ws-card img, .ws-card__info { transition: none; }
                }
            </style>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                @foreach($sites as $site)
                    <figure class="ws-card" tabindex="0">
                        <img src="{{ $site['image'] }}" alt="{{ $site['alt'] }}" loading="lazy" />

                        {{-- Teks tersembunyi saat awal, muncul saat hover / fokus / disentuh --}}
                        <figcaption class="ws-card__info">
                            <span class="inline-block px-2.5 py-0.5 rounded-full bg-surface/95 text-primary border border-secondary/50 font-label text-[11px] leading-[14px] uppercase font-bold">
                                {{ $site['era'] }}
                            </span>
                            <span class="block mt-2 font-label text-[11px] leading-[14px] tracking-widest uppercase font-bold" style="color: #E8CC6E;">{{ $site['category'] }}</span>
                            <h4 class="font-serif text-[20px] leading-[26px] font-bold text-white mt-1">{{ $site['title'] }}</h4>
                            <p class="font-body text-[13px] leading-[19px] mt-1.5" style="color: #F3E9D2;">{{ $site['description'] }}</p>
                        </figcaption>
                    </figure>
                @endforeach
            </div>
        </div>
    </section>

</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Audio toggle interaction
        const audioBtn = document.getElementById('audio-toggle');
        const audioIcon = document.getElementById('audio-icon');
        let isPlaying = false;

        if (audioBtn && audioIcon) {
            audioBtn.addEventListener('click', function() {
                isPlaying = !isPlaying;
                audioIcon.textContent = isPlaying ? 'pause' : 'volume_up';
                audioBtn.classList.toggle('animate-pulse', isPlaying);
            });
        }

        // Smooth scroll to heritage sites
        const exploreBtn = document.getElementById('btn-explore');
        if (exploreBtn) {
            exploreBtn.addEventListener('click', function() {
                const target = document.getElementById('heritage-sites');
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth' });
                }
            });
        }

        // Mobile menu toggle
        const menuToggle = document.getElementById('mobile-menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');
        if (menuToggle && mobileMenu) {
            menuToggle.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');
                const icon = menuToggle.querySelector('.material-symbols-outlined');
                icon.textContent = mobileMenu.classList.contains('hidden') ? 'menu' : 'close';
            });
        }

    });
</script>
@endpush