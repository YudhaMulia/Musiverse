// =========================================================
// MUSIVERSE MATCH - logika permainan
// Aturan: buka 2 kartu. Cocok = +1 pasang dan main lagi.
// Tidak cocok / waktu giliran habis = giliran pindah.
//
// Ada 3 mode:
//   solo : kamu lawan bot. Semua dijalankan di browsermu sendiri.
//   host : tuan rumah. Browsernya menjalankan SEMUA aturan (kartu, giliran,
//          waktu, bot), lalu mengirim "keadaan" permainan ke pemain lain
//          lewat Pusher.
//   tamu : pemain lain. Hanya menampilkan keadaan dari tuan rumah, dan
//          mengirim nomor kartu yang diklik saat gilirannya.
// =========================================================
(() => {
    const arena = document.querySelector('[data-match]');
    if (!arena) return;

    // ---------- Pengaturan ----------
    const WAKTU_GILIRAN = 15;        // detik per giliran
    const WAKTU_TOTAL = 10 * 60;     // detik untuk seluruh permainan
    const INGATAN_BOT = 0.75;        // peluang bot mengingat kartu yang pernah terbuka
    const WARNA = ['#e9c349', '#e0566a', '#5fb3a1', '#8fa8e8'];
    const JUMLAH_PASANG = 18;
    const TUNGGU_TAMU = 12000;       // ms: tuan rumah menunggu tamu siap, lalu mulai

    const KARTU = JSON.parse(document.getElementById('data-kartu').textContent);
    const URL_AVATAR = arena.dataset.avatarUrl;
    const GAMBAR_BELAKANG = arena.dataset.belakang;
    const CSRF = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

    const papan = arena.querySelector('[data-papan]');
    const teksStatus = arena.querySelector('[data-status]');
    const teksWaktu = arena.querySelector('[data-waktu]');
    const jam = arena.querySelector('[data-jam]');
    const sorotan = arena.querySelector('[data-sorotan]');
    const dialogKeluar = document.getElementById('dialog-keluar');
    const dialogHasil = document.getElementById('dialog-hasil');

    const ambil = (k, tempat = localStorage) => { try { return tempat.getItem(k); } catch (e) { return null; } };
    const acak = (arr) => {
        for (let i = arr.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [arr[i], arr[j]] = [arr[j], arr[i]];
        }
        return arr;
    };
    const acakSatu = (arr) => arr.length ? arr[Math.floor(Math.random() * arr.length)] : undefined;
    const kartuDariId = (id) => KARTU.find((k) => k.id === id);

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
    if (!Array.isArray(daftar) || daftar.length < 2) {
        const avatarku = parseInt(ambil('musiverse_karakter'), 10) || 1;
        daftar = [
            { nama: arena.dataset.nama, avatar: avatarku, kamu: true },
            { nama: 'Bot Ampera', avatar: avatarku === 3 ? 4 : 3, bot: true },
        ];
    }

    let mode = 'solo';
    if (KODE_RUANG && window.Pusher && arena.dataset.pusherKey
        && daftar.some((p) => p.kamu) && adaManusiaLain(daftar)) {
        mode = daftar[0].kamu ? 'host' : 'tamu';
    }

    // Urutan pemain (nomor) sama di semua browser, supaya "giliran" cocok di semua layar
    const pemain = daftar.slice(0, 4).map((p, i) => ({
        nomor: i,
        id: p.id,          // id baris room_players (dipakai RuangSesi untuk mengenali siapa yang keluar)
        keluar: false,     // true kalau pemain ini sudah keluar dari ruangan
        nama: String(p.nama || `Pemain ${i + 1}`),
        avatar: p.avatar,
        kamu: !!p.kamu,
        bot: !!p.bot || (mode === 'solo' && !p.kamu),   // mode solo: pemain lain dijalankan bot
        skor: 0,
        tebakan: 0,            // berapa kali membuka 2 kartu
        meleset: 0,            // tebakan yang salah
        totalDetik: 0,         // total waktu berpikir (untuk rata-rata)
        rangkaian: 0,          // pasangan benar berturut-turut saat ini
        rangkaianTerbaik: 0,   // rekor rangkaian
        warna: WARNA[i],
        ingatan: new Map(),   // khusus bot: nomor kartu -> id gambar
    }));
    const saya = Math.max(0, pemain.findIndex((p) => p.kamu));   // nomorku

    // Kamu selalu di bawah. Pemain lain disebar ke atas/kiri/kanan sesuai urutan setelahmu.
    const susunanKursi = { 2: ['atas'], 3: ['kiri', 'kanan'], 4: ['kiri', 'atas', 'kanan'] }[pemain.length];
    const KELILING = 2 * Math.PI * 46;

    pemain.forEach((p, i) => {
        const urutanDariKamu = (i - saya + pemain.length) % pemain.length;
        const posisi = urutanDariKamu === 0 ? 'bawah' : susunanKursi[urutanDariKamu - 1];
        const kursi = arena.querySelector(`[data-kursi="${posisi}"]`);
        const el = document.createElement('div');
        el.className = 'pemain' + (p.kamu ? ' pemain--kamu' : '');
        el.style.setProperty('--warna', p.warna);
        el.innerHTML = `
            <div class="pemain__foto">
                <svg class="pemain__cincin" viewBox="0 0 100 100" aria-hidden="true">
                    <circle class="pemain__cincin-latar" cx="50" cy="50" r="46"/>
                    <circle class="pemain__cincin-sisa" cx="50" cy="50" r="46"
                            stroke-dasharray="${KELILING}" stroke-dashoffset="0"/>
                </svg>
                <img src="${URL_AVATAR}/${p.avatar}.svg" alt="">
                <span class="pemain__detik" data-detik></span>
            </div>
            <div class="pemain__info">
                <p class="pemain__nama"></p>
                <p class="pemain__skor"><b data-skor>0</b> pasang</p>
            </div>`;
        el.querySelector('.pemain__nama').textContent = p.kamu ? `${p.nama} (Kamu)` : p.nama;
        kursi.appendChild(el);
        p.el = el;
        p.cincin = el.querySelector('.pemain__cincin-sisa');
        p.detik = el.querySelector('[data-detik]');
    });

    // ---------- Simpanan (supaya refresh tidak mengulang permainan) ----------
    const KUNCI_SIMPAN = `musiverse_match_${KODE_RUANG || 'solo'}_${RONDE}`;
    const simpan = (isi) => { try { sessionStorage.setItem(KUNCI_SIMPAN, JSON.stringify(isi)); } catch (e) { /* abaikan */ } };
    const hapusSimpanan = () => { try { sessionStorage.removeItem(KUNCI_SIMPAN); } catch (e) { /* abaikan */ } };
    let simpanan = null;
    try { simpanan = JSON.parse(sessionStorage.getItem(KUNCI_SIMPAN)); } catch (e) { simpanan = null; }

    // ---------- 2. Kartu ----------
    // Solo/host: 18 pasang dipilih acak dari 32, lalu diacak posisinya.
    // Tamu: menunggu susunan kartu dari tuan rumah (supaya semua orang melihat susunan yang sama).
    let dek = [];          // isi kartu per posisi
    let kartuEl = [];      // tombol kartu di layar
    let kartuMain = [];    // 18 kartu yang dimainkan (untuk halaman rekap)

    const bangunPapan = (isiDek) => {
        dek = isiDek;
        kartuMain = [...new Set(dek.map((k) => k.id))].map(kartuDariId);
        papan.innerHTML = '';
        kartuEl = dek.map((k, i) => {
            const b = document.createElement('button');
            b.type = 'button';
            b.className = 'kartu';
            b.dataset.i = i;
            b.setAttribute('aria-label', 'Kartu tertutup');
            b.innerHTML = `
                <span class="kartu__dalam">
                    <span class="kartu__muka kartu__belakang"><img src="${GAMBAR_BELAKANG}" alt="" draggable="false"></span>
                    <span class="kartu__muka kartu__depan"><img src="${k.gambar}" alt="" draggable="false"></span>
                </span>`;
            b.style.animationDelay = `${(i % 6 + Math.floor(i / 6)) * 25}ms`;
            papan.appendChild(b);
            return b;
        });
    };

    let dipulihkan = false;   // true kalau halaman di-refresh dan permainan dilanjutkan
    if (mode !== 'tamu') {
        // Main sendiri maupun tuan rumah sama-sama bisa melanjutkan permainan setelah refresh
        const lama = (simpanan && simpanan.host && !simpanan.selesai
            && Array.isArray(simpanan.dek) && simpanan.dek.every((id) => kartuDariId(id))) ? simpanan : null;
        if (lama) {
            bangunPapan(lama.dek.map((id) => ({ ...kartuDariId(id) })));
            dipulihkan = true;
        } else {
            const dipilih = acak([...KARTU]).slice(0, JUMLAH_PASANG);
            bangunPapan(acak([...dipilih, ...dipilih].map((k) => ({ ...k }))));
        }
    }

    // ---------- 3. Keadaan permainan ----------
    let giliran = 0;
    let terbuka = [];            // kartu yang sedang dibuka (maks. 2)
    const cocok = new Set();     // kartu yang sudah ditemukan pasangannya
    let terkunci = false;        // sedang menunggu animasi
    let selesai = false;
    let alasanSelesai = '';
    let jeda = false;            // popup keluar sedang terbuka (hanya mode solo)
    let salahAktif = false;      // kartu sedang bergoyang karena salah
    let sisaGiliran = WAKTU_GILIRAN;
    let sisaTotal = WAKTU_TOTAL;
    let token = 0;               // penanda giliran (agar langkah bot lama dibatalkan); 0 = belum mulai
    const penemu = {};           // id pasangan -> { pemain: nomor pemain, urutan: ke berapa ditemukan }
    let urutanTemu = 0;

    const tunda = (ms) => new Promise((ok) => {
        const cek = () => (jeda ? setTimeout(cek, 200) : ok());
        setTimeout(cek, ms);
    });

    // ---------- 4. Tampilan ----------
    const formatWaktu = (d) => {
        const s = Math.max(0, Math.ceil(d));
        return `${String(Math.floor(s / 60)).padStart(2, '0')}:${String(s % 60).padStart(2, '0')}`;
    };

    const tampilGiliran = () => {
        const p = pemain[giliran];
        pemain.forEach((q, i) => q.el.classList.toggle('is-giliran', i === giliran));
        papan.classList.toggle('is-giliranku', p.kamu);
        teksStatus.classList.toggle('is-kamu', p.kamu);
        teksStatus.textContent = p.kamu ? 'Giliranmu! Buka 2 kartu' : `Giliran ${p.nama}...`;
    };

    const tampilWaktu = () => {
        const p = pemain[giliran];
        const rasio = Math.max(0, sisaGiliran / WAKTU_GILIRAN);
        p.cincin.setAttribute('stroke-dashoffset', String(KELILING * (1 - rasio)));
        p.el.classList.toggle('is-mepet', sisaGiliran <= 5);
        p.detik.textContent = Math.ceil(Math.max(0, sisaGiliran));
        teksWaktu.textContent = formatWaktu(sisaTotal);
        jam.classList.toggle('is-kritis', sisaTotal <= 60);
    };

    const tampilSkor = () => pemain.forEach((p) => { p.el.querySelector('[data-skor]').textContent = p.skor; });

    let timerSorotan;
    const tampilSorotan = (kartu, p) => {
        sorotan.innerHTML = `<img src="${kartu.gambar}" alt=""><p><span></span> menemukan <b></b>!</p>`;
        sorotan.querySelector('span').textContent = p.kamu ? 'Kamu' : p.nama;
        sorotan.querySelector('b').textContent = kartu.nama;
        sorotan.hidden = false;
        sorotan.classList.remove('is-tampil');
        void sorotan.offsetWidth;            // ulang animasi
        sorotan.classList.add('is-tampil');
        clearTimeout(timerSorotan);
        timerSorotan = setTimeout(() => { sorotan.hidden = true; }, 2200);
    };

    // ---------- 5. Pusher: tuan rumah mengirim keadaan, tamu menerima ----------
    let kanal = null;            // channel Pusher ruangan ini
    let kanalSiap = false;       // true setelah berhasil masuk channel
    let versi = Date.now();      // nomor urut keadaan (berbasis waktu, jadi setelah refresh tetap lebih baru)
    let terakhirKirim = 0;

    // Foto seluruh permainan saat ini (ukurannya kecil, jauh di bawah batas 10 KB Pusher)
    const ambilKeadaan = () => ({
        v: ++versi,
        mulai: token > 0,
        dek: dek.map((k) => k.id),
        terbuka: [...terbuka],
        cocok: [...cocok],
        salah: salahAktif,
        giliran, sisaGiliran, sisaTotal, terkunci,
        urutanTemu, penemu,
        selesai, alasan: alasanSelesai,
        pemain: pemain.map((p) => [p.skor, p.tebakan, p.meleset, p.totalDetik, p.rangkaian, p.rangkaianTerbaik]),
    });

    const siarkan = () => {
        if (mode === 'tamu') return;
        const keadaan = ambilKeadaan();
        // Cadangan di browser: dipakai main sendiri maupun tuan rumah kalau halaman di-refresh
        simpan({ ...keadaan, host: true });
        terakhirKirim = performance.now();
        if (mode !== 'host' || !kanalSiap) return;
        try { kanal.trigger('client-keadaan', keadaan); } catch (e) { /* abaikan */ }
    };

    // --- sisi tamu: pasang keadaan dari tuan rumah ke layar ---
    let versiTerakhir = 0;
    let urutanTemuTampil = 0;
    let sudahTerima = false;
    let terakhirTerima = 0;

    const terapkan = (s) => {
        if (mode !== 'tamu' || !s || s.v <= versiTerakhir) return;   // pesan lama dibuang
        if (!Array.isArray(s.dek) || !s.dek.every((id) => kartuDariId(id))) return;

        // Bangun ulang papan kalau belum ada ATAU susunannya beda dari tuan rumah
        const beda = dek.length !== s.dek.length || dek.some((k, i) => k.id !== s.dek[i]);
        if (beda) {
            bangunPapan(s.dek.map((id) => ({ ...kartuDariId(id) })));
            urutanTemuTampil = s.urutanTemu || 0;   // jangan munculkan pemberitahuan pasangan lama
        }
        simpan(s);   // cadangan supaya refresh langsung bisa menggambar layar
        versiTerakhir = s.v;
        sudahTerima = true;
        terakhirTerima = performance.now();

        terbuka = s.terbuka;
        cocok.clear();
        s.cocok.forEach((i) => cocok.add(i));
        giliran = s.giliran;
        sisaGiliran = s.sisaGiliran;
        sisaTotal = s.sisaTotal;
        terkunci = s.terkunci;
        token = s.mulai ? 1 : 0;
        Object.keys(penemu).forEach((k) => delete penemu[k]);
        Object.assign(penemu, s.penemu);
        s.pemain.forEach((a, i) => {
            const p = pemain[i];
            if (p) [p.skor, p.tebakan, p.meleset, p.totalDetik, p.rangkaian, p.rangkaianTerbaik] = a;
        });

        kartuEl.forEach((el, i) => {
            const terlihat = cocok.has(i) || terbuka.includes(i);
            el.classList.toggle('is-terbuka', terlihat);
            el.classList.toggle('is-cocok', cocok.has(i));
            el.classList.toggle('is-salah', !!s.salah && terbuka.includes(i));
            el.disabled = cocok.has(i);
            el.setAttribute('aria-label', terlihat ? dek[i].nama : 'Kartu tertutup');
            if (cocok.has(i)) {
                const f = penemu[dek[i].id];
                if (f && pemain[f.pemain]) el.style.setProperty('--warna', pemain[f.pemain].warna);
            }
        });

        tampilSkor();

        // Ada pasangan baru ditemukan: tampilkan pemberitahuan
        if (s.urutanTemu > urutanTemuTampil) {
            urutanTemuTampil = s.urutanTemu;
            const baru = Object.entries(penemu).find(([, v]) => v.urutan === s.urutanTemu);
            if (baru && kartuDariId(Number(baru[0])) && pemain[baru[1].pemain]) {
                tampilSorotan(kartuDariId(Number(baru[0])), pemain[baru[1].pemain]);
            }
        }

        if (s.selesai) { akhiri(s.alasan); return; }
        if (s.mulai) { tampilGiliran(); tampilWaktu(); } else { teksStatus.textContent = 'Menunggu tuan rumah memulai...'; }
    };

    // --- sisi tuan rumah: menerima "siap" dan klik kartu dari tamu ---
    const siapTamu = new Set();
    let sudahMulai = false;
    let timerTunggu;

    const tamuManusia = pemain.filter((p) => !p.kamu && !p.bot);

    const mulaiPermainan = () => {
        if (sudahMulai) return;
        sudahMulai = true;
        clearTimeout(timerTunggu);
        setTimeout(lanjut, 900);   // beri jeda sampai animasi kartu muncul selesai
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

        // Tamu mengklik kartu saat gilirannya
        kanal.bind('client-buka', (d) => {
            const p = pemain[giliran];
            if (!d || !p || p.kamu || p.bot || p.nomor !== d.dari) return;   // bukan gilirannya
            if (selesai || terkunci || token === 0) return;
            const i = Number(d.kartu);
            if (!Number.isInteger(i) || i < 0 || i >= dek.length || cocok.has(i) || terbuka.includes(i)) return;
            buka(i);
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
                teksStatus.textContent = 'Gagal tersambung ke ruangan. Muat ulang halaman.';
            }
        });

        if (mode === 'host') {
            kanal.bind('pusher:subscription_succeeded', () => {
                kanalSiap = true;
                if (!dipulihkan) {
                    teksStatus.textContent = 'Menunggu pemain lain siap...';
                    timerTunggu = setTimeout(mulaiPermainan, TUNGGU_TAMU);
                }
                siarkan();
            });

            pasangPenangkap();
        } else {
            teksStatus.textContent = 'Menunggu tuan rumah...';
            let sudahLive = false;   // true setelah menerima keadaan langsung dari tuan rumah (bukan dari simpanan)
            kanal.bind('client-keadaan', (s) => { sudahLive = true; terapkan(s); });

            const kirimSiap = () => {
                    if (token > 0 && sudahLive) return;
                try { kanal.trigger('client-siap', { dari: saya }); } catch (e) { /* abaikan */ }
            };
            kanal.bind('pusher:subscription_succeeded', () => {
                kirimSiap();
                setInterval(kirimSiap, 1500);   // ulangi sampai keadaan pertama diterima
            });
        }
    };

    // ---------- Pemain keluar / tuan rumah berganti saat permainan berjalan ----------
    const pemainKeluar = (id) => {
        const p = pemain.find((x) => x.id === id);
        if (!p || p.keluar || p.kamu) return;
        p.keluar = true;
        p.el.remove();   // hilang dari tampilan
        if (mode === 'tamu' || selesai || token === 0) return;   // tamu menunggu keadaan baru dari tuan rumah

        // Gilirannya sedang berjalan: tutup kartunya dan pindahkan giliran.
        // (Kalau sedang ada animasi periksa kartu, animasinya sendiri yang memindahkan giliran.)
        if (pemain[giliran] === p && !terkunci) {
            terbuka.forEach(tutup);
            terbuka = [];
            gantiGiliran();
        }
    };

    // Kamu naik jadi tuan rumah (tuan rumah lama keluar): ambil alih jalannya permainan
    const jadiTuanRumah = () => {
        if (mode !== 'tamu') return;
        mode = 'host';
        kanalSiap = true;               // di Match, tamu belum menandai channel siap; tuan rumah wajib
        versi = versiTerakhir + 1000;   // keadaan baru harus selalu "lebih baru" dari milik tuan rumah lama
        urutanTemu = urutanTemuTampil;  // lanjutkan penomoran pasangan yang sudah ditemukan
        pasangPenangkap();
        if (selesai) return;

        if (token === 0) {   // tuan rumah lama keluar sebelum permainan dimulai
            if (!dek.length) {
                const dipilih = acak([...KARTU]).slice(0, JUMLAH_PASANG);
                bangunPapan(acak([...dipilih, ...dipilih].map((k) => ({ ...k }))));
            }
            mulaiPermainan();
            return;
        }

        sudahMulai = true;
        // Tutup kartu yang sedang terbuka lalu lanjutkan giliran seperti biasa
        terbuka.forEach(tutup);
        terbuka = [];
        salahAktif = false;
        terkunci = false;
        kartuEl.forEach((el) => el.classList.remove('is-salah'));
        sisaGiliran = WAKTU_GILIRAN;
        lanjut();
    };

    // ---------- 6. Aturan (hanya dijalankan solo dan tuan rumah) ----------
    const tersedia = () => dek.map((_, i) => i).filter((i) => !cocok.has(i) && !terbuka.includes(i));

    const buka = (i) => {
        kartuEl[i].classList.add('is-terbuka');
        kartuEl[i].setAttribute('aria-label', dek[i].nama);
        terbuka.push(i);
        // semua bot "melihat" kartu ini (kadang lupa)
        pemain.forEach((p) => { if (p.bot && Math.random() < INGATAN_BOT) p.ingatan.set(i, dek[i].id); });
        if (terbuka.length === 2) periksa();
        siarkan();
    };

    const tutup = (i) => {
        kartuEl[i].classList.remove('is-terbuka');
        kartuEl[i].setAttribute('aria-label', 'Kartu tertutup');
    };

    const periksa = () => {
        terkunci = true;
        const [a, b] = terbuka;
        const p = pemain[giliran];

        // catat statistik: satu tebakan = satu kali membuka 2 kartu
        p.tebakan++;
        p.totalDetik += WAKTU_GILIRAN - sisaGiliran;   // lama berpikir sebelum membuka 2 kartu

        if (dek[a].id === dek[b].id) {
            // COCOK: tetap terbuka, skor +1, main lagi
            setTimeout(() => {
                [a, b].forEach((i) => {
                    cocok.add(i);
                    kartuEl[i].classList.add('is-cocok');
                    kartuEl[i].style.setProperty('--warna', p.warna);
                    kartuEl[i].disabled = true;
                    pemain.forEach((q) => q.ingatan.delete(i));
                });
                p.skor++;
                p.rangkaian++;
                p.rangkaianTerbaik = Math.max(p.rangkaianTerbaik, p.rangkaian);
                penemu[dek[a].id] = { pemain: pemain.indexOf(p), urutan: ++urutanTemu };
                terbuka = [];
                terkunci = false;
                tampilSkor();
                tampilSorotan(dek[a], p);
                if (cocok.size === dek.length) return akhiri('Semua pasangan sudah ditemukan!');
                sisaGiliran = WAKTU_GILIRAN;
                lanjut();
            }, 450);
        } else {
            // TIDAK COCOK: goyang, tutup lagi, giliran pindah
            p.meleset++;
            p.rangkaian = 0;
            setTimeout(() => {
                [a, b].forEach((i) => kartuEl[i].classList.add('is-salah'));
                salahAktif = true;
                siarkan();
            }, 450);
            setTimeout(() => {
                [a, b].forEach((i) => { kartuEl[i].classList.remove('is-salah'); tutup(i); });
                terbuka = [];
                salahAktif = false;
                terkunci = false;
                gantiGiliran();
            }, 1300);
        }
    };

    const gantiGiliran = () => {
        pemain[giliran].el.classList.remove('is-mepet');
        do { giliran = (giliran + 1) % pemain.length; } while (pemain[giliran].keluar);   // lewati yang sudah keluar
        sisaGiliran = WAKTU_GILIRAN;
        lanjut();
    };

    const lanjut = () => {
        if (pemain[giliran].keluar) { gantiGiliran(); return; }   // pemilik giliran sudah keluar: oper ke yang berikutnya
        token++;
        tampilGiliran();
        tampilWaktu();
        siarkan();
        if (pemain[giliran].bot) jalankanBot(token);
    };

    const waktuGiliranHabis = () => {
        if (terkunci) return;
        terbuka.forEach(tutup);
        terbuka = [];
        teksStatus.textContent = 'Waktu habis! Giliran pindah';
        pemain[giliran].rangkaian = 0;
        gantiGiliran();
    };

    // ---------- 7. Bot (hanya dijalankan solo dan tuan rumah) ----------
    const jalankanBot = async (tokenku) => {
        const bot = pemain[giliran];
        const batal = () => selesai || tokenku !== token;

        // cari pasangan yang sudah diketahui
        const pasanganDiketahui = () => {
            const lihat = new Map();
            for (const [i, id] of bot.ingatan) {
                if (cocok.has(i)) continue;
                if (lihat.has(id)) return [lihat.get(id), i];
                lihat.set(id, i);
            }
            return null;
        };
        const belumDikenal = () => tersedia().filter((i) => !bot.ingatan.has(i));

        await tunda(700 + Math.random() * 500);
        if (batal()) return;

        const pasangan = pasanganDiketahui();
        const pertama = pasangan ? pasangan[0] : (acakSatu(belumDikenal()) ?? acakSatu(tersedia()));
        if (pertama === undefined) return;
        buka(pertama);

        await tunda(700 + Math.random() * 400);
        if (batal()) return;

        let kedua;
        if (pasangan) {
            kedua = pasangan[1];
        } else {
            const idPertama = dek[pertama].id;
            const kenal = [...bot.ingatan].find(([i, id]) => id === idPertama && i !== pertama && !cocok.has(i));
            kedua = kenal ? kenal[0] : (acakSatu(belumDikenal()) ?? acakSatu(tersedia()));
        }
        if (kedua === undefined) return;
        buka(kedua);
    };

    // ---------- 8. Klik kartu ----------
    papan.addEventListener('click', (e) => {
        const el = e.target.closest('.kartu');
        if (!el || selesai || jeda || terkunci || !pemain[giliran].kamu) return;
        const i = +el.dataset.i;
        if (cocok.has(i) || terbuka.includes(i)) return;

        if (mode === 'tamu') {
            // Tamu tidak membuka kartu sendiri: kirim ke tuan rumah, layar berubah saat keadaan baru datang
            if (kanalSiap || sudahTerima) {
                try { kanal.trigger('client-buka', { kartu: i, dari: saya }); } catch (err) { /* abaikan */ }
            }
            return;
        }
        buka(i);
    });

    // ---------- 9. Waktu berjalan ----------
    // Memakai jam asli (bukan hitungan tiap 0,1 detik) supaya tidak melambat saat tab di latar belakang
    let terakhirDetak = performance.now();
    const detak = setInterval(() => {
        const sekarang = performance.now();
        const dt = Math.min(2, (sekarang - terakhirDetak) / 1000);
        terakhirDetak = sekarang;
        if (jeda || selesai || token === 0) return;   // token 0 = belum mulai

        sisaTotal -= dt;
        if (!terkunci) sisaGiliran -= dt;
        tampilWaktu();

        if (mode === 'tamu') {
            // Tamu hanya menghitung mundur untuk tampilan; keputusan ada di tuan rumah
            if (sudahTerima && sekarang - terakhirTerima > 10000) {
                teksStatus.textContent = 'Koneksi ke tuan rumah terputus...';
            }
            return;
        }

        if (sisaTotal <= 0) return akhiri('Waktu permainan habis!');
        if (sisaGiliran <= 0) waktuGiliranHabis();
        // Denyut tiap 1 detik: tuan rumah mengirim keadaan, main sendiri menyimpan cadangan
        if (mode !== 'tamu' && sekarang - terakhirKirim > 1000) siarkan();
    }, 100);

    // ---------- 10. Selesai ----------
    const akhiri = (alasan) => {
        if (selesai) return;
        selesai = true;
        alasanSelesai = alasan;
        siarkan();
        setTimeout(siarkan, 400);   // kirim sekali lagi, jaga-jaga ada tamu yang terlewat
        clearInterval(detak);
        pemain.forEach((p) => p.el.classList.remove('is-giliran', 'is-mepet'));
        papan.classList.remove('is-giliranku');
        teksStatus.textContent = 'Permainan selesai';

        // Urutkan dari skor tertinggi, lalu simpan untuk halaman rekap
        const urut = [...pemain].filter((p) => !p.keluar).sort((a, b) => b.skor - a.skor);
        const hasil = {
            mode: mode,           // 'solo', 'host', atau 'tamu'
            ruang: KODE_RUANG,    // kode ruangan (kosong kalau main sendiri)
            ronde: RONDE,         // penanda permainan yang baru selesai
            alasan: alasan,
            totalPasang: dek.length / 2,
            sisaWaktu: Math.max(0, sisaTotal),
            waktuTotal: WAKTU_TOTAL,
            kartu: kartuMain,    // 18 kartu yang dimainkan: id, nama, gambar
            penemu: penemu,      // siapa menemukan pasangan yang mana
            pemain: urut.map((p) => ({
                nama: p.nama,
                avatar: p.avatar,
                kamu: p.kamu,
                bot: p.bot,
                skor: p.skor,
                warna: p.warna,
                tebakan: p.tebakan,
                meleset: p.meleset,
                rataDetik: p.tebakan ? p.totalDetik / p.tebakan : 0,
                rangkaianTerbaik: p.rangkaianTerbaik,
                nomor: pemain.indexOf(p),   // nomor asli, untuk mencocokkan dengan "penemu"
            })),
        };
        try { sessionStorage.setItem('musiverse_hasil_match', JSON.stringify(hasil)); } catch (e) { /* abaikan */ }

        // Jeda sebentar agar pasangan terakhir sempat terlihat, lalu pindah halaman
        setTimeout(() => { location.href = arena.dataset.rekap; }, 900);
    };

    dialogHasil.querySelector('[data-main-lagi]').addEventListener('click', () => location.reload());
    dialogHasil.addEventListener('cancel', (e) => e.preventDefault());   // tidak bisa ditutup dengan Esc

    // ---------- 11. Tombol keluar ----------
    arena.querySelector('[data-buka-keluar]').addEventListener('click', () => {
        if (selesai) { location.href = arena.dataset.keluar; return; }
        if (mode === 'solo') jeda = true;   // main bersama tidak bisa dijeda
        dialogKeluar.showModal();
    });
    dialogKeluar.querySelector('[data-tutup-dialog]')?.addEventListener('click', () => dialogKeluar.close());
    dialogKeluar.querySelector('[data-main-lagi]')?.addEventListener('click', () => dialogKeluar.close());
    dialogKeluar.addEventListener('close', () => { jeda = false; });

    // Tombol "Keluar" di popup: main bersama -> keluar dari ruangan dulu (supaya hilang di layar pemain lain)
    dialogKeluar.querySelector('[data-keluar-link]')?.addEventListener('click', (e) => {
        hapusSimpanan();           // keluar = permainan berakhir, jangan dilanjutkan lagi
        if (!KODE_RUANG) return;   // main sendiri: link biasa
        e.preventDefault();
        RuangSesi.keluar(arena.dataset.urlKeluar, KODE_RUANG, arena.dataset.keluar);
    });
    dialogKeluar.addEventListener('click', (e) => { if (e.target === dialogKeluar) dialogKeluar.close(); });

    // Tamu: unduh semua gambar kartu selagi menunggu tuan rumah, supaya tidak hitam saat kartu muncul
    if (mode === 'tamu') {
        [GAMBAR_BELAKANG, ...KARTU.map((k) => k.gambar)].forEach((src) => { new Image().src = src; });
    }

    // ---------- Mulai ----------
    // Tuan rumah yang di-refresh: kembalikan skor, kartu yang cocok, dan giliran
    const pulihkanTuanRumah = (s) => {
        urutanTemu = s.urutanTemu || 0;
        Object.assign(penemu, s.penemu);
        s.pemain.forEach((a, i) => {
            const p = pemain[i];
            if (p) [p.skor, p.tebakan, p.meleset, p.totalDetik, p.rangkaian, p.rangkaianTerbaik] = a;
        });
        s.cocok.forEach((i) => {
            const el = kartuEl[i];
            if (!el) return;
            cocok.add(i);
            el.classList.add('is-terbuka', 'is-cocok');
            el.disabled = true;
            el.setAttribute('aria-label', dek[i].nama);
            const f = penemu[dek[i].id];
            if (f && pemain[f.pemain]) el.style.setProperty('--warna', pemain[f.pemain].warna);
        });
        giliran = pemain[s.giliran] ? s.giliran : 0;
        sisaTotal = s.sisaTotal;
        sisaGiliran = WAKTU_GILIRAN;   // kartu yang sedang terbuka ditutup, waktu giliran diulang
        sudahMulai = true;             // tidak perlu menunggu tamu lagi
    };
    if (dipulihkan) pulihkanTuanRumah(simpanan);

    // Tamu yang di-refresh: tampilkan keadaan terakhir dulu, yang terbaru menyusul lewat Pusher
    if (mode === 'tamu' && simpanan && !simpanan.host && !simpanan.selesai) terapkan(simpanan);

    tampilSkor();
    tampilGiliran();
    if (!dipulihkan && !sudahTerima) teksStatus.textContent = 'Bersiap...';
    if (mode === 'solo') mulaiPermainan();
    else sambung();
    if (dipulihkan) setTimeout(lanjut, 900);   // lanjutkan giliran setelah kartu selesai muncul
})();