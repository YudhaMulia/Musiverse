@extends('layouts.app')

@section('title', 'Beranda')
@section('jarak_atas', 'pt-0')

@section('content')
<div class="flex flex-col w-full bg-surface">
    <!-- HERO SECTION dengan Image Carousel Natural (Tanpa Overlay Warna Menutupi) -->
    <div class="w-full relative overflow-hidden min-h-[85vh] flex flex-col items-center justify-center pt-28 pb-12" data-navbar-gelap>
        <!-- Carousel Images Background (Foto Asli dengan Soft Blur 2.5px & Exposure Optimal 0.68) -->
        <div class="absolute inset-0 z-0 overflow-hidden">
            @foreach($carouselSites as $index => $site)
            <div class="carousel-slide absolute inset-0 transition-opacity duration-1000 ease-in-out {{ $index === 0 ? 'opacity-100' : 'opacity-0' }}" data-index="{{ $index }}">
                @if($site->image_url)
                <img class="w-full h-full object-cover transition-transform duration-1000"
                     style="filter: blur(2.5px) brightness(0.68); transform: scale(1.06);"
                     src="{{ $site->image_url }}" alt="{{ $site->name }}" />
                @else
                <div class="w-full h-full bg-surface-container flex items-center justify-center">
                    <span class="material-symbols-outlined text-primary text-[96px] opacity-20">image</span>
                </div>
                @endif
            </div>
            @endforeach
        </div>

        {{-- Subtle Ambient Scrim (Menyatu Alami dengan Foto, Memberikan Kontras Maksimal Tanpa Kotak) --}}
        <div class="absolute inset-0 z-10 pointer-events-none"
             style="background: radial-gradient(circle at center, rgba(35, 6, 6, 0.35) 0%, rgba(25, 4, 4, 0.2) 60%, rgba(20, 3, 3, 0.45) 100%);">
        </div>

        {{-- Transisi Halus ke Bagian Bawah --}}
        <div class="absolute bottom-0 left-0 right-0 h-16 bg-gradient-to-t from-surface to-transparent z-10 pointer-events-none"></div>

        <!-- Content Overlay (Tanpa Background Box, Teks Kontras Tinggi & Sangat Terbaca) -->
        <div class="relative z-20 px-4 py-8 flex flex-col gap-space-md items-center justify-center text-center max-w-4xl mx-auto">
            <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full border-2 border-secondary text-secondary font-label-md text-label-md uppercase tracking-widest font-bold drop-shadow-[0_2px_14px_rgba(20,3,3,0.95)] shadow-[0_2px_15px_rgba(212,175,55,0.3)]">
                <span class="w-2 h-2 rounded-full bg-secondary animate-ping"></span>
                Eksplorasi Cagar Budaya Palembang
            </span>

            <!-- Main Headline Tanpa Background Box (Super Kontras) -->
            <h1 class="font-display-lg text-3xl sm:text-5xl md:text-6xl text-[#F9F6F0] leading-tight tracking-tight font-extrabold"
                style="text-shadow: 0 2px 4px rgba(25, 4, 4, 0.9), 0 6px 18px rgba(25, 4, 4, 0.95), 0 14px 34px rgba(15, 2, 2, 0.98);">
                Menghidupkan Kembali Jejak Sejarah Palembang yang Terlupakan
            </h1>

            <!-- Sub-headline Tanpa Background Box -->
            <p class="font-body-lg text-base sm:text-lg md:text-xl text-[#F9F6F0] max-w-2xl leading-relaxed font-semibold"
               style="text-shadow: 0 1px 3px rgba(20, 3, 3, 0.92), 0 3px 12px rgba(20, 3, 3, 0.95);">
                Jelajahi cagar budaya terbengkalai Palembang dengan dokumentasi visual foto asli lokasi. Memahami nilai sejarah yang tersembunyi secara interaktif dan edukatif.
            </p>

            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-space-md mt-4">
                <a href="{{ route('cagar-budaya.index') }}" class="px-8 py-4 rounded-full bg-primary hover:bg-[#5A1414] text-[#F9F6F0] font-label-lg text-label-lg tracking-wider uppercase flex items-center gap-2 shadow-[0_4px_25px_rgba(212,175,55,0.4)] hover:scale-105 transition-all border-2 border-secondary font-bold">
                    <span class="material-symbols-outlined text-secondary text-[20px]">explore</span>
                    <span>Mulai Jelajah Peta</span>
                </a>
                <a href="#" class="px-8 py-4 rounded-full bg-[#F9F6F0]/90 hover:bg-[#F9F6F0] text-primary border-2 border-secondary font-label-lg text-label-lg tracking-wider uppercase flex items-center gap-2 transition-all shadow-md font-bold hover:scale-105">
                    <span class="material-symbols-outlined text-secondary text-[20px]">games</span>
                    <span>Coba Main Game</span>
                </a>
            </div>
        </div>

        <!-- Carousel Indicators (Dots) -->
        <div class="absolute bottom-6 left-1/2 -translate-x-1/2 z-30 flex items-center gap-2 px-3 py-1.5 rounded-full bg-surface/90 backdrop-blur-md border border-secondary/40 shadow-md">
            @foreach($carouselSites as $index => $site)
            <button class="carousel-indicator w-2.5 h-2.5 rounded-full transition-all duration-300 {{ $index === 0 ? 'bg-primary w-8' : 'bg-secondary/60 hover:bg-secondary' }}" data-index="{{ $index }}" title="{{ $site->name }}"></button>
            @endforeach
        </div>

        <!-- Carousel Navigation Arrows -->
        <button class="carousel-prev absolute left-4 md:left-8 top-1/2 -translate-y-1/2 z-30 w-11 h-11 rounded-full bg-surface/90 backdrop-blur-md hover:bg-surface-container border border-secondary/50 flex items-center justify-center text-primary transition-all hover:scale-110 shadow-md">
            <span class="material-symbols-outlined text-[24px]">chevron_left</span>
        </button>
        <button class="carousel-next absolute right-4 md:right-8 top-1/2 -translate-y-1/2 z-30 w-11 h-11 rounded-full bg-surface/90 backdrop-blur-md hover:bg-surface-container border border-secondary/50 flex items-center justify-center text-primary transition-all hover:scale-110 shadow-md">
            <span class="material-symbols-outlined text-[24px]">chevron_right</span>
        </button>
    </div>

    <!-- STAT BANNER -->
    <div class="w-full px-margin py-space-lg flex flex-col gap-space-md">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-space-md">
            @foreach($stats as $stat)
            <div class="p-space-md rounded-xl bg-surface-container-lowest border border-secondary/35 hover:border-secondary hover:bg-surface-container-low transition-all flex flex-col items-center text-center gap-space-sm shadow-sm hover:shadow-md">
                <div class="w-14 h-14 rounded-lg bg-primary border border-secondary/40 flex items-center justify-center text-secondary shadow-sm">
                    <span class="material-symbols-outlined text-[28px]">{{ $stat['icon'] }}</span>
                </div>
                <div class="flex flex-col gap-1">
                    <span class="font-display-lg text-display-lg text-primary font-bold">{{ $stat['number'] }}+</span>
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
                    <h3 class="font-title-lg text-title-lg text-primary font-bold">Peta &amp; Rute Eksplorasi</h3>
                    <p class="font-body-sm text-body-sm text-on-surface-variant leading-relaxed">
                        Temukan lokasi situs cagar budaya terbengkalai di Palembang beserta rute perjalanan terdekat melalui peta interaktif.
                    </p>
                </div>
                <div class="mt-auto pt-space-md border-t border-secondary/20">
                    <span class="inline-flex items-center gap-1.5 text-primary font-label-md text-label-md uppercase tracking-wider font-bold">
                        <span>Jelajahi Peta</span>
                        <span class="material-symbols-outlined text-[16px] group-hover:translate-x-1 transition-transform text-secondary">arrow_forward</span>
                    </span>
                </div>
            </div>

            <!-- Feature 2: AI Storyteller -->
            <div class="rounded-xl bg-surface-container-lowest p-space-md border border-secondary/35 hover:border-secondary hover:bg-surface-container-low transition-all flex flex-col gap-space-md shadow-sm hover:shadow-md group">
                <div class="w-12 h-12 rounded-lg bg-primary border border-secondary/40 flex items-center justify-center text-secondary shadow-sm">
                    <span class="material-symbols-outlined text-[28px]">auto_stories</span>
                </div>
                <div class="flex flex-col gap-2">
                    <h3 class="font-title-lg text-title-lg text-primary font-bold">AI Storyteller &amp; Rekonstruksi Visual</h3>
                    <p class="font-body-sm text-body-sm text-on-surface-variant leading-relaxed">
                        Pelajari cerita sejarah dengan bahasa yang mudah dicerna serta bayangan bentuk megah bangunan di masa lalu melalui AI.
                    </p>
                </div>
                <div class="mt-auto pt-space-md border-t border-secondary/20">
                    <span class="inline-flex items-center gap-1.5 text-primary font-label-md text-label-md uppercase tracking-wider font-bold">
                        <span>Dengarkan Cerita</span>
                        <span class="material-symbols-outlined text-[16px] group-hover:translate-x-1 transition-transform text-secondary">arrow_forward</span>
                    </span>
                </div>
            </div>

            <!-- Feature 3: Gamification -->
            <div class="rounded-xl bg-surface-container-lowest p-space-md border border-secondary/35 hover:border-secondary hover:bg-surface-container-low transition-all flex flex-col gap-space-md shadow-sm hover:shadow-md group">
                <div class="w-12 h-12 rounded-lg bg-primary border border-secondary/40 flex items-center justify-center text-secondary shadow-sm">
                    <span class="material-symbols-outlined text-[28px]">gamepad</span>
                </div>
                <div class="flex flex-col gap-2">
                    <h3 class="font-title-lg text-title-lg text-primary font-bold">Match Card Gamification</h3>
                    <p class="font-body-sm text-body-sm text-on-surface-variant leading-relaxed">
                        Uji pengetahuan sejarah melalui permainan mencocokkan kartu yang seru dan kumpulkan poin serta lencana digital.
                    </p>
                </div>
                <div class="mt-auto pt-space-md border-t border-secondary/20">
                    <span class="inline-flex items-center gap-1.5 text-primary font-label-md text-label-md uppercase tracking-wider font-bold">
                        <span>Main Sekarang</span>
                        <span class="material-symbols-outlined text-[16px] group-hover:translate-x-1 transition-transform text-secondary">arrow_forward</span>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- FEATURED HERITAGE SITES PREVIEW (Gambar Asli & Alami Tanpa Filter Warna) -->
    <div class="w-full px-margin py-space-lg flex flex-col gap-space-md">
        <div class="flex items-center gap-space-sm mb-2">
            <span class="material-symbols-outlined text-primary text-[24px]">star</span>
            <h2 class="font-headline-md text-headline-md text-primary font-bold">Sorotan Cagar Budaya Pilihan</h2>
        </div>
        <p class="font-body-md text-body-md text-on-surface-variant mb-space-md font-medium">Jelajahi situs-situs bersejarah paling menarik yang telah dikurasi khusus untuk Anda</p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-space-md">
            @foreach($featuredSites as $site)
            <div class="rounded-xl bg-surface-container-lowest p-space-md hover:bg-surface-container-low transition-all group flex flex-col justify-between gap-space-md border border-secondary/35 hover:border-secondary shadow-sm hover:shadow-md">
                {{-- Container Gambar Asli & Jernih --}}
                <div class="relative w-full h-48 rounded-lg overflow-hidden bg-surface-container border border-secondary/30">
                    @if($site->image_url)
                    <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" src="{{ $site->image_url }}" alt="{{ $site->name }}" />
                    @else
                    <div class="w-full h-full flex items-center justify-center bg-surface-container">
                        <span class="material-symbols-outlined text-primary text-[48px] opacity-40">image</span>
                    </div>
                    @endif
                    {{-- Badges di atas gambar dengan latar belakang bersih agar gambar tetap jelas --}}
                    <div class="absolute top-2.5 left-2.5 px-2.5 py-0.5 rounded bg-surface/95 backdrop-blur-md text-primary border border-secondary/40 font-label-md text-label-md uppercase font-bold shadow-sm">
                        {{ $site->era->name }}
                    </div>
                    <div class="absolute bottom-2.5 right-2.5 px-2.5 py-0.5 rounded bg-surface/95 backdrop-blur-md text-primary font-label-md text-label-md border border-secondary/40 font-semibold shadow-sm">
                        {{ $site->year_built ?? 'Tahun TBD' }}
                    </div>
                </div>

                <div class="flex flex-col gap-1">
                    <span class="font-label-md text-label-md text-secondary-container uppercase tracking-widest font-bold">{{ $site->era->name }}</span>
                    <h3 class="font-headline-sm text-headline-sm text-primary font-bold">{{ $site->name }}</h3>
                    <p class="font-body-sm text-body-sm text-on-surface-variant line-clamp-2 mt-1">{{ $site->short_description }}</p>
                </div>

                <a href="{{ route('cagar-budaya.show', $site->slug) }}" class="w-full py-2.5 rounded bg-surface-container hover:bg-primary hover:text-[#F9F6F0] text-primary border border-secondary/40 font-label-md text-label-md uppercase tracking-wider flex items-center justify-center gap-1.5 transition-all shadow-sm font-bold">
                    <span>Tinjau Lokasi</span>
                    <span class="material-symbols-outlined text-[16px] text-secondary">arrow_forward</span>
                </a>
            </div>
            @endforeach
        </div>
    </div>

    <!-- HOW IT WORKS SECTION -->
    <div class="w-full px-margin py-space-lg flex flex-col gap-space-md">
        <div class="flex items-center justify-center mb-space-md">
            <h2 class="font-headline-lg text-headline-lg text-primary font-bold text-center">Panduan 3 Langkah Mudah</h2>
        </div>

        <div class="max-w-4xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-space-lg">
                <!-- Step 1 -->
                <div class="relative flex flex-col items-center text-center">
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
                <div class="relative flex flex-col items-center text-center">
                    <div class="w-16 h-16 rounded-full bg-primary shadow-md flex items-center justify-center text-[#F9F6F0] font-headline-lg font-bold mb-space-md border-4 border-surface">
                        2
                    </div>
                    <h3 class="font-title-lg text-title-lg text-primary font-bold mb-2">Baca Ceritanya</h3>
                    <p class="font-body-sm text-body-sm text-on-surface-variant leading-relaxed">
                        Pahami sejarahnya lewat penjelasan santai dan menarik buatan AI kami.
                    </p>
                    <div class="hidden md:block absolute top-1/4 -right-1/2 w-1/2 h-1 bg-gradient-to-r from-secondary to-transparent"></div>
                </div>

                <!-- Step 3 -->
                <div class="relative flex flex-col items-center text-center">
                    <div class="w-16 h-16 rounded-full bg-primary shadow-md flex items-center justify-center text-[#F9F6F0] font-headline-lg font-bold mb-space-md border-4 border-surface">
                        3
                    </div>
                    <h3 class="font-title-lg text-title-lg text-primary font-bold mb-2">Mainkan Gamenya</h3>
                    <p class="font-body-sm text-body-sm text-on-surface-variant leading-relaxed">
                        Uji ingatanmu di Match Card Game dan klaim lencana digital kamu!
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="w-full px-margin py-space-xl flex flex-col gap-space-lg items-center justify-center text-center relative overflow-hidden">
        <div class="absolute -top-32 -right-32 w-64 h-64 bg-secondary/15 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col gap-space-md max-w-3xl">
            <h2 class="font-headline-lg text-headline-lg text-primary font-bold">Siap Untuk Petualangan?</h2>
            <p class="font-body-lg text-body-lg text-on-surface-variant font-medium">
                Mulai jelajahi cagar budaya Palembang dan temukan cerita-cerita menakjubkan di balik setiap bangunan bersejarah.
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-space-md mt-space-md">
                <a href="{{ route('cagar-budaya.index') }}" class="px-8 py-4 rounded-lg bg-primary hover:bg-[#5A1414] text-[#F9F6F0] font-label-lg text-label-lg tracking-wider uppercase flex items-center gap-2 shadow-md hover:scale-[1.01] transition-all border border-secondary/50 font-bold">
                    <span class="material-symbols-outlined text-secondary text-[20px]">map</span>
                    <span>Mulai Eksplorasi</span>
                </a>
                <a href="#" class="px-8 py-4 rounded-lg bg-surface-container hover:bg-surface-container-high text-primary hover:text-primary border border-secondary/40 font-label-lg text-label-lg tracking-wider uppercase flex items-center gap-2 transition-colors font-bold shadow-sm">
                    <span class="material-symbols-outlined text-secondary text-[20px]">info</span>
                    <span>Pelajari Lebih</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
