@extends('layouts.app')

@section('title', 'Home - Rediscover Heritage Palembang')

@section('content')
<div class="flex flex-col w-full">
    <!-- HERO SECTION dengan Image Carousel -->
    <div class="w-full relative overflow-hidden min-h-screen flex flex-col items-center justify-center">
        <!-- Carousel Images Background -->
        <div class="absolute inset-0 z-0">
            @foreach($carouselSites as $index => $site)
            <div class="carousel-slide absolute inset-0 transition-opacity duration-1000 ease-in-out {{ $index === 0 ? 'opacity-100' : 'opacity-0' }}" data-index="{{ $index }}">
                @if($site->image_url)
                <img class="w-full h-full object-cover" src="{{ $site->image_url }}" alt="{{ $site->name }}" />
                @else
                <div class="w-full h-full bg-surface-container-lowest flex items-center justify-center">
                    <span class="material-symbols-outlined text-secondary text-[96px] opacity-30">image</span>
                </div>
                @endif
            </div>
            @endforeach

            <!-- Dark Overlay for Text Readability -->
            <div class="absolute inset-0 bg-gradient-to-b from-surface-container-lowest/70 via-surface-container-lowest/80 to-surface-container-lowest/90 z-10"></div>
        </div>

        <!-- Content Overlay -->
        <div class="relative z-20 px-margin py-space-xl flex flex-col gap-space-lg items-center justify-center text-center max-w-4xl">
            <!-- Main Headline -->
            <h1 class="font-display-lg text-display-lg text-on-surface leading-tight tracking-tight drop-shadow-lg">
                Menghidupkan Kembali Jejak Sejarah Palembang yang Terlupakan
            </h1>

            <!-- Sub-headline -->
            <p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl leading-relaxed drop-shadow-md">
                Jelajahi cagar budaya terbengkalai Palembang dengan gambar-gambar asli lokasi. Memahami nilai sejarah yang tersembunyi di balik bangunan-bangunan bersejarah dengan cara yang interaktif dan menyenangkan.
            </p>

            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-space-md mt-space-md">
                <a href="{{ route('cagar-budaya.index') }}" class="px-8 py-4 rounded-lg bg-gradient-to-r from-primary-container via-[#540818] to-secondary-container text-secondary font-label-lg text-label-lg tracking-wider uppercase flex items-center gap-2 shadow-[0_0_20px_rgba(114,9,33,0.6)] hover:shadow-secondary/25 hover:scale-[1.01] transition-all border border-secondary/50 font-semibold">
                    <span class="material-symbols-outlined text-[18px]">explore</span>
                    <span>Mulai Jelajah Peta</span>
                </a>
                <a href="#" class="px-8 py-4 rounded-lg bg-surface-container-high hover:bg-surface-bright text-on-surface hover:text-secondary border border-secondary/30 font-label-lg text-label-lg tracking-wider uppercase flex items-center gap-2 transition-colors shadow-lg">
                    <span class="material-symbols-outlined text-secondary text-[18px]">games</span>
                    <span>Coba Main Game</span>
                </a>
            </div>
        </div>

        <!-- Carousel Indicators (Dots) -->
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 z-30 flex items-center gap-2">
            @foreach($carouselSites as $index => $site)
            <button class="carousel-indicator w-2.5 h-2.5 rounded-full transition-all duration-300 {{ $index === 0 ? 'bg-secondary w-8' : 'bg-secondary/50 hover:bg-secondary/75' }}" data-index="{{ $index }}" title="{{ $site->name }}"></button>
            @endforeach
        </div>

        <!-- Carousel Navigation Arrows -->
        <button class="carousel-prev absolute left-6 top-1/2 -translate-y-1/2 z-30 w-12 h-12 rounded-full bg-surface-container-lowest/80 hover:bg-surface-container/80 border border-secondary/30 flex items-center justify-center text-secondary transition-all hover:scale-110">
            <span class="material-symbols-outlined text-[24px]">chevron_left</span>
        </button>
        <button class="carousel-next absolute right-6 top-1/2 -translate-y-1/2 z-30 w-12 h-12 rounded-full bg-surface-container-lowest/80 hover:bg-surface-container/80 border border-secondary/30 flex items-center justify-center text-secondary transition-all hover:scale-110">
            <span class="material-symbols-outlined text-[24px]">chevron_right</span>
        </button>
    </div>

    <!-- STAT BANNER -->
    <div class="w-full px-margin py-space-lg flex flex-col gap-space-md">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-space-md">
            @foreach($stats as $stat)
            <div class="p-space-md rounded-xl bg-surface-container border border-secondary/25 hover:border-secondary/60 hover:bg-surface-container-high transition-all flex flex-col items-center text-center gap-space-sm shadow-md hover:shadow-lg">
                <div class="w-14 h-14 rounded-lg bg-primary-container border border-secondary/40 flex items-center justify-center text-secondary shadow-[0_0_15px_rgba(233,195,73,0.3)]">
                    <span class="material-symbols-outlined text-[28px]">{{ $stat['icon'] }}</span>
                </div>
                <div class="flex flex-col gap-1">
                    <span class="font-display-lg text-display-lg text-secondary font-bold">{{ $stat['number'] }}+</span>
                    <span class="font-label-lg text-label-lg text-on-surface uppercase tracking-widest font-semibold">{{ $stat['label'] }}</span>
                    <p class="font-body-sm text-body-sm text-on-surface-variant">{{ $stat['description'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- CORE FEATURES SECTION -->
    <div class="w-full px-margin py-space-lg flex flex-col gap-space-md">
        <div class="flex items-center justify-center mb-space-md">
            <h2 class="font-headline-lg text-headline-lg text-on-surface text-center">Fitur Unggulan Aplikasi</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-space-md">
            <!-- Feature 1: Map & Exploration -->
            <div class="rounded-xl bg-surface-container p-space-md border border-secondary/25 hover:border-secondary/60 hover:bg-surface-container-high transition-all flex flex-col gap-space-md shadow-md hover:shadow-lg group">
                <div class="w-12 h-12 rounded-lg bg-primary-container border border-secondary/40 flex items-center justify-center text-secondary shadow-[0_0_10px_rgba(233,195,73,0.2)]">
                    <span class="material-symbols-outlined text-[28px]">map</span>
                </div>
                <div class="flex flex-col gap-2">
                    <h3 class="font-title-lg text-title-lg text-on-surface font-semibold">Peta & Rute Eksplorasi</h3>
                    <p class="font-body-sm text-body-sm text-on-surface-variant leading-relaxed">
                        Temukan lokasi situs cagar budaya terbengkalai di Palembang beserta rute perjalanan terdekat melalui peta interaktif.
                    </p>
                </div>
                <div class="mt-auto pt-space-md border-t border-outline-variant/30">
                    <span class="inline-flex items-center gap-1.5 text-secondary font-label-md text-label-md uppercase tracking-wider">
                        <span>Jelajahi Peta</span>
                        <span class="material-symbols-outlined text-[16px] group-hover:translate-x-1 transition-transform">arrow_forward</span>
                    </span>
                </div>
            </div>

            <!-- Feature 2: AI Storyteller -->
            <div class="rounded-xl bg-surface-container p-space-md border border-secondary/25 hover:border-secondary/60 hover:bg-surface-container-high transition-all flex flex-col gap-space-md shadow-md hover:shadow-lg group">
                <div class="w-12 h-12 rounded-lg bg-primary-container border border-secondary/40 flex items-center justify-center text-secondary shadow-[0_0_10px_rgba(233,195,73,0.2)]">
                    <span class="material-symbols-outlined text-[28px]">auto_stories</span>
                </div>
                <div class="flex flex-col gap-2">
                    <h3 class="font-title-lg text-title-lg text-on-surface font-semibold">AI Storyteller & Rekonstruksi Visual</h3>
                    <p class="font-body-sm text-body-sm text-on-surface-variant leading-relaxed">
                        Pelajari cerita sejarah dengan bahasa yang mudah dicerna serta bayangan bentuk megah bangunan di masa lalu melalui AI.
                    </p>
                </div>
                <div class="mt-auto pt-space-md border-t border-outline-variant/30">
                    <span class="inline-flex items-center gap-1.5 text-secondary font-label-md text-label-md uppercase tracking-wider">
                        <span>Dengarkan Cerita</span>
                        <span class="material-symbols-outlined text-[16px] group-hover:translate-x-1 transition-transform">arrow_forward</span>
                    </span>
                </div>
            </div>

            <!-- Feature 3: Gamification -->
            <div class="rounded-xl bg-surface-container p-space-md border border-secondary/25 hover:border-secondary/60 hover:bg-surface-container-high transition-all flex flex-col gap-space-md shadow-md hover:shadow-lg group">
                <div class="w-12 h-12 rounded-lg bg-primary-container border border-secondary/40 flex items-center justify-center text-secondary shadow-[0_0_10px_rgba(233,195,73,0.2)]">
                    <span class="material-symbols-outlined text-[28px]">gamepad</span>
                </div>
                <div class="flex flex-col gap-2">
                    <h3 class="font-title-lg text-title-lg text-on-surface font-semibold">Match Card Gamification</h3>
                    <p class="font-body-sm text-body-sm text-on-surface-variant leading-relaxed">
                        Uji pengetahuan sejarah melalui permainan mencocokkan kartu yang seru dan kumpulkan poin serta lencana digital.
                    </p>
                </div>
                <div class="mt-auto pt-space-md border-t border-outline-variant/30">
                    <span class="inline-flex items-center gap-1.5 text-secondary font-label-md text-label-md uppercase tracking-wider">
                        <span>Main Sekarang</span>
                        <span class="material-symbols-outlined text-[16px] group-hover:translate-x-1 transition-transform">arrow_forward</span>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- FEATURED HERITAGE SITES PREVIEW -->
    <div class="w-full px-margin py-space-lg flex flex-col gap-space-md">
        <div class="flex items-center gap-space-sm mb-2">
            <span class="material-symbols-outlined text-secondary text-[24px]">star</span>
            <h2 class="font-headline-md text-headline-md text-on-surface">Sorotan Cagar Budaya Pilihan</h2>
        </div>
        <p class="font-body-md text-body-md text-on-surface-variant mb-space-md">Jelajahi situs-situs bersejarah paling menarik yang telah dikurasi khusus untuk Anda</p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-space-md">
            @foreach($featuredSites as $site)
            <div class="rounded-xl bg-surface-container p-space-md hover:bg-surface-container-high transition-all group flex flex-col justify-between gap-space-md border border-secondary/25 hover:border-secondary/60 hover:shadow-[0_4px_24px_rgba(114,9,33,0.4)]">
                <div class="relative w-full h-44 rounded-lg overflow-hidden bg-surface-container-lowest border border-outline-variant/30">
                    @if($site->image_url)
                    <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" src="{{ $site->image_url }}" alt="{{ $site->name }}" />
                    @else
                    <div class="w-full h-full flex items-center justify-center bg-surface-container-high">
                        <span class="material-symbols-outlined text-secondary text-[48px] opacity-50">image</span>
                    </div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-surface-container via-transparent to-transparent"></div>
                    <div class="absolute top-2.5 left-2.5 px-2 py-0.5 rounded bg-surface-container-lowest/85 backdrop-blur-md text-secondary border border-secondary/30 font-label-md text-label-md uppercase font-semibold">
                        {{ $site->era->name }}
                    </div>
                    <div class="absolute bottom-2.5 right-2.5 px-2 py-0.5 rounded bg-surface-container-lowest/85 backdrop-blur-md text-secondary font-label-md text-label-md border border-secondary/30">
                        {{ $site->year_built ?? 'Tahun TBD' }}
                    </div>
                </div>

                <div class="flex flex-col gap-1">
                    <span class="font-label-md text-label-md text-secondary uppercase tracking-widest">{{ $site->era->name }}</span>
                    <h3 class="font-headline-sm text-headline-sm text-on-surface">{{ $site->name }}</h3>
                    <p class="font-body-sm text-body-sm text-on-surface-variant line-clamp-2 mt-1">{{ $site->short_description }}</p>
                </div>

                <a href="{{ route('cagar-budaya.show', $site->slug) }}" class="w-full py-2.5 rounded bg-surface-container-low hover:bg-gradient-to-r hover:from-primary-container hover:to-secondary-container text-on-surface hover:text-secondary border border-secondary/30 font-label-md text-label-md uppercase tracking-wider flex items-center justify-center gap-1.5 transition-all shadow-sm">
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
            <h2 class="font-headline-lg text-headline-lg text-on-surface text-center">Panduan 3 Langkah Mudah</h2>
        </div>

        <div class="max-w-4xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-space-lg">
                <!-- Step 1 -->
                <div class="relative flex flex-col items-center text-center">
                    <div class="w-16 h-16 rounded-full bg-gradient-to-br from-primary-container to-secondary shadow-[0_0_20px_rgba(114,9,33,0.5)] flex items-center justify-center text-on-surface font-headline-lg font-bold mb-space-md border-4 border-surface">
                        1
                    </div>
                    <h3 class="font-title-lg text-title-lg text-on-surface font-semibold mb-2">Pilih Situs</h3>
                    <p class="font-body-sm text-body-sm text-on-surface-variant leading-relaxed">
                        Buka peta dan pilih cagar budaya yang ingin kamu pelajari lebih lanjut.
                    </p>
                    <div class="hidden md:block absolute top-1/4 -right-1/2 w-1/2 h-1 bg-gradient-to-r from-secondary to-transparent"></div>
                </div>

                <!-- Step 2 -->
                <div class="relative flex flex-col items-center text-center">
                    <div class="w-16 h-16 rounded-full bg-gradient-to-br from-primary-container to-secondary shadow-[0_0_20px_rgba(114,9,33,0.5)] flex items-center justify-center text-on-surface font-headline-lg font-bold mb-space-md border-4 border-surface">
                        2
                    </div>
                    <h3 class="font-title-lg text-title-lg text-on-surface font-semibold mb-2">Baca Ceritanya</h3>
                    <p class="font-body-sm text-body-sm text-on-surface-variant leading-relaxed">
                        Pahami sejarahnya lewat penjelasan santai dan menarik buatan AI kami.
                    </p>
                    <div class="hidden md:block absolute top-1/4 -right-1/2 w-1/2 h-1 bg-gradient-to-r from-secondary to-transparent"></div>
                </div>

                <!-- Step 3 -->
                <div class="relative flex flex-col items-center text-center">
                    <div class="w-16 h-16 rounded-full bg-gradient-to-br from-primary-container to-secondary shadow-[0_0_20px_rgba(114,9,33,0.5)] flex items-center justify-center text-on-surface font-headline-lg font-bold mb-space-md border-4 border-surface">
                        3
                    </div>
                    <h3 class="font-title-lg text-title-lg text-on-surface font-semibold mb-2">Mainkan Gamenya</h3>
                    <p class="font-body-sm text-body-sm text-on-surface-variant leading-relaxed">
                        Uji ingatanmu di Match Card Game dan klaim lencana digital kamu!
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="w-full px-margin py-space-xl flex flex-col gap-space-lg items-center justify-center text-center relative overflow-hidden">
        <div class="absolute -top-32 -right-32 w-64 h-64 bg-secondary/25 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col gap-space-md max-w-3xl">
            <h2 class="font-headline-lg text-headline-lg text-on-surface">Siap Untuk Petualangan?</h2>
            <p class="font-body-lg text-body-lg text-on-surface-variant">
                Mulai jelajahi cagar budaya Palembang dan temukan cerita-cerita menakjubkan di balik setiap bangunan bersejarah.
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-space-md mt-space-md">
                <a href="{{ route('cagar-budaya.index') }}" class="px-8 py-4 rounded-lg bg-gradient-to-r from-primary-container via-[#540818] to-secondary-container text-secondary font-label-lg text-label-lg tracking-wider uppercase flex items-center gap-2 shadow-[0_0_20px_rgba(114,9,33,0.6)] hover:shadow-secondary/25 hover:scale-[1.01] transition-all border border-secondary/50 font-semibold">
                    <span class="material-symbols-outlined text-[18px]">map</span>
                    <span>Mulai Eksplorasi</span>
                </a>
                <a href="#" class="px-8 py-4 rounded-lg bg-surface-container-high hover:bg-surface-bright text-on-surface hover:text-secondary border border-secondary/30 font-label-lg text-label-lg tracking-wider uppercase flex items-center gap-2 transition-colors">
                    <span class="material-symbols-outlined text-secondary text-[18px]">info</span>
                    <span>Pelajari Lebih</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
