// =========================================================
// MUSIVERSE - EMOTE (ruang tunggu & semua game mode main bersama)
//
// Cara pakai (dipanggil setelah channel Pusher dibuat):
//   Emote.pasang({ kanal, nama })
//     kanal : channel Pusher "private-ruang.KODE" (harus sudah subscribe)
//     nama  : nama pemain ini (teks), atau fungsi yang mengembalikan teks
//
// Emote dikirim lewat client event Pusher ("client-emote"), jadi tidak
// perlu tabel database maupun route baru. Gambar emote digambar sebagai
// SVG di file ini, jadi tidak perlu file gambar tambahan.
// =========================================================
window.Emote = (() => {
    const GARIS = '#3A0C0C';
    const KULIT = '#F2C48D';

    // ---------- Gambar ----------
    const badan = `
        <circle cx="14" cy="39" r="3.2" fill="${KULIT}" stroke="${GARIS}" stroke-width="1.8"/>
        <circle cx="50" cy="39" r="3.2" fill="${KULIT}" stroke="${GARIS}" stroke-width="1.8"/>
        <path d="M8 64 Q9 52 32 52 Q55 52 56 64Z" fill="#8B1E2D" stroke="${GARIS}" stroke-width="2" stroke-linejoin="round"/>
        <path d="M21 53 Q32 61 43 53" fill="none" stroke="#D4AF37" stroke-width="3" stroke-linecap="round"/>
        <path d="M14 60l2.5 2.5-2.5 2.5-2.5-2.5zM50 60l2.5 2.5-2.5 2.5-2.5-2.5z" fill="#F0DFA0"/>
        <circle cx="32" cy="36" r="18" fill="${KULIT}" stroke="${GARIS}" stroke-width="2"/>`;

    const garis = (d, l = 2.2) =>
        `<path d="${d}" fill="none" stroke="${GARIS}" stroke-width="${l}" stroke-linecap="round" stroke-linejoin="round"/>`;
    const titik = (x, y, r = 2.2) => `<circle cx="${x}" cy="${y}" r="${r}" fill="${GARIS}"/>`;
    const pipi = (c = '#E8707F', o = .45) =>
        `<circle cx="20" cy="44" r="3" fill="${c}" opacity="${o}"/><circle cx="44" cy="44" r="3" fill="${c}" opacity="${o}"/>`;
    const hati = (x, y, s, w = '#D6264A') =>
        `<path transform="translate(${x} ${y}) scale(${s})" d="M0-1.5C0-4.8-5.2-4.8-5.2-1.2C-5.2 2 0 4.8 0 6.8C0 4.8 5.2 2 5.2-1.2C5.2-4.8 0-4.8 0-1.5Z" fill="${w}"/>`;
    const tetes = (x, y) =>
        `<path d="M${x} ${y}q-2.6 4.6 0 6.2q2.6-1.6 0-6.2z" fill="#6EC1F0" stroke="#2E86B8" stroke-width=".8"/>`;

    // Wajah (ekspresi)
    const wajah = {
        senyum: titik(25, 38) + titik(39, 38) + garis('M25 45Q32 52 39 45') + pipi(),
        tertawa:
            garis('M21.5 39Q25 34 28.5 39') + garis('M35.5 39Q39 34 42.5 39') +
            `<path d="M23 44Q32 58 41 44Z" fill="#7A1C1C" stroke="${GARIS}" stroke-width="1.8" stroke-linejoin="round"/>` +
            `<path d="M27 51Q32 47 37 51Q32 55 27 51Z" fill="#E8707F"/>` +
            tetes(16.5, 41) + tetes(47.5, 41),
        kaget:
            `<circle cx="25" cy="38" r="4.4" fill="#fff" stroke="${GARIS}" stroke-width="1.8"/>` +
            `<circle cx="39" cy="38" r="4.4" fill="#fff" stroke="${GARIS}" stroke-width="1.8"/>` +
            titik(25, 38, 1.7) + titik(39, 38, 1.7) +
            garis('M20 31Q25 27.5 30 31') + garis('M34 31Q39 27.5 44 31') +
            `<ellipse cx="32" cy="49" rx="3.6" ry="4.6" fill="#7A1C1C" stroke="${GARIS}" stroke-width="1.8"/>` +
            tetes(52, 28),
        sedih:
            titik(25, 38) + titik(39, 38) +
            garis('M20.5 34L29 31M35 31L43.5 34') +
            garis('M26 50Q32 44.5 38 50') +
            tetes(24, 42) + tetes(40, 42),
        marah:
            garis('M20 32L29 36M35 36L44 32', 2.9) + titik(26, 40, 1.9) + titik(38, 40, 1.9) +
            garis('M26 50Q32 45 38 50') + pipi('#E0402F', .38) +
            `<path d="M52 24q3.4 0 3.4-3.4M52 24q3.4 0 3.4 3.4M52 24q-3.4 0-3.4-3.4M52 24q-3.4 0-3.4 3.4" fill="none" stroke="#D6264A" stroke-width="2" stroke-linecap="round"/>`,
        cinta:
            hati(25, 38, .85) + hati(39, 38, .85) +
            garis('M26.5 46Q32 51.5 37.5 46') + pipi('#E8707F', .5) +
            hati(53, 28, .5, '#F08AA0') + hati(57, 38, .35, '#F08AA0'),
    };

    // Penutup kepala adat
    const topi = {
        tanjak:
            `<path d="M13 27Q13 17 22 15L38 3Q42 10 41 16Q51 18 51 27Z" fill="#8B1E2D" stroke="${GARIS}" stroke-width="1.8" stroke-linejoin="round"/>` +
            `<rect x="13" y="22" width="38" height="5" rx="2" fill="#D4AF37" stroke="${GARIS}" stroke-width="1.2"/>` +
            `<path d="M26 12l3 3-3 3-3-3zM38 12l3 3-3 3-3-3z" fill="#F0DFA0"/>`,
        gending:
            `<path d="M13 27L14 12L22 19L27 7L32 17L37 7L42 19L50 12L51 27Z" fill="#D4AF37" stroke="#8F6B1C" stroke-width="1.8" stroke-linejoin="round"/>` +
            `<circle cx="32" cy="22" r="2.6" fill="#C8243A" stroke="${GARIS}" stroke-width="1"/>` +
            `<circle cx="22" cy="24" r="1.7" fill="#fff"/><circle cx="42" cy="24" r="1.7" fill="#fff"/>` +
            `<circle cx="11" cy="24" r="2.4" fill="#D4AF37" stroke="#8F6B1C"/><circle cx="53" cy="24" r="2.4" fill="#D4AF37" stroke="#8F6B1C"/>`,
        paksangko:
            `<path d="M20 24L24 10L32 2L40 10L44 24Z" fill="#E6CB70" stroke="#8F6B1C" stroke-width="1.8" stroke-linejoin="round"/>` +
            `<rect x="11" y="22" width="42" height="6" rx="3" fill="#D4AF37" stroke="#8F6B1C" stroke-width="1.5"/>` +
            `<circle cx="32" cy="13" r="3" fill="#C8243A" stroke="${GARIS}" stroke-width="1"/>` +
            `<circle cx="13" cy="17" r="3.6" fill="#C8243A" stroke="${GARIS}" stroke-width="1"/><circle cx="13" cy="17" r="1.3" fill="#F0DFA0"/>` +
            `<circle cx="51" cy="17" r="3.6" fill="#C8243A" stroke="${GARIS}" stroke-width="1"/><circle cx="51" cy="17" r="1.3" fill="#F0DFA0"/>`,
        tengkuluk:
            `<path d="M12 31Q10 12 32 11Q54 12 52 31Q50 23 32 22Q14 23 12 31Z" fill="#A33030" stroke="${GARIS}" stroke-width="1.8" stroke-linejoin="round"/>` +
            `<path d="M13 26Q32 16 51 26" fill="none" stroke="#D4AF37" stroke-width="2.6" stroke-linecap="round"/>` +
            `<circle cx="50" cy="20" r="4.2" fill="#8B1E2D" stroke="#D4AF37" stroke-width="1.5"/>`,
        songkok:
            `<path d="M15 27L17 13Q32 6 47 13L49 27Z" fill="#2B1B17" stroke="${GARIS}" stroke-width="1.8" stroke-linejoin="round"/>` +
            `<rect x="15" y="22" width="34" height="5" fill="#D4AF37" stroke="${GARIS}" stroke-width="1.2"/>` +
            `<path d="M24 15l2 2-2 2-2-2zM32 13l2 2-2 2-2-2zM40 15l2 2-2 2-2-2z" fill="#D4AF37"/>`,
        suhunan:
            `<path d="M18 27Q18 14 32 12Q46 14 46 27Z" fill="#D4AF37" stroke="#8F6B1C" stroke-width="1.8" stroke-linejoin="round"/>` +
            `<path d="M24 10a3.2 3.2 0 1 0 .1 0zM32 6a3.2 3.2 0 1 0 .1 0zM40 10a3.2 3.2 0 1 0 .1 0z" fill="#E8707F" stroke="${GARIS}" stroke-width="1"/>` +
            `<circle cx="24" cy="10" r="1.2" fill="#F0DFA0"/><circle cx="32" cy="6" r="1.2" fill="#F0DFA0"/><circle cx="40" cy="10" r="1.2" fill="#F0DFA0"/>` +
            `<path d="M18 24L14 34M46 24L50 34" fill="none" stroke="#8F6B1C" stroke-width="1.6" stroke-linecap="round"/>`,
    };

    const gambar = (w, t) =>
        `<svg viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">${badan}${wajah[w]}${topi[t]}</svg>`;

    // Urutan di sini = nomor emote yang dikirim lewat jaringan. Jangan diacak.
    const DAFTAR = [
        { label: 'Halo, Kawan!', svg: gambar('senyum',  'tanjak')    },
        { label: 'Hahaha!',      svg: gambar('tertawa', 'gending')   },
        { label: 'Waduh!',       svg: gambar('kaget',   'paksangko') },
        { label: 'Yaah...',      svg: gambar('sedih',   'tengkuluk') },
        { label: 'Awas, ya!',    svg: gambar('marah',   'songkok')   },
        { label: 'Mantap!',      svg: gambar('cinta',   'suhunan')   },
    ];

    // ---------- Gaya ----------
    const pasangGaya = () => {
        if (document.getElementById('em-gaya')) return;
        const g = document.createElement('style');
        g.id = 'em-gaya';
        g.textContent = `
            .em-tombol { position: fixed; left: 20px; bottom: 20px; z-index: 58;
                width: 56px; height: 56px; padding: 0; cursor: pointer; border-radius: 50%;
                background: #5a1313; border: 3px solid #d4af37;
                box-shadow: 0 0 0 3px #3a0c0c, 0 5px 0 3px #3a0c0c;
                display: grid; place-items: center; overflow: hidden;
                transition: transform .12s, box-shadow .12s, filter .15s; }
            .em-tombol svg { width: 44px; height: 44px; margin-top: 4px; }
            .em-tombol:hover { transform: translateY(-2px); filter: brightness(1.1); }
            .em-tombol:active { transform: translateY(3px); box-shadow: 0 0 0 3px #3a0c0c, 0 1px 0 3px #3a0c0c; }
            .em-tombol:focus-visible, .em-pilih:focus-visible { outline: 3px solid #f0dfa0; outline-offset: 3px; }

            .em-panel { position: fixed; left: 20px; bottom: 92px; z-index: 58;
                width: min(300px, calc(100vw - 40px)); padding: 14px 12px 12px;
                display: grid; grid-template-columns: repeat(3, 1fr); gap: 8px;
                border-radius: 20px; background: linear-gradient(180deg, #7a1c1c, #5a1313 55%);
                border: 3px solid #d4af37; box-shadow: 0 0 0 3px #3a0c0c, 0 8px 0 3px #3a0c0c, 0 18px 30px rgba(0, 0, 0, .4);
                transform-origin: 0 100%; animation: em-buka .25s cubic-bezier(.3, 1.5, .5, 1) both; }
            .em-panel[hidden] { display: none; }
            .em-pilih { display: grid; justify-items: center; gap: 2px; padding: 8px 2px 6px; cursor: pointer;
                border-radius: 14px; border: 2px solid rgba(212, 175, 55, .35); background: rgba(58, 12, 12, .55);
                color: #f5ecd2; font: 800 .72rem/1.2 inherit; font-family: inherit;
                transition: transform .12s, background .15s, border-color .15s; }
            .em-pilih svg { width: 54px; height: 54px; }
            .em-pilih:hover { transform: translateY(-3px) scale(1.04); background: rgba(212, 175, 55, .2); border-color: #d4af37; }
            .em-pilih:active { transform: scale(.95); }
            .em-pilih[disabled] { opacity: .45; cursor: not-allowed; transform: none; }

            .em-layar { position: fixed; left: 14px; bottom: 96px; z-index: 57; pointer-events: none;
                display: flex; flex-direction: column-reverse; gap: 10px; align-items: flex-start; }
            .em-gelembung { display: flex; align-items: center; gap: 8px; padding: 6px 16px 6px 8px;
                border-radius: 999px; background: #3a0c0c; border: 2px solid #d4af37;
                box-shadow: 0 6px 14px rgba(0, 0, 0, .35); color: #f5ecd2;
                animation: em-naik 3.4s ease-out both; }
            .em-gelembung svg { width: 54px; height: 54px; flex-shrink: 0; animation: em-goyang .6s ease-in-out .15s 2; }
            .em-gelembung b { display: block; font: 800 .8rem/1.2 inherit; font-family: inherit; color: #f0dfa0; max-width: 150px;
                overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
            .em-gelembung span { display: block; font: 700 .95rem/1.2 inherit; font-family: inherit; }
            .em-gelembung--aku { background: #5a1313; }

            @keyframes em-buka   { from { opacity: 0; transform: scale(.6) translateY(20px); } }
            @keyframes em-naik   { 0% { opacity: 0; transform: translateY(30px) scale(.6); }
                                   12% { opacity: 1; transform: translateY(0) scale(1.08); }
                                   20% { transform: scale(1); }
                                   80% { opacity: 1; }
                                   100% { opacity: 0; transform: translateY(-34px); } }
            @keyframes em-goyang { 0%, 100% { rotate: 0deg; } 30% { rotate: -9deg; } 70% { rotate: 9deg; } }

            @media (max-width: 600px) {
                .em-tombol { left: 12px; bottom: 12px; width: 48px; height: 48px; }
                .em-tombol svg { width: 38px; height: 38px; }
                .em-panel { left: 12px; bottom: 76px; }
                .em-layar { left: 10px; bottom: 80px; }
            }
            @media (prefers-reduced-motion: reduce) {
                .em-panel, .em-gelembung, .em-gelembung svg { animation-duration: .01s; animation-iteration-count: 1; }
            }`;
        document.head.appendChild(g);
    };

    // ---------- Pasang ----------
    let sudahPasang = false;
    const JEDA = 1500;        // ms antar emote (cegah spam & batas Pusher)
    const MAKS_TAMPIL = 4;    // gelembung yang tampil bersamaan

    const pasang = ({ kanal, nama }) => {
        if (sudahPasang || !kanal) return;
        sudahPasang = true;
        pasangGaya();

        const namaku = () => String((typeof nama === 'function' ? nama() : nama) || 'Pemain').slice(0, 24);

        // Tombol bulat + panel pilihan
        const tombol = document.createElement('button');
        tombol.type = 'button';
        tombol.className = 'em-tombol';
        tombol.setAttribute('aria-label', 'Kirim emote');
        tombol.setAttribute('aria-expanded', 'false');
        tombol.innerHTML = DAFTAR[0].svg;

        const panel = document.createElement('div');
        panel.className = 'em-panel';
        panel.hidden = true;
        panel.setAttribute('role', 'group');
        panel.setAttribute('aria-label', 'Pilih emote');

        const layar = document.createElement('div');
        layar.className = 'em-layar';
        layar.setAttribute('role', 'status');
        layar.setAttribute('aria-live', 'polite');

        const pilihan = DAFTAR.map((e, i) => {
            const b = document.createElement('button');
            b.type = 'button';
            b.className = 'em-pilih';
            b.setAttribute('aria-label', e.label);
            b.innerHTML = `${e.svg}<span>${e.label}</span>`;
            b.addEventListener('click', () => kirim(i));
            panel.appendChild(b);
            return b;
        });

        document.body.append(layar, panel, tombol);

        const buka = (ya) => {
            panel.hidden = !ya;
            tombol.setAttribute('aria-expanded', String(ya));
        };
        tombol.addEventListener('click', () => buka(panel.hidden));
        document.addEventListener('keydown', (e) => { if (e.key === 'Escape') buka(false); });
        document.addEventListener('click', (e) => {
            if (!panel.hidden && !panel.contains(e.target) && !tombol.contains(e.target)) buka(false);
        });

        // Tampilkan gelembung emote (punyaku maupun teman)
        const tampil = (no, pengirim, aku) => {
            const e = DAFTAR[no];
            if (!e) return;

            const el = document.createElement('div');
            el.className = 'em-gelembung' + (aku ? ' em-gelembung--aku' : '');
            el.innerHTML = `${e.svg}<div><b></b><span></span></div>`;
            el.querySelector('b').textContent = aku ? 'Kamu' : pengirim;   // textContent = aman dari HTML
            el.querySelector('span').textContent = e.label;
            layar.appendChild(el);

            while (layar.children.length > MAKS_TAMPIL) layar.firstElementChild.remove();
            setTimeout(() => el.remove(), 3500);
        };

        // Kirim emote milikku
        let terakhir = 0;
        function kirim(no) {
            const sekarang = Date.now();
            if (sekarang - terakhir < JEDA) return;

            let ok = false;
            try { ok = kanal.trigger('client-emote', { e: no, nama: namaku() }) !== false; } catch (err) { ok = false; }
            if (!ok) return;      // belum tersambung ke ruangan: jangan pura-pura terkirim

            terakhir = sekarang;
            tampil(no, '', true);
            buka(false);
            pilihan.forEach((b) => { b.disabled = true; });
            setTimeout(() => pilihan.forEach((b) => { b.disabled = false; }), JEDA);
        }

        // Terima emote dari teman
        kanal.bind('client-emote', (d) => {
            const no = Number(d?.e);
            if (!Number.isInteger(no) || no < 0 || no >= DAFTAR.length) return;
            tampil(no, String(d?.nama || 'Pemain').slice(0, 24), false);
        });

        // Kalau tidak bisa tersambung ke ruangan (mis. main sendiri melawan bot), sembunyikan tombolnya
        kanal.bind('pusher:subscription_error', () => {
            [tombol, panel, layar].forEach((el) => el.remove());
            sudahPasang = false;
        });
    };

    return { pasang, daftar: DAFTAR };
})();