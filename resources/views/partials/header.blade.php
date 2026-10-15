{{-- Header Navigation --}}
<header class="fixed top-0 left-0 right-0 z-50 bg-surface-container-lowest/85 backdrop-blur-xl border-b border-outline-variant/30 shadow-[0_4px_25px_rgba(0,0,0,0.6)]">
    <div class="h-20 w-full px-5 md:px-12 flex items-center justify-between">

        {{-- Logo & Branding --}}
        <a href="{{ route('home') }}" class="flex items-center gap-4 group">
            <div class="relative flex items-center justify-center w-10 h-10 rounded-lg bg-surface-container-high border border-secondary/40 shadow-[0_0_15px_rgba(233,195,73,0.25)]">
                <div class="absolute -inset-0.5 rounded-lg bg-gradient-to-tr from-primary-container via-secondary to-primary opacity-40 blur-[4px]"></div>
                <span class="material-symbols-outlined relative text-secondary text-[24px]">diamond</span>
            </div>
            <div class="flex flex-col">
                <span class="font-serif text-[22px] leading-none font-bold text-on-surface tracking-tight group-hover:text-secondary transition-colors">Rediscover Heritage</span>
                <span class="font-label text-[12px] leading-[16px] tracking-[0.2em] text-secondary uppercase font-semibold mt-1">Cagar Budaya Palembang</span>
            </div>
        </a>

        {{-- Desktop Navigation --}}
        <nav class="hidden md:flex items-center gap-6">
            <a href="{{ route('home') }}"
               class="uppercase tracking-wider py-2 px-3.5 font-label text-[14px] leading-[18px] tracking-[0.08em] font-semibold rounded-lg transition-all duration-200
                      {{ request()->routeIs('home') ? '' : 'text-on-surface-variant hover:text-secondary hover:bg-surface-container-low' }}"
               @if(request()->routeIs('home'))
                   style="background: linear-gradient(135deg, #720921 0%, #410005 100%); color: #ffe088; border: 1px solid rgba(233, 195, 73, 0.45); box-shadow: 0 0 15px rgba(114, 9, 33, 0.6);"
               @endif>
                Home
            </a>
            <a href="#"
               class="font-label text-[14px] leading-[18px] tracking-[0.08em] font-semibold uppercase tracking-wider text-on-surface-variant hover:text-secondary transition-colors py-2 px-3 rounded-lg hover:bg-surface-container-low">
                Cagar Budaya
            </a>
            <a href="#"
               class="font-label text-[14px] leading-[18px] tracking-[0.08em] font-semibold uppercase tracking-wider text-on-surface-variant hover:text-secondary transition-colors py-2 px-3 rounded-lg hover:bg-surface-container-low">
                Games
            </a>
        </nav>

        {{-- Right Side: Badge & Profile --}}
        <div class="flex items-center gap-4">
            {{-- POLSRI Badge --}}
            <div class="hidden sm:flex items-center gap-2 bg-surface-container-high/90 px-3.5 py-1.5 rounded-full border border-secondary/35 shadow-[0_0_12px_rgba(233,195,73,0.15)]">
                <span class="w-2 h-2 rounded-full bg-secondary animate-pulse shadow-[0_0_8px_#e9c349]"></span>
                <span class="font-label text-[12px] leading-[16px] tracking-[0.06em] uppercase text-secondary font-semibold tracking-widest">POLSRI</span>
                <span class="text-outline-variant font-label text-[12px]">•</span>
                <span class="font-label text-[12px] leading-[16px] tracking-[0.06em] text-on-surface-variant">HERITAGE LAB</span>
            </div>

            {{-- Profile Button --}}
            <div class="w-9 h-9 rounded-full flex items-center justify-center cursor-pointer hover:scale-105 transition-transform"
                 style="background: linear-gradient(135deg, #ffe088 0%, #e9c349 60%, #af8d11 100%); color: #410005; box-shadow: 0 0 14px rgba(233, 195, 73, 0.45); border: 1px solid #ffe088;">
                <span class="material-symbols-outlined text-[19px] font-bold">person</span>
            </div>

            {{-- Mobile Menu Toggle --}}
            <button class="md:hidden w-9 h-9 rounded-lg flex items-center justify-center bg-surface-container-high border border-outline-variant/30 text-on-surface-variant hover:text-secondary transition-colors"
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
