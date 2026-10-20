// =========================================================
// GALERI BUDAYA - JavaScript halaman Galeri Budaya
// =========================================================

document.addEventListener('DOMContentLoaded', () => {
    const wadah = document.querySelector('[data-galeri-hero]');
    if (!wadah) return;

    const slide  = wadah.querySelectorAll('[data-slide]');   // panel besar
    const tombol = wadah.querySelectorAll('[data-pilih]');   // kartu kecil

    // Tampilkan budaya urutan ke-i, sembunyikan yang lain
    function tampilkan(i) {
        slide.forEach((s, n) => {
            s.classList.toggle('is-aktif', n === i);
            s.setAttribute('aria-hidden', n === i ? 'false' : 'true');
        });
        tombol.forEach((t, n) => {
            t.classList.toggle('is-aktif', n === i);
            t.setAttribute('aria-pressed', n === i ? 'true' : 'false');
        });
    }

    tombol.forEach((t, n) => t.addEventListener('click', () => tampilkan(n)));
});


// ---------------------------------------------------------
// KATEGORI: karusel kartu miring
// ---------------------------------------------------------
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-karusel]').forEach((wadah) => {
        const panggung = wadah.querySelector('[data-panggung]');
        const kartu    = Array.from(wadah.querySelectorAll('[data-kartu]'));
        const hitung   = wadah.querySelector('[data-hitung]');
        const cerita   = Array.from(wadah.querySelectorAll('[data-cerita]'));
        const n        = kartu.length;
        if (n === 0) return;

        const separuh = Math.floor(n / 2);
        let aktif = 0;

        // Hitung posisi tiap kartu: 0 = tengah, negatif = kiri, positif = kanan
        function tata() {
            kartu.forEach((k, i) => {
                let p = (i - aktif + n) % n;
                if (p > separuh) p -= n;
                k.dataset.pos = p;
            });
            if (hitung) hitung.textContent = (aktif + 1) + ' / ' + n;
            cerita.forEach((c, i) => c.classList.toggle('is-aktif', i === aktif));
        }

        const geser = (arah) => { aktif = (aktif + arah + n) % n; tata(); };

        wadah.querySelector('[data-prev]')?.addEventListener('click', () => geser(-1));
        wadah.querySelector('[data-next]')?.addEventListener('click', () => geser(1));

        // Klik kartu samping: jadikan kartu tengah
        kartu.forEach((k, i) => k.addEventListener('click', () => {
            if (i !== aktif) { aktif = i; tata(); }
        }));

        // Tombol panah keyboard saat panggung difokus
        panggung?.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowLeft')  geser(-1);
            if (e.key === 'ArrowRight') geser(1);
        });

        // Geser jari di layar sentuh
        let awalX = null;
        panggung?.addEventListener('touchstart', (e) => { awalX = e.touches[0].clientX; }, { passive: true });
        panggung?.addEventListener('touchend', (e) => {
            if (awalX === null) return;
            const selisih = e.changedTouches[0].clientX - awalX;
            if (Math.abs(selisih) > 40) geser(selisih < 0 ? 1 : -1);
            awalX = null;
        });

        tata();
    });
});

// ---------------------------------------------------------
// HERO: beri tanda saat hero sedang terlihat di layar
// (CSS memakai tanda ini untuk menjeda animasi di luar layar)
// ---------------------------------------------------------
document.addEventListener('DOMContentLoaded', () => {
    const hero = document.querySelector('[data-galeri-hero]');
    if (!hero || !('IntersectionObserver' in window)) return;

    new IntersectionObserver(([entry]) => {
        hero.classList.toggle('is-di-layar', entry.isIntersecting);
    }).observe(hero);
});