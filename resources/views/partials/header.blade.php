{{-- Header Navigation --}}
<header class="fixed top-0 left-0 right-0 z-50 bg-surface-container-lowest/95 backdrop-blur-xl border-b border-secondary/30 shadow-[0_2px_15px_rgba(122,28,28,0.08)]">
    <div class="h-20 w-full px-5 md:px-12 flex items-center justify-between">

        {{-- Logo & Branding --}}
        <a href="{{ route('home') }}" class="flex items-center gap-4 group">
            <div class="relative flex items-center justify-center w-10 h-10 rounded-lg bg-surface-container border border-secondary/50 shadow-[0_0_12px_rgba(212,175,55,0.25)]">
                <div class="absolute -inset-0.5 rounded-lg bg-gradient-to-tr from-primary via-secondary to-primary opacity-30 blur-[4px]"></div>
                <span class="material-symbols-outlined relative text-primary text-[24px]">diamond</span>
            </div>
            <div class="flex flex-col">
                <span class="font-serif text-[22px] leading-none font-bold text-primary tracking-tight group-hover:text-secondary-container transition-colors">Rediscover Heritage</span>
                <span class="font-label text-[12px] leading-[16px] tracking-[0.2em] text-secondary-container uppercase font-semibold mt-1">Cagar Budaya Palembang</span>
            </div>
        </a>

        {{-- Desktop Navigation --}}
        <nav class="hidden md:flex items-center gap-6">
            <a href="{{ route('home') }}"
               class="uppercase tracking-wider py-2 px-3.5 font-label text-[14px] leading-[18px] tracking-[0.08em] font-semibold rounded-lg transition-all duration-200
                      {{ request()->routeIs('home') ? '' : 'text-on-surface hover:text-primary hover:bg-surface-container' }}"
               @if(request()->routeIs('home'))
                   style="background: linear-gradient(135deg, #7A1C1C 0%, #5A1414 100%); color: #F9F6F0; border: 1px solid rgba(212, 175, 55, 0.45); box-shadow: 0 2px 10px rgba(122, 28, 28, 0.3);"
               @endif>
                Home
            </a>
            <a href="{{ route('cagar-budaya.index') }}"
               class="font-label text-[14px] leading-[18px] tracking-[0.08em] font-semibold uppercase tracking-wider text-on-surface hover:text-primary transition-colors py-2 px-3 rounded-lg hover:bg-surface-container">
                Cagar Budaya
            </a>
            <a href="#"
               class="font-label text-[14px] leading-[18px] tracking-[0.08em] font-semibold uppercase tracking-wider text-on-surface hover:text-primary transition-colors py-2 px-3 rounded-lg hover:bg-surface-container">
                Games
            </a>
        </nav>

        {{-- Right Side: Badge & Profile --}}
        <div class="flex items-center gap-4">
            {{-- POLSRI Badge --}}
            <div class="hidden sm:flex items-center gap-2 bg-surface-container px-3.5 py-1.5 rounded-full border border-secondary/40 shadow-sm">
                <span class="w-2 h-2 rounded-full bg-secondary animate-pulse shadow-[0_0_8px_#D4AF37]"></span>
                <span class="font-label text-[12px] leading-[16px] tracking-[0.06em] uppercase text-primary font-bold tracking-widest">POLSRI</span>
                <span class="text-secondary font-label text-[12px]">•</span>
                <span class="font-label text-[12px] leading-[16px] tracking-[0.06em] text-on-surface-variant font-medium">HERITAGE LAB</span>
            </div>

            {{-- Profile Button --}}
            <div class="w-9 h-9 rounded-full flex items-center justify-center cursor-pointer hover:scale-105 transition-transform"
                 style="background: linear-gradient(135deg, #E8CC6E 0%, #D4AF37 60%, #B38B2D 100%); color: #4A1010; box-shadow: 0 2px 10px rgba(212, 175, 55, 0.35); border: 1px solid #E8CC6E;">
                <span class="material-symbols-outlined text-[19px] font-bold">person</span>
            </div>

            {{-- Mobile Menu Toggle --}}
            <button class="md:hidden w-9 h-9 rounded-lg flex items-center justify-center bg-surface-container border border-secondary/30 text-on-surface hover:text-primary transition-colors"
                    id="mobile-menu-toggle">
                <span class="material-symbols-outlined text-[22px]">menu</span>
            </button>
        </div>
    </div>

    {{-- Mobile Navigation --}}
    <div class="md:hidden hidden px-5 pb-4 border-t border-outline-variant/20" id="mobile-menu">
        <nav class="flex flex-col gap-2 pt-3">
            <a href="{{ route('home') }}"
               class="uppercase tracking-wider py-2.5 px-4 font-label text-[14px] font-semibold rounded-lg transition-all
                      {{ request()->routeIs('home') ? 'text-secondary bg-primary-container/50' : 'text-on-surface-variant hover:text-secondary hover:bg-surface-container-low' }}">
                Home
            </a>
            <a href="#" class="uppercase tracking-wider py-2.5 px-4 font-label text-[14px] font-semibold rounded-lg text-on-surface-variant hover:text-secondary hover:bg-surface-container-low transition-all">
                Cagar Budaya
            </a>
            <a href="#" class="uppercase tracking-wider py-2.5 px-4 font-label text-[14px] font-semibold rounded-lg text-on-surface-variant hover:text-secondary hover:bg-surface-container-low transition-all">
                Games
            </a>
        </nav>
    </div>
</header>
