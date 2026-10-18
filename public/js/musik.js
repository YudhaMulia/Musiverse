// =========================================================
// MUSIVERSE - MUSIK LATAR (semua halaman)
// Cara kerja: posisi lagu disimpan di localStorage. Saat halaman baru
// dibuka, lagu dilanjutkan dari posisi itu (ditambah waktu yang berlalu
// selama halaman dimuat), jadi lagu tidak mulai dari awal lagi.
// =========================================================

(() => {
    const audio = document.getElementById('musikLatar');
    const tombol = document.getElementById('tombolMusik');
    if (!audio || !tombol) return;
    
    // Halaman permainan memakai musik sendiri (lihat js/suara.js), jadi musik latar dilewati di sini
    if (document.querySelector('[data-match], [data-quiz], [data-puzzle]')) return;

    const KUNCI_STATUS = 'musiverse_musik_status';   // 'on' atau 'off'
    const KUNCI_POSISI = 'musiverse_musik_posisi';   // { t: detik, at: waktu disimpan }
    const VOLUME = 0.5;

    // Pembungkus localStorage yang aman (bisa diblokir di mode tertentu)
    const simpan = (k, v) => { try { localStorage.setItem(k, v); } catch (e) {} };
    const ambil = (k) => { try { return localStorage.getItem(k); } catch (e) { return null; } };

    const statusAwal = ambil(KUNCI_STATUS) || 'on';   // bawaan: musik menyala
    const waktuBuka = Date.now();                       // kapan halaman ini dibuka

    // ---------- Tampilan tombol ----------
    const aturTombol = (menyala) => {
        tombol.classList.toggle('is-playing', menyala);
        tombol.setAttribute('aria-label', menyala ? 'Matikan musik' : 'Nyalakan musik');
    };

    // ---------- Simpan posisi lagu ----------
    const simpanPosisi = () => {
        if (!audio.paused) {
            simpan(KUNCI_POSISI, JSON.stringify({ t: audio.currentTime, at: Date.now() }));
        }
    };
    // saat dimatikan: simpan posisi tanpa waktu, supaya tidak "loncat" ketika dinyalakan lagi
    const simpanPosisiBerhenti = () => {
        simpan(KUNCI_POSISI, JSON.stringify({ t: audio.currentTime, at: null }));
    };

    // ---------- Hitung posisi lanjutan ----------
    const posisiLanjutan = () => {
        try {
            const data = JSON.parse(ambil(KUNCI_POSISI));
            if (!data || !audio.duration) return 0;
            // detik yang berlalu antara halaman lama ditutup dan halaman ini dibuka
            const berlalu = data.at ? Math.max(0, (waktuBuka - data.at) / 1000) : 0;
            if (berlalu > 60 * 30) return 0;                    // lebih dari 30 menit: mulai baru
            return (data.t + berlalu) % audio.duration;
        } catch (e) {
            return 0;
        }
    };

    // ---------- Volume naik perlahan (supaya tidak kaget) ----------
    const naikkanVolume = () => {
        audio.volume = 0;
        const langkah = setInterval(() => {
            audio.volume = Math.min(VOLUME, audio.volume + 0.05);
            if (audio.volume >= VOLUME) clearInterval(langkah);
        }, 60);
    };

    // ---------- Putar ----------
    const putar = () => {
        const mulai = () => {
            audio.currentTime = posisiLanjutan();
            naikkanVolume();
            return audio.play().then(() => aturTombol(true));
        };
        // durasi lagu harus diketahui dulu sebelum lompat ke posisi tertentu
        if (audio.readyState >= 1) return mulai();
        return new Promise((ok, gagal) => {
            audio.addEventListener('loadedmetadata', () => mulai().then(ok, gagal), { once: true });
        });
    };

    // ---------- Tombol nyala/mati ----------
    tombol.addEventListener('click', (e) => {
        e.stopPropagation();
        if (audio.paused) {
            simpan(KUNCI_STATUS, 'on');
            putar().catch(() => aturTombol(false));
        } else {
            audio.pause();
            simpanPosisiBerhenti();
            simpan(KUNCI_STATUS, 'off');
            aturTombol(false);
        }
    });

    // ---------- Saat halaman dibuka ----------
    aturTombol(false);
    if (statusAwal === 'on') {
        putar().catch(() => {
            // Browser menolak memutar otomatis sebelum ada interaksi.
            // Putar begitu pengunjung pertama kali klik/sentuh/tekan tombol.
            const putarSetelahInteraksi = (e) => {
                if (e.target.closest && e.target.closest('#tombolMusik')) return;
                if (ambil(KUNCI_STATUS) !== 'off') putar().catch(() => {});
                ['click', 'touchstart', 'keydown'].forEach((ev) =>
                    document.removeEventListener(ev, putarSetelahInteraksi));
            };
            ['click', 'touchstart', 'keydown'].forEach((ev) =>
                document.addEventListener(ev, putarSetelahInteraksi));
        });
    }

    // Simpan posisi tiap detik dan tepat sebelum pindah halaman
    setInterval(simpanPosisi, 1000);
    window.addEventListener('pagehide', simpanPosisi);
})();