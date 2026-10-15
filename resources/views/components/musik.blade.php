{{-- =========================================================
     MUSIK LATAR GENDING SRIWIJAYA (dipakai SEMUA halaman)
     Lagu melanjutkan dari detik terakhir saat pindah halaman.
     JS: public/js/musik.js  |  CSS: public/css/navbar.css
     ========================================================= --}}
<audio id="musikLatar" src="{{ route('musik.latar') }}" preload="auto" loop></audio>

<button type="button" class="tombol-musik" id="tombolMusik" aria-label="Matikan musik" title="Musik Gending Sriwijaya">
    {{-- ikon speaker menyala --}}
    <svg class="tombol-musik__on" viewBox="0 0 24 24" aria-hidden="true">
        <path d="M3 10v4h4l5 4V6L7 10H3z" fill="currentColor"/>
        <path d="M15.5 8.5a5 5 0 0 1 0 7M18 6a8.5 8.5 0 0 1 0 12" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
    </svg>
    {{-- ikon speaker mati --}}
    <svg class="tombol-musik__off" viewBox="0 0 24 24" aria-hidden="true">
        <path d="M3 10v4h4l5 4V6L7 10H3z" fill="currentColor"/>
        <path d="M16 9l5 6M21 9l-5 6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
    </svg>
    {{-- bar equalizer kecil, bergerak saat lagu diputar --}}
    <span class="tombol-musik__bars" aria-hidden="true"><i></i><i></i><i></i></span>
</button>