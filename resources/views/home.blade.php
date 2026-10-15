@extends('layouts.app')

@section('title', 'Rediscover Heritage — Cagar Budaya Palembang')
@section('meta_description', 'Menjelajahi jejak peninggalan bersejarah Kota Palembang melalui eksplorasi 3D interaktif, rekonstruksi visual bertenaga AI, dan gamifikasi edukatif.')

@section('content')
<div class="flex flex-col w-full relative overflow-hidden select-none">

    {{-- Atmospheric Glow Layers --}}
    <div class="pointer-events-none absolute -top-40 -left-32 w-[680px] h-[680px] rounded-full bg-primary-container/30 blur-[150px]"></div>
    <div class="pointer-events-none absolute top-1/4 right-0 w-[600px] h-[600px] rounded-full bg-secondary-container/20 blur-[170px]"></div>
    <div class="pointer-events-none absolute bottom-10 left-1/3 w-[500px] h-[500px] rounded-full bg-primary/10 blur-[140px]"></div>

    {{-- Floating Embers --}}
    <div class="pointer-events-none absolute inset-0 z-10 overflow-hidden">
        <span class="absolute w-1.5 h-1.5 rounded-full bg-secondary shadow-[0_0_10px_#e9c349] top-1/3 left-1/4 animate-pulse opacity-80"></span>
        <span class="absolute w-2 h-2 rounded-full bg-primary-container shadow-[0_0_14px_#fd7683] top-1/2 left-[16%] animate-ping opacity-60"></span>
        <span class="absolute w-1 h-1 rounded-full bg-secondary-fixed shadow-[0_0_8px_#ffe088] top-2/3 left-1/3 animate-pulse opacity-70"></span>
        <span class="absolute w-2.5 h-2.5 rounded-full bg-secondary shadow-[0_0_16px_#e9c349] top-1/4 right-1/4 animate-bounce opacity-50"></span>
        <span class="absolute w-1.5 h-1.5 rounded-full bg-secondary-fixed-dim top-[60%] right-1/3 animate-pulse opacity-90 shadow-[0_0_9px_#e9c349]"></span>
        <span class="absolute w-2 h-2 rounded-full bg-primary shadow-[0_0_12px_#ffb2b6] top-3/4 right-[20%] animate-ping opacity-40"></span>
    </div>

    {{-- ═══════════════════════════════════════════════════════
         HERO SECTION
         ═══════════════════════════════════════════════════════ --}}
    <section class="relative z-20 w-full px-5 md:px-12 pt-6 md:pt-10 pb-6">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-center">

            {{-- Hero Left: Content --}}
            <div class="lg:col-span-7 flex flex-col items-start space-y-6">

                {{-- Heritage Pill Badge --}}
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full backdrop-blur-md bg-glass-dark border border-gold shadow-[0_0_20px_rgba(114,9,33,0.5)]">
                    <span class="relative flex h-2.5 w-2.5">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-secondary opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-secondary"></span>
                    </span>
                    <span class="font-label text-[12px] leading-[16px] tracking-[0.22em] uppercase text-secondary font-semibold">
                        ✦ Cagar Budaya Palembang • Sriwijaya 1928
                    </span>
                    <span class="font-label text-[12px] text-outline">|</span>
                    <span class="font-label text-[12px] leading-[16px] font-bold tracking-wider" style="color: #ffe088; text-shadow: 0 0 10px rgba(233, 195, 73, 0.5);">
                        SK WALIKOTA NO. 14/2018
                    </span>
                </div>

                {{-- Master Headline --}}
                <div class="flex flex-col">
                    <h1 class="font-serif text-[40px] leading-[50px] md:text-[56px] md:leading-[68px] md:tracking-[-0.02em] font-bold text-on-surface">
                        Menghidupkan
                        <span class="block italic font-bold my-1 text-gradient-gold" style="filter: drop-shadow(0 0 25px rgba(212, 175, 55, 0.65)) drop-shadow(0 0 45px rgba(155, 17, 30, 0.75));">
                            Cagar Budaya
                        </span>
                    </h1>
                    <p class="font-serif text-[22px] leading-[30px] md:text-[28px] md:leading-[36px] font-medium tracking-wide mt-2 text-shadow-gold" style="color: #e9c349;">
                        Yang Terlupakan Melalui Kecerdasan Buatan
                    </p>
                </div>

                {{-- Description --}}
                <p class="font-body text-[18px] leading-[28px] text-on-surface-variant max-w-2xl">
                    Menjelajahi jejak peninggalan bersejarah Kota Palembang yang tersembunyi dan terabaikan. Melalui eksplorasi 3D interaktif, rekonstruksi visual bertenaga AI, dan gamifikasi edukatif untuk melestarikan memori kejayaan Sriwijaya hingga masa Hindia Belanda.
                </p>

                {{-- Academic Credits --}}
                <div class="w-full max-w-2xl p-4 rounded-xl backdrop-blur-xl shadow-lg"
                     style="background: linear-gradient(135deg, rgba(37, 24, 27, 0.92) 0%, rgba(22, 11, 14, 0.95) 100%); border-width: 1px 1px 1px 3px; border-style: solid; border-color: rgba(233, 195, 73, 0.3) rgba(233, 195, 73, 0.2) rgba(233, 195, 73, 0.2) #e9c349; box-shadow: 0 8px 24px rgba(0, 0, 0, 0.65);">
                    <div class="flex items-center gap-2 mb-1.5">
                        <span class="material-symbols-outlined text-secondary text-[18px]">school</span>
                        <span class="font-label text-[12px] leading-[16px] tracking-[0.18em] uppercase text-secondary font-semibold">Riset Vokasi Terapan POLSRI</span>
                    </div>
                    <p class="font-body text-[13px] leading-[20px] text-on-surface-variant">
                        <span class="text-on-surface font-semibold">Tim Pengembang Mahasiswa:</span> Muhammad Fadli, Siti Nurhaliza, Rizky Pratama, Anisa Rahmawati
                        <span class="text-outline mx-1">•</span>
                        <span class="text-on-surface font-semibold">Dosen Pembimbing:</span> Dr. Hendra Wijaya, S.T., M.Kom.
                    </p>
                </div>

                {{-- CTA Buttons --}}
                <div class="flex flex-wrap items-center gap-4 pt-2">
                    {{-- Primary: Mulai Jelajah --}}
                    <button class="group relative inline-flex items-center justify-center gap-2 px-7 py-4 rounded-lg font-label text-[14px] leading-[18px] tracking-[0.08em] font-bold uppercase tracking-widest hover:scale-[1.03] active:scale-[0.98] transition-all duration-300 cursor-pointer"
                            id="btn-explore"
                            style="background: linear-gradient(135deg, #ffe088 0%, #e9c349 45%, #af8d11 100%); color: #342800; border: 1px solid #ffe088; box-shadow: 0 0 35px rgba(233, 195, 73, 0.65), 0 1px 0 rgba(255, 255, 255, 0.45) inset;">
                        <span class="material-symbols-outlined text-[20px] transition-transform duration-300 group-hover:rotate-45" style="font-variation-settings: 'FILL' 1;">explore</span>
                        <span>Mulai Jelajah</span>
                    </button>

                    {{-- Secondary: Peta Interaktif --}}
                    <button class="inline-flex items-center justify-center gap-2 px-6 py-4 rounded-lg font-label text-[14px] leading-[18px] tracking-[0.08em] font-semibold uppercase tracking-wider transition-all duration-200 hover:scale-[1.02] cursor-pointer"
                            style="background: rgba(37, 24, 27, 0.85); color: #ffe088; border: 1px solid rgba(233, 195, 73, 0.45); box-shadow: 0 4px 18px rgba(0, 0, 0, 0.6);">
                        <span class="material-symbols-outlined text-[20px] text-secondary">map</span>
                        <span>Peta Interaktif</span>
                    </button>

                    {{-- Tertiary: Game Sejarah --}}
                    <button class="inline-flex items-center justify-center gap-2 px-5 py-4 rounded-lg font-label text-[14px] leading-[18px] tracking-[0.08em] font-semibold uppercase tracking-wider transition-all duration-200 hover:bg-surface-container cursor-pointer"
                            style="background: rgba(22, 11, 14, 0.7); color: #f4dde1; border: 1px solid rgba(233, 195, 73, 0.28);">
                        <span class="material-symbols-outlined text-secondary text-[20px]" style="font-variation-settings: 'FILL' 1;">sports_esports</span>
                        <span>Game Sejarah</span>
                    </button>
                </div>

                {{-- Quick Stats --}}
                <div class="grid grid-cols-3 gap-4 pt-4 w-full max-w-xl">
                    @php
                        $stats = [
                            ['value' => '14', 'suffix' => '+', 'label' => 'Situs Terdata', 'color' => '#ffe088'],
                            ['value' => '1928', 'suffix' => '', 'label' => 'Titik Awal Ledeng', 'color' => '#e9c349'],
                            ['value' => '98.4', 'suffix' => '%', 'label' => 'Akurasi Visual AI', 'color' => '#ffb2b6'],
                        ];
                    @endphp
                    @foreach($stats as $stat)
                        <div class="flex flex-col p-3 rounded-lg shadow-md"
                             style="background: linear-gradient(145deg, rgba(41, 28, 31, 0.9) 0%, rgba(22, 11, 14, 0.9) 100%); border: 1px solid rgba(233, 195, 73, 0.35); box-shadow: 0 4px 16px rgba(0, 0, 0, 0.55);">
                            <div class="flex items-center gap-1" style="color: {{ $stat['color'] }};">
                                <span class="font-serif text-[28px] leading-[36px] font-bold leading-none tracking-tight">{{ $stat['value'] }}</span>
                                @if($stat['suffix'])
                                    <span class="font-serif text-[22px] leading-[30px] leading-none">{{ $stat['suffix'] }}</span>
                                @endif
                            </div>
                            <span class="font-label text-[12px] leading-[16px] tracking-[0.06em] text-on-surface-variant uppercase tracking-wider mt-1">{{ $stat['label'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Hero Right: Visual Card --}}
            <div class="lg:col-span-5 relative flex items-center justify-center mt-8 lg:mt-0">

                {{-- Ambient Light Backplate --}}
                <div class="absolute -inset-4 rounded-full bg-gradient-to-t from-primary-container/25 via-secondary/20 to-transparent blur-3xl opacity-80"></div>

                {{-- Main Landmark Card --}}
                <div class="relative z-10 w-full rounded-2xl overflow-hidden bg-surface-container-lowest group"
                     style="border: 1px solid rgba(233, 195, 73, 0.4); box-shadow: 0 25px 60px -10px rgba(0, 0, 0, 0.9), 0 0 35px rgba(114, 9, 33, 0.45);">

                    <div class="relative h-[420px] sm:h-[490px] md:h-[580px] w-full overflow-hidden bg-surface-container-lowest">
                        <img class="w-full h-full object-cover object-center transform scale-100 group-hover:scale-105 transition-transform duration-700 ease-out brightness-[0.95] contrast-[1.1]"
                             src="https://lh3.googleusercontent.com/aida/AEtjO1WYqbmGEFDYbetelwk_FE7lHtoFs6wZaiBkgz8Ll8AevzODcdlXp4yiuvioc_86EsKnGHFurFtfhDSpmhQQxrKdatdI2DCk5zOA4ppVhZkOC6TpofjgjBl2C80NlY4mP-59809xogyZ2bKEiXTGX3ZnVPUerb0dUjZBGUtarPXhE2B9RhSFvgp1iKZVEI0NIXAMBqG6WBmLA4OnLpA1QGJ7PXVzA9ph8FBy69Lzcsp5RNGE_N47uBi39-c"
                             alt="Menara Air Palembang 1928 — Kantor Ledeng bersejarah dengan arsitektur kolonial" />

                        {{-- Vignette Gradients --}}
                        <div class="absolute inset-0 bg-gradient-to-t from-surface-container-lowest via-surface-container-lowest/35 to-transparent"></div>
                        <div class="absolute inset-0 bg-radial-[at_50%_50%] from-transparent via-transparent to-surface-container-lowest/85"></div>

                        {{-- Coordinate Tag --}}
                        <div class="absolute top-4 left-4 z-20 flex items-center gap-1 px-3 py-1.5 rounded-full backdrop-blur-md shadow-md"
                             style="background: rgba(22, 11, 14, 0.85); border: 1px solid rgba(233, 195, 73, 0.35);">
                            <span class="material-symbols-outlined text-secondary text-[16px]">fmd_good</span>
                            <span class="font-label text-[12px] leading-[16px] tracking-[0.06em] text-on-surface tracking-widest font-mono">2°59'17.2"S 104°45'34.8"E</span>
                        </div>

                        {{-- AR/3D Badge --}}
                        <div class="absolute top-4 right-4 z-20 flex items-center gap-1 px-2.5 py-1.5 rounded-full backdrop-blur-md shadow-md"
                             style="background: linear-gradient(135deg, #720921 0%, #410005 100%); color: #ffe088; border: 1px solid rgba(233, 195, 73, 0.5); box-shadow: 0 0 16px rgba(114, 9, 33, 0.6);">
                            <span class="w-1.5 h-1.5 rounded-full bg-secondary animate-ping"></span>
                            <span class="font-label text-[12px] leading-[16px] tracking-[0.06em] uppercase tracking-wider font-semibold">AR/3D Ready</span>
                        </div>

                        {{-- Audio Guide Dock --}}
                        <div class="absolute bottom-6 left-6 right-6 z-20 p-4 rounded-xl backdrop-blur-xl shadow-2xl flex flex-col gap-3"
                             style="background: rgba(28, 16, 19, 0.92); border: 1px solid rgba(233, 195, 73, 0.45); box-shadow: 0 12px 35px rgba(0, 0, 0, 0.85), 0 0 25px rgba(114, 9, 33, 0.4);">
                            <div class="flex items-start justify-between">
                                <div>
                                    <div class="flex items-center gap-2">
                                        <span class="font-label text-[12px] leading-[16px] tracking-[0.06em] uppercase tracking-widest text-secondary font-semibold">Objek Cagar Budaya #01</span>
                                        <span class="text-outline text-xs">•</span>
                                        <span class="font-label text-[12px] leading-[16px] tracking-[0.06em] text-on-surface-variant">Arsitektur Kolonial</span>
                                    </div>
                                    <h3 class="font-serif text-[22px] leading-[30px] font-semibold text-on-surface mt-0.5">Menara Air 1928 (Kantor Ledeng)</h3>
                                </div>
                                <button class="w-10 h-10 rounded-full flex items-center justify-center hover:scale-105 transition-transform shadow-md cursor-pointer shrink-0"
                                        id="audio-toggle"
                                        title="Putar Narasi Audio Sejarah"
                                        style="background: linear-gradient(135deg, #ffe088 0%, #e9c349 60%, #af8d11 100%); color: #342800; border: 1px solid #ffe088; box-shadow: 0 0 20px rgba(233, 195, 73, 0.6);">
                                    <span class="material-symbols-outlined text-[20px]" id="audio-icon">volume_up</span>
                                </button>
                            </div>

                            {{-- Audio Wave Visualizer --}}
                            <div class="flex items-center justify-between gap-1 h-5 px-1.5 rounded-lg"
                                 style="background: rgba(22, 11, 14, 0.7); border: 1px solid rgba(87, 65, 66, 0.4);">
                                <span class="font-label text-[12px] text-outline font-mono">00:48</span>
                                <div class="flex items-end gap-1 h-3 flex-1 mx-3">
                                    <span class="w-1 rounded-full h-2 animate-pulse" style="background: #e9c349;"></span>
                                    <span class="w-1 rounded-full h-3 animate-bounce" style="background: #fd7683;"></span>
                                    <span class="w-1 rounded-full h-1" style="background: #ffe088;"></span>
                                    <span class="w-1 rounded-full h-2.5 animate-pulse" style="background: #e9c349;"></span>
                                    <span class="w-1 rounded-full h-1.5" style="background: #720921;"></span>
                                    <span class="w-1 rounded-full h-3 animate-bounce" style="background: #ffe088;"></span>
                                    <span class="w-1 rounded-full h-2 animate-pulse" style="background: #fd7683;"></span>
                                    <span class="w-1 rounded-full h-1" style="background: #e9c349;"></span>
                                    <span class="w-1 rounded-full h-2.5" style="background: #ffe088;"></span>
                                </div>
                                <span class="font-label text-[12px] text-on-surface-variant font-mono">03:12</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Floating Prasasti Badge --}}
                <div class="hidden sm:flex absolute -bottom-5 -left-6 z-30 items-center gap-2 p-3.5 rounded-xl backdrop-blur-xl shadow-2xl max-w-xs"
                     style="background: rgba(37, 24, 27, 0.95); border: 1px solid rgba(233, 195, 73, 0.45); box-shadow: 0 10px 30px rgba(0, 0, 0, 0.8), 0 0 20px rgba(114, 9, 33, 0.4);">
                    <div class="w-10 h-10 rounded-lg bg-surface-container-lowest flex items-center justify-center shrink-0 border border-secondary/30">
                        <span class="material-symbols-outlined text-secondary text-[22px]">auto_stories</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="font-label text-[12px] leading-[16px] tracking-[0.06em] text-secondary uppercase tracking-widest font-bold">Prasasti Kedukan Bukit</span>
                        <span class="font-body text-[13px] leading-[20px] text-on-surface-variant line-clamp-1">Konektivitas Dinasti Syailendra 683 M</span>
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
                    <span class="material-symbols-outlined text-secondary text-[22px]" style="text-shadow: 0 0 12px rgba(233, 195, 73, 0.6);">account_balance</span>
                    <h2 class="font-serif text-[22px] leading-[30px] font-bold text-on-surface tracking-tight">Koleksi Situs Warisan Unggulan</h2>
                </div>
                <a href="#" class="inline-flex items-center gap-1 font-label text-[14px] leading-[18px] tracking-[0.08em] font-semibold uppercase tracking-wider transition-colors hover:text-secondary-fixed"
                   style="color: #e9c349; text-shadow: 0 0 10px rgba(233, 195, 73, 0.3);">
                    <span>Lihat Semua Arsip</span>
                    <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                </a>
            </div>

            {{-- Heritage Sites Cards Grid --}}
            @php
                $sites = [
                    [
                        'era' => '1780 Masehi',
                        'category' => 'Benteng Keraton',
                        'title' => 'Benteng Kuto Besak',
                        'description' => 'Satu-satunya benteng di Nusantara berdinding batu karya pribumi kesultanan.',
                        'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCp4AQMyg2dfY9PvqzvOtDUqcxidhT0x10cPtoYYHO96iQFmCD_fMYWzN3qlyMP4bONYdAz0XwQwwOO57x82opCHlNoXj9a2LSrBHK9dPqZhn-VOLwycNpxUbHn1xbYplQ4Ep8686f59eqTOopT4lMb5hNTrnpL-LIRX-s_GUJXglQd3vnReGpQdSLWOMUWcIfQ3z_DPx7Ey1xXK7SQnBK8DHJg0DRx-EynqAoyCJi6DPuy67vMJp2J',
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
                        'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAOqZF1ivFJUmGEFebWDmH9sd7CGqFZKn9r4tCUNbUMW8Kibsf2s4Kg2Ke02gbrTQ80Q1quotH1ofEGLntest1ELRThuZRBQM_VzAOnRqH31IQ90vK6nu4MkDmRP-vDcvmrq-Z8vqDwvTM925fcMv5mGbpn9y-nwjHwFGt5V0NNmA0_NXhfTigVP7LxzaQ-jiJKxr_ZiE4Ad7aMrVBNUXOZxDTf44VD0uOHx5TtpPYIviccccUIwugm',
                        'alt' => 'Bukit Siguntang situs sakral peninggalan Sriwijaya',
                    ],
                    [
                        'era' => '1823 Masehi',
                        'category' => 'Limas Arsitektur',
                        'title' => 'Museum SMB II',
                        'description' => 'Penyimpan manuskrip kuno, mata uang kesultanan, dan pusaka Songket Emas.',
                        'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAS4FCYjnaqNP4TKvKwYzYsqgXTiEkfHU27CZeyM-O_2oj8yp25hqhaaDjB0GcrJ1Y3iLnsUgEbUyBpGjegU4OV2cwlw1ZnMLwqFjE5K5gk-zEUBuHRz2Vxb-YUR-yz6VDc7PghlmpOwOGCDRGlIe0vtDN_dNHUnIvmvJOHYeEmgzB9Eove81a9KqTjI02LrjGNTzxNZystPv_OsTkkoEuMU2fIM4rifCAP94LcnRx-3aICAVywAN6F',
                        'alt' => 'Museum Sultan Mahmud Badaruddin II Palembang',
                    ],
                ];
            @endphp

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach($sites as $site)
                    <div class="group relative rounded-xl transition-all duration-300 overflow-hidden flex flex-col justify-between h-72 hover:-translate-y-1 bg-card-dark"
                         style="border: 1px solid rgba(233, 195, 73, 0.38); box-shadow: 0 10px 25px rgba(0, 0, 0, 0.7), 0 0 15px rgba(114, 9, 33, 0.25);">

                        {{-- Background Image --}}
                        <div class="absolute inset-0 z-0">
                            <img class="w-full h-full object-cover object-center brightness-[0.4] group-hover:brightness-[0.55] group-hover:scale-105 transition-all duration-500"
                                 src="{{ $site['image'] }}"
                                 alt="{{ $site['alt'] }}" />
                            <div class="absolute inset-0 bg-gradient-to-t from-surface-container-lowest via-surface-container-lowest/60 to-transparent"></div>
                        </div>

                        {{-- Card Header --}}
                        <div class="relative z-10 p-4 flex justify-between items-start">
                            <span class="font-label text-[12px] leading-[16px] tracking-[0.06em] px-2.5 py-1 rounded-sm backdrop-blur-md uppercase font-semibold tracking-wider text-secondary"
                                  style="background: rgba(22, 11, 14, 0.85); border: 1px solid rgba(233, 195, 73, 0.3);">
                                {{ $site['era'] }}
                            </span>
                            <span class="material-symbols-outlined text-on-surface-variant group-hover:text-secondary transition-colors text-[20px] cursor-pointer">bookmark</span>
                        </div>

                        {{-- Card Content --}}
                        <div class="relative z-10 p-4 flex flex-col">
                            <span class="font-label text-[12px] leading-[16px] tracking-[0.06em] text-secondary uppercase tracking-widest font-mono">{{ $site['category'] }}</span>
                            <h4 class="font-serif text-[20px] leading-[28px] font-bold text-on-surface group-hover:text-secondary transition-colors">{{ $site['title'] }}</h4>
                            <p class="font-body text-[13px] leading-[20px] text-on-surface-variant line-clamp-1 mt-1">{{ $site['description'] }}</p>
                        </div>
                    </div>
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
