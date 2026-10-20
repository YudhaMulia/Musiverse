@extends('layouts.app')

@section('title', $cagarBudaya->name . ' - Rediscover Heritage')

@section('content')
<div class="flex flex-col w-full bg-surface">
    <div class="w-full px-margin py-space-md flex flex-col gap-space-md">
        <!-- Breadcrumb -->
        <div class="flex items-center gap-2 text-on-surface-variant text-body-sm font-medium">
            <a href="{{ route('home') }}" class="hover:text-primary transition-colors">Home</a>
            <span class="text-secondary">›</span>
            <a href="{{ route('cagar-budaya.index') }}" class="hover:text-primary transition-colors">Cagar Budaya</a>
            <span class="text-secondary">›</span>
            <span class="text-primary font-bold">{{ $cagarBudaya->name }}</span>
        </div>

        <!-- Hero Image (100% Bebas Tanpa Tertutup Box/Background Apapun) -->
        <div class="w-full rounded-2xl overflow-hidden bg-surface-container border-2 border-secondary/50 relative group shadow-lg flex items-center justify-center" style="min-height: 400px;">
            @if($cagarBudaya->image_url)
            <img class="max-w-full max-h-[600px] object-contain group-hover:scale-105 transition-transform duration-700" src="{{ $cagarBudaya->image_url }}" alt="{{ $cagarBudaya->name }}" />
            @else
            <div class="w-full h-96 flex items-center justify-center bg-surface-container">
                <span class="material-symbols-outlined text-primary text-[96px] opacity-40">image</span>
            </div>
            @endif
        </div>

        <!-- Title & Metadata Bar (Di Bawah Foto, Menjaga Gambar Utama 100% Tidak Terhalang) -->
        <div class="w-full flex flex-col md:flex-row md:items-center justify-between gap-4 p-5 rounded-xl bg-surface-container-lowest border border-secondary/40 shadow-sm">
            <div class="flex flex-col gap-1.5">
                <div class="flex items-center gap-2">
                    <span class="px-3 py-1 rounded-lg bg-surface text-primary border border-secondary/50 font-label-md text-label-md uppercase tracking-wider flex items-center gap-1.5 font-bold">
                        <span class="material-symbols-outlined text-secondary text-[16px]">history_edu</span>
                        {{ $cagarBudaya->era->name }}
                    </span>
                    <span class="px-3 py-1 rounded-lg bg-primary text-[#F9F6F0] font-label-md text-label-md uppercase border border-secondary/40 font-bold text-xs shadow-sm">
                        {{ ucfirst($cagarBudaya->status) }}
                    </span>
                </div>
                <h1 class="font-headline-lg text-headline-lg text-primary font-bold">{{ $cagarBudaya->name }}</h1>
            </div>
            @if($cagarBudaya->ai_reconstruction_url)
            <div class="flex items-center gap-3 shrink-0">
                <div class="w-12 h-12 rounded-full bg-surface-container border-2 border-secondary flex items-center justify-center text-primary shadow-sm" title="AI Rekonstruksi 3D">
                    <span class="material-symbols-outlined text-[24px]">view_in_ar</span>
                </div>
            </div>
            @endif
        </div>

        <!-- Main Content Grid -->
        <div class="w-full grid grid-cols-1 xl:grid-cols-3 gap-space-md">
            <!-- Left Content -->
            <div class="xl:col-span-2 flex flex-col gap-space-md">
                <!-- Factsheet -->
                <div class="w-full bg-surface-container-lowest rounded-xl p-space-md flex flex-col gap-space-sm border border-secondary/35 shadow-sm">
                    <h2 class="font-title-lg text-title-lg text-primary font-bold mb-2">Informasi Resmi</h2>

                    <div class="flex items-center justify-between pb-2 border-b border-secondary/20">
                        <span class="font-label-md text-label-md text-secondary-container uppercase tracking-wider font-semibold">Nama Resmi</span>
                        <span class="font-body-md text-body-md text-primary font-bold text-right">{{ $cagarBudaya->name }}</span>
                    </div>

                    @if($cagarBudaya->registration_number)
                    <div class="flex items-center justify-between pb-2 border-b border-secondary/20">
                        <span class="font-label-md text-label-md text-secondary-container uppercase tracking-wider font-semibold">Nomor Registrasi</span>
                        <span class="font-label-md text-label-md text-primary font-bold tracking-wide">{{ $cagarBudaya->registration_number }}</span>
                    </div>
                    @endif

                    @if($cagarBudaya->architect)
                    <div class="flex items-center justify-between pb-2 border-b border-secondary/20">
                        <span class="font-label-md text-label-md text-secondary-container uppercase tracking-wider font-semibold">Perancang</span>
                        <span class="font-body-md text-body-md text-on-surface font-medium">{{ $cagarBudaya->architect }}</span>
                    </div>
                    @endif

                    @if($cagarBudaya->year_built)
                    <div class="flex items-center justify-between pb-2 border-b border-secondary/20">
                        <span class="font-label-md text-label-md text-secondary-container uppercase tracking-wider font-semibold">Tahun Dibangun</span>
                        <span class="font-body-md text-body-md text-on-surface font-medium">{{ $cagarBudaya->year_built }}</span>
                    </div>
                    @endif

                    <div class="flex items-center justify-between pb-2 border-b border-secondary/20">
                        <span class="font-label-md text-label-md text-secondary-container uppercase tracking-wider font-semibold">Fungsi Asal &amp; Kini</span>
                        <span class="font-body-md text-body-md text-on-surface text-right font-medium">{{ $cagarBudaya->original_function ?? 'N/A' }} → {{ $cagarBudaya->current_function ?? 'N/A' }}</span>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="font-label-md text-label-md text-secondary-container uppercase tracking-wider font-semibold">Aksesibilitas</span>
                        <span class="inline-flex items-center gap-1.5 text-primary font-label-md text-label-md font-bold">
                            <span class="w-2 h-2 rounded-full bg-secondary animate-pulse"></span>
                            Terbuka Publik
                        </span>
                    </div>
                </div>

                <!-- Description -->
                <div class="flex flex-col gap-1.5 bg-surface-container-lowest rounded-xl p-space-md border border-secondary/35 shadow-sm">
                    <span class="font-label-md text-label-md text-secondary-container uppercase tracking-widest font-bold">Deskripsi Naratif</span>
                    <p class="font-body-md text-body-md text-on-surface leading-relaxed">
                        {{ $cagarBudaya->full_description ?? $cagarBudaya->short_description }}
                    </p>
                </div>

                <!-- Location Info -->
                <div class="flex flex-col gap-2 bg-surface-container-lowest rounded-xl p-space-md border border-secondary/35 shadow-sm">
                    <h3 class="font-title-lg text-title-lg text-primary font-bold">Lokasi</h3>
                    <div class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-primary text-[22px] flex-shrink-0">location_on</span>
                        <div class="flex flex-col gap-1">
                            <p class="font-body-md text-body-md text-primary font-bold">{{ $cagarBudaya->location->address }}</p>
                            <p class="font-body-sm text-body-sm text-on-surface-variant">{{ $cagarBudaya->location->district }}, {{ $cagarBudaya->location->postal_code }}</p>
                            <p class="font-label-md text-label-md text-secondary-container mt-1 font-semibold">📍 {{ $cagarBudaya->location->latitude }}, {{ $cagarBudaya->location->longitude }}</p>
                        </div>
                    </div>
                </div>

                {{-- Leaflet Map --}}
                <div class="flex flex-col gap-space-md bg-surface-container-lowest rounded-xl p-space-md border border-secondary/35 shadow-sm">
                    <h3 class="font-title-lg text-title-lg text-primary font-bold">Lokasi Peta</h3>
                    @include('components.leaflet-map', ['cagarBudaya' => $cagarBudaya])
                </div>
            </div>

            <!-- Sidebar -->
            <div class="flex flex-col gap-space-md">
                <!-- AI Reconstruction -->
                @if($cagarBudaya->ai_reconstruction_url)
                <div class="w-full rounded-xl bg-surface-container-lowest p-space-md shadow-md border-2 border-secondary/40 flex flex-col gap-space-md">
                    <div class="flex items-center justify-between">
                        <span class="font-title-md text-title-md text-primary font-bold">Rekonstruksi Visual AI</span>
                        <span class="font-label-md text-label-md text-secondary-container uppercase tracking-wider font-bold">Preview</span>
                    </div>
                    <div class="w-full rounded-lg overflow-hidden bg-surface-container border border-secondary/30">
                        <img class="w-full h-auto" src="{{ $cagarBudaya->ai_reconstruction_url }}" alt="AI Reconstruction" />
                    </div>
                    <p class="font-body-sm text-body-sm text-on-surface-variant">Rekonstruksi visual berbasis AI untuk membantu membayangkan bentuk asli bangunan ini di masa lampau.</p>
                </div>
                @endif

                <!-- Audio Tour -->
                @if($cagarBudaya->audioTours->count() > 0)
                <div class="w-full rounded-xl bg-surface-container-lowest p-space-md shadow-md border-2 border-secondary/40 flex flex-col gap-space-md">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-secondary text-[24px]">headphones</span>
                            <h3 class="font-title-md text-title-md text-primary font-bold">Audio Tour & Pemandu</h3>
                        </div>
                        <span class="text-xs px-2.5 py-0.5 rounded-full bg-secondary/15 text-primary border border-secondary/40 font-semibold">Resmi</span>
                    </div>

                    @foreach($cagarBudaya->audioTours as $audio)
                    <div class="w-full p-4 bg-surface-container rounded-xl flex flex-col gap-3 border border-secondary/30" id="audio-card-{{ $audio->id }}">
                        <audio id="audio-element-{{ $audio->id }}" src="{{ $audio->audio_file_url }}" preload="metadata"></audio>
                        
                        <div class="flex items-center justify-between gap-3">
                            <div class="flex items-center gap-3">
                                <button type="button" 
                                        onclick="toggleAudioTour({{ $audio->id }})" 
                                        id="play-btn-{{ $audio->id }}"
                                        class="w-11 h-11 rounded-full bg-primary text-secondary flex items-center justify-center hover:scale-105 active:scale-95 transition-all shadow-md cursor-pointer flex-shrink-0"
                                        title="Putar Audio Tour">
                                    <span class="material-symbols-outlined text-[26px] font-bold" id="play-icon-{{ $audio->id }}">play_arrow</span>
                                </button>
                                <div class="flex flex-col">
                                    <span class="font-body-sm text-body-sm text-primary font-bold line-clamp-1">{{ $audio->title }}</span>
                                    <div class="flex items-center gap-2 text-xs text-on-surface-variant">
                                        <span>{{ $audio->narrator ?? 'Pemandu Budaya' }}</span>
                                        <span>•</span>
                                        <span id="time-display-{{ $audio->id }}">0:00 / {{ floor($audio->duration_seconds / 60) }}:{{ str_pad($audio->duration_seconds % 60, 2, '0', STR_PAD_LEFT) }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            {{-- Visualizer Wave Bars --}}
                            <div class="flex items-end gap-1 h-6 pr-2 flex-shrink-0" id="wave-bars-{{ $audio->id }}">
                                <span class="w-1 h-3 bg-secondary rounded-full transition-all"></span>
                                <span class="w-1 h-5 bg-primary rounded-full transition-all"></span>
                                <span class="w-1 h-2 bg-secondary rounded-full transition-all"></span>
                                <span class="w-1 h-4 bg-primary rounded-full transition-all"></span>
                            </div>
                        </div>

                        {{-- Progress Bar --}}
                        <div class="w-full bg-surface-container-highest rounded-full h-1.5 overflow-hidden cursor-pointer" onclick="seekAudioTour(event, {{ $audio->id }})">
                            <div id="progress-bar-{{ $audio->id }}" class="bg-secondary h-full rounded-full transition-all duration-100" style="width: 0%;"></div>
                        </div>

                        {{-- Transcript Narration Collapsible --}}
                        @if($audio->narration)
                        <details class="text-xs group border-t border-secondary/20 pt-2 mt-1">
                            <summary class="cursor-pointer text-primary/80 hover:text-primary font-semibold flex items-center justify-between select-none py-1">
                                <span class="flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-[16px] text-secondary">article</span>
                                    <span>Tampilkan Naskah Narasi</span>
                                </span>
                                <span class="material-symbols-outlined text-[18px] transition-transform group-open:rotate-180">expand_more</span>
                            </summary>
                            <p class="mt-2 text-on-surface-variant leading-relaxed bg-surface-container-lowest p-3 rounded-lg border border-secondary/20 italic">
                                "{{ $audio->narration }}"
                            </p>
                        </details>
                        @endif
                    </div>
                    @endforeach
                </div>
                @endif

                <!-- CTA Buttons -->
                <div class="flex flex-col gap-space-sm">
                    <a href="{{ route('home') }}" class="w-full py-3 px-4 rounded-lg bg-surface-container hover:bg-surface-container-high text-primary font-bold border border-secondary/40 font-label-md text-label-md tracking-wider uppercase flex items-center justify-center gap-2 transition-colors">
                        <span class="material-symbols-outlined text-secondary text-[18px]">map</span>
                        <span>Kembali ke Home</span>
                    </a>
                    <button class="w-full py-3 px-4 rounded-lg bg-primary hover:bg-[#5A1414] text-[#F9F6F0] font-label-lg text-label-lg tracking-wider uppercase font-bold flex items-center justify-center gap-2 shadow-md hover:scale-[1.01] transition-all border border-secondary/50">
                        <span class="material-symbols-outlined text-secondary text-[18px]">near_me</span>
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
                    <span class="material-symbols-outlined text-primary text-[24px]">travel_explore</span>
                    <h2 class="font-headline-sm text-headline-sm text-primary font-bold">Cagar Budaya Terkait</h2>
                </div>
                <span class="font-label-md text-label-md text-secondary-container font-bold uppercase tracking-wider">Era: {{ $cagarBudaya->era->name }}</span>
            </div>

            <div class="w-full grid grid-cols-1 md:grid-cols-3 gap-space-md">
                @foreach($relatedSites as $site)
                <a href="{{ route('cagar-budaya.show', $site->slug) }}" class="rounded-xl bg-surface-container-lowest p-space-md hover:bg-surface-container-low transition-all group flex flex-col justify-between gap-space-md border border-secondary/35 hover:border-secondary shadow-sm hover:shadow-md">
                    <div class="relative w-full h-44 rounded-lg overflow-hidden bg-surface-container border border-secondary/30">
                        @if($site->image_url)
                        <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" src="{{ $site->image_url }}" alt="{{ $site->name }}" />
                        @else
                        <div class="w-full h-full flex items-center justify-center bg-surface-container">
                            <span class="material-symbols-outlined text-primary text-[48px] opacity-40">image</span>
                        </div>
                        @endif
                    </div>
                    <div class="flex flex-col gap-1">
                        <h3 class="font-headline-sm text-headline-sm text-primary font-bold group-hover:text-secondary-container transition-colors">{{ $site->name }}</h3>
                        <p class="font-body-sm text-body-sm text-on-surface-variant line-clamp-2">{{ $site->short_description }}</p>
                    </div>
                    <button class="w-full py-2 px-3 rounded bg-surface-container text-primary hover:bg-primary hover:text-[#F9F6F0] border border-secondary/40 font-label-md text-label-md uppercase transition-all flex items-center justify-center gap-1 font-bold">
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

@push('scripts')
<script>
let bgMusicWasPlaying = false;

function toggleAudioTour(id) {
    const audio = document.getElementById('audio-element-' + id);
    const playIcon = document.getElementById('play-icon-' + id);
    const waveBars = document.getElementById('wave-bars-' + id);
    const timeDisplay = document.getElementById('time-display-' + id);
    const progressBar = document.getElementById('progress-bar-' + id);
    const bgMusic = document.getElementById('musikLatar');

    if (!audio) return;

    // Pause all other audio tour elements
    document.querySelectorAll('audio[id^="audio-element-"]').forEach(a => {
        if (a !== audio && !a.paused) {
            a.pause();
            const otherId = a.id.replace('audio-element-', '');
            const otherIcon = document.getElementById('play-icon-' + otherId);
            const otherWave = document.getElementById('wave-bars-' + otherId);
            if (otherIcon) otherIcon.textContent = 'play_arrow';
            if (otherWave) otherWave.querySelectorAll('span').forEach(s => s.classList.remove('animate-pulse'));
        }
    });

    if (audio.paused) {
        // Softly duck or pause background music
        if (bgMusic && !bgMusic.paused) {
            bgMusicWasPlaying = true;
            bgMusic.pause();
        }

        audio.play().then(() => {
            playIcon.textContent = 'pause';
            if (waveBars) {
                waveBars.querySelectorAll('span').forEach(s => s.classList.add('animate-pulse'));
            }
        }).catch(err => {
            console.error('Audio playback failed:', err);
        });
    } else {
        audio.pause();
        playIcon.textContent = 'play_arrow';
        if (waveBars) {
            waveBars.querySelectorAll('span').forEach(s => s.classList.remove('animate-pulse'));
        }

        // Resume bg music if it was playing before
        if (bgMusic && bgMusicWasPlaying) {
            bgMusic.play().catch(() => {});
        }
    }

    audio.ontimeupdate = function() {
        if (audio.duration) {
            const pct = (audio.currentTime / audio.duration) * 100;
            if (progressBar) progressBar.style.width = pct + '%';

            const curMins = Math.floor(audio.currentTime / 60);
            const curSecs = Math.floor(audio.currentTime % 60).toString().padStart(2, '0');
            const durMins = Math.floor(audio.duration / 60);
            const durSecs = Math.floor(audio.duration % 60).toString().padStart(2, '0');
            if (timeDisplay) timeDisplay.textContent = `${curMins}:${curSecs} / ${durMins}:${durSecs}`;
        }
    };

    audio.onended = function() {
        playIcon.textContent = 'play_arrow';
        if (waveBars) {
            waveBars.querySelectorAll('span').forEach(s => s.classList.remove('animate-pulse'));
        }
        if (progressBar) progressBar.style.width = '0%';
        audio.currentTime = 0;

        if (bgMusic && bgMusicWasPlaying) {
            bgMusic.play().catch(() => {});
        }
    };
}

function seekAudioTour(e, id) {
    const audio = document.getElementById('audio-element-' + id);
    if (!audio || !audio.duration) return;
    const rect = e.currentTarget.getBoundingClientRect();
    const clickX = e.clientX - rect.left;
    const width = rect.width;
    audio.currentTime = (clickX / width) * audio.duration;
}
</script>
@endpush
