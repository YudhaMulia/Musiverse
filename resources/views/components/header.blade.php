<header class="fixed top-0 left-0 right-0 z-50 bg-surface-container-lowest/95 backdrop-blur-xl border-b border-secondary/30 shadow-[0_2px_15px_rgba(122,28,28,0.08)]">
    <div class="h-20 w-full px-margin flex items-center justify-between">
        <div class="flex items-center gap-space-md">
            <a href="{{ route('home') }}" class="flex items-center gap-space-md">
                <div class="relative flex items-center justify-center w-10 h-10 rounded-lg bg-surface-container border border-secondary/50 shadow-[0_0_12px_rgba(212,175,55,0.25)]">
                    <div class="absolute -inset-0.5 rounded-lg bg-gradient-to-tr from-primary via-secondary to-primary opacity-30 blur-[4px]"></div>
                    <span class="material-symbols-outlined relative text-primary text-[24px]">diamond</span>
                </div>
                <div class="flex flex-col">
                    <span class="font-headline-sm text-headline-sm text-primary font-bold tracking-tight leading-none">Rediscover Heritage</span>
                    <span class="font-label-md text-label-md text-secondary-container uppercase tracking-[0.2em] font-semibold mt-1">Cagar Budaya Palembang</span>
                </div>
            </a>
        </div>

        <nav class="hidden md:flex items-center gap-space-lg">
            <a class="font-label-lg text-label-lg uppercase tracking-wider {{ request()->routeIs('home') ? 'bg-gradient-to-r from-primary to-[#5A1414] text-on-primary font-label-lg rounded-lg border border-secondary/50 shadow-[0_2px_10px_rgba(122,28,28,0.3)] py-2 px-3' : 'text-on-surface hover:text-primary hover:bg-surface-container transition-colors py-2 px-3 rounded-lg' }}" href="{{ route('home') }}">Home</a>
            <a class="font-label-lg text-label-lg uppercase tracking-wider {{ request()->routeIs('cagar-budaya.*') ? 'bg-gradient-to-r from-primary to-[#5A1414] text-on-primary font-label-lg rounded-lg border border-secondary/50 shadow-[0_2px_10px_rgba(122,28,28,0.3)] py-2 px-3' : 'text-on-surface hover:text-primary hover:bg-surface-container transition-colors py-2 px-3 rounded-lg' }}" href="{{ route('cagar-budaya.index') }}">Cagar Budaya</a>
            <a class="font-label-lg text-label-lg uppercase tracking-wider text-on-surface hover:text-primary hover:bg-surface-container transition-colors py-2 px-3 rounded-lg" href="#">Games</a>
        </nav>

        <div class="flex items-center gap-space-md">
            <div class="hidden sm:flex items-center gap-space-sm bg-surface-container px-3 py-1.5 rounded-full border border-secondary/40 shadow-sm">
                <span class="w-2 h-2 rounded-full bg-secondary animate-pulse shadow-[0_0_8px_#D4AF37]"></span>
                <span class="font-label-md text-label-md uppercase text-primary tracking-widest font-bold">POLSRI</span>
                <span class="text-secondary font-label-md">•</span>
                <span class="font-label-md text-label-md text-on-surface-variant font-medium">HERITAGE LAB</span>
            </div>
            <div class="w-8 h-8 rounded-full bg-primary border border-secondary/50 flex items-center justify-center text-on-primary shadow-sm">
                <span class="material-symbols-outlined text-[18px]">person</span>
            </div>
        </div>
    </div>
</header>
