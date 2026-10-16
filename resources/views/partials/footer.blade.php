{{-- Footer --}}
<footer class="w-full py-10 mt-10 shadow-[0_-2px_15px_rgba(122,28,28,0.15)] bg-gradient-to-b from-primary via-[#6B1818] to-[#5A1414] border-t-2 border-secondary/50 text-[#F9F6F0]">
    <div class="w-full px-5 md:px-12 flex flex-col md:flex-row items-center justify-between gap-6">

        {{-- Branding --}}
        <div class="flex flex-col items-center md:items-start">
            <div class="flex items-center gap-2 mb-2">
                <span class="material-symbols-outlined text-secondary text-[22px]">account_balance</span>
                <span class="font-serif text-[22px] leading-[30px] font-bold text-[#F9F6F0] tracking-tight">Rediscover Heritage</span>
            </div>
            <p class="font-body text-[13px] leading-[20px] text-[#F9F6F0]/80 text-center md:text-left">
                Pusat Dokumentasi Digital &amp; Pelestarian Cagar Budaya Palembang • Politeknik Negeri Sriwijaya
            </p>
        </div>

        {{-- Badges --}}
        <div class="flex flex-wrap items-center justify-center gap-6">
            <div class="flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#5A1414] border border-secondary/40">
                <span class="material-symbols-outlined text-secondary text-[16px]">verified</span>
                <span class="font-label text-[12px] leading-[16px] tracking-[0.06em] uppercase text-secondary tracking-wider font-bold">Cagar Budaya Resmi</span>
            </div>
            <div class="flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#5A1414] border border-secondary/30">
                <span class="material-symbols-outlined text-secondary text-[16px]">school</span>
                <span class="font-label text-[12px] leading-[16px] tracking-[0.06em] uppercase text-[#F9F6F0]/90 tracking-wider font-semibold">Riset Vokasi POLSRI</span>
            </div>
        </div>

        {{-- Copyright --}}
        <div class="font-label text-[12px] leading-[16px] tracking-[0.06em] text-[#F9F6F0]/70 tracking-widest uppercase">
            © {{ date('Y') }} POLSRI • All Rights Reserved
        </div>
    </div>
</footer>
