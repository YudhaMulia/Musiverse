// =========================================================
// MUSIVERSE PUZZLE - logika permainan
// Aturan:
//   1. Gambar tampil, pemain punya 5 detik untuk mengamati (tombol merah terkunci).
//   2. Setelah 5 detik, tombol merah terbuka. Siapa tercepat menekan, dialah yang menjawab.
//   3. Pemain itu mengetik jawaban. Benar = dapat poin. Salah = kesempatan hangus.
//   4. Setelah ada yang salah, hitung mundur 3 detik, lalu rebutan dibuka lagi
//      untuk pemain yang kesempatannya belum hangus.
//   5. Semua hangus / tidak ada yang menekan = jawaban ditampilkan, lanjut soal berikutnya.
//
// Ada 3 mode (sama seperti Match):
//   solo : kamu lawan bot. Semua dijalankan di browsermu sendiri.
//   host : tuan rumah. Browsernya menjalankan SEMUA aturan (siapa tercepat,
//          waktu, poin, bot), lalu mengirim "keadaan" permainan lewat Pusher.
//   tamu : pemain lain. Hanya menampilkan keadaan dari tuan rumah, dan
//          mengirim "aku menekan tombol" serta jawaban ketikannya.
// =========================================================
(() => {
    const arena = document.querySelector('[data-puzzle]');
    if (!arena) return;

    // ---------- Pengaturan (ubah angka di sini kalau ingin menyetel permainan) ----------
    const WAKTU_AMATI = 5;        // detik mengamati gambar (tombol merah terkunci)
    const WAKTU_REBUT = 12;       // detik maksimal menunggu ada yang menekan tombol merah
    const WAKTU_KETIK = 15;       // detik untuk mengetik jawaban setelah menekan tombol
    const JEDA_REBUT = 3;         // detik hitung mundur sebelum rebutan dibuka lagi
    const JEDA_UNGKAP = 3500;     // milidetik jawaban benar ditampilkan
    const POIN_BENAR = 100;       // poin untuk jawaban benar
    const POIN_BONUS = 50;        // bonus maksimal kalau menekan tombol secepat kilat
    const WARNA = ['#e9c349', '#e0566a', '#5fb3a1', '#8fa8e8'];
    const TUNGGU_TAMU = 12000;    // ms: tuan rumah menunggu tamu siap, lalu mulai

    const SOAL = JSON.parse(document.getElementById('data-soal').textContent);
    if (!SOAL.length) return;
    // ---------- Pramuat gambar ----------
    // Semua gambar diunduh di awal dan disimpan di cache, jadi tidak dibatalkan browser.
    const cacheGambar = new Map();
    const muatGambar = (url) => {
        if (!url) return Promise.resolve();
        if (!cacheGambar.has(url)) {
            const img = new Image();
            img.src = url;
            const siap = img.decode
                ? img.decode().catch(() => {})
                : new Promise((r) => { img.onload = img.onerror = r; });
            cacheGambar.set(url, { img, siap });
        }
        return cacheGambar.get(url).siap;
    };
    // Gambar soal 1 diunduh duluan, baru sisanya, supaya soal pertama tidak antre
    muatGambar(SOAL[0].gambar).then(() => SOAL.slice(1).forEach((s) => muatGambar(s.gambar)));

    // Timer berhenti selama gambar soal ini belum siap (maksimal 15 detik)
    let menungguGambar = false;
    const tungguGambar = (url) => {
        menungguGambar = true;
        tampilStatus('Memuat gambar...');
        Promise.race([muatGambar(url), new Promise((r) => setTimeout(r, 15000))]).then(() => {
            menungguGambar = false;
            tampilStatus('Perhatikan gambarnya baik-baik!');
        });
    };
    const URL_AVATAR = arena.dataset.avatarUrl;
    const CSRF = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

    const cari = (s) => arena.querySelector(s);
    const elStatus = cari('[data-status]');
    const elNomor = cari('[data-nomor]');
    const elTotal = cari('[data-total]');
    const elSkorBar = cari('[data-skor-bar]');
    const elWaktu = cari('[data-waktu-wadah]');
    const elFase = cari('[data-fase]');
    const elBar = cari('[data-bar]');
    const elDetik = cari('[data-detik]');
    const elGambar = cari('[data-gambar]');
    const elHitung = cari('[data-hitung]');
    const elUngkap = cari('[data-ungkap]');
    const elUngkapJudul = cari('[data-ungkap-judul]');
    const elUngkapJawab = cari('[data-ungkap-jawab]');
    const elForm = cari('[data-form]');
    const elInput = cari('[data-input]');
    const elTombol = cari('[data-tombol]');
    const elTombolTeks = cari('[data-tombol-teks]');
    const dialogKeluar = document.getElementById('dialog-keluar');

    const ambil = (k, tempat = localStorage) => { try { return tempat.getItem(k); } catch (e) { return null; } };
    const acakSatu = (arr) => arr.length ? arr[Math.floor(Math.random() * arr.length)] : undefined;

    // Samakan teks sebelum dibandingkan: huruf kecil, tanpa spasi, tanda baca, atau aksen
    const samakan = (t) => String(t).toLowerCase().normalize('NFD')
        .replace(/[\u0300-\u036f]/g, '').replace(/[^a-z0-9]/g, '');

    // ---------- 1. Pemain dan mode ----------
    // Daftar pemain dari ruang tunggu (sessionStorage), urutannya sama di semua browser.
    // Nomor 0 selalu tuan rumah. Mode solo (?solo) atau tanpa data = kamu vs 1 bot.
    const params = new URLSearchParams(location.search);
    const KODE_RUANG = (params.get('ruang') || '').toUpperCase();
    const RONDE = params.get('ronde') || '';   // penanda permainan, dipakai tombol "Main Lagi" di halaman rekap
    const adaManusiaLain = (d) => d.some((p) => !p.kamu && !p.bot);

    let daftar = null;
    if (!params.has('solo')) {
        try { daftar = JSON.parse(ambil('musiverse_pemain', sessionStorage)); } catch (e) { daftar = null; }
    }
    // Tanpa kode ruangan, data pemain dari ruangan lama tidak dipakai
    if (!KODE_RUANG && Array.isArray(daftar) && adaManusiaLain(daftar)) daftar = null;
    if (!Array.isArray(daftar) || daftar.length < 2 || !daftar.some((p) => p.kamu)) {
        const avatarku = parseInt(ambil('musiverse_karakter'), 10) || 1;
        daftar = [
            { nama: arena.dataset.nama, avatar: avatarku, kamu: true },
            { nama: 'Bot Ampera', avatar: avatarku === 3 ? 4 : 3, bot: true },
        ];
    }

    let mode = 'solo';
    if (KODE_RUANG && window.Pusher && arena.dataset.pusherKey && adaManusiaLain(daftar)) {
        mode = daftar[0].kamu ? 'host' : 'tamu';
    }

    const pemain = daftar.slice(0, 4).map((p, i) => ({
        nomor: i,
        id: p.id,          // id baris room_players (dipakai RuangSesi untuk mengenali siapa yang keluar)
        keluar: false,     // true kalau pemain ini sudah keluar dari ruangan
        nama: String(p.nama || `Pemain ${i + 1}`),
        avatar: p.avatar,
        kamu: !!p.kamu,
        bot: !!p.bot || (mode === 'solo' && !p.kamu),   // mode solo: pemain lain dijalankan bot
        warna: WARNA[i],
        skor: 0,
        benar: 0,
        bonus: 0,                                // total poin dari bonus kecepatan
        akurasi: 0.45 + Math.random() * 0.3,     // khusus bot: peluang menjawab benar (45% - 75%)
        refleks: 0,                              // khusus bot: detik sampai menekan tombol merah
        rencanaKetik: 0,                         // khusus bot: lama mengetik (milidetik)
        rencanaBenar: false,                     // khusus bot: jawabannya benar atau salah
        cepat: 0,                                // seberapa cepat menekan tombol (0 - 1)
    }));
    const kamu = pemain.find((p) => p.kamu);
    const saya = kamu.nomor;                     // nomorku

    // Papan skor
    pemain.forEach((p) => {
        const el = document.createElement('div');
        el.className = 'pz-pemain' + (p.kamu ? ' pz-pemain--kamu' : '');
        el.style.setProperty('--warna', p.warna);
        el.innerHTML = `
            <img src="${URL_AVATAR}/${p.avatar}.svg" alt="">
            <div>
                <p class="pz-pemain__nama"></p>
                <span class="pz-pemain__poin"><b data-poin>0</b> poin</span>
            </div>`;
        el.querySelector('.pz-pemain__nama').textContent = p.kamu ? `${p.nama} (Kamu)` : p.nama;
        elSkorBar.appendChild(el);
        p.el = el;
        p.elPoin = el.querySelector('[data-poin]');
    });

    // ---------- 2. Keadaan permainan ----------
    let nomor = 0;               // soal ke berapa (mulai dari 0)
    let fase = 'amati';          // amati | rebut | jawab | jeda | ungkap
    let ms = 0;                  // waktu berjalan di fase sekarang (milidetik)
    let totalFase = WAKTU_AMATI; // lama fase sekarang (detik), untuk bar waktu
    let layak = [];              // pemain yang kesempatannya belum hangus di soal ini
    let pemegang = null;         // pemain yang sedang menjawab (menekan tombol duluan)
    let percobaan = [];          // catatan tebakan di soal ini
    let jeda = false;            // popup keluar sedang terbuka (hanya mode solo)
    let selesai = false;
    let mulai = false;           // false = belum mulai (menunggu semua pemain siap)
    let totalSoal = SOAL.length;
    const rekam = [];            // rekam[soal] = { jawaban, pemenang, poin, percobaan }, untuk halaman rekap
    const soalTamu = [];         // khusus tamu: soal yang sudah diungkap (untuk halaman rekap)

    elTotal.textContent = totalSoal;

    // ---------- 3. Tampilan ----------
    const tampilStatus = (teks, giliranKamu = false) => {
        elStatus.textContent = teks;
        elStatus.classList.toggle('is-kamu', giliranKamu);
    };

    const tampilWaktu = () => {
        const sisa = Math.max(0, totalFase - ms / 1000);
        elBar.style.transform = `scaleX(${totalFase ? sisa / totalFase : 0})`;
        elDetik.textContent = Math.ceil(sisa);
        elWaktu.classList.toggle('is-mepet', sisa <= 3 && fase !== 'ungkap');

        // Angka besar di atas gambar hanya saat 5 detik pengamatan
        elHitung.hidden = fase !== 'amati';
        if (fase === 'amati') elHitung.textContent = Math.max(1, Math.ceil(sisa));
    };

    const aturFase = (label, detik) => {
        elFase.textContent = label;
        totalFase = detik;
        tampilWaktu();
    };

    // mode: 'kunci' (tidak bisa ditekan) atau 'siap' (menyala, bisa ditekan)
    const aturTombol = (keadaan, teks) => {
        elTombol.disabled = keadaan !== 'siap';
        elTombol.classList.toggle('is-siap', keadaan === 'siap');
        elTombolTeks.textContent = teks;
    };

    const tampilPoinBaru = (p, tambah) => {
        const el = document.createElement('span');
        el.className = 'pz-pemain__tambah';
        el.textContent = `+${tambah}`;
        p.el.appendChild(el);
        setTimeout(() => el.remove(), 1700);
    };

    const siapNama = (p) => (p.kamu ? 'Kamu' : p.nama);

    // Tampilan fase "ungkap": jawaban benar + siapa pemenangnya (dipakai solo, tuan rumah, dan tamu)
    const tampilUngkap = (pemenang, jawaban) => {
        elForm.hidden = true;
        elUngkapJudul.textContent = pemenang
            ? `${siapNama(pemenang)} menjawab benar!`
            : 'Tidak ada yang berhasil menebak';
        elUngkapJawab.textContent = jawaban;
        elUngkap.hidden = false;

        aturFase('Soal berikutnya', JEDA_UNGKAP / 1000);
        aturTombol('kunci', '—');
        if (pemenang && pemenang.kamu) tampilStatus('Benar! Mantap!');
        else if (pemenang) tampilStatus(`${pemenang.nama} lebih cepat dan tepat.`);
        else tampilStatus('Waktu habis atau semua hangus.');
    };

    // ---------- 4. Pusher: tuan rumah mengirim keadaan, tamu menerima ----------
    let kanal = null;            // channel Pusher ruangan ini
    let kanalSiap = false;       // true setelah berhasil masuk channel
    let versi = 0;               // nomor urut keadaan (tuan rumah menaikkan, tamu membuang yang lama)
    let terakhirKirim = 0;

    // ---------- Simpanan: refresh halaman tidak mengulang dari soal 1 ----------
    const KUNCI_SIMPAN = `musiverse_puzzle_${KODE_RUANG}_${RONDE}`;
    let dipulihkan = false;    // true kalau permainan dilanjutkan dari simpanan
    let akhiriPulih = false;   // true kalau ternyata permainan sudah di ujung
    let sedangKeluar = false;  // true setelah menekan "Keluar": jangan simpan lagi

    const simpan = () => {
        if (mode === 'tamu' || !RONDE || sedangKeluar) return;
        try {
            sessionStorage.setItem(KUNCI_SIMPAN, JSON.stringify({
                v: versi, mulai, selesai, fase, nomor,
                total: SOAL.length,
                pemain: pemain.map((p) => [p.skor, p.benar, p.bonus]),
                rekam,
            }));
        } catch (e) { /* abaikan */ }
    };

    // Main sendiri maupun tuan rumah sama-sama bisa melanjutkan permainan setelah refresh
    if (mode !== 'tamu' && RONDE) {
        try {
            const d = JSON.parse(sessionStorage.getItem(KUNCI_SIMPAN));
            if (d && d.mulai && d.total === SOAL.length && d.pemain.length === pemain.length) {
                d.pemain.forEach((a, i) => {
                    [pemain[i].skor, pemain[i].benar, pemain[i].bonus] = a;
                    pemain[i].elPoin.textContent = pemain[i].skor;
                });
                d.rekam.forEach((r, i) => { if (r) rekam[i] = r; });
                // Soal yang sudah diungkap tidak diulang (supaya poin tidak dihitung dua kali)
                nomor = d.fase === 'ungkap' ? d.nomor + 1 : d.nomor;
                if (d.selesai || nomor >= SOAL.length) { nomor = SOAL.length - 1; akhiriPulih = true; }
                versi = d.v + 1000;   // harus lebih baru dari pesan lama, kalau tidak diabaikan pemain lain
                dipulihkan = true;
            }
        } catch (e) { /* simpanan rusak: mulai dari awal */ }
    }

    // Foto permainan saat ini (kecil, jauh di bawah batas 10 KB Pusher)
    const ambilKeadaan = () => {
        const s = SOAL[nomor];
        const k = {
            v: ++versi,
            mulai,
            total: SOAL.length,
            nomor, fase, ms, totalFase,
            gambar: s.gambar,
            berikut: SOAL[nomor + 1] ? SOAL[nomor + 1].gambar : null,   // supaya tamu mengunduh lebih dulu
            layak: layak.map((p) => p.nomor),
            pegang: pemegang ? pemegang.nomor : null,
            percobaan,
            selesai,
            pemain: pemain.map((p) => [p.skor, p.benar, p.bonus]),
        };
        if (fase === 'ungkap' && rekam[nomor]) {
            k.ungkap = {
                jawaban: s.jawaban,
                penjelasan: s.penjelasan || '',
                pemenang: rekam[nomor].pemenang,
                poin: rekam[nomor].poin,
            };
        }
        return k;
    };

    const siarkan = () => {
        simpan();
        if (mode !== 'host' || !kanalSiap) return;
        terakhirKirim = performance.now();
        try { kanal.trigger('client-keadaan', ambilKeadaan()); } catch (e) { /* abaikan */ }
    };

    // --- sisi tamu: pasang keadaan dari tuan rumah ke layar ---
    let versiTerakhir = 0;
    let nomorTampil = -1;        // soal terakhir yang sudah digambar di layar tamu
    let nomorUngkap = -1;        // soal terakhir yang jawabannya sudah diungkap di layar tamu
    let sudahTerima = false;
    let terakhirTerima = 0;
    let terkirim = false;        // tamu sudah mengirim jawaban ketikannya

    const terapkan = (s) => {
        if (mode !== 'tamu' || !s || s.v <= versiTerakhir) return;   // pesan lama dibuang
        versiTerakhir = s.v;
        sudahTerima = true;
        terakhirTerima = performance.now();

        if (!s.mulai) { tampilStatus('Menunggu tuan rumah memulai...'); return; }
        mulai = true;

        totalSoal = s.total;
        elTotal.textContent = totalSoal;

        s.pemain.forEach((a, i) => {
            const p = pemain[i];
            if (!p) return;
            [p.skor, p.benar, p.bonus] = a;
            p.elPoin.textContent = p.skor;
        });

        layak = s.layak.map((n) => pemain[n]).filter(Boolean);
        pemegang = s.pegang !== null ? (pemain[s.pegang] || null) : null;
        percobaan = s.percobaan || [];

        if (s.nomor !== nomorTampil) {
            nomor = s.nomor;
            nomorTampil = s.nomor;
            elNomor.textContent = nomor + 1;
            elGambar.src = s.gambar;
            elUngkap.hidden = true;
            elForm.hidden = true;
            terkirim = false;
        }
        if (s.berikut) muatGambar(s.berikut);

        fase = s.fase;
        ms = s.ms;
        pemain.forEach((p, i) => {
            p.el.classList.toggle('is-hangus', !s.layak.includes(i));
            p.el.classList.toggle('is-pegang', s.pegang === i && s.fase === 'jawab');
        });
        if (s.fase !== 'jawab') elForm.hidden = true;

        if (s.fase === 'amati') {
            aturFase('Perhatikan gambar', s.totalFase);
            aturTombol('kunci', 'Tunggu...');
            tampilStatus('Perhatikan gambarnya baik-baik!');

        } else if (s.fase === 'rebut') {
            aturFase('Rebut tombol merah!', s.totalFase);
            if (layak.includes(kamu)) {
                aturTombol('siap', 'TEKAN!');
                tampilStatus('Tekan tombol merah sekarang!', true);
            } else {
                aturTombol('kunci', 'Hangus');
                tampilStatus('Kesempatanmu hangus. Menunggu pemain lain...');
            }

        } else if (s.fase === 'jawab') {
            if (pemegang && pemegang.kamu) {
                aturFase('Ketik jawabanmu', s.totalFase);
                aturTombol('kunci', 'Jawab!');
                if (elForm.hidden) {
                    elForm.hidden = false;
                    elInput.disabled = false;
                    elInput.value = '';
                    elInput.focus();
                    terkirim = false;
                }
                if (terkirim) tampilStatus('Jawaban terkirim. Menunggu hasil...');
                else tampilStatus('Kamu tercepat! Ketik jawabanmu lalu tekan Enter.', true);
            } else if (pemegang) {
                aturFase(`${pemegang.nama} mengetik...`, s.totalFase);
                aturTombol('kunci', '...');
                tampilStatus(`${pemegang.nama} menekan tombol duluan!`);
                elForm.hidden = true;
            }

        } else if (s.fase === 'jeda') {
            aturFase('Rebutan dibuka lagi', s.totalFase);
            aturTombol('kunci', Math.max(1, Math.ceil(JEDA_REBUT - ms / 1000)));
            const terakhir = percobaan[percobaan.length - 1];
            const yangSalah = terakhir ? pemain[terakhir.pemain] : null;
            if (yangSalah) tampilStatus(`${siapNama(yangSalah)} salah! Kesempatan hangus.`);

        } else if (s.fase === 'ungkap' && s.ungkap) {
            const u = s.ungkap;
            const pemenang = u.pemenang !== null && u.pemenang !== undefined ? (pemain[u.pemenang] || null) : null;
            if (s.nomor !== nomorUngkap) {
                nomorUngkap = s.nomor;
                soalTamu[s.nomor] = { gambar: s.gambar, jawaban: u.jawaban, penjelasan: u.penjelasan };
                rekam[s.nomor] = { jawaban: u.jawaban, pemenang: pemenang ? pemenang.nomor : null, poin: u.poin, percobaan: s.percobaan || [] };
                if (pemenang && u.poin > 0) tampilPoinBaru(pemenang, u.poin);
            }
            tampilUngkap(pemenang, u.jawaban);
        }

        if (s.selesai) akhiri();
    };

    // --- sisi tuan rumah: menerima "siap", tombol merah, dan jawaban dari tamu ---
    const siapTamu = new Set();
    let sudahMulai = false;
    let timerTunggu;

    const tamuManusia = pemain.filter((p) => !p.kamu && !p.bot);

    const mulaiPermainan = () => {
        if (sudahMulai) return;
        sudahMulai = true;
        clearTimeout(timerTunggu);
        setTimeout(() => { mulai = true; if (akhiriPulih) akhiri(); else mulaiSoal(); }, 600);
    };

    // Pemain tamu yang sah dari pesan "client-..." (null kalau pesannya tidak masuk akal)
    const tamuDari = (d) => {
        if (!d || !Number.isInteger(d.dari)) return null;
        const p = pemain[d.dari];
        if (!p || p.kamu || p.bot || p.keluar) return null;
        if (selesai || !mulai || d.soal !== nomor) return null;
        return p;
    };

    // Menerima pesan dari tamu (siap, klik, jawaban). Dipasang oleh tuan rumah,
    // baik tuan rumah sejak awal maupun yang baru naik jabatan di tengah permainan.
    let penangkapTerpasang = false;
    const pasangPenangkap = () => {
        if (penangkapTerpasang) return;
        penangkapTerpasang = true;
        // Tamu bilang "aku sudah siap" (atau minta keadaan terbaru)
        kanal.bind('client-siap', (d) => {
            if (!d) return;
            siapTamu.add(d.dari);
            siarkan();
            if (tamuManusia.every((p) => siapTamu.has(p.nomor))) mulaiPermainan();
        });

        // Tamu menekan tombol merah (tuan rumah yang menentukan siapa tercepat)
        kanal.bind('client-tekan', (d) => {
            const p = tamuDari(d);
            if (p) tekan(p);
        });

        // Tamu mengirim jawaban ketikannya (hanya diterima dari pemegang tombol)
        kanal.bind('client-jawab', (d) => {
            const p = tamuDari(d);
            if (!p || fase !== 'jawab' || pemegang !== p) return;
            proses(p, String(d.teks ?? '').slice(0, 40));
        });
    };

    const sambung = () => {
        const pusher = new Pusher(arena.dataset.pusherKey, {
            cluster: arena.dataset.pusherCluster,
            channelAuthorization: {
                endpoint: '/broadcasting/auth',
                headers: { 'X-CSRF-TOKEN': CSRF },
            },
        });
        kanal = pusher.subscribe(`private-ruang.${KODE_RUANG}`);
        window.Emote?.pasang({ kanal, nama: arena.dataset.nama });

        // Pantau siapa yang keluar dan siapa tuan rumah sekarang (lihat public/js/ruang-sesi.js)
        RuangSesi.pantau({
            kode: KODE_RUANG,
            urlSinkron: arena.dataset.urlSinkron,
            kanal,
            pemain: pemain.map((p) => ({ id: p.id, nama: p.nama, tuanRumah: p.nomor === 0 })),
            akuTuanRumah: mode === 'host',
            saatKeluar: pemainKeluar,
            saatJadiTuanRumah: jadiTuanRumah,
        });

        kanal.bind('pusher:subscription_error', () => {
            if (mode === 'host') {
                // Tidak bisa tersambung: main sendiri melawan bot
                mode = 'solo';
                pemain.forEach((p) => { if (!p.kamu) p.bot = true; });
                mulaiPermainan();
            } else {
                tampilStatus('Gagal tersambung ke ruangan. Muat ulang halaman.');
            }
        });

        if (mode === 'host') {
            kanal.bind('pusher:subscription_succeeded', () => {
                kanalSiap = true;
                tampilStatus('Menunggu pemain lain siap...');
                // Habis refresh, pemain lain sudah di dalam permainan: tidak perlu menunggu 12 detik
                timerTunggu = setTimeout(mulaiPermainan, dipulihkan ? 800 : TUNGGU_TAMU);
                siarkan();
            });

            pasangPenangkap();
        } else {
            tampilStatus('Menunggu tuan rumah...');
            kanal.bind('client-keadaan', terapkan);

            // Ulangi "siap" sampai tuan rumah benar-benar memulai permainan
            const kirimSiap = () => {
                if (mulai) return;
                try { kanal.trigger('client-siap', { dari: saya }); } catch (e) { /* abaikan */ }
            };
            kanal.bind('pusher:subscription_succeeded', () => {
                kanalSiap = true;
                kirimSiap();
                setInterval(kirimSiap, 1500);
            });
        }
    };

    // ---------- Pemain keluar / tuan rumah berganti saat permainan berjalan ----------
    const pemainKeluar = (id) => {
        const p = pemain.find((x) => x.id === id);
        if (!p || p.keluar || p.kamu) return;
        p.keluar = true;
        p.el.remove();   // hilang dari tampilan
        layak = layak.filter((x) => x !== p);
        if (mode === 'tamu' || selesai || !mulai) return;   // tamu menunggu keadaan baru dari tuan rumah

        if (fase === 'jawab' && pemegang === p) {
            // Yang sedang menjawab keluar: rebutan dibuka lagi (atau soal diungkap kalau tidak ada yang tersisa)
            pemegang = null;
            if (layak.length === 0) ungkap(null, 0); else bukaRebut();
        } else if (fase !== 'ungkap' && layak.length === 0) {
            ungkap(null, 0);
        }
        siarkan();
    };

    // Kamu naik jadi tuan rumah (tuan rumah lama keluar): ambil alih jalannya permainan
    const jadiTuanRumah = () => {
        if (mode !== 'tamu') return;
        mode = 'host';
        versi = versiTerakhir + 1000;   // keadaan baru harus selalu "lebih baru" dari milik tuan rumah lama
        pasangPenangkap();
        if (selesai) return;
        if (!mulai) { mulaiPermainan(); return; }   // tuan rumah lama keluar sebelum permainan dimulai
        sudahMulai = true;
        if (fase === 'ungkap') { siarkan(); return; }   // lanjut ke soal berikutnya seperti biasa
        mulaiSoal();                                    // soal yang sedang berjalan diulang dari awal (skor tetap)
    };

    // ---------- 5. Alur satu soal (hanya dijalankan solo dan tuan rumah) ----------
    // Tahap 1: mengamati gambar (5 detik)
    const mulaiSoal = () => {
        const s = SOAL[nomor];
        fase = 'amati';
        ms = 0;
        layak = pemain.filter((p) => !p.keluar);
        pemegang = null;
        percobaan = [];

        elNomor.textContent = nomor + 1;
        elGambar.src = s.gambar;
        elUngkap.hidden = true;
        elForm.hidden = true;
        elInput.value = '';
        pemain.forEach((p) => p.el.classList.remove('is-hangus', 'is-pegang'));

        aturFase('Perhatikan gambar', WAKTU_AMATI);
        aturTombol('kunci', 'Tunggu...');
        tampilStatus('Perhatikan gambarnya baik-baik!');

        // Tahan timer sampai gambar soal ini benar-benar siap
        tungguGambar(s.gambar);
        siarkan();
    };

    // Tahap 2: tombol merah dibuka, semua yang masih layak boleh rebutan
    const bukaRebut = () => {
        fase = 'rebut';
        ms = 0;
        pemain.forEach((p) => { if (p.bot) p.refleks = 0.7 + Math.random() * 2.5; });

        aturFase('Rebut tombol merah!', WAKTU_REBUT);
        if (layak.includes(kamu)) {
            aturTombol('siap', 'TEKAN!');
            tampilStatus('Tekan tombol merah sekarang!', true);
        } else {
            aturTombol('kunci', 'Hangus');
            tampilStatus('Kesempatanmu hangus. Menunggu pemain lain...');
        }
        siarkan();
    };

    // Tahap 3: seseorang menekan tombol merah duluan, dialah yang menjawab
    const tekan = (p) => {
        if (fase !== 'rebut' || !layak.includes(p)) return;

        p.cepat = Math.max(0, 1 - (ms / 1000) / WAKTU_REBUT);   // makin cepat makin besar
        fase = 'jawab';
        ms = 0;
        pemegang = p;
        p.el.classList.add('is-pegang');

        if (p.kamu) {
            aturFase('Ketik jawabanmu', WAKTU_KETIK);
            aturTombol('kunci', 'Jawab!');
            tampilStatus('Kamu tercepat! Ketik jawabanmu lalu tekan Enter.', true);
            elForm.hidden = false;
            elInput.value = '';
            elInput.focus();
        } else {
            aturFase(`${p.nama} mengetik...`, WAKTU_KETIK);
            aturTombol('kunci', '...');
            tampilStatus(`${p.nama} menekan tombol duluan!`);
            if (p.bot) {
                p.rencanaKetik = 2000 + Math.random() * 2500;
                p.rencanaBenar = Math.random() < p.akurasi;
            }
        }
        siarkan();
    };

    // Tahap 4: periksa jawaban
    const proses = (p, teks) => {
        const s = SOAL[nomor];
        const jawab = samakan(teks);
        const benar = jawab !== '' && jawab === samakan(s.jawaban);

        percobaan.push({ pemain: p.nomor, teks: String(teks).trim(), benar });
        p.el.classList.remove('is-pegang');
        elForm.hidden = true;

        if (benar) {
            const bonus = Math.round(POIN_BONUS * p.cepat);
            const poin = POIN_BENAR + bonus;
            p.skor += poin;
            p.bonus += bonus;
            p.benar++;
            p.elPoin.textContent = p.skor;
            tampilPoinBaru(p, poin);
            ungkap(p, poin);
            return;
        }

        // Salah: kesempatan pemain ini hangus
        p.el.classList.add('is-hangus');
        layak = layak.filter((x) => x !== p);
        if (layak.length === 0) ungkap(null, 0);
        else mulaiJeda(p);
    };

    // Tahap 5: setelah ada yang salah, hitung mundur 3 detik sebelum rebutan dibuka lagi
    const mulaiJeda = (yangSalah) => {
        fase = 'jeda';
        ms = 0;
        pemegang = null;   // setelah menjawab, tidak ada lagi pemegang tombol
        aturFase('Rebutan dibuka lagi', JEDA_REBUT);
        aturTombol('kunci', JEDA_REBUT);
        tampilStatus(`${siapNama(yangSalah)} salah! Kesempatan hangus.`);
        siarkan();
    };

    // Tahap 6: tampilkan jawaban yang benar, lalu lanjut
    const ungkap = (pemenang, poin) => {
        fase = 'ungkap';
        ms = 0;
        const s = SOAL[nomor];

        rekam[nomor] = {
            jawaban: s.jawaban,
            pemenang: pemenang ? pemenang.nomor : null,   // nomor pemain, null = tidak ada
            poin,
            percobaan,                                    // tebakan tiap pemain (teks + benar/salah)
        };

        tampilUngkap(pemenang, s.jawaban);
        siarkan();
    };

    const soalBerikut = () => {
        // Soal terakhir: langsung selesai (nomor dibiarkan di soal terakhir)
        if (nomor + 1 >= SOAL.length) { akhiri(); return; }
        nomor++;
        mulaiSoal();
    };

    // ---------- 6. Jam permainan (berdetak tiap 0,1 detik) ----------
    // Memakai jam asli (bukan hitungan +100 ms) supaya tidak melambat saat tab di latar belakang
    let terakhirDetak = performance.now();
    const detak = setInterval(() => {
        const sekarang = performance.now();
        const dt = Math.min(2000, sekarang - terakhirDetak);
        terakhirDetak = sekarang;
        if (jeda || selesai || !mulai || menungguGambar) return;

        ms += dt;

        if (mode === 'tamu') {
            // Tamu hanya menghitung mundur untuk tampilan; keputusan ada di tuan rumah
            tampilWaktu();
            if (fase === 'jeda') aturTombol('kunci', Math.max(1, Math.ceil(JEDA_REBUT - ms / 1000)));
            if (sudahTerima && sekarang - terakhirTerima > 10000) {
                tampilStatus('Koneksi ke tuan rumah terputus...');
            }
            return;
        }

        if (fase === 'amati') {
            tampilWaktu();
            if (ms >= WAKTU_AMATI * 1000) bukaRebut();

        } else if (fase === 'rebut') {
            tampilWaktu();
            const detik = ms / 1000;
            // Bot yang layak menekan tombol saat refleksnya tiba (yang tercepat menang)
            const bot = layak
                .filter((p) => p.bot && detik >= p.refleks)
                .sort((a, b) => a.refleks - b.refleks)[0];
            if (bot) tekan(bot);
            else if (ms >= WAKTU_REBUT * 1000) ungkap(null, 0);   // tidak ada yang menekan

        } else if (fase === 'jawab') {
            tampilWaktu();
            if (pemegang.bot && ms >= pemegang.rencanaKetik) {
                // Bot "mengetik": kalau salah, pakai jawaban acak dari gambar lain
                const s = SOAL[nomor];
                const salah = acakSatu(SOAL.filter((x) => x.jawaban !== s.jawaban));
                proses(pemegang, pemegang.rencanaBenar ? s.jawaban : (salah ? salah.jawaban : 'tidak tahu'));
            } else if (!pemegang.bot && ms >= WAKTU_KETIK * 1000) {
                // Manusia (kamu atau tamu) kehabisan waktu mengetik: dianggap salah
                if (pemegang.kamu) tampilStatus('Waktu mengetik habis!');
                proses(pemegang, '');
            }

        } else if (fase === 'jeda') {
            tampilWaktu();
            aturTombol('kunci', Math.max(1, Math.ceil(JEDA_REBUT - ms / 1000)));
            if (ms >= JEDA_REBUT * 1000) bukaRebut();

        } else if (fase === 'ungkap') {
            tampilWaktu();
            if (ms >= JEDA_UNGKAP) soalBerikut();
        }

        if (mode === 'host' && sekarang - terakhirKirim > 1000) siarkan();   // denyut tiap 1 detik
    }, 100);

    // ---------- 7. Kontrol pemain (klik, Spasi, Enter) ----------
    const kamuTekan = () => {
        if (jeda || selesai || !mulai) return;
        if (mode === 'tamu') {
            // Tamu hanya memberi tahu tuan rumah; layar berubah saat keadaan baru datang
            if (fase !== 'rebut' || !layak.includes(kamu) || !kanalSiap) return;
            try { kanal.trigger('client-tekan', { soal: nomor, dari: saya }); } catch (e) { /* abaikan */ }
            aturTombol('kunci', '...');
            return;
        }
        tekan(kamu);
    };

    elTombol.addEventListener('click', kamuTekan);

    document.addEventListener('keydown', (e) => {
        if (jeda || selesai || e.ctrlKey || e.metaKey || e.altKey) return;
        if (e.code === 'Space' && document.activeElement !== elInput) {
            e.preventDefault();   // cegah halaman tergulir
            if (!e.repeat) kamuTekan();
        }
    });

    elForm.addEventListener('submit', (e) => {
        e.preventDefault();
        if (selesai || jeda || !mulai || fase !== 'jawab' || !pemegang || !pemegang.kamu) return;

        if (mode === 'tamu') {
            if (terkirim || !kanalSiap) return;
            terkirim = true;
            try { kanal.trigger('client-jawab', { soal: nomor, dari: saya, teks: elInput.value.slice(0, 40) }); } catch (err) { /* abaikan */ }
            elInput.disabled = true;
            tampilStatus('Jawaban terkirim. Menunggu hasil...');
            return;
        }
        proses(kamu, elInput.value);
    });

    // ---------- 8. Selesai ----------
    const akhiri = () => {
        if (selesai) return;
        selesai = true;
        siarkan();
        setTimeout(siarkan, 400);   // kirim sekali lagi, jaga-jaga ada tamu yang terlewat
        clearInterval(detak);
        aturTombol('kunci', 'Selesai');
        tampilStatus('Permainan selesai. Membuka rekap...');

        // Soal yang terlewat (khusus tamu yang sempat terputus) diisi pengganti agar rekap tidak error
        const kosongSoal = { gambar: '', jawaban: '?', penjelasan: '' };
        const kosongJawab = { jawaban: '?', pemenang: null, poin: 0, percobaan: [] };
        const sumberSoal = mode === 'tamu' ? soalTamu : SOAL;
        const daftarSoal = Array.from({ length: totalSoal }, (_, i) => sumberSoal[i] || kosongSoal);
        const daftarJawaban = Array.from({ length: totalSoal }, (_, i) => rekam[i] || kosongJawab);

        // Urutkan dari skor tertinggi, lalu dari jumlah benar terbanyak
        const urut = [...pemain].filter((p) => !p.keluar).sort((a, b) => (b.skor - a.skor) || (b.benar - a.benar));
        const hasil = {
            mode: mode,           // 'solo', 'host', atau 'tamu'
            ruang: KODE_RUANG,    // kode ruangan (kosong kalau main sendiri)
            ronde: RONDE,         // penanda permainan yang baru selesai
            totalSoal: totalSoal,
            poinBenar: POIN_BENAR,
            soal: daftarSoal,        // gambar + jawaban + penjelasan
            jawaban: daftarJawaban,  // jawaban[soal] = { jawaban, pemenang, poin, percobaan }
            pemain: urut.map((p) => ({
                nama: p.nama,
                avatar: p.avatar,
                kamu: p.kamu,
                bot: p.bot,
                warna: p.warna,
                skor: p.skor,
                benar: p.benar,
                bonus: p.bonus,
                nomor: p.nomor,   // nomor asli, untuk mencocokkan dengan "pemenang" & "percobaan"
            })),
        };
        try { sessionStorage.setItem('musiverse_hasil_puzzle', JSON.stringify(hasil)); } catch (e) { /* abaikan */ }

        // Jeda sebentar, lalu pindah ke halaman rekap
        setTimeout(() => { location.href = arena.dataset.rekap; }, 900);
    };

    // ---------- 9. Tombol keluar ----------
    cari('[data-buka-keluar]').addEventListener('click', () => {
        if (selesai) { location.href = arena.dataset.keluar; return; }
        if (mode === 'solo') jeda = true;   // main bersama tidak bisa dijeda
        dialogKeluar.showModal();
    });
    dialogKeluar.querySelector('[data-tutup-dialog]').addEventListener('click', () => dialogKeluar.close());
    dialogKeluar.addEventListener('close', () => { jeda = false; });

    // Tombol "Keluar" di popup: main bersama -> keluar dari ruangan dulu (supaya hilang di layar pemain lain)
    dialogKeluar.querySelector('[data-keluar-link]')?.addEventListener('click', (e) => {
        sedangKeluar = true;   // keluar = permainan berakhir, jangan disimpan/dilanjutkan lagi
        try { sessionStorage.removeItem(KUNCI_SIMPAN); } catch (err) { /* abaikan */ }
        if (!KODE_RUANG) return;   // main sendiri: link biasa
        e.preventDefault();
        RuangSesi.keluar(arena.dataset.urlKeluar, KODE_RUANG, arena.dataset.keluar);
    });
    dialogKeluar.addEventListener('click', (e) => { if (e.target === dialogKeluar) dialogKeluar.close(); });

    // ---------- Mulai ----------
    if (mode === 'solo') {
        mulai = true;
        // Kalau halaman di-refresh di tengah permainan, "nomor" sudah berisi soal terakhir
        if (akhiriPulih) akhiri();
        else mulaiSoal();
    } else {
        tampilStatus('Bersiap...');
        sambung();
    }
})();