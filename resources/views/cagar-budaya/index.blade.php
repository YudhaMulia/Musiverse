@extends('layouts.app')

@section('title', 'Peta Cagar Budaya - Rediscover Heritage')

@section('content')
<div class="flex flex-col w-full">
    <div class="w-full px-margin py-space-md flex flex-col gap-space-md">
        <!-- Filter & Search Bar -->
        <div class="w-full bg-surface-container-low/95 backdrop-blur-xl rounded-xl p-space-md shadow-2xl border border-secondary/20 flex flex-col lg:flex-row items-stretch lg:items-center justify-between gap-space-md relative overflow-hidden">
            <div class="absolute -right-16 -top-16 w-56 h-56 bg-primary-container/25 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute left-1/3 -bottom-10 w-44 h-44 bg-secondary/15 rounded-full blur-2xl pointer-events-none"></div>

            <div class="flex flex-col gap-1 min-w-0 relative z-10">
                <div class="flex items-center gap-space-sm flex-wrap">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-secondary/15 text-secondary border border-secondary/30 font-label-md text-label-md uppercase tracking-widest shadow-sm">
                        <span class="w-1.5 h-1.5 rounded-full bg-secondary animate-ping"></span>
                        {{ $cagarBudayas->count() }}+ Titik Terverifikasi
                    </span>
                </div>
                <h1 class="font-headline-md text-headline-md text-on-surface tracking-tight mt-0.5">Peta Digital Cagar Budaya Palembang</h1>
            </div>

            <!-- Era Filters -->
            <div class="flex items-center gap-1 p-1 bg-surface-container-lowest rounded-lg border border-outline-variant/40 overflow-x-auto">
                <button class="px-3 py-1.5 rounded bg-gradient-to-r from-primary-container to-[#540818] text-secondary font-label-md text-label-md tracking-wider uppercase transition-all shadow-md border border-secondary/40 font-semibold whitespace-nowrap" data-filter="all">
                    Semua
                </button>
                @foreach($eras as $era)
                <button class="px-3 py-1.5 rounded hover:bg-surface-container-high text-on-surface-variant hover:text-secondary font-label-md text-label-md tracking-wider uppercase transition-all whitespace-nowrap" data-filter="{{ $era->slug }}">
                    {{ $era->name }}
                </button>
                @endforeach
            </div>
        </div>

        <!-- Heritage Grid -->
        <div class="w-full grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-space-md">
            @forelse($cagarBudayas as $site)
            <a href="{{ route('cagar-budaya.show', $site->slug) }}" class="rounded-xl bg-surface-container p-space-md hover:bg-surface-container-high transition-all group flex flex-col justify-between gap-space-md border border-secondary/25 hover:border-secondary/60 hover:shadow-[0_4px_24px_rgba(114,9,33,0.4)]">
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
                    <div class="absolute bottom-2.5 right-2.5 px-2 py-0.5 rounded bg-surface-container-lowest/85 backdrop-blur-md text-secondary font-label-md text-label-md border border-secondary/30 flex items-center gap-1">
                        <span class="material-symbols-outlined text-[14px]">visibility</span>
                        {{ $site->view_count }}
                    </div>
                </div>

                <div class="flex flex-col gap-1">
                    <span class="font-label-md text-label-md text-secondary uppercase tracking-widest">{{ $site->era->name }}</span>
                    <h3 class="font-headline-sm text-headline-sm text-on-surface group-hover:text-secondary transition-colors">{{ $site->name }}</h3>
                    <p class="font-body-sm text-body-sm text-on-surface-variant line-clamp-2 mt-1">{{ $site->short_description }}</p>
                </div>

                <div class="flex items-center gap-space-xs text-on-surface-variant text-body-sm">
                    <span class="material-symbols-outlined text-[16px] text-secondary">location_on</span>
                    <span>{{ $site->location->district }}</span>
                </div>
            </a>
            @empty
            <div class="col-span-full py-12 text-center">
                <span class="material-symbols-outlined text-secondary text-[48px] opacity-50 inline-block mb-4">search_off</span>
                <p class="font-body-md text-body-md text-on-surface-variant">Tidak ada cagar budaya yang ditemukan</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('[data-filter]').forEach(btn => {
        btn.addEventListener('click', () => {
            const filter = btn.dataset.filter;
            document.querySelectorAll('[data-filter]').forEach(b => {
                b.classList.remove('bg-gradient-to-r', 'from-primary-container', 'to-[#540818]', 'text-secondary', 'border-secondary/40', 'font-semibold', 'shadow-md');
                b.classList.add('text-on-surface-variant', 'hover:bg-surface-container-high');
            });
            btn.classList.add('bg-gradient-to-r', 'from-primary-container', 'to-[#540818]', 'text-secondary', 'border', 'border-secondary/40', 'font-semibold', 'shadow-md');
            btn.classList.remove('text-on-surface-variant', 'hover:bg-surface-container-high');
        });
    });
</script>
@endsection
