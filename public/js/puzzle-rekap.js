// =========================================================
// MUSIVERSE PUZZLE - halaman rekap
// Membaca hasil permainan dari sessionStorage ('musiverse_hasil_puzzle',
// disimpan oleh puzzle.js), lalu mengisi halaman rekap.
//
// Bentuk data:
//   hasil.soal[i]    = { gambar, jawaban, penjelasan }
//   hasil.jawaban[i] = { jawaban, pemenang, poin, percobaan: [{ pemain, teks, benar }] }
//                      pemenang = nomor pemain yang benar (null = tidak ada)
//   hasil.pemain[k]  = { nama, avatar, kamu, bot, warna, skor, benar, bonus, nomor }
// =========================================================
(() => {
    const root = document.querySelector('[data-rekap]');
    if (!root) return;

    const URL_AVATAR = root.dataset.avatarUrl;
    const $ = (s) => root.querySelector(s);

    // Buat elemen dengan aman (teks lewat textContent, bukan innerHTML)
    const el = (tag, kelas, teks) => {
        const e = document.createElement(tag);
        if (kelas) e.className = kelas;
        if (teks !== undefined) e.textContent = teks;
        return e;
    };
    const avatar = (p, kelas) => {
        const img = el('img', kelas);
        img.src = `${URL_AVATAR}/${p.avatar}.svg`;
        img.alt = '';
        return img;
    };

    // ---------- Ambil hasil permainan ----------
    let hasil = null;
    try { hasil = JSON.parse(sessionStorage.getItem('musiverse_hasil_puzzle')); } catch (e) { hasil = null; }

    const kosong = $('[data-kosong]');
    const isi = $('[data-isi]');
    const sah = hasil && Array.isArray(hasil.pemain) && hasil.pemain.length
        && Array.isArray(hasil.soal) && Array.isArray(hasil.jawaban);
    if (!sah) return;                      // biarkan tampilan "Belum ada hasil permainan"
    kosong.hidden = true;
    isi.hidden = false;

    // ---------- Tombol "Main Lagi" ----------
    // Main sendiri: tetap main sendiri lagi (link bawaan).
    // Main bersama: kembali ke ruang tunggu yang berisi pemain-pemain tadi.
    const tombolUlang = $('[data-main-lagi]');
    if (tombolUlang && hasil.mode && hasil.mode !== 'solo' && hasil.ruang) {
        const alamat = tombolUlang.dataset.urlBersama.replace('__KODE__', encodeURIComponent(hasil.ruang));
        tombolUlang.href = `${alamat}?ronde=${encodeURIComponent(hasil.ronde || '')}`;
    }

    // ---------- Tombol "Kembali ke Games" ----------
    // Main bersama: keluar dulu dari ruangan (supaya hilang dari daftar pemain), baru pindah halaman.
    const tombolKembali = $('[data-kembali]');
    if (tombolKembali && hasil.mode && hasil.mode !== 'solo' && hasil.ruang) {
        tombolKembali.addEventListener('click', async (e) => {
            e.preventDefault();
            try {
                await fetch(tombolKembali.dataset.urlKeluar.replace('__KODE__', encodeURIComponent(hasil.ruang)), {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content ?? '',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    redirect: 'manual',
                });
            } catch (err) { /* abaikan, tetap kembali ke Games */ }
            location.href = tombolKembali.href;
        });
    }

    const kamu = hasil.pemain.find((p) => p.kamu) || hasil.pemain[0];
    const posisi = hasil.pemain.indexOf(kamu) + 1;
    const total = Math.min(hasil.soal.length, hasil.jawaban.length);
    const pemainNomor = (n) => hasil.pemain.find((p) => p.nomor === n);
    const sebut = (p) => (p.kamu ? 'Kamu' : p.nama);

    // ---------- Hitung statistik milikmu dari catatan tebakan ----------
    // status: benar | salah (kamu menebak tapi keliru) | direbut (lawan yang benar, kamu tidak menebak)
    //         | kosong (tidak ada yang benar dan kamu tidak menebak)
    const status = [];
    let benar = 0, salah = 0, lewat = 0, berhasilRebut = 0, rangkaian = 0, rangkaianTerbaik = 0;
    for (let i = 0; i < total; i++) {
        const j = hasil.jawaban[i];
        const tebakanKamu = (j.percobaan || []).some((c) => c.pemain === kamu.nomor);
        if (tebakanKamu) berhasilRebut++;

        let st;
        if (j.pemenang === kamu.nomor) st = 'benar';
        else if (tebakanKamu) st = 'salah';
        else if (j.pemenang !== null && j.pemenang !== undefined) st = 'direbut';
        else st = 'kosong';
        status.push(st);

        if (st === 'benar') {
            benar++; rangkaian++;
            rangkaianTerbaik = Math.max(rangkaianTerbaik, rangkaian);
        } else {
            rangkaian = 0;
            if (st === 'salah') salah++; else lewat++;
        }
    }
    const persen = total ? Math.round((benar / total) * 100) : 0;

    // ---------- 1. Ringkasan ----------
    $('[data-ucapan]').textContent = posisi === 1 ? 'Kamu Juara 1!' : `Kamu di Peringkat ${posisi}`;
    $('[data-alasan]').textContent = `${benar} dari ${total} gambar berhasil kamu tebak.`;
    $('[data-peringkat-kamu]').textContent = `${posisi}/${hasil.pemain.length}`;
    $('[data-poin-kamu]').textContent = kamu.skor;
    $('[data-avatar-kamu]').src = `${URL_AVATAR}/${kamu.avatar}.svg`;

    // ---------- 2. Bar nilai ----------
    $('[data-bar]').style.width = `${persen}%`;
    $('[data-bar-label]').textContent = `${persen}%`;
    $('[data-bar-catatan]').textContent =
        persen >= 80 ? 'Luar biasa! Matamu tajam dan kamu hafal budaya Palembang.'
        : persen >= 50 ? 'Bagus! Sedikit lagi kamu jadi ahli tebak budaya Palembang.'
        : 'Jangan menyerah! Baca penjelasan di bawah, lalu coba lagi.';

    // ---------- 3. Statistik ----------
    $('[data-total-soal]').textContent = `${total} gambar`;
    $('[data-stat-benar]').textContent = benar;
    $('[data-stat-salah]').textContent = salah;
    $('[data-stat-lewat]').textContent = lewat;
    $('[data-stat-runtun]').textContent = rangkaianTerbaik;
    const poinDasar = (hasil.poinBenar || 100) * benar;
    $('[data-rincian-poin]').textContent =
        `Kamu berhasil merebut tombol merah ${berhasilRebut} kali. `
        + `Rincian poin: ${poinDasar} dari tebakan benar + ${kamu.bonus || 0} bonus kecepatan = ${kamu.skor} poin.`;

    // ---------- 4. Peringkat semua pemain ----------
    const daftarPeringkat = $('[data-peringkat]');
    hasil.pemain.forEach((p, i) => {
        const li = el('li', 'pr-pemain' + (p.kamu ? ' pr-pemain--kamu' : '') + (i === 0 ? ' pr-pemain--juara' : ''));
        li.style.setProperty('--warna', p.warna || '#D4AF37');
        const teks = el('div', 'pr-pemain__teks');
        teks.append(el('p', 'pr-pemain__nama', p.kamu ? `${p.nama} (Kamu)` : p.nama),
                    el('span', 'pr-pemain__sub', `${p.benar} tebakan benar dari ${total} gambar`));
        li.append(el('span', 'pr-pemain__no', i + 1), avatar(p), teks, el('span', 'pr-pemain__poin', `${p.skor} poin`));
        daftarPeringkat.appendChild(li);
    });

    // ---------- 6. Review gambar + penjelasan ----------
    const daftarReview = $('[data-review]');
    const label = { benar: 'Benar', salah: 'Salah', direbut: 'Direbut lawan', kosong: 'Tidak terjawab' };

    for (let i = 0; i < total; i++) {
        const s = hasil.soal[i];
        const j = hasil.jawaban[i];
        const st = status[i];

        const d = el('details', `pr-soal pr-soal--${st}`);

        // Baris ringkas: gambar kecil, nomor, jawaban, status
        const ringkas = el('summary', 'pr-soal__ringkas');
        const mini = el('img', 'pr-soal__mini');
        mini.src = s.gambar;
        mini.alt = '';
        mini.loading = 'lazy';
        const judul = el('span', 'pr-soal__judul');
        judul.append(el('small', '', `Gambar ${i + 1}`), el('b', '', s.jawaban));
        ringkas.append(mini, judul, el('span', `pr-status pr-status--${st}`, label[st]));
        d.appendChild(ringkas);

        // Isi: gambar besar, penjelasan, riwayat tebakan
        const isiSoal = el('div', 'pr-soal__isi');

        const besar = el('img', 'pr-soal__besar');
        besar.src = s.gambar;
        besar.alt = s.jawaban;
        besar.loading = 'lazy';
        isiSoal.appendChild(besar);

        const jelas = el('div', 'pr-penjelasan');
        jelas.append(el('p', 'pr-penjelasan__judul', `Tentang ${s.jawaban}`),
                     el('p', 'pr-penjelasan__teks', s.penjelasan || 'Penjelasan untuk gambar ini belum tersedia.'));
        isiSoal.appendChild(jelas);

        const riwayat = el('div', 'pr-riwayat');
        riwayat.appendChild(el('p', 'pr-riwayat__judul', 'Riwayat tebakan'));
        const percobaan = j.percobaan || [];
        if (!percobaan.length) {
            riwayat.appendChild(el('p', 'pr-riwayat__kosong', 'Tidak ada yang menekan tombol merah.'));
        } else {
            const ul = el('ul', 'pr-riwayat__daftar');
            percobaan.forEach((c) => {
                const p = pemainNomor(c.pemain);
                if (!p) return;
                const li = el('li', 'pr-tebak' + (c.benar ? ' is-benar' : ' is-salah'));
                li.style.setProperty('--warna', p.warna || '#D4AF37');
                li.append(avatar(p),
                          el('span', 'pr-tebak__nama', sebut(p)),
                          el('span', 'pr-tebak__teks', c.teks ? c.teks : '(tidak sempat mengetik)'),
                          el('span', 'pr-tebak__tanda', c.benar ? '✓' : '✗'));
                ul.appendChild(li);
            });
            riwayat.appendChild(ul);
        }
        const juara = pemainNomor(j.pemenang);
        riwayat.appendChild(el('p', 'pr-riwayat__hasil', juara
            ? `${sebut(juara)} menjawab benar${j.poin ? ` dan mendapat +${j.poin} poin` : ''}.`
            : 'Tidak ada yang berhasil menebak gambar ini.'));
        isiSoal.appendChild(riwayat);

        d.appendChild(isiSoal);
        daftarReview.appendChild(d);
    }

    // Saring: hanya tampilkan yang belum benar
    $('[data-hanya-salah]').addEventListener('change', (e) => {
        daftarReview.querySelectorAll('.pr-soal--benar').forEach((d) => { d.hidden = e.target.checked; });
    });

    // Buka / tutup semua penjelasan sekaligus
    const tombolBuka = $('[data-buka-semua]');
    let terbuka = false;
    tombolBuka.addEventListener('click', () => {
        terbuka = !terbuka;
        daftarReview.querySelectorAll('details').forEach((d) => { d.open = terbuka; });
        tombolBuka.textContent = terbuka ? 'Tutup semua' : 'Buka semua';
    });
})();