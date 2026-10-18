// =========================================================
// REKAP MUSIVERSE MATCH
// Membaca hasil permainan dari sessionStorage (disimpan oleh
// public/js/match.js saat permainan selesai), lalu mengisi
// halaman games/match-rekap.blade.php.
// =========================================================
(() => {
    const halaman = document.querySelector('[data-rekap]');
    if (!halaman) return;

    const $ = (selektor) => halaman.querySelector(selektor);
    const URL_AVATAR = halaman.dataset.avatarUrl;

    // Membuat elemen dengan aman: nama pemain dimasukkan lewat textContent, bukan innerHTML
    const buat = (tag, kelas, teks) => {
        const el = document.createElement(tag);
        if (kelas) el.className = kelas;
        if (teks !== undefined) el.textContent = teks;
        return el;
    };
    const desimal = (n) => n.toFixed(1).replace('.', ',');

    // ---------- 1. Ambil data hasil permainan ----------
    let hasil = null;
    try { hasil = JSON.parse(sessionStorage.getItem('musiverse_hasil_match')); } catch (e) { hasil = null; }

    const ada = hasil && Array.isArray(hasil.pemain) && hasil.pemain.length > 0;
    $('[data-kosong]').hidden = ada;
    $('[data-isi]').hidden = !ada;
    if (!ada) return;
    
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

    const daftar = hasil.pemain;                       // sudah urut dari skor tertinggi
    const kartu = Array.isArray(hasil.kartu) ? hasil.kartu : [];
    const penemu = hasil.penemu || {};
    const totalPasang = hasil.totalPasang || kartu.length || 32;
    const kamu = daftar.find((p) => p.kamu) || daftar[0];
    const tertinggi = Math.max(...daftar.map((p) => p.skor));
    const juara = daftar.filter((p) => p.skor === tertinggi);

    // Peringkat: skor yang sama mendapat nomor yang sama
    const peringkatDari = (p) => 1 + daftar.filter((q) => q.skor > p.skor).length;

    // ---------- 2. Kartu ringkasan ----------
    const ucapan = $('[data-ucapan]');
    if (tertinggi === 0) {
        ucapan.textContent = 'Belum Ada Pemenang';
    } else if (juara.length > 1) {
        ucapan.textContent = 'Hasil Seri!';
    } else if (juara[0].kamu) {
        ucapan.textContent = 'Kamu Menang!';
        ucapan.classList.add('is-menang');
    } else {
        ucapan.textContent = `${juara[0].nama} Menang!`;
    }
    $('[data-alasan]').textContent = hasil.alasan || '';
    $('[data-peringkat-kamu]').textContent = `${peringkatDari(kamu)}/${daftar.length}`;
    $('[data-pasang-kamu]').textContent = kamu.skor;

    const avatar = $('[data-avatar-kamu]');
    avatar.src = `${URL_AVATAR}/${kamu.avatar}.svg`;
    avatar.onerror = () => { avatar.hidden = true; };

    // ---------- 3. Bar persentase ----------
    const persen = Math.round((kamu.skor / totalPasang) * 100);
    const ditemukanSemua = Object.keys(penemu).length;
    $('[data-bar-label]').textContent = `${persen}%`;
    $('[data-bar-catatan]').textContent = kamu.skor === 0
        ? 'Belum ada pasangan yang kamu temukan. Ingat posisi kartu yang sudah terbuka, ya.'
        : `Kamu menemukan ${kamu.skor} dari ${totalPasang} pasangan. Bersama pemain lain: ${ditemukanSemua} pasangan.`;
    // Diisi sedikit terlambat supaya bar terlihat "mengisi"
    const bar = $('[data-bar]').parentElement;
    setTimeout(() => bar.style.setProperty('--persen', `${persen}%`), 350);

    // ---------- 4. Statistik performa (milik kamu) ----------
    $('[data-total-tebakan]').textContent = `${kamu.tebakan || 0} tebakan`;
    $('[data-stat-benar]').textContent = kamu.skor;
    $('[data-stat-salah]').textContent = kamu.meleset || 0;
    $('[data-stat-waktu]').textContent = desimal(kamu.rataDetik || 0);
    $('[data-stat-runtun]').textContent = kamu.rangkaianTerbaik || 0;

    // ---------- 5. Peringkat semua pemain ----------
    const olPeringkat = $('[data-peringkat]');
    daftar.forEach((p) => {
        const li = buat('li', 'rekap-pemain');
        if (p.kamu) li.classList.add('is-kamu');
        if (tertinggi > 0 && p.skor === tertinggi) li.classList.add('is-juara');
        li.style.setProperty('--warna', p.warna);

        const gambar = buat('img');
        gambar.src = `${URL_AVATAR}/${p.avatar}.svg`;
        gambar.alt = '';

        li.append(
            buat('span', 'rekap-pemain__no', peringkatDari(p)),
            gambar,
            buat('span', 'rekap-pemain__nama', p.kamu ? `${p.nama} (Kamu)` : p.nama),
            buat('span', 'rekap-pemain__skor', `${p.skor} pasang`)
        );
        olPeringkat.appendChild(li);
    });

    // ---------- 6. Review: semua pasangan dan penemunya ----------
    const pemainDariNomor = new Map(daftar.map((p) => [p.nomor, p]));

    // Yang sudah ditemukan diurutkan menurut waktu temu, yang belum ditemukan di bagian akhir
    const urutan = (k) => (penemu[k.id] ? penemu[k.id].urutan : Infinity);
    const kartuUrut = [...kartu].sort((a, b) => urutan(a) - urutan(b));

    const ulReview = $('[data-review]');
    ulReview.classList.add('rekap-review--detail');
    kartuUrut.forEach((k) => {
        const temu = penemu[k.id];
        const pemainTemu = temu ? pemainDariNomor.get(temu.pemain) : null;

        const li = buat('li', 'rekap-item rekap-item--detail');
        const gambar = buat('img');
        gambar.src = k.gambar;
        gambar.alt = '';
        gambar.loading = 'lazy';

        const teks = buat('div');
        teks.append(buat('p', 'rekap-item__nama', k.nama));
        if (k.kategori) teks.append(buat('span', 'rekap-item__kategori', k.kategori));

        if (temu && pemainTemu) {
            li.style.setProperty('--warna', pemainTemu.warna);
            const nama = pemainTemu.kamu ? `${pemainTemu.nama} (Kamu)` : pemainTemu.nama;
            teks.append(buat('p', 'rekap-item__info', `Ditemukan oleh ${nama}, pasangan ke-${temu.urutan}`));
        } else {
            li.classList.add('is-hilang');
            teks.append(buat('p', 'rekap-item__info', 'Belum ditemukan'));
        }

        if (k.penjelasan) teks.append(buat('p', 'rekap-item__penjelasan', k.penjelasan));

        li.append(gambar, teks);
        ulReview.appendChild(li);
    });
    $('[data-total-review]').textContent = `${ditemukanSemua} dari ${totalPasang} ditemukan`;
})();