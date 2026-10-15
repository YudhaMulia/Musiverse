<header class="fixed top-0 left-0 right-0 z-50 bg-surface-container-lowest/90 backdrop-blur-xl border-b border-outline-variant/30 shadow-[0_4px_20px_rgba(0,0,0,0.5)]">
    <div class="h-20 w-full px-margin flex items-center justify-between">
        <div class="flex items-center gap-space-md">
            <a href="{{ route('home') }}" class="flex items-center gap-space-md">
                <div class="relative flex items-center justify-center w-10 h-10 rounded-lg bg-surface-container border border-secondary/40 shadow-[0_0_12px_rgba(233,195,73,0.25)]">
                    <div class="absolute -inset-0.5 rounded-lg bg-gradient-to-tr from-primary-container via-secondary to-primary-container opacity-40 blur-[4px]"></div>
                    <span class="material-symbols-outlined relative text-secondary text-[24px]">diamond</span>
                </div>
                <div class="flex flex-col">
                    <span class="font-headline-sm text-headline-sm text-on-surface tracking-tight leading-none">Rediscover Heritage</span>
                    <span class="font-label-md text-label-md text-secondary uppercase tracking-[0.2em] mt-1">Cagar Budaya Palembang</span>
                </div>
            </a>
        </div>

        <nav class="hidden md:flex items-center gap-space-lg">
            <a class="font-label-lg text-label-lg uppercase tracking-wider {{ request()->routeIs('home') ? 'bg-gradient-to-r from-primary-container to-[#540818] text-secondary font-label-lg rounded-lg border border-secondary/50 shadow-[0_0_15px_rgba(114,9,33,0.6)] py-2 px-3' : 'text-on-surface-variant hover:text-secondary transition-colors py-2 px-3 rounded-lg' }}" href="{{ route('home') }}">Home</a>
            <a class="font-label-lg text-label-lg uppercase tracking-wider {{ request()->routeIs('cagar-budaya.*') ? 'bg-gradient-to-r from-primary-container to-[#540818] text-secondary font-label-lg rounded-lg border border-secondary/50 shadow-[0_0_15px_rgba(114,9,33,0.6)] py-2 px-3' : 'text-on-surface-variant hover:text-secondary transition-colors py-2 px-3 rounded-lg' }}" href="{{ route('cagar-budaya.index') }}">Cagar Budaya</a>
            <a class="font-label-lg text-label-lg uppercase tracking-wider text-on-surface-variant hover:text-secondary transition-colors py-2 px-3 rounded-lg" href="#">Games</a>
        </nav>

        <div class="flex items-center gap-space-md">
            <div class="hidden sm:flex items-center gap-space-sm bg-surface-container px-3 py-1.5 rounded-full border border-secondary/30 shadow-md">
                <span class="w-2 h-2 rounded-full bg-secondary animate-pulse shadow-[0_0_8px_#e9c349]"></span>
                <span class="font-label-md text-label-md uppercase text-secondary tracking-widest font-semibold">POLSRI</span>
                <span class="text-outline-variant font-label-md">•</span>
                <span class="font-label-md text-label-md text-on-surface-variant">HERITAGE LAB</span>
            </div>
            <div class="w-8 h-8 rounded-full bg-primary-container border border-secondary/40 flex items-center justify-center text-secondary shadow-md">
                <span class="material-symbols-outlined text-[18px]">person</span>
            </div>
        </div>
    </div>
</header>
