// =========================================================
// MUSIVERSE - JavaScript untuk semua halaman
// =========================================================

document.addEventListener('DOMContentLoaded', () => {

    // 1. Navbar: transparen di atas, berlatar gelap setelah di-scroll
    const navbar = document.querySelector('.navbar');
    const cekScroll = () => navbar?.classList.toggle('is-scrolled', window.scrollY > 40);
    cekScroll();
    window.addEventListener('scroll', cekScroll, { passive: true });

    // 2. Menu navbar untuk layar HP
    const toggle = document.querySelector('[data-toggle-menu]');
    const menu = document.querySelector('[data-menu]');
    toggle?.addEventListener('click', () => {
        menu.classList.toggle('is-open');
        navbar.classList.toggle('menu-open');
    });

    // 2b. Kartu profil: tutup saat klik di luar kartu atau tekan Esc
    const profil = document.querySelector('[data-profil]');
    if (profil) {
        document.addEventListener('click', (e) => {
            if (!profil.contains(e.target)) profil.removeAttribute('open');
        });
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') profil.removeAttribute('open');
        });
    }

    // 3. Animasi fade-up: elemen dengan class "reveal" muncul saat terlihat di layar
    const elemenReveal = document.querySelectorAll('.reveal');
    if ('IntersectionObserver' in window) {
        const pengamat = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    pengamat.unobserve(entry.target);   // cukup sekali animasi
                }
            });
        }, { threshold: 0.15 });

        elemenReveal.forEach((el) => pengamat.observe(el));
    } else {
        elemenReveal.forEach((el) => el.classList.add('is-visible'));
    }
});
