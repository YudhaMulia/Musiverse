{{-- Footer --}}
<footer class="w-full py-10 mt-10 shadow-[0_-4px_25px_rgba(0,0,0,0.5)] bg-footer-gradient border-t border-secondary/[0.28]">
    <div class="w-full px-5 md:px-12 flex flex-col md:flex-row items-center justify-between gap-6">

        {{-- Branding --}}
        <div class="flex flex-col items-center md:items-start">
            <div class="flex items-center gap-2 mb-2">
                <span class="material-symbols-outlined text-secondary text-[20px]">account_balance</span>
                <span class="font-serif text-[22px] leading-[30px] font-bold text-on-surface">Rediscover Heritage</span>
            </div>
            <p class="font-body text-[13px] leading-[20px] text-on-surface-variant text-center md:text-left">
                Pusat Dokumentasi Digital &amp; Pelestarian Cagar Budaya Palembang • Politeknik Negeri Sriwijaya
            </p>
        </div>

        {{-- Badges --}}
        <div class="flex flex-wrap items-center justify-center gap-6">
            <div class="flex items-center gap-1">
                <span class="material-symbols-outlined text-secondary text-[16px]">verified</span>
                <span class="font-label text-[12px] leading-[16px] tracking-[0.06em] uppercase text-secondary tracking-wider font-semibold">Cagar Budaya Resmi</span>
            </div>
            <div class="flex items-center gap-1">
                <span class="material-symbols-outlined text-primary text-[16px]">school</span>
                <span class="font-label text-[12px] leading-[16px] tracking-[0.06em] uppercase text-on-surface-variant tracking-wider">Riset Vokasi POLSRI</span>
            </div>
        </div>

        {{-- Copyright --}}
        <div class="font-label text-[12px] leading-[16px] tracking-[0.06em] text-outline tracking-widest uppercase">
            © {{ date('Y') }} POLSRI • All Rights Reserved
        </div>
    </div>
</footer>
