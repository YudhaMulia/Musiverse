// =========================================================
// MUSIVERSE - PEMANTAU RUANGAN SAAT PERMAINAN BERJALAN
// Dipakai oleh match.js, quiz.js, dan puzzle.js (mode main bersama).
//
//   RuangSesi.pantau({...})  -> tahu kalau ada pemain yang keluar, dan kalau
//                               kamu naik jadi tuan rumah baru.
//   RuangSesi.keluar(...)    -> keluar dari ruangan (server memilih tuan rumah baru
//                               kalau yang keluar adalah tuan rumah), lalu pindah halaman.
//   RuangSesi.toast('teks')  -> pemberitahuan kecil di atas layar.
//
// Sumber kebenarannya server: endpoint "sinkron" mengembalikan daftar pemain yang
// masih ada beserta siapa tuan rumahnya. Dicek saat ada sinyal Pusher "diperbarui",
// dan tiap 6 detik sebagai cadangan.
// =========================================================
window.RuangSesi = (() => {
    const CSRF = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

    // ---------- Pemberitahuan kecil ----------
    let wadah = null;
    const toast = (teks) => {
        if (!wadah) {
            const gaya = document.createElement('style');
            gaya.textContent = `
                .rs-toast-wadah { position: fixed; top: 14px; left: 50%; transform: translateX(-50%); z-index: 9999;
                    display: flex; flex-direction: column; align-items: center; gap: 8px;
                    width: min(92vw, 460px); pointer-events: none; }
                .rs-toast { background: #3a0c0c; color: #f5ecd2; border: 2px solid #d4af37; border-radius: 14px;
                    padding: 10px 18px; font: 700 .95rem/1.35 inherit; font-family: inherit; text-align: center;
                    box-shadow: 0 6px 18px rgba(0, 0, 0, .35); animation: rs-masuk .3s ease;
                    transition: opacity .4s ease, transform .4s ease; }
                .rs-toast.is-hilang { opacity: 0; transform: translateY(-8px); }
                @keyframes rs-masuk { from { opacity: 0; transform: translateY(-10px); } }`;
            document.head.appendChild(gaya);

            wadah = document.createElement('div');
            wadah.className = 'rs-toast-wadah';
            wadah.setAttribute('role', 'status');
            wadah.setAttribute('aria-live', 'polite');
            document.body.appendChild(wadah);
        }

        const el = document.createElement('div');
        el.className = 'rs-toast';
        el.textContent = teks;          // aman dari HTML
        wadah.appendChild(el);
        setTimeout(() => {
            el.classList.add('is-hilang');
            setTimeout(() => el.remove(), 450);
        }, 5000);
    };

    // ---------- Pantau pemain ----------
    // opsi:
    //   kode, urlSinkron ("...__KODE__..."), kanal (channel Pusher),
    //   pemain: [{ id, nama, tuanRumah }]  daftar awal (id = id baris room_players)
    //   akuTuanRumah: true kalau kamu tuan rumah saat ini
    //   saatKeluar(id): dipanggil untuk tiap pemain yang keluar
    //   saatJadiTuanRumah(): dipanggil sekali saat kamu naik jadi tuan rumah
    const pantau = (opsi) => {
        const url = opsi.urlSinkron.replace('__KODE__', encodeURIComponent(opsi.kode));
        const masih = new Map(opsi.pemain
            .filter((p) => p.id !== undefined && p.id !== null)
            .map((p) => [p.id, { nama: p.nama, host: !!p.tuanRumah }]));
        let akuHost = !!opsi.akuTuanRumah;
        let sedangAmbil = false;
        let ulangi = false;

        const proses = (s) => {
            const ada = new Set(s.pemain.map((p) => p.id));
            const hostBaru = s.pemain.find((p) => p.host);

            [...masih].forEach(([id, d]) => {
                if (ada.has(id)) return;
                masih.delete(id);

                let pesan = `${d.nama} keluar dari permainan.`;
                if (d.host && hostBaru) {
                    pesan += hostBaru.kamu ? ' Kamu sekarang jadi tuan rumah.' : ` ${hostBaru.nama} sekarang jadi tuan rumah.`;
                }
                toast(pesan);
                opsi.saatKeluar(id);
            });

            s.pemain.forEach((p) => { if (masih.has(p.id)) masih.get(p.id).host = !!p.host; });

            if (s.tuanRumah && !akuHost) {
                akuHost = true;
                opsi.saatJadiTuanRumah();
            }
        };

        const cek = async () => {
            if (sedangAmbil) { ulangi = true; return; }   // ada sinyal baru saat sedang mengambil: ulangi sesudahnya
            sedangAmbil = true;
            try {
                const res = await fetch(url, {
                    headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                });
                if (res.ok) proses(await res.json());
            } catch (e) { /* jaringan putus sebentar, coba lagi nanti */ }
            sedangAmbil = false;
            if (ulangi) { ulangi = false; cek(); }
        };

        opsi.kanal.bind('diperbarui', cek);
        setInterval(() => { if (!document.hidden) cek(); }, 6000);
        document.addEventListener('visibilitychange', () => { if (!document.hidden) cek(); });

        return { cek, proses };
    };

    // ---------- Keluar dari ruangan ----------
    const keluar = async (urlKeluar, kode, urlTujuan) => {
        try {
            await fetch(urlKeluar.replace('__KODE__', encodeURIComponent(kode)), {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': CSRF, 'X-Requested-With': 'XMLHttpRequest' },
                redirect: 'manual',
                keepalive: true,
            });
        } catch (e) { /* tetap pindah halaman */ }
        location.href = urlTujuan;
    };

    return { toast, pantau, keluar };
})();
