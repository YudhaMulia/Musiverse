@extends('layouts.app')

@section('title', $cagarBudaya->name . ' - Rediscover Heritage')

@section('content')
<div class="flex flex-col w-full">
    <div class="w-full px-margin py-space-md flex flex-col gap-space-md">
        <!-- Breadcrumb -->
        <div class="flex items-center gap-2 text-on-surface-variant text-body-sm">
            <a href="{{ route('home') }}" class="hover:text-secondary transition-colors">Home</a>
            <span>›</span>
            <a href="{{ route('cagar-budaya.index') }}" class="hover:text-secondary transition-colors">Cagar Budaya</a>
            <span>›</span>
            <span class="text-secondary">{{ $cagarBudaya->name }}</span>
        </div>

        <!-- Hero Image -->
        <div class="w-full rounded-xl overflow-hidden bg-black border border-outline-variant/30 relative group shadow-2xl flex items-center justify-center" style="min-height: 400px;">
            @if($cagarBudaya->image_url)
            <img class="max-w-full max-h-[600px] object-contain group-hover:scale-105 transition-transform duration-700" src="{{ $cagarBudaya->image_url }}" alt="{{ $cagarBudaya->name }}" />
            @else
            <div class="w-full h-96 flex items-center justify-center bg-surface-container-high">
                <span class="material-symbols-outlined text-secondary text-[96px] opacity-50">image</span>
            </div>
            @endif
            <div class="absolute inset-0 bg-gradient-to-t from-surface-container via-surface-container/40 to-transparent pointer-events-none"></div>

            <!-- Info Badges -->
            <div class="absolute top-4 left-4 flex items-center gap-2">
                <span class="px-3 py-1.5 rounded bg-surface-container-lowest/85 backdrop-blur-md text-secondary border border-secondary/40 font-label-md text-label-md uppercase tracking-wider flex items-center gap-1 shadow-md">
                    <span class="material-symbols-outlined text-[14px]">history_edu</span>
                    {{ $cagarBudaya->era->name }}
                </span>
                <span class="px-3 py-1.5 rounded bg-surface-container-lowest/85 backdrop-blur-md text-primary font-label-md text-label-md uppercase border border-primary/30">
                    {{ ucfirst($cagarBudaya->status) }}
                </span>
            </div>

            <!-- Title Overlay -->
            <div class="absolute bottom-4 left-4 right-4 flex items-end justify-between">
                <div class="flex flex-col">
                    <span class="font-label-md text-label-md text-secondary uppercase tracking-widest font-semibold">{{ $cagarBudaya->era->name }}</span>
                    <h1 class="font-headline-lg text-headline-lg text-on-surface">{{ $cagarBudaya->name }}</h1>
                </div>
                @if($cagarBudaya->ai_reconstruction_url)
                <div class="w-12 h-12 rounded-full bg-surface-container-lowest/90 backdrop-blur-md border border-secondary/40 flex items-center justify-center text-secondary shadow-[0_0_12px_rgba(233,195,73,0.3)]">
                    <span class="material-symbols-outlined text-[20px]">view_in_ar</span>
                </div>
                @endif
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="w-full grid grid-cols-1 xl:grid-cols-3 gap-space-md">
            <!-- Left Content -->
            <div class="xl:col-span-2 flex flex-col gap-space-md">
                <!-- Factsheet -->
                <div class="w-full bg-surface-container-low rounded-lg p-space-md flex flex-col gap-space-sm border border-outline-variant/30">
                    <h2 class="font-title-lg text-title-lg text-on-surface mb-2">Informasi Resmi</h2>

                    <div class="flex items-center justify-between pb-2 border-b border-outline-variant/40">
                        <span class="font-label-md text-label-md text-outline uppercase tracking-wider">Nama Resmi</span>
                        <span class="font-body-md text-body-md text-on-surface font-semibold text-right">{{ $cagarBudaya->name }}</span>
                    </div>

                    @if($cagarBudaya->registration_number)
                    <div class="flex items-center justify-between pb-2 border-b border-outline-variant/40">
                        <span class="font-label-md text-label-md text-outline uppercase tracking-wider">Nomor Registrasi</span>
                        <span class="font-label-md text-label-md text-secondary font-medium tracking-wide">{{ $cagarBudaya->registration_number }}</span>
                    </div>
                    @endif

                    @if($cagarBudaya->architect)
                    <div class="flex items-center justify-between pb-2 border-b border-outline-variant/40">
                        <span class="font-label-md text-label-md text-outline uppercase tracking-wider">Perancang</span>
                        <span class="font-body-md text-body-md text-on-surface">{{ $cagarBudaya->architect }}</span>
                    </div>
                    @endif

                    @if($cagarBudaya->year_built)
                    <div class="flex items-center justify-between pb-2 border-b border-outline-variant/40">
                        <span class="font-label-md text-label-md text-outline uppercase tracking-wider">Tahun Dibangun</span>
                        <span class="font-body-md text-body-md text-on-surface">{{ $cagarBudaya->year_built }}</span>
                    </div>
                    @endif

                    <div class="flex items-center justify-between pb-2 border-b border-outline-variant/40">
                        <span class="font-label-md text-label-md text-outline uppercase tracking-wider">Fungsi Asal & Kini</span>
                        <span class="font-body-md text-body-md text-on-surface text-right">{{ $cagarBudaya->original_function ?? 'N/A' }} → {{ $cagarBudaya->current_function ?? 'N/A' }}</span>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="font-label-md text-label-md text-outline uppercase tracking-wider">Aksesibilitas</span>
                        <span class="inline-flex items-center gap-1.5 text-secondary font-label-md text-label-md">
                            <span class="w-2 h-2 rounded-full bg-secondary animate-pulse"></span>
                            Terbuka Publik
                        </span>
                    </div>
                </div>

                <!-- Description -->
                <div class="flex flex-col gap-1.5 bg-surface-container-low rounded-lg p-space-md border border-outline-variant/30">
                    <span class="font-label-md text-label-md text-secondary uppercase tracking-widest font-semibold">Deskripsi Naratif</span>
                    <p class="font-body-md text-body-md text-on-surface-variant leading-relaxed">
                        {{ $cagarBudaya->full_description ?? $cagarBudaya->short_description }}
                    </p>
                </div>

                <!-- Location Info -->
                <div class="flex flex-col gap-2 bg-surface-container-low rounded-lg p-space-md border border-outline-variant/30">
                    <h3 class="font-title-lg text-title-lg text-on-surface">Lokasi</h3>
                    <div class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-secondary text-[20px] flex-shrink-0">location_on</span>
                        <div class="flex flex-col gap-1">
                            <p class="font-body-md text-body-md text-on-surface">{{ $cagarBudaya->location->address }}</p>
                            <p class="font-body-sm text-body-sm text-on-surface-variant">{{ $cagarBudaya->location->district }}, {{ $cagarBudaya->location->postal_code }}</p>
                            <p class="font-label-md text-label-md text-secondary mt-1">📍 {{ $cagarBudaya->location->latitude }}, {{ $cagarBudaya->location->longitude }}</p>
                        </div>
                    </div>
                </div>

                {{-- Leaflet Map --}}
                <div class="flex flex-col gap-space-md bg-surface-container-low rounded-lg p-space-md border border-outline-variant/30">
                    <h3 class="font-title-lg text-title-lg text-on-surface">Lokasi Peta</h3>
                    @include('components.leaflet-map', ['cagarBudaya' => $cagarBudaya])
                </div>
            </div>

            <!-- Sidebar -->
            <div class="flex flex-col gap-space-md">
                <!-- AI Reconstruction -->
                @if($cagarBudaya->ai_reconstruction_url)
                <div class="w-full rounded-xl bg-surface-container p-space-md shadow-2xl border border-secondary/30 flex flex-col gap-space-md">
                    <div class="flex items-center justify-between">
                        <span class="font-title-md text-title-md text-on-surface">Rekonstruksi Visual AI</span>
                        <span class="font-label-md text-label-md text-secondary/70 uppercase tracking-wider">Preview</span>
                    </div>
                    <div class="w-full rounded-lg overflow-hidden bg-surface-container-lowest border border-outline-variant/30">
                        <img class="w-full h-auto" src="{{ $cagarBudaya->ai_reconstruction_url }}" alt="AI Reconstruction" />
                    </div>
                    <p class="font-body-sm text-body-sm text-on-surface-variant">Rekonstruksi visual berbasis AI untuk membantu membayangkan bentuk asli bangunan ini di masa lampau.</p>
                </div>
                @endif

                <!-- Audio Tour -->
                @if($cagarBudaya->audioTours->count() > 0)
                <div class="w-full rounded-xl bg-surface-container p-space-md shadow-2xl border border-secondary/30 flex flex-col gap-space-md">
                    <h3 class="font-title-md text-title-md text-on-surface">Audio Tour</h3>

                    @foreach($cagarBudaya->audioTours as $audio)
                    <div class="w-full p-space-sm bg-surface-container-lowest rounded-lg flex items-center justify-between gap-space-sm border border-secondary/25">
                        <div class="flex items-center gap-space-sm">
                            <button class="w-10 h-10 rounded-full bg-gradient-to-tr from-primary-container to-secondary text-surface-container-lowest flex items-center justify-center hover:scale-105 transition-transform shadow-[0_0_12px_rgba(233,195,73,0.4)]">
                                <span class="material-symbols-outlined text-[22px] font-bold">play_arrow</span>
                            </button>
                            <div class="flex flex-col">
                                <span class="font-body-sm text-body-sm text-on-surface font-medium">{{ $audio->title }}</span>
                                <span class="font-label-md text-label-md text-secondary/80">{{ floor($audio->duration_seconds / 60) }}:{{ str_pad($audio->duration_seconds % 60, 2, '0', STR_PAD_LEFT) }} min</span>
                            </div>
                        </div>
                        <div class="flex items-end gap-1 h-6 pr-2">
                            <span class="w-1 h-3 bg-secondary animate-pulse"></span>
                            <span class="w-1 h-5 bg-primary-container animate-pulse" style="animation-delay: 0.15s;"></span>
                            <span class="w-1 h-2 bg-secondary animate-pulse" style="animation-delay: 0.3s;"></span>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif

                <!-- CTA Buttons -->
                <div class="flex flex-col gap-space-sm">
                    <a href="{{ route('home') }}" class="w-full py-3 px-4 rounded-lg bg-surface-container-high hover:bg-surface-bright text-on-surface hover:text-secondary border border-secondary/30 font-label-md text-label-md tracking-wider uppercase flex items-center justify-center gap-2 transition-colors">
                        <span class="material-symbols-outlined text-secondary text-[18px]">map</span>
                        <span>Kembali ke Home</span>
                    </a>
                    <button class="w-full py-3 px-4 rounded-lg bg-gradient-to-r from-primary-container via-[#540818] to-secondary-container text-secondary font-label-lg text-label-lg tracking-wider uppercase font-bold flex items-center justify-center gap-2 shadow-[0_0_20px_rgba(114,9,33,0.6)] hover:shadow-secondary/25 hover:scale-[1.01] transition-all border border-secondary/50">
                        <span class="material-symbols-outlined text-[18px]">near_me</span>
                        <span>Rute ke Lokasi</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Related Sites -->
        @if($relatedSites->count() > 0)
        <div class="w-full mt-space-xl flex flex-col gap-space-md">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-space-sm">
                    <span class="material-symbols-outlined text-secondary text-[24px]">travel_explore</span>
                    <h2 class="font-headline-sm text-headline-sm text-on-surface">Cagar Budaya Terkait</h2>
                </div>
                <span class="font-label-md text-label-md text-outline uppercase tracking-wider">Era: {{ $cagarBudaya->era->name }}</span>
            </div>

            <div class="w-full grid grid-cols-1 md:grid-cols-3 gap-space-md">
                @foreach($relatedSites as $site)
                <a href="{{ route('cagar-budaya.show', $site->slug) }}" class="rounded-xl bg-surface-container p-space-md hover:bg-surface-container-high transition-all group flex flex-col justify-between gap-space-md border border-secondary/25 hover:border-secondary/60 hover:shadow-[0_4px_24px_rgba(114,9,33,0.4)]">
                    <div class="relative w-full h-44 rounded-lg overflow-hidden bg-surface-container-lowest border border-outline-variant/30">
                        @if($site->image_url)
                        <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" src="{{ $site->image_url }}" alt="{{ $site->name }}" />
                        @else
                        <div class="w-full h-full flex items-center justify-center bg-surface-container-high">
                            <span class="material-symbols-outlined text-secondary text-[48px] opacity-50">image</span>
                        </div>
                        @endif
                    </div>
                    <div class="flex flex-col gap-1">
                        <h3 class="font-headline-sm text-headline-sm text-on-surface group-hover:text-secondary transition-colors">{{ $site->name }}</h3>
                        <p class="font-body-sm text-body-sm text-on-surface-variant line-clamp-2">{{ $site->short_description }}</p>
                    </div>
                    <button class="w-full py-2 px-3 rounded bg-surface-container-low hover:bg-gradient-to-r hover:from-primary-container hover:to-secondary-container text-on-surface hover:text-secondary border border-secondary/30 font-label-md text-label-md uppercase transition-all flex items-center justify-center gap-1">
                        <span>Lihat</span>
                        <span class="material-symbols-outlined text-[16px] text-secondary">arrow_forward</span>
                    </button>
                </a>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Reviews Section -->
        @include('review.display')
    </div>
</div>
@endsection
