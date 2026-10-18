// =========================================================
// MUSIVERSE - SUARA PERMAINAN (efek suara + musik permainan)
//
// Semua suara dibuat langsung oleh browser (Web Audio API), jadi tidak
// ada file audio yang perlu diunduh atau dilisensikan.
//
// Cara kerja:
//  1. Efek suara  : klik tombol, balik kartu, pasangan cocok/salah, hitung
//                   mundur, tombol merah, jawaban benar/salah, menang, kalah.
//  2. Musik       : tiap game punya lagu sendiri (tangga nada slendro ala
//                   gamelan), hanya diputar di halaman permainan.
//  3. Pemicu      : file ini MEMANTAU tampilan halaman (teks status, class
//                   kartu, angka waktu), jadi match.js / quiz.js / puzzle.js
//                   tidak perlu diubah dan suaranya sama di mode solo,
//                   tuan rumah, maupun tamu.
//  4. Tombol musik: memakai tombol speaker yang sama dan pengaturan yang
//                   sama (nyala/mati) dengan musik latar di halaman lain.
// =========================================================
(() => {
    'use strict';

    const AC = window.AudioContext || window.webkitAudioContext;
    if (!AC) return;

    const KUNCI_STATUS = 'musiverse_musik_status';   // 'on' atau 'off' (sama dengan musik.js)
    const VOLUME_MUSIK = 0.42;                       // volume musik permainan (0 - 1)
    const VOLUME_EFEK = 0.9;                         // volume efek suara (0 - 1)

    const ambil = (k, tempat = localStorage) => { try { return tempat.getItem(k); } catch (e) { return null; } };
    const simpan = (k, v) => { try { localStorage.setItem(k, v); } catch (e) { /* abaikan */ } };
    const aktif = () => ambil(KUNCI_STATUS) !== 'off';

    // =====================================================
    // 1. Mesin suara
    // =====================================================
    let ctx = null, master = null, busEfek = null, busMusik = null, derau = null;
    let sudahInteraksi = false;

    const siapkan = () => {
        if (ctx) return ctx;
        ctx = new AC();

        // Pembatas volume lembut supaya suara tidak pecah saat banyak nada bersamaan
        const komp = ctx.createDynamicsCompressor();
        komp.threshold.value = -16;
        komp.knee.value = 24;
        komp.ratio.value = 4;
        komp.attack.value = 0.003;
        komp.release.value = 0.2;

        master = ctx.createGain();
        master.gain.value = 0.9;
        busEfek = ctx.createGain();
        busEfek.gain.value = VOLUME_EFEK;
        busMusik = ctx.createGain();
        busMusik.gain.value = 0;
        busEfek.connect(master);
        busMusik.connect(master);
        master.connect(komp);
        komp.connect(ctx.destination);

        // Satu detik "derau putih" dipakai untuk desis & perkusi
        derau = ctx.createBuffer(1, ctx.sampleRate, ctx.sampleRate);
        const data = derau.getChannelData(0);
        for (let i = 0; i < data.length; i++) data[i] = Math.random() * 2 - 1;
        return ctx;
    };

    const berjalan = () => !!ctx && ctx.state === 'running';

    // ---------- Bahan dasar suara ----------
    // Satu nada. opsi: tipe, vol, attack, ke (nada akhir, meluncur), bus
    const nada = (f, t, dur, o = {}) => {
        const osc = ctx.createOscillator();
        const g = ctx.createGain();
        osc.type = o.tipe || 'sine';
        osc.frequency.setValueAtTime(f, t);
        if (o.ke) osc.frequency.exponentialRampToValueAtTime(o.ke, t + dur);
        const vol = Math.max(0.0002, o.vol === undefined ? 0.3 : o.vol);
        const a = Math.min(o.attack === undefined ? 0.005 : o.attack, dur * 0.5);
        g.gain.setValueAtTime(0.0001, t);
        g.gain.exponentialRampToValueAtTime(vol, t + a);
        g.gain.exponentialRampToValueAtTime(0.0001, t + dur);
        osc.connect(g);
        g.connect(o.bus || busEfek);
        osc.start(t);
        osc.stop(t + dur + 0.05);
    };

    // Desis / derau yang disaring (untuk "swish", perkusi, kilau)
    const desis = (t, dur, o = {}) => {
        const src = ctx.createBufferSource();
        src.buffer = derau;
        const filter = ctx.createBiquadFilter();
        filter.type = o.tipe || 'bandpass';
        filter.frequency.setValueAtTime(o.f || 2000, t);
        if (o.ke) filter.frequency.exponentialRampToValueAtTime(o.ke, t + dur);
        filter.Q.value = o.q === undefined ? 1 : o.q;
        const g = ctx.createGain();
        const a = Math.min(o.attack === undefined ? 0.004 : o.attack, dur * 0.5);
        g.gain.setValueAtTime(0.0001, t);
        g.gain.exponentialRampToValueAtTime(Math.max(0.0002, o.vol === undefined ? 0.2 : o.vol), t + a);
        g.gain.exponentialRampToValueAtTime(0.0001, t + dur);
        src.connect(filter);
        filter.connect(g);
        g.connect(o.bus || busEfek);
        src.start(t, Math.random() * 0.4);
        src.stop(t + dur + 0.05);
    };

    // Bunyi logam ala gamelan / metalofon: nada dasar + dua nada atas yang cepat hilang
    const lonceng = (f, t, vol = 0.25, bus = null, d = 1.2) => {
        [[1, 1, d], [2.76, 0.35, d * 0.55], [5.4, 0.15, d * 0.3]].forEach(([r, v, dd]) => {
            nada(f * r, t, dd, { vol: vol * v, attack: 0.003, bus: bus || busEfek });
        });
    };

    const hz = (m) => 440 * Math.pow(2, (m - 69) / 12);   // nomor nada MIDI -> Hz
    const slendro = (dasar, d) => dasar * Math.pow(2, d / 5);   // tangga nada slendro (5 nada per oktaf)

    // =====================================================
    // 2. Efek suara
    // =====================================================
    const EFEK = {
        // Menekan tombol biasa: "tok" kayu singkat
        klik: (t) => {
            nada(620, t, 0.07, { vol: 0.24, ke: 320 });
            desis(t, 0.02, { tipe: 'highpass', f: 3500, vol: 0.05 });
        },
        // Memilih jawaban (Quiz)
        pilih: (t) => {
            nada(660, t, 0.09, { tipe: 'triangle', vol: 0.24 });
            nada(990, t + 0.06, 0.13, { tipe: 'triangle', vol: 0.2 });
        },
        // Membalik kartu (Match): desis kertas + ketukan halus
        balik: (t) => {
            desis(t, 0.12, { tipe: 'bandpass', f: 1400, ke: 4200, q: 0.8, vol: 0.22 });
            nada(300, t + 0.08, 0.06, { vol: 0.16, ke: 180 });
        },
        // Pasangan kartu cocok: empat lonceng naik + kilau
        cocok: (t) => {
            [72, 76, 79, 84].forEach((m, i) => lonceng(hz(m), t + i * 0.08, 0.22, null, 1.0));
            desis(t + 0.2, 0.3, { tipe: 'highpass', f: 6500, vol: 0.05 });
        },
        // Salah (kartu tidak cocok, jawaban keliru): dua nada rendah turun
        salah: (t) => {
            nada(300, t, 0.22, { tipe: 'triangle', vol: 0.3, ke: 200 });
            nada(210, t + 0.14, 0.3, { tipe: 'triangle', vol: 0.3, ke: 130 });
            nada(150, t, 0.4, { tipe: 'square', vol: 0.05, ke: 100 });
        },
        // Jawaban benar milikmu: tiga lonceng riang
        benar: (t) => {
            [79, 84, 88].forEach((m, i) => lonceng(hz(m), t + i * 0.1, 0.25, null, 1.1));
            nada(hz(91), t + 0.3, 0.5, { tipe: 'triangle', vol: 0.1 });
        },
        // Lawan menjawab benar: dua lonceng lembut
        benarLawan: (t) => {
            lonceng(hz(72), t, 0.14, null, 0.8);
            lonceng(hz(79), t + 0.1, 0.14, null, 0.8);
        },
        // Waktu habis: klakson rendah
        habis: (t) => {
            nada(130, t, 0.55, { tipe: 'sawtooth', vol: 0.15, ke: 90 });
            nada(98, t, 0.6, { tipe: 'square', vol: 0.07, ke: 70 });
        },
        // Detik terakhir (jam berdetak)
        tik: (t) => {
            nada(1000, t, 0.05, { tipe: 'square', vol: 0.08 });
        },
        // Hitung mundur 5-4-3-2-1 (Puzzle): makin dekat, makin tinggi
        hitung: (t, n = 3) => {
            const f = 480 + (6 - Math.min(5, Math.max(1, n))) * 85;
            nada(f, t, 0.14, { vol: 0.3 });
            nada(f * 2, t, 0.09, { vol: 0.07 });
        },
        // Permainan dimulai / tombol merah terbuka
        mulai: (t) => {
            lonceng(hz(79), t, 0.22, null, 0.9);
            lonceng(hz(86), t + 0.12, 0.26, null, 1.2);
            nada(hz(74), t, 0.35, { tipe: 'triangle', vol: 0.12 });
        },
        siap: (t) => {
            nada(880, t, 0.12, { tipe: 'triangle', vol: 0.22 });
            nada(1320, t + 0.09, 0.2, { tipe: 'triangle', vol: 0.2 });
        },
        // Menekan tombol merah (milikmu): buzzer tegas
        tekanku: (t) => {
            nada(190, t, 0.2, { tipe: 'square', vol: 0.17, ke: 140 });
            nada(285, t, 0.2, { tipe: 'square', vol: 0.09, ke: 210 });
            desis(t, 0.05, { tipe: 'highpass', f: 2500, vol: 0.14 });
        },
        // Lawan menekan tombol merah duluan
        buzzerLawan: (t) => {
            nada(140, t, 0.22, { tipe: 'square', vol: 0.12, ke: 100 });
            nada(105, t, 0.22, { tipe: 'square', vol: 0.07, ke: 80 });
        },
        // Kamu tercepat dan boleh menjawab
        tercepat: (t) => {
            lonceng(hz(81), t, 0.2, null, 0.8);
            lonceng(hz(88), t + 0.1, 0.2, null, 0.9);
        },
        // Giliranmu (Match)
        giliran: (t) => {
            lonceng(hz(76), t, 0.17, null, 0.7);
            lonceng(hz(83), t + 0.12, 0.17, null, 0.8);
        },
        // Soal / gambar baru
        soal: (t) => {
            desis(t, 0.25, { tipe: 'bandpass', f: 400, ke: 2400, q: 0.7, vol: 0.16 });
            nada(880, t + 0.2, 0.1, { tipe: 'triangle', vol: 0.15 });
        },
        // Sisa waktu permainan di bawah 1 menit
        peringatan: (t) => {
            [0, 0.2, 0.4].forEach((d) => nada(880, t + d, 0.12, { tipe: 'square', vol: 0.09 }));
        },
        // Permainan selesai (gong singkat; halaman rekap memutar fanfare)
        selesai: (t) => {
            nada(98, t, 2.4, { vol: 0.4, attack: 0.01 });
            nada(98 * 2.01, t, 1.6, { vol: 0.2 });
            nada(98 * 2.9, t, 1.0, { vol: 0.1 });
            lonceng(hz(84), t + 0.05, 0.15, null, 1.2);
        },
        // Halaman rekap: kamu juara
        menang: (t) => {
            [[72, 0], [76, 0.14], [79, 0.28], [84, 0.42]].forEach(([m, d]) => {
                lonceng(hz(m), t + d, 0.22, null, 1.0);
                nada(hz(m), t + d, 0.3, { tipe: 'triangle', vol: 0.16 });
            });
            [84, 88, 91].forEach((m) => {
                lonceng(hz(m), t + 0.62, 0.2, null, 1.6);
                nada(hz(m), t + 0.62, 1.1, { tipe: 'triangle', vol: 0.13, attack: 0.01 });
            });
            for (let i = 0; i < 6; i++) lonceng(hz(96 + (i % 3) * 4), t + 0.7 + i * 0.1, 0.06, null, 0.6);
        },
        // Halaman rekap: belum juara (tetap hangat, tidak menyedihkan)
        kalah: (t) => {
            [67, 64, 60].forEach((m, i) => nada(hz(m), t + i * 0.24, 0.5, { tipe: 'triangle', vol: 0.26 }));
            lonceng(hz(55), t + 0.7, 0.14, null, 1.4);
        },
    };

    const terakhirMain = {};
    const main = (nama, arg) => {
        if (!aktif() || !siapkan() || !berjalan()) return;
        const fn = EFEK[nama];
        if (!fn) return;
        const kini = performance.now();
        if (kini - (terakhirMain[nama] ?? -1e9) < 70) return;   // cegah suara dobel
        terakhirMain[nama] = kini;
        try { fn(ctx.currentTime + 0.005, arg); } catch (e) { /* suara gagal: abaikan */ }
    };

    // =====================================================
    // 3. Musik permainan (satu lagu per game)
    // Setiap lagu = 4 birama x 16 langkah. Angka = nada slendro
    // (0-4 oktaf dasar, 5-9 oktaf di atasnya), -1 = diam.
    // Ubah angka di sini kalau ingin mengganti melodi.
    // =====================================================
    const TEMA = {
        // Tenang dan ceria, cocok untuk mengingat kartu
        match: {
            bpm: 92, dasar: 196, vol: 0.17,
            melodi: [
                [5, -1, 7, -1, 6, -1, 5, -1, 3, -1, 5, -1, 4, -1, -1, -1],
                [5, -1, 7, -1, 8, -1, 7, -1, 5, -1, 6, -1, 5, -1, -1, -1],
                [3, -1, 5, -1, 6, -1, 5, -1, 3, -1, 4, -1, 2, -1, -1, -1],
                [3, -1, 2, -1, 3, -1, 5, -1, 4, -1, 3, -1, 5, 5, -1, -1],
            ],
            bass: [[0, 0, 2, 0], [0, 0, 4, 2], [3, 3, 2, 0], [0, 2, 3, 4]],
            dung: 'x.......x.......', tak: '....x.......x...', hat: '.x.x.x.x.x.x.x.x',
        },
        // Lebih cepat dan menegang, cocok untuk berpikir cepat
        quiz: {
            bpm: 108, dasar: 220, vol: 0.16,
            melodi: [
                [5, -1, 5, -1, 7, -1, 5, -1, 8, -1, 7, -1, 5, -1, -1, -1],
                [5, -1, 5, -1, 7, -1, 5, -1, 9, -1, 8, -1, 7, -1, -1, -1],
                [4, -1, 4, -1, 6, -1, 4, -1, 7, -1, 6, -1, 4, -1, -1, -1],
                [3, -1, 4, -1, 5, -1, 6, -1, 7, -1, 6, -1, 5, 5, 4, -1],
            ],
            bass: [[0, 0, 3, 0], [0, 0, 4, 2], [4, 4, 2, 0], [0, 2, 3, 4]],
            dung: 'x.....x.x.......', tak: '....x.......x..x', hat: 'xxxxxxxxxxxxxxxx',
        },
        // Misterius dan bersyncopasi, cocok untuk menebak gambar
        puzzle: {
            bpm: 118, dasar: 174.6, vol: 0.17,
            melodi: [
                [7, -1, -1, 5, -1, 7, -1, -1, 8, -1, -1, 7, -1, 5, -1, -1],
                [7, -1, -1, 5, -1, 7, -1, -1, 9, -1, 8, -1, 7, -1, -1, -1],
                [5, -1, -1, 3, -1, 5, -1, -1, 6, -1, -1, 5, -1, 3, -1, -1],
                [4, -1, 5, -1, 6, -1, -1, 5, 3, -1, 4, -1, 2, -1, -1, -1],
            ],
            bass: [[0, 0, 2, 0], [0, 3, 4, 2], [3, 3, 2, 0], [0, 2, 4, 3]],
            dung: 'x..x..x.x..x..x.', tak: '....x.......x...', hat: '.x.x.x.xx.x.x.xx',
        },
    };

    const musik = { tema: null, nama: null, langkah: 0, waktuBerikut: 0, timer: null, faktor: 1, tegang: false };

    const mainkanLangkah = (s, t) => {
        const T = musik.tema;
        const bar = (s >> 4) & 3;
        const k = s & 15;
        const detikLangkah = 60 / (T.bpm * musik.faktor) / 2;

        // Melodi (lonceng gamelan). Di langkah kosong kadang ada kilau pelan agar tidak monoton.
        const d = T.melodi[bar][k];
        if (d >= 0) {
            lonceng(slendro(T.dasar, d), t, T.vol, busMusik, 1.3);
        } else if (k % 2 === 1 && Math.random() < 0.3) {
            lonceng(slendro(T.dasar, 5 + Math.floor(Math.random() * 5)), t, 0.05, busMusik, 0.8);
        }

        // Bas: satu nada tiap ketukan
        if (k % 4 === 0) {
            nada(slendro(T.dasar, T.bass[bar][k >> 2] - 5), t, detikLangkah * 3.6,
                { tipe: 'triangle', vol: 0.26, attack: 0.012, bus: busMusik });
        }

        // Perkusi ala kendang: dung (rendah), tak (nyaring), dan desis halus
        if (T.dung[k] === 'x') nada(120, t, 0.2, { vol: 0.4, ke: 52, bus: busMusik });
        if (T.tak[k] === 'x') desis(t, 0.08, { tipe: 'bandpass', f: 1700, q: 2.2, vol: 0.13, bus: busMusik });
        if (T.hat[k] === 'x') {
            desis(t, 0.035, { tipe: 'highpass', f: 7000, vol: 0.04 + (musik.tegang ? 0.03 : 0), bus: busMusik });
        }

        // Gong di awal tiap putaran 4 birama
        if (s === 0) {
            const g0 = T.dasar / 2;
            [[1, 0.45, 4], [2.01, 0.2, 3], [2.9, 0.12, 2], [4.3, 0.06, 1.5]].forEach(([r, v, dd]) => {
                nada(g0 * r, t, dd, { vol: v, attack: 0.02, bus: busMusik });
            });
        }
    };

    const jadwalkan = () => {
        if (!ctx || !musik.tema) return;
        while (musik.waktuBerikut < ctx.currentTime + 0.3) {
            mainkanLangkah(musik.langkah, musik.waktuBerikut);
            musik.waktuBerikut += 60 / (musik.tema.bpm * musik.faktor) / 2;
            musik.langkah = (musik.langkah + 1) % 64;
        }
    };

    const mulaiMusik = (nama) => {
        if (!aktif() || !TEMA[nama] || !siapkan()) return;
        if (musik.timer && musik.nama === nama) return;
        hentikanMusik(true);
        musik.nama = nama;
        musik.tema = TEMA[nama];
        musik.langkah = 0;
        musik.faktor = 1;
        musik.tegang = false;
        musik.waktuBerikut = ctx.currentTime + 0.08;
        musik.timer = setInterval(jadwalkan, 50);
        jadwalkan();
        const t = ctx.currentTime;
        busMusik.gain.cancelScheduledValues(t);
        busMusik.gain.setValueAtTime(0.0001, t);
        busMusik.gain.linearRampToValueAtTime(VOLUME_MUSIK, t + 1.6);   // masuk perlahan
    };

    function hentikanMusik(langsung) {
        if (!musik.timer) return;
        clearInterval(musik.timer);
        musik.timer = null;
        musik.tema = null;
        if (!ctx) return;
        const t = ctx.currentTime;
        busMusik.gain.cancelScheduledValues(t);
        busMusik.gain.setValueAtTime(Math.max(0.0001, busMusik.gain.value), t);
        busMusik.gain.linearRampToValueAtTime(0.0001, t + (langsung ? 0.05 : 0.8));   // keluar perlahan
    }

    // Sisa waktu hampir habis: lagu sedikit dipercepat
    const aturTegang = (ya) => {
        musik.tegang = ya;
        musik.faktor = ya ? 1.14 : 1;
    };

    // =====================================================
    // 4. Memantau tampilan halaman (pemicu suara)
    // =====================================================
    const amati = (el, opsi, fn) => {
        if (el) new MutationObserver(fn).observe(el, opsi);
    };

    // Menunggu sampai browser mengizinkan suara (setelah pengunjung klik / sentuh / tekan tombol)
    const antrean = [];
    const setelahAktif = (fn, batasMs = 8000) => {
        const dibuat = performance.now();
        siapkan();
        if (berjalan()) { fn(); return; }
        antrean.push(() => { if (performance.now() - dibuat < batasMs) fn(); });
    };

    const pasangPembuka = () => {
        const buka = () => {
            sudahInteraksi = true;
            siapkan();
            const lanjut = () => { while (antrean.length) antrean.shift()(); };
            if (ctx.state === 'suspended') ctx.resume().then(lanjut, () => {});
            else lanjut();
        };
        ['pointerdown', 'keydown', 'touchstart'].forEach((e) => document.addEventListener(e, buka, { capture: true }));

        // Tab disembunyikan: suara berhenti dulu, supaya tidak berisik di latar belakang
        document.addEventListener('visibilitychange', () => {
            if (!ctx) return;
            if (document.hidden) { if (ctx.state === 'running') ctx.suspend(); }
            else if (sudahInteraksi) ctx.resume();
        });
    };

    // Klik tombol biasa di semua halaman yang memuat file ini
    const pasangKlikUmum = () => {
        const KECUALI = '.kartu, .pilihan, [data-tombol]';   // punya suara sendiri
        document.addEventListener('click', (e) => {
            const el = e.target.closest && e.target.closest('button, a[href], [role="button"], summary');
            if (!el || el.disabled || el.closest(KECUALI)) return;
            main('klik');
        }, true);
    };

    // Reaksi terhadap teks status ("Benar! Mantap!", "Waktu habis!", dll.)
    const REAKSI = {
        match: [[/^Waktu habis/, 'habis'], [/^Giliranmu/, 'giliran']],
        quiz: [[/^Benar/, 'benar'], [/^Waktu habis/, 'habis'], [/^Belum tepat/, 'salah'], [/^Pilih jawabanmu/, 'soal']],
        puzzle: [
            [/^Benar!/, 'benar'], [/lebih cepat dan tepat/, 'benarLawan'], [/^Waktu habis/, 'habis'],
            [/salah! Kesempatan hangus/, 'salah'], [/^Kamu tercepat/, 'tercepat'],
            [/menekan tombol duluan/, 'buzzerLawan'], [/^Tekan tombol merah/, 'siap'], [/^Perhatikan gambar/, 'soal'],
        ],
    };

    const pantauStatus = (arena, jenis) => {
        const el = arena.querySelector('[data-status]');
        if (!el) return;
        let lama = el.textContent.trim();
        let sudahMulai = false;
        let sudahSelesai = false;
        const menunggu = (s) => /^(Bersiap|Menunggu)/.test(s);

        // Mode solo di Quiz & Puzzle langsung mulai sebelum file ini siap: bunyikan tanda mulai sekarang
        if (!menunggu(lama)) {
            sudahMulai = true;
            setTimeout(() => setelahAktif(() => main('mulai'), 3000), 250);
        }

        amati(el, { childList: true, characterData: true, subtree: true }, () => {
            const baru = el.textContent.trim();
            if (baru === lama) return;
            const sebelum = lama;
            lama = baru;

            if (!sudahMulai && menunggu(sebelum) && !menunggu(baru)) {
                sudahMulai = true;
                main('mulai');
                return;
            }
            if (/^Permainan selesai/.test(baru)) {
                if (!sudahSelesai) { sudahSelesai = true; hentikanMusik(); main('selesai'); }
                return;
            }
            const cocok = REAKSI[jenis].find(([pola]) => pola.test(baru));
            if (cocok) main(cocok[1]);
        });
    };

    // Angka detik yang berubah saat waktu hampir habis -> bunyi "tik"
    const pantauDetik = (arena, jenis) => {
        const lama = new WeakMap();
        amati(arena, { childList: true, characterData: true, subtree: true }, (rekaman) => {
            const sudah = new Set();
            rekaman.forEach((r) => {
                const n = r.target.nodeType === 3 ? r.target.parentElement : r.target;
                const el = n && n.closest ? n.closest('[data-detik]') : null;
                if (!el || sudah.has(el)) return;
                sudah.add(el);

                const teks = el.textContent.trim();
                if (lama.get(el) === teks) return;
                lama.set(el, teks);
                if (!/^\d+$/.test(teks)) return;

                let mepet = false;
                if (jenis === 'match') {
                    const p = el.closest('.pemain');
                    mepet = !!p && p.classList.contains('is-mepet') && p.classList.contains('is-giliran');
                } else {
                    const wadah = arena.querySelector('[data-waktu-wadah]');
                    mepet = !!wadah && wadah.classList.contains('is-mepet');
                    // Puzzle: saat 5 detik pengamatan, angka besar punya bunyi sendiri
                    const hitung = arena.querySelector('[data-hitung]');
                    if (hitung && !hitung.hidden) mepet = false;
                }
                if (mepet) main('tik');
            });
        });
    };

    // ---------- Match ----------
    const pasangMatch = (arena) => {
        // Kartu: terbuka / cocok / salah
        amati(arena.querySelector('[data-papan]'),
            { attributes: true, attributeFilter: ['class'], subtree: true, attributeOldValue: true },
            (rekaman) => {
                let balik = false, cocok = false, salah = false;
                rekaman.forEach((r) => {
                    const lama = new Set((r.oldValue || '').split(/\s+/));
                    const kini = r.target.classList;
                    if (kini.contains('is-terbuka') && !lama.has('is-terbuka') && !kini.contains('is-cocok')) balik = true;
                    if (kini.contains('is-cocok') && !lama.has('is-cocok')) cocok = true;
                    if (kini.contains('is-salah') && !lama.has('is-salah')) salah = true;
                });
                if (cocok) main('cocok');
                else if (salah) main('salah');
                else if (balik) main('balik');
            });

        // Sisa waktu permainan di bawah 1 menit
        const jam = arena.querySelector('[data-jam]');
        let kritis = false;
        amati(jam, { attributes: true, attributeFilter: ['class'] }, () => {
            const ya = jam.classList.contains('is-kritis');
            if (ya && !kritis) { main('peringatan'); aturTegang(true); }
            kritis = ya;
        });
    };

    // ---------- Quiz ----------
    const pasangQuiz = (arena) => {
        const pilihan = arena.querySelector('[data-pilihan]');
        pilihan?.addEventListener('click', (e) => {
            const el = e.target.closest('.pilihan');
            if (el && !el.disabled) main('pilih');
        }, true);
    };

    // ---------- Puzzle ----------
    const pasangPuzzle = (arena) => {
        // Hitung mundur 5 detik di atas gambar
        const hitung = arena.querySelector('[data-hitung]');
        let lamaHitung = '';
        amati(hitung, { childList: true, characterData: true, subtree: true }, () => {
            const teks = hitung.textContent.trim();
            if (teks === lamaHitung) return;
            lamaHitung = teks;
            if (!hitung.hidden && /^\d+$/.test(teks)) main('hitung', Number(teks));
        });

        // Tombol merah (klik atau tombol Spasi) saat sedang menyala
        const tombol = arena.querySelector('[data-tombol]');
        const bisaDitekan = () => tombol && !tombol.disabled && tombol.classList.contains('is-siap');
        tombol?.addEventListener('click', () => { if (bisaDitekan()) main('tekanku'); }, true);
        document.addEventListener('keydown', (e) => {
            if (e.code !== 'Space' || e.repeat || e.ctrlKey || e.metaKey || e.altKey) return;
            if (document.activeElement && document.activeElement.tagName === 'INPUT') return;
            if (bisaDitekan()) main('tekanku');
        }, true);
    };

    // Halaman rekap: fanfare kalau kamu juara, nada hangat kalau belum
    const pasangRekap = () => {
        const m = location.pathname.match(/\/games\/(match|quiz|puzzle)\/rekap/);
        if (!m) return;
        let hasil = null;
        try { hasil = JSON.parse(sessionStorage.getItem(`musiverse_hasil_${m[1]}`)); } catch (e) { hasil = null; }
        const pemain = hasil && hasil.pemain;
        if (!Array.isArray(pemain) || !pemain.length) return;

        const tertinggi = Math.max(...pemain.map((p) => p.skor || 0));
        const kamu = pemain.find((p) => p.kamu);
        const menang = !!kamu && (kamu.skor || 0) >= tertinggi && tertinggi > 0;
        setTimeout(() => setelahAktif(() => main(menang ? 'menang' : 'kalah')), 350);
    };

    // Tombol speaker di halaman permainan: menyalakan / mematikan musik DAN efek suara
    const pasangTombolMusik = (jenis) => {
        const tombol = document.getElementById('tombolMusik');
        const tampil = (nyala) => {
            if (!tombol) return;
            tombol.classList.toggle('is-playing', nyala);
            tombol.setAttribute('aria-label', nyala ? 'Matikan suara' : 'Nyalakan suara');
            tombol.title = 'Musik & efek suara permainan';
        };
        tampil(aktif());

        tombol?.addEventListener('click', (e) => {
            e.stopPropagation();
            if (aktif()) {
                simpan(KUNCI_STATUS, 'off');
                hentikanMusik();
                tampil(false);
            } else {
                simpan(KUNCI_STATUS, 'on');
                tampil(true);
                siapkan();
                const mulai = () => mulaiMusik(jenis);
                if (ctx.state === 'suspended') ctx.resume().then(mulai, () => {}); else mulai();
            }
        });
    };

    // =====================================================
    // 5. Mulai
    // =====================================================
    const pasang = () => {
        const arena = document.querySelector('[data-match], [data-quiz], [data-puzzle]');
        pasangPembuka();
        pasangKlikUmum();

        if (arena) {
            const jenis = arena.hasAttribute('data-match') ? 'match'
                : arena.hasAttribute('data-quiz') ? 'quiz' : 'puzzle';
            pasangTombolMusik(jenis);
            pantauStatus(arena, jenis);
            pantauDetik(arena, jenis);
            if (jenis === 'match') pasangMatch(arena);
            if (jenis === 'quiz') pasangQuiz(arena);
            if (jenis === 'puzzle') pasangPuzzle(arena);

            // Musik permainan: mulai begitu browser mengizinkan
            if (aktif()) {
                siapkan();
                mulaiMusik(jenis);
            }
        } else {
            pasangRekap();
        }
    };

    window.Suara = { main, mulaiMusik, hentikanMusik, aktif };

    if (typeof document !== 'undefined') {
        if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', pasang);
        else pasang();
    }
})();