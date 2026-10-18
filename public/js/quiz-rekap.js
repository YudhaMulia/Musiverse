// =========================================================
// MUSIVERSE QUIZ - halaman rekap
// Membaca hasil permainan dari sessionStorage ('musiverse_hasil_quiz',
// disimpan oleh quiz.js), lalu mengisi halaman rekap.
// =========================================================
(() => {
    const root = document.querySelector('[data-rekap]');
    if (!root) return;

    const URL_AVATAR = root.dataset.avatarUrl;
    const HURUF = ['A', 'B', 'C', 'D'];
    const $ = (s) => root.querySelector(s);

    // Buat elemen dengan aman (teks lewat textContent, bukan innerHTML)
    const el = (tag, kelas, teks) => {
        const e = document.createElement(tag);
        if (kelas) e.className = kelas;
        if (teks !== undefined) e.textContent = teks;
        return e;
    };
    const koma = (n, desimal = 1) => n.toFixed(desimal).replace('.', ',');

    // ---------- Ambil hasil permainan ----------
    let hasil = null;
    try { hasil = JSON.parse(sessionStorage.getItem('musiverse_hasil_quiz')); } catch (e) { hasil = null; }

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

    // ---------- Hitung statistik milikmu dari catatan jawaban ----------
    let benar = 0, salah = 0, jumlahJawab = 0, totalDetik = 0, rangkaian = 0, rangkaianTerbaik = 0;
    const perKategori = {};
    for (let i = 0; i < total; i++) {
        const s = hasil.soal[i];
        const j = hasil.jawaban[i][kamu.nomor] || { pilih: null };
        const kat = s.kategori || 'Budaya';
        perKategori[kat] = perKategori[kat] || { benar: 0, total: 0 };
        perKategori[kat].total++;

        if (j.pilih !== null) { jumlahJawab++; totalDetik += j.detik; }
        if (j.pilih === s.benar) {
            benar++; rangkaian++;
            rangkaianTerbaik = Math.max(rangkaianTerbaik, rangkaian);
            perKategori[kat].benar++;
        } else {
            salah++; rangkaian = 0;
        }
    }
    const persen = total ? Math.round((benar / total) * 100) : 0;
    const rataDetik = jumlahJawab ? totalDetik / jumlahJawab : 0;

    // ---------- 1. Ringkasan ----------
    $('[data-ucapan]').textContent = posisi === 1 ? 'Kamu Juara 1!' : `Kamu di Peringkat ${posisi}`;
    $('[data-alasan]').textContent = `${benar} dari ${total} soal kamu jawab dengan benar.`;
    $('[data-peringkat-kamu]').textContent = `${posisi}/${hasil.pemain.length}`;
    $('[data-poin-kamu]').textContent = kamu.skor;
    $('[data-avatar-kamu]').src = `${URL_AVATAR}/${kamu.avatar}.svg`;

    // ---------- 2. Bar nilai ----------
    $('[data-bar]').style.width = `${persen}%`;
    $('[data-bar-label]').textContent = `${persen}%`;
    $('[data-bar-catatan]').textContent =
        persen >= 80 ? 'Luar biasa! Kamu benar-benar paham budaya Palembang.'
        : persen >= 50 ? 'Bagus! Sedikit lagi kamu jadi ahli budaya Palembang.'
        : 'Jangan menyerah! Baca penjelasan di bawah, lalu coba lagi.';

    // ---------- 3. Statistik ----------
    $('[data-total-soal]').textContent = `${total} soal`;
    $('[data-stat-benar]').textContent = benar;
    $('[data-stat-salah]').textContent = salah;
    $('[data-stat-waktu]').textContent = koma(rataDetik);
    $('[data-stat-runtun]').textContent = rangkaianTerbaik;
    const poinDasar = (hasil.poinDasar || 100) * benar;
    $('[data-rincian-poin]').textContent =
        `Rincian poin: ${poinDasar} dari jawaban benar + ${kamu.bonus || 0} bonus kecepatan = ${kamu.skor} poin.`;

    // ---------- 4. Peringkat semua pemain ----------
    const daftarPeringkat = $('[data-peringkat]');
    hasil.pemain.forEach((p, i) => {
        const li = el('li', 'kr-pemain' + (p.kamu ? ' kr-pemain--kamu' : '') + (i === 0 ? ' kr-pemain--juara' : ''));
        li.style.setProperty('--warna', p.warna || '#D4AF37');
        const img = el('img');
        img.src = `${URL_AVATAR}/${p.avatar}.svg`;
        img.alt = '';
        const teks = el('div', 'kr-pemain__teks');
        teks.append(el('p', 'kr-pemain__nama', p.kamu ? `${p.nama} (Kamu)` : p.nama),
                    el('span', 'kr-pemain__sub', `${p.benar} benar dari ${total} soal`));
        li.append(el('span', 'kr-pemain__no', i + 1), img, teks, el('span', 'kr-pemain__poin', `${p.skor} poin`));
        daftarPeringkat.appendChild(li);
    });

    // ---------- 5. Per kategori ----------
    const daftarKategori = $('[data-kategori]');
    Object.entries(perKategori)
        .sort((a, b) => (b[1].benar / b[1].total) - (a[1].benar / a[1].total))
        .forEach(([nama, v]) => {
            const li = el('li', 'kr-kat');
            const atas = el('div', 'kr-kat__atas');
            atas.append(el('span', 'kr-kat__nama', nama), el('span', 'kr-kat__nilai', `${v.benar}/${v.total}`));
            const batang = el('div', 'kr-batang');
            const isiBatang = el('span');
            isiBatang.style.width = `${(v.benar / v.total) * 100}%`;
            batang.appendChild(isiBatang);
            li.append(atas, batang);
            daftarKategori.appendChild(li);
        });

    // ---------- 6. Review soal ----------
    const daftarReview = $('[data-review]');
    for (let i = 0; i < total; i++) {
        const s = hasil.soal[i];
        const j = hasil.jawaban[i][kamu.nomor] || { pilih: null, detik: null, poin: 0 };
        const status = j.pilih === null ? 'habis' : j.pilih === s.benar ? 'benar' : 'salah';
        const labelStatus = { benar: 'Benar', salah: 'Salah', habis: 'Waktu habis' }[status];

        const d = el('details', `kr-soal kr-soal--${status}`);
        const ringkas = el('summary', 'kr-soal__ringkas');
        ringkas.append(el('span', 'kr-soal__no', i + 1),
                       el('span', 'kr-soal__tanya', s.pertanyaan),
                       el('span', `kr-status kr-status--${status}`, labelStatus));
        d.appendChild(ringkas);

        const isiSoal = el('div', 'kr-soal__isi');

        const opsi = el('ul', 'kr-opsi');
        s.opsi.forEach((teks, k) => {
            const li = el('li', 'kr-opsi__item'
                + (k === s.benar ? ' is-benar' : '')
                + (k === j.pilih && k !== s.benar ? ' is-salah' : ''));
            li.append(el('b', '', HURUF[k]), el('span', '', teks));
            if (k === s.benar) li.appendChild(el('em', '', 'Jawaban benar'));
            else if (k === j.pilih) li.appendChild(el('em', '', 'Jawabanmu'));
            opsi.appendChild(li);
        });
        isiSoal.appendChild(opsi);

        const info = j.pilih === null
            ? 'Kamu tidak sempat menjawab soal ini.'
            : `Kamu menjawab dalam ${koma(j.detik)} detik${j.poin ? ` dan mendapat +${j.poin} poin` : ''}.`;
        isiSoal.appendChild(el('p', 'kr-soal__info', info));
        if (s.penjelasan) isiSoal.appendChild(el('p', 'kr-penjelasan', s.penjelasan));

        // Pilihan semua pemain (berguna saat main bersama)
        if (hasil.pemain.length > 1) {
            const lain = el('div', 'kr-lain');
            hasil.pemain.forEach((p) => {
                const jp = hasil.jawaban[i][p.nomor] || { pilih: null };
                const ok = jp.pilih === s.benar;
                const chip = el('span', 'kr-lain__chip' + (ok ? ' is-benar' : ''));
                chip.style.setProperty('--warna', p.warna || '#D4AF37');
                const img = el('img');
                img.src = `${URL_AVATAR}/${p.avatar}.svg`;
                img.alt = '';
                chip.append(img, el('span', '', jp.pilih === null ? '-' : HURUF[jp.pilih]));
                chip.title = `${p.nama}: ${jp.pilih === null ? 'tidak menjawab' : HURUF[jp.pilih]}`;
                lain.appendChild(chip);
            });
            isiSoal.appendChild(lain);
        }

        d.appendChild(isiSoal);
        daftarReview.appendChild(d);
    }

    // Saring: hanya tampilkan yang salah / habis waktu
    $('[data-hanya-salah]').addEventListener('change', (e) => {
        daftarReview.querySelectorAll('.kr-soal--benar').forEach((d) => { d.hidden = e.target.checked; });
    });
})();