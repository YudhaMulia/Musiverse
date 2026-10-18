// =========================================================
// MUSIVERSE - JavaScript halaman Games (versi mentahan)
// =========================================================

document.addEventListener('DOMContentLoaded', () => {

    // 1. Buka modal: tombol dengan atribut data-open="id-modal"
    document.querySelectorAll('[data-open]').forEach((tombol) => {
        tombol.addEventListener('click', () => {
            const modal = document.getElementById(tombol.dataset.open);
            if (!modal) return;

            // isi nama game di judul modal "Buat Ruangan ..."
            const namaGame = modal.querySelector('[data-game-name]');
            if (namaGame && tombol.dataset.game) namaGame.textContent = tombol.dataset.game;

            // modal ajak masuk: titipkan tujuan semula ke link Masuk & Daftar
            if (tombol.dataset.kembali) {
                modal.querySelectorAll('[data-link-auth]').forEach((a) => {
                    const url = new URL(a.getAttribute('href'), window.location.origin);
                    url.searchParams.set('kembali', tombol.dataset.kembali);
                    a.href = url.toString();
                });
            }

            modal.showModal();
        });
    });

    // 2. Tutup modal: tombol x, atau klik area gelap di luar kotak
    document.querySelectorAll('dialog.modal').forEach((modal) => {
        modal.querySelector('[data-close]')?.addEventListener('click', () => modal.close());
        modal.addEventListener('click', (e) => { if (e.target === modal) modal.close(); });
    });

    // 3. Input kode ruangan: otomatis huruf besar, hanya huruf & angka
    const inputKode = document.getElementById('kode-ruangan');
    inputKode?.addEventListener('input', () => {
        inputKode.value = inputKode.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
    });

    // 4. Tombol Single Player (sementara hanya pemberitahuan)
    document.querySelectorAll('[data-solo]').forEach((tombol) => {
        tombol.addEventListener('click', () => {
            alert(`Mode Single Player ${tombol.dataset.solo} akan dibuat di tahap berikutnya.`);
        });
    });

    // 5. Efek miring 3D mengikuti kursor (hanya di perangkat dengan mouse)
    const bisaHover = window.matchMedia('(hover: hover)').matches;
    const kurangiGerak = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    if (bisaHover && !kurangiGerak) {
        document.querySelectorAll('[data-tilt]').forEach((card) => {
            const MAKS = 4; // derajat kemiringan maksimal

            card.addEventListener('mousemove', (e) => {
                const r = card.getBoundingClientRect();
                const x = (e.clientX - r.left) / r.width - 0.5;   // -0.5 s/d 0.5
                const y = (e.clientY - r.top) / r.height - 0.5;
                card.classList.add('is-tilting');
                card.style.transform =
                    `perspective(1200px) rotateX(${(-y * MAKS).toFixed(2)}deg) rotateY(${(x * MAKS).toFixed(2)}deg)`;
            });

            card.addEventListener('mouseleave', () => {
                card.classList.remove('is-tilting');
                card.style.transform = '';   // kembali lurus perlahan
            });
        });
    }

    // 6. Paralaks hero: gambar penari bergeser sedikit mengikuti kursor
    const hero = document.querySelector('[data-parallax]');
    const gambarHero = hero?.querySelector('.hero__art');

    if (hero && gambarHero && bisaHover && !kurangiGerak) {
        hero.addEventListener('mousemove', (e) => {
            const r = hero.getBoundingClientRect();
            const x = (e.clientX - r.left) / r.width - 0.5;
            const y = (e.clientY - r.top) / r.height - 0.5;
            gambarHero.style.translate = `${(-x * 18).toFixed(1)}px ${(-y * 12).toFixed(1)}px`;
        });
        hero.addEventListener('mouseleave', () => { gambarHero.style.translate = ''; });
    }
});
