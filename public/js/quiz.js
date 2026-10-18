// =========================================================
// MUSIVERSE QUIZ - logika permainan
// Aturan: 15 soal pilihan ganda A-D.
//   Benar  = poin dasar + bonus kecepatan (makin cepat makin besar).
//   Salah / waktu habis = 0 poin (poin tidak dikurangi).
//
// Ada 3 mode (sama seperti Match):
//   solo : kamu lawan bot. Semua dijalankan di browsermu sendiri.
//   host : tuan rumah. Browsernya menjalankan SEMUA aturan (soal, waktu,
//          poin, bot), lalu mengirim "keadaan" permainan lewat Pusher.
//   tamu : pemain lain. Hanya menampilkan keadaan dari tuan rumah, dan
//          mengirim jawabannya ke tuan rumah.
// =========================================================
(() => {
    const arena = document.querySelector('[data-quiz]');
    if (!arena) return;

    // ---------- Pengaturan (ubah angka di sini kalau ingin menyetel permainan) ----------
    const WAKTU_SOAL = 20;       // detik untuk menjawab tiap soal
    const JEDA_JAWABAN = 4500;   // milidetik jawaban benar + penjelasan ditampilkan
    const POIN_DASAR = 100;      // poin untuk jawaban benar
    const POIN_BONUS = 50;       // bonus maksimal kalau menjawab secepat kilat
    const WARNA = ['#e9c349', '#e0566a', '#5fb3a1', '#8fa8e8'];
    const HURUF = ['A', 'B', 'C', 'D'];
    const TUNGGU_TAMU = 12000;   // ms: tuan rumah menunggu tamu siap, lalu mulai

    const SOAL = JSON.parse(document.getElementById('data-soal').textContent);
    if (!SOAL.length) return;
    const URL_AVATAR = arena.dataset.avatarUrl;
    const CSRF = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

    const elStatus = arena.querySelector('[data-status]');
    const elNomor = arena.querySelector('[data-nomor]');
    const elTotal = arena.querySelector('[data-total]');
    const elSkorBar = arena.querySelector('[data-skor-bar]');
    const elWaktu = arena.querySelector('[data-waktu-wadah]');
    const elBar = arena.querySelector('[data-bar]');
    const elDetik = arena.querySelector('[data-detik]');
    const elKategori = arena.querySelector('[data-kategori]');
    const elTanya = arena.querySelector('[data-tanya]');
    const elPilihan = arena.querySelector('[data-pilihan]');
    const elUngkap = arena.querySelector('[data-ungkap]');
    const elUngkapJudul = arena.querySelector('[data-ungkap-judul]');
    const elUngkapTeks = arena.querySelector('[data-ungkap-teks]');
    const dialogKeluar = document.getElementById('dialog-keluar');

    const ambil = (k, tempat = localStorage) => { try { return tempat.getItem(k); } catch (e) { return null; } };
    const acakSatu = (arr) => arr.length ? arr[Math.floor(Math.random() * arr.length)] : undefined;

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
        akurasi: 0.55 + Math.random() * 0.3,   // khusus bot: peluang menjawab benar (55% - 85%)
        bonus: 0,                              // total poin dari bonus kecepatan
        jawab: null,                           // nomor pilihan yang diambil (null = belum menjawab)
        detikJawab: null,                      // detik ke berapa menjawab
        rencanaDetik: 0,                       // khusus bot: kapan akan menjawab
        rencanaPilih: 0,                       // khusus bot: pilihan yang akan diambil
    }));
    const kamu = pemain.find((p) => p.kamu);
    const saya = kamu.nomor;                   // nomorku

    // Papan skor
    pemain.forEach((p) => {
        const el = document.createElement('div');
        el.className = 'kuis-pemain' + (p.kamu ? ' kuis-pemain--kamu' : '');
        el.style.setProperty('--warna', p.warna);
        el.innerHTML = `
            <img src="${URL_AVATAR}/${p.avatar}.svg" alt="">
            <div>
                <p class="kuis-pemain__nama"></p>
                <span class="kuis-pemain__poin"><b data-poin>0</b> poin</span>
            </div>`;
        el.querySelector('.kuis-pemain__nama').textContent = p.kamu ? `${p.nama} (Kamu)` : p.nama;
        elSkorBar.appendChild(el);
        p.el = el;
        p.elPoin = el.querySelector('[data-poin]');
    });

    // ---------- 2. Keadaan permainan ----------
    let nomor = 0;               // soal ke berapa (mulai dari 0)
    let fase = 'tanya';          // 'tanya' = menjawab, 'ungkap' = menampilkan jawaban benar
    let berlaluMs = 0;           // waktu berjalan di soal ini
    let tungguMs = 0;            // lama jawaban benar sudah ditampilkan
    let jeda = false;            // popup keluar sedang terbuka (hanya mode solo)
    let selesai = false;
    let mulai = false;           // false = belum mulai (menunggu semua pemain siap)
    let totalSoal = SOAL.length;
    let soalIni = null;          // soal yang sedang tampil
    const rekam = [];            // rekam[soal][nomor pemain] = { pilih, detik, poin }, untuk halaman rekap
    const soalTamu = [];         // khusus tamu: soal lengkap yang sudah diungkap (untuk halaman rekap)

    elTotal.textContent = totalSoal;

    // ---------- 3. Tampilan ----------
    const tampilWaktu = () => {
        const sisa = Math.max(0, WAKTU_SOAL - berlaluMs / 1000);
        elBar.style.transform = `scaleX(${sisa / WAKTU_SOAL})`;
        elDetik.textContent = Math.ceil(sisa);
        elWaktu.classList.toggle('is-mepet', sisa <= 5);
    };

    const tampilStatus = (teks, giliranKamu = false) => {
        elStatus.textContent = teks;
        elStatus.classList.toggle('is-kamu', giliranKamu);
    };

    const tampilPoinBaru = (p, tambah) => {
        const el = document.createElement('span');
        el.className = 'kuis-pemain__tambah';
        el.textContent = `+${tambah}`;
        p.el.appendChild(el);
        setTimeout(() => el.remove(), 1700);
    };

    // Menampilkan satu soal di layar (dipakai solo, tuan rumah, dan tamu)
    const tampilSoal = (s) => {
        soalIni = s;
        fase = 'tanya';
        berlaluMs = 0;
        tungguMs = 0;

        elNomor.textContent = nomor + 1;
        elKategori.textContent = s.kategori || 'Budaya';
        elTanya.textContent = s.pertanyaan;
        elUngkap.hidden = true;

        elPilihan.innerHTML = '';
        s.opsi.forEach((teks, i) => {
            const b = document.createElement('button');
            b.type = 'button';
            b.className = 'pilihan';
            b.dataset.i = i;
            const huruf = document.createElement('span');
            huruf.className = 'pilihan__huruf';
            huruf.textContent = HURUF[i];
            const isi = document.createElement('span');
            isi.className = 'pilihan__teks';
            isi.textContent = teks;
            const tanda = document.createElement('span');
            tanda.className = 'pilihan__tanda';
            tanda.setAttribute('aria-hidden', 'true');
            b.append(huruf, isi, tanda);
            elPilihan.appendChild(b);
        });

        pemain.forEach((p) => {
            p.jawab = null;
            p.detikJawab = null;
            p.el.classList.remove('is-jawab');
        });

        tampilWaktu();
        tampilStatus('Pilih jawabanmu!', true);
    };

    // Menandai pilihan benar/salah dan menampilkan penjelasan (s harus punya benar & penjelasan)
    const tampilUngkap = (s) => {
        elPilihan.querySelectorAll('.pilihan').forEach((b) => {
            const i = +b.dataset.i;
            b.disabled = true;
            b.classList.remove('is-dipilih');
            const tanda = b.querySelector('.pilihan__tanda');
            if (i === s.benar) {
                b.classList.add('is-benar');
                tanda.textContent = '✓';
            } else if (i === kamu.jawab) {
                b.classList.add('is-salah');
                tanda.textContent = '✗';
            } else {
                b.classList.add('is-redup');
            }
        });

        elUngkapJudul.textContent = `Jawaban yang benar: ${HURUF[s.benar]}. ${s.opsi[s.benar]}`;
        elUngkapTeks.textContent = s.penjelasan || '';
        elUngkap.hidden = false;

        if (kamu.jawab === s.benar) tampilStatus('Benar! Mantap!');
        else if (kamu.jawab === null) tampilStatus('Waktu habis!');
        else tampilStatus('Belum tepat, tapi kamu jadi tahu jawabannya!');
    };

    // ---------- 4. Pusher: tuan rumah mengirim keadaan, tamu menerima ----------
    let kanal = null;            // channel Pusher ruangan ini
    let kanalSiap = false;       // true setelah berhasil masuk channel
    let versi = 0;               // nomor urut keadaan (tuan rumah menaikkan, tamu membuang yang lama)
    let terakhirKirim = 0;

    // Foto permainan saat ini. Soal yang dikirim TIDAK memuat jawaban benar sampai fasenya "ungkap".
    const ambilKeadaan = () => {
        const s = SOAL[nomor];
        const k = {
            v: ++versi,
            mulai,
            total: SOAL.length,
            nomor, fase,
            ms: berlaluMs,
            tunggu: tungguMs,
            selesai,
            soal: { kategori: s.kategori, pertanyaan: s.pertanyaan, opsi: s.opsi },
            sudah: pemain.map((p) => p.jawab !== null),
            pemain: pemain.map((p) => [p.skor, p.benar, p.bonus]),
        };
        if (fase === 'ungkap' && rekam[nomor]) {
            k.ungkap = {
                benar: s.benar,
                penjelasan: s.penjelasan || '',
                jawaban: rekam[nomor].map((r) => [r.pilih, r.detik, r.poin]),
            };
        }
        return k;
    };

    const siarkan = () => {
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

    const terapkan = (s) => {
        if (mode !== 'tamu' || !s || s.v <= versiTerakhir) return;   // pesan lama dibuang
        versiTerakhir = s.v;
        sudahTerima = true;
        terakhirTerima = performance.now();

        if (!s.mulai) { tampilStatus('Menunggu tuan rumah memulai...'); return; }
        mulai = true;

        totalSoal = s.total;
        elTotal.textContent = totalSoal;

        if (s.nomor !== nomorTampil) {
            nomor = s.nomor;
            nomorTampil = s.nomor;
            tampilSoal(s.soal);
        }
        fase = s.fase;
        berlaluMs = s.ms;
        tungguMs = s.tunggu;

        s.pemain.forEach((a, i) => {
            const p = pemain[i];
            if (!p) return;
            [p.skor, p.benar, p.bonus] = a;
            p.elPoin.textContent = p.skor;
        });

        if (s.fase === 'tanya') {
            s.sudah.forEach((ya, i) => pemain[i]?.el.classList.toggle('is-jawab', !!ya));
            tampilWaktu();
            if (kamu.jawab === null) tampilStatus('Pilih jawabanmu!', true);
            else tampilStatus('Jawaban terkunci. Menunggu pemain lain...');
        } else if (s.ungkap && s.nomor !== nomorUngkap) {
            nomorUngkap = s.nomor;
            const u = s.ungkap;
            const lengkap = { ...s.soal, benar: u.benar, penjelasan: u.penjelasan };
            soalTamu[s.nomor] = lengkap;
            rekam[s.nomor] = u.jawaban.map(([pilih, detik, poin]) => ({ pilih, detik, poin }));
            u.jawaban.forEach(([pilih, detik, poin], i) => {
                const p = pemain[i];
                if (!p) return;
                p.jawab = pilih;
                p.detikJawab = detik;
                if (poin > 0) tampilPoinBaru(p, poin);
            });
            tampilWaktu();
            tampilUngkap(lengkap);
        }

        if (s.selesai) akhiri();
    };

    // --- sisi tuan rumah: menerima "siap" dan jawaban dari tamu ---
    const siapTamu = new Set();
    let sudahMulai = false;
    let timerTunggu;

    const tamuManusia = pemain.filter((p) => !p.kamu && !p.bot);

    const mulaiPermainan = () => {
        if (sudahMulai) return;
        sudahMulai = true;
        clearTimeout(timerTunggu);
        setTimeout(() => { mulai = true; mulaiSoal(); }, 600);
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

        // Tamu mengirim jawabannya
        kanal.bind('client-jawab', (d) => {
            if (!d || !Number.isInteger(d.dari)) return;
            const p = pemain[d.dari];
            if (!p || p.kamu || p.bot || p.keluar) return;
            if (selesai || !mulai || fase !== 'tanya' || d.soal !== nomor) return;
            const i = Number(d.pilih);
            if (!Number.isInteger(i) || i < 0 || i >= SOAL[nomor].opsi.length) return;
            jawabkan(p, i, berlaluMs / 1000);   // waktu dihitung oleh tuan rumah
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
                timerTunggu = setTimeout(mulaiPermainan, TUNGGU_TAMU);
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
        // Yang tersisa menunggu tidak perlu menunggu dia lagi: dicek otomatis oleh jam permainan
        if (mode !== 'tamu' && !selesai && mulai) siarkan();
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

    // ---------- 5. Satu soal (hanya dijalankan solo dan tuan rumah) ----------
    const mulaiSoal = () => {
        const s = SOAL[nomor];
        tampilSoal(s);

        // Siapkan jawaban bot: kapan menjawab dan memilih apa
        pemain.forEach((p) => {
            if (p.bot) {
                p.rencanaDetik = 2.5 + Math.random() * Math.max(1, WAKTU_SOAL - 8);
                const salah = [0, 1, 2, 3].filter((i) => i !== s.benar);
                p.rencanaPilih = Math.random() < p.akurasi ? s.benar : acakSatu(salah);
            }
        });
        siarkan();
    };

    const jawabkan = (p, pilihan, detik) => {
        if (p.jawab !== null) return;
        p.jawab = pilihan;
        p.detikJawab = detik;
        p.el.classList.add('is-jawab');
        if (p.kamu) {
            elPilihan.querySelectorAll('.pilihan').forEach((b) => {
                b.disabled = true;
                b.classList.toggle('is-dipilih', +b.dataset.i === pilihan);
            });
            tampilStatus('Jawaban terkunci. Menunggu pemain lain...');
        }
        siarkan();
    };

    const ungkap = () => {
        if (fase !== 'tanya') return;
        fase = 'ungkap';
        tungguMs = 0;
        const s = SOAL[nomor];

        // Hitung poin + catat jawaban tiap pemain (urutan sama dengan array pemain)
        rekam[nomor] = pemain.map((p) => {
            let poin = 0;
            if (p.jawab === s.benar) {
                const cepat = Math.max(0, 1 - p.detikJawab / WAKTU_SOAL);
                const bonus = Math.round(POIN_BONUS * cepat);
                poin = POIN_DASAR + bonus;
                p.skor += poin;
                p.bonus += bonus;
                p.benar++;
                p.elPoin.textContent = p.skor;
                tampilPoinBaru(p, poin);
            }
            return { pilih: p.jawab, detik: p.detikJawab, poin };
        });

        tampilUngkap(s);
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
        if (jeda || selesai || !mulai) return;

        if (mode === 'tamu') {
            // Tamu hanya menghitung mundur untuk tampilan; keputusan ada di tuan rumah
            if (fase === 'tanya') { berlaluMs += dt; tampilWaktu(); } else { tungguMs += dt; }
            if (sudahTerima && sekarang - terakhirTerima > 10000) {
                tampilStatus('Koneksi ke tuan rumah terputus...');
            }
            return;
        }

        if (fase === 'tanya') {
            berlaluMs += dt;
            const detik = berlaluMs / 1000;
            pemain.forEach((p) => {
                if (p.bot && p.jawab === null && detik >= p.rencanaDetik) jawabkan(p, p.rencanaPilih, detik);
            });
            tampilWaktu();
            if (pemain.every((p) => p.keluar || p.jawab !== null) || berlaluMs >= WAKTU_SOAL * 1000) ungkap();
        } else {
            tungguMs += dt;
            if (tungguMs >= JEDA_JAWABAN) soalBerikut();
        }
        if (mode === 'host' && sekarang - terakhirKirim > 1000) siarkan();   // denyut tiap 1 detik
    }, 100);

    // ---------- 7. Menjawab (klik atau keyboard) ----------
    const kamuJawab = (i) => {
        if (selesai || jeda || !mulai || fase !== 'tanya' || kamu.jawab !== null) return;
        if (!soalIni || i < 0 || i >= soalIni.opsi.length) return;

        if (mode === 'tamu') {
            if (!kanalSiap) return;
            jawabkan(kamu, i, berlaluMs / 1000);   // hanya mengunci tampilan; tuan rumah yang menghitung poin
            try { kanal.trigger('client-jawab', { soal: nomor, pilih: i, dari: saya }); } catch (e) { /* abaikan */ }
            return;
        }
        jawabkan(kamu, i, berlaluMs / 1000);
    };

    elPilihan.addEventListener('click', (e) => {
        const el = e.target.closest('.pilihan');
        if (el) kamuJawab(+el.dataset.i);
    });

    document.addEventListener('keydown', (e) => {
        if (e.ctrlKey || e.metaKey || e.altKey) return;
        const k = e.key.toLowerCase();
        const i = ['a', 'b', 'c', 'd'].indexOf(k) >= 0 ? ['a', 'b', 'c', 'd'].indexOf(k) : ['1', '2', '3', '4'].indexOf(k);
        if (i >= 0) kamuJawab(i);
    });

    // ---------- 8. Selesai ----------
    const akhiri = () => {
        if (selesai) return;
        selesai = true;
        siarkan();
        setTimeout(siarkan, 400);   // kirim sekali lagi, jaga-jaga ada tamu yang terlewat
        clearInterval(detak);
        tampilStatus('Permainan selesai. Membuka rekap...');

        // Soal yang terlewat (khusus tamu yang sempat terputus) diisi pengganti agar rekap tidak error
        const kosongSoal = { kategori: 'Budaya', pertanyaan: '(soal ini terlewat)', opsi: ['-', '-', '-', '-'], benar: 0, penjelasan: '' };
        const sumberSoal = mode === 'tamu' ? soalTamu : SOAL;
        const daftarSoal = Array.from({ length: totalSoal }, (_, i) => sumberSoal[i] || kosongSoal);
        const daftarJawaban = Array.from({ length: totalSoal }, (_, i) =>
            rekam[i] || pemain.map(() => ({ pilih: null, detik: null, poin: 0 })));

        // Urutkan dari skor tertinggi, lalu dari jumlah benar terbanyak
        const urut = [...pemain].filter((p) => !p.keluar).sort((a, b) => (b.skor - a.skor) || (b.benar - a.benar));
        const hasil = {
            mode: mode,           // 'solo', 'host', atau 'tamu'
            ruang: KODE_RUANG,    // kode ruangan (kosong kalau main sendiri)
            ronde: RONDE,         // penanda permainan yang baru selesai
            totalSoal: totalSoal,
            waktuSoal: WAKTU_SOAL,
            poinDasar: POIN_DASAR,
            soal: daftarSoal,        // kategori, pertanyaan, opsi, benar, penjelasan
            jawaban: daftarJawaban,  // jawaban[soal][nomor pemain] = { pilih, detik, poin }
            pemain: urut.map((p) => ({
                nama: p.nama,
                avatar: p.avatar,
                kamu: p.kamu,
                bot: p.bot,
                warna: p.warna,
                skor: p.skor,
                benar: p.benar,
                bonus: p.bonus,
                nomor: p.nomor,   // nomor asli, untuk mencocokkan dengan "jawaban"
            })),
        };
        try { sessionStorage.setItem('musiverse_hasil_quiz', JSON.stringify(hasil)); } catch (e) { /* abaikan */ }

        // Jeda sebentar, lalu pindah ke halaman rekap
        setTimeout(() => { location.href = arena.dataset.rekap; }, 900);
    };

    // ---------- 9. Tombol keluar ----------
    arena.querySelector('[data-buka-keluar]').addEventListener('click', () => {
        if (selesai) { location.href = arena.dataset.keluar; return; }
        if (mode === 'solo') jeda = true;   // main bersama tidak bisa dijeda
        dialogKeluar.showModal();
    });
    dialogKeluar.querySelector('[data-tutup-dialog]').addEventListener('click', () => dialogKeluar.close());
    dialogKeluar.addEventListener('close', () => { jeda = false; });

    // Tombol "Keluar" di popup: main bersama -> keluar dari ruangan dulu (supaya hilang di layar pemain lain)
    dialogKeluar.querySelector('[data-keluar-link]')?.addEventListener('click', (e) => {
        if (!KODE_RUANG) return;   // main sendiri: link biasa
        e.preventDefault();
        RuangSesi.keluar(arena.dataset.urlKeluar, KODE_RUANG, arena.dataset.keluar);
    });
    dialogKeluar.addEventListener('click', (e) => { if (e.target === dialogKeluar) dialogKeluar.close(); });

    // ---------- Mulai ----------
    if (mode === 'solo') {
        mulai = true;
        mulaiSoal();
    } else {
        tampilStatus('Bersiap...');
        sambung();
    }
})();