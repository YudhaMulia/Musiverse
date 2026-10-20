// =========================================================
// MUSIVERSE - RUANG TUNGGU
// Data ruangan disimpan di database. Setiap aksi (ganti karakter,
// tambah/keluarkan bot, mulai) dikirim ke server, lalu tampilan
// digambar ulang dari data balasan server.
// =========================================================
(() => {
    const lobby = document.querySelector('[data-lobby]');
    if (!lobby) return;

    const URL_AVATAR = lobby.dataset.avatarUrl;
    const CSRF = document.querySelector('meta[name="csrf-token"]')?.content ?? '';
    const KUNCI_KARAKTER = 'musiverse_karakter';   // dipakai mode solo di halaman permainan

    let state = JSON.parse(lobby.dataset.state);
    let sedangMulai = false;   // true setelah tuan rumah menekan Mulai (hentikan pengecekan otomatis)

    const slotGrid    = lobby.querySelector('[data-slots]');
    const teksJumlah  = lobby.querySelector('[data-jumlah]');
    const aksiHost    = lobby.querySelector('[data-aksi-host]');  // wadah tombol Mulai & Tambah Bot (hanya tampil untuk tuan rumah)
    const tombolMulai = lobby.querySelector('[data-mulai]');
    const tombolBot   = lobby.querySelector('[data-tambah-bot]');
    const teksInfo    = lobby.querySelector('[data-info]');
    const tombolKarakter = lobby.querySelectorAll('[data-karakter]');

    const simpan = (k, v) => { try { localStorage.setItem(k, v); } catch (e) {} };
    const gambar = (no) => `${URL_AVATAR}/${no}.svg`;

    // ---------- Kirim permintaan ke server ----------
    const kirim = async (url, method, body) => {
        const res = await fetch(url, {
            method,
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': CSRF,
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: body ? JSON.stringify(body) : undefined,
        });
        const data = await res.json().catch(() => ({}));
        if (!res.ok) throw new Error(data.message || 'Terjadi kesalahan, coba lagi.');
        return data;
    };

    const jalankan = async (url, method, body) => {
        try {
            state = await kirim(url, method, body);
            render();
            return state;
        } catch (e) {
            alert(e.message);
            return null;
        }
    };

    const label = (p) => (p.kamu ? 'Kamu' : p.bot ? 'Bot' : p.host ? 'Tuan rumah' : 'Pemain');

    // ---------- Gambar ulang kartu pemain ----------
    const render = () => {
        slotGrid.innerHTML = '';

        for (let i = 0; i < state.maks; i++) {
            const p = state.pemain[i];
            const slot = document.createElement('div');

            if (p) {
                slot.className = 'slot slot--isi' + (p.bot ? ' slot--bot' : '');
                slot.innerHTML = `
                    <img class="slot__avatar" src="${gambar(p.avatar)}" alt="">
                    <div class="slot__teks">
                        <p class="slot__nama"></p>
                        <span class="slot__tag">${label(p)}</span>
                    </div>
                    ${!p.kamu && state.tuanRumah ? `<button type="button" class="slot__hapus" data-hapus="${p.id}" aria-label="Keluarkan pemain">&times;</button>` : ''}`;
                slot.querySelector('.slot__nama').textContent = p.nama; // aman dari HTML
            } else {
                slot.className = 'slot slot--kosong';
                slot.innerHTML = `
                    <span class="slot__tanya">?</span>
                    <p class="slot__tunggu">Menunggu pemain<span>.</span><span>.</span><span>.</span></p>`;
            }
            slotGrid.appendChild(slot);
        }

        const jumlah = state.pemain.length;
        teksJumlah.textContent = jumlah;
        if (tombolBot) tombolBot.disabled = jumlah >= state.maks;
        if (tombolMulai) tombolMulai.disabled = jumlah < 2;

        // Tombol Mulai & Tambah Bot muncul untuk siapa pun yang sekarang jadi tuan rumah
        if (aksiHost) aksiHost.hidden = !state.tuanRumah;

        if (state.tuanRumah) {
            teksInfo.textContent = jumlah >= state.maks
                ? 'Ruangan penuh. Siap bermain!'
                : jumlah < 2
                    ? 'Butuh minimal 2 pemain. Ajak teman atau tambahkan bot.'
                    : 'Sudah bisa mulai, atau tunggu teman lain bergabung.';
        } else {
            teksInfo.textContent = 'Menunggu tuan rumah memulai permainan.';
        }

        // Tandai karakterku
        const saya = state.pemain.find((p) => p.kamu);
        if (saya) {
            tombolKarakter.forEach((b) =>
                b.setAttribute('aria-pressed', String(+b.dataset.karakter === saya.avatar)));
            simpan(KUNCI_KARAKTER, saya.avatar);
        }
    };

    // ---------- Pilih karakter ----------
    tombolKarakter.forEach((b) => {
        b.addEventListener('click', () => {
            jalankan(lobby.dataset.urlAvatar, 'PUT', { avatar: +b.dataset.karakter });
        });
    });

    // ---------- Tambah bot ----------
    tombolBot?.addEventListener('click', () => {
        jalankan(lobby.dataset.urlBot, 'POST');
    });

    // ---------- Keluarkan bot (tombol x di kartunya) ----------
        slotGrid.addEventListener('click', (e) => {
        const hapus = e.target.closest('[data-hapus]');
        if (!hapus) return;

        const id       = +hapus.dataset.hapus;
        const cadangan = state;

        // Hilangkan kartunya dulu supaya terasa instan, server menyusul
        state = { ...state, pemain: state.pemain.filter((p) => p.id !== id) };
        render();

        jalankan(lobby.dataset.urlHapus.replace('__ID__', id), 'DELETE').then((hasil) => {
            // Kalau server menolak, kembalikan kartunya
            if (!hasil) { state = cadangan; render(); }
        });
    });

    // ---------- Salin kode ----------
    const tombolSalin = lobby.querySelector('[data-salin]');
    tombolSalin?.addEventListener('click', async () => {
        const kode = lobby.querySelector('[data-kode]').textContent.trim();
        try {
            await navigator.clipboard.writeText(kode);
            tombolSalin.textContent = 'Tersalin!';
        } catch (e) {
            tombolSalin.textContent = 'Gagal';
        }
        setTimeout(() => { tombolSalin.textContent = 'Salin'; }, 1500);
    });

    // ---------- Mulai: server menandai ruangan "playing", lalu pindah ke halaman permainan ----------
    tombolMulai?.addEventListener('click', async () => {
        tombolMulai.disabled = true;
        sedangMulai = true;
        const hasil = await jalankan(lobby.dataset.urlMulai, 'POST');
        if (!hasil) { sedangMulai = false; render(); return; }

        const data = hasil.pemain.map(({ id, nama, avatar, kamu, bot }) => ({ id, nama, avatar, kamu: !!kamu, bot: !!bot }));
        try { sessionStorage.setItem('musiverse_pemain', JSON.stringify(data)); } catch (e) {}
        location.href = hasil.url || lobby.dataset.main;
    });

    // ---------- Ambil data terbaru dari server ----------
    const sinkron = async () => {
        if (sedangMulai) return;

        try {
            const res = await fetch(lobby.dataset.urlSinkron, {
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            });

            // Ruangan ditutup tuan rumah (404) atau kamu sudah tidak terdaftar (403)
            if (res.status === 403 || res.status === 404) {
                location.href = lobby.dataset.urlGames;
                return;
            }
            if (!res.ok) return;

            const baru = await res.json();

            // Tuan rumah sudah menekan Mulai: ikut pindah ke halaman permainan
            if (baru.status === 'playing') {
                sedangMulai = true;
                const data = baru.pemain.map(({ id, nama, avatar, kamu, bot }) => ({ id, nama, avatar, kamu: !!kamu, bot: !!bot }));
                try { sessionStorage.setItem('musiverse_pemain', JSON.stringify(data)); } catch (e) {}
                location.href = baru.url || lobby.dataset.main;
                return;
            }

            // Gambar ulang hanya kalau datanya berubah
            if (JSON.stringify(baru) !== JSON.stringify(state)) {
                state = baru;
                render();
            }
        } catch (e) { /* jaringan putus sebentar, coba lagi nanti */ }
    };

    // ---------- Realtime lewat Pusher: ada sinyal "diperbarui" -> ambil data terbaru ----------
    if (window.Pusher && lobby.dataset.pusherKey) {
        const pusher = new Pusher(lobby.dataset.pusherKey, {
            cluster: lobby.dataset.pusherCluster,
            channelAuthorization: {
                endpoint: '/broadcasting/auth',
                headers: { 'X-CSRF-TOKEN': CSRF },
            },
        });
        const kanal = pusher.subscribe(lobby.dataset.channel);
        kanal.bind('diperbarui', sinkron);

        // Emote (lihat public/js/emote.js)
        window.Emote?.pasang({ kanal, nama: () => state.pemain.find((p) => p.kamu)?.nama });
    }

    // Jaring pengaman: kalau koneksi realtime sempat putus, tetap cek tiap 15 detik
    setInterval(() => { if (!document.hidden) sinkron(); }, 5000);

    render();
})();