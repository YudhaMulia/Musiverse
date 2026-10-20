@php
    $mapSites = collect(config('heritage_map.sites'))->map(fn ($s) => [
        'slug'     => $s['slug'],
        'name'     => $s['name'],
        'era'      => $s['era'] ?? '',
        'category' => $s['category'] ?? 'lainnya',
        'desc'     => $s['desc'] ?? '',
        'lat'      => (float) $s['lat'],
        'lng'      => (float) $s['lng'],
        'photos'   => collect($s['photos'] ?? [])->map(fn ($p) => asset($p))->all(),
        'tour'     => $s['tour'] ?? null,
        'rating'   => $s['rating'] ?? null,
        'reviews'  => $s['reviews'] ?? 0,
    ])->values();
        $gamesUrl = url(config('heritage_map.games_url', '/games'));
    $myVisits = auth()->check()
        ? \App\Models\Visit::with('photos')
            ->where('user_id', auth()->id())->get()
            ->mapWithKeys(fn ($v) => [$v->site_slug => $v->toMap()])
            ->all()
        : [];
@endphp

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
      integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="">

<style>
    .hm { --ink:#3a2a20; --muted:#7b6a5d; --brown:#6b3a28; --gold:#f6c453; --cream:#fbf6ee; --card:#fffdf8; --line:#eadfce;
          background: var(--cream); color: var(--ink); border-radius: 22px; padding: 18px; margin: 16px 0;
          box-shadow: 0 20px 50px rgba(0,0,0,.35); }
    .hm * { box-sizing: border-box; }
    .hm-head { display:flex; flex-wrap:wrap; gap:12px; align-items:center; justify-content:space-between; margin-bottom:14px; }
    .hm-head h1 { font-size:22px; font-weight:700; margin:0; color:var(--ink); }
    .hm-head p { margin:2px 0 0; color:var(--muted); font-size:13px; }
    .hm-head-right { display:flex; gap:10px; align-items:center; flex-wrap:wrap; }
    .hm-search { position:relative; width:300px; max-width:100%; }
    .hm-search input { width:100%; border:1px solid var(--line); background:#fff; border-radius:999px; padding:10px 16px; font-size:14px; color:var(--ink); }
    .hm-results { position:absolute; top:44px; left:0; right:0; z-index:1200; background:#fff; border:1px solid var(--line);
                  border-radius:14px; box-shadow:0 12px 30px rgba(0,0,0,.18); overflow:hidden; }
    .hm-results button { display:block; width:100%; text-align:left; padding:10px 14px; background:none; border:0; cursor:pointer; font-size:14px; color:var(--ink); }
    .hm-results button:hover { background:#f6efe3; }
    .hm-score { background:#fff; border:1px solid var(--line); border-radius:999px; padding:8px 14px; font-size:13px; font-weight:600; }

    .hm-grid { display:grid; grid-template-columns:1fr; gap:14px; }
    .hm-grid.has-panel { grid-template-columns:1fr 380px; }
    .hm-grid:not(.has-panel) .hm-panel { display:none; }
    .hm-mapbox { position:relative; height:640px; border-radius:16px; overflow:hidden; border:1px solid var(--line); isolation:isolate; }
    #heritage-map { height:100%; width:100%; background:#e8e2d6; }

    .hm-legend { position:absolute; top:12px; left:12px; z-index:500; background:rgba(255,253,248,.96); border:1px solid var(--line);
                 border-radius:14px; padding:10px 12px; font-size:12px; box-shadow:0 6px 18px rgba(0,0,0,.18); }
    .hm-legend-item { display:flex; align-items:center; gap:8px; background:none; border:0; padding:3px 0; cursor:pointer; color:var(--ink); font-size:12px; }
    .hm-legend-item.off { opacity:.4; text-decoration:line-through; }
    .hm-dot { width:12px; height:12px; border-radius:50%; flex:none; display:inline-block; }
    .hm-toast { position:absolute; left:50%; bottom:16px; transform:translateX(-50%); z-index:600; background:#3a2a20; color:#fff;
                padding:9px 14px; border-radius:999px; font-size:13px; box-shadow:0 6px 18px rgba(0,0,0,.3); max-width:90%; text-align:center; }
    .hm-locate { width:34px; height:34px; background:#fff; border:2px solid rgba(0,0,0,.2); border-radius:4px; cursor:pointer; font-size:18px; line-height:1; }

    .hm-tip.leaflet-tooltip { background:#fffdf8; border:1px solid var(--line); border-radius:12px; padding:8px 10px; color:#3a2a20;
                              box-shadow:0 8px 22px rgba(0,0,0,.3); font-size:12px; }
    .hm-tip.leaflet-tooltip-top:before { border-top-color:#fffdf8; }

    .me-wrap { position:relative; width:40px; height:40px; }
    .me-pulse { position:absolute; inset:0; border-radius:50%; background:rgba(37,99,235,.35); animation:mePulse 2s ease-out infinite; }
    .me-dot { position:absolute; inset:7px; border-radius:50%; background:#2563eb; border:3px solid #fff; box-shadow:0 2px 6px rgba(0,0,0,.5);
              display:flex; align-items:center; justify-content:center; }
    @keyframes mePulse { 0% { transform:scale(.6); opacity:1; } 100% { transform:scale(1.6); opacity:0; } }

    .hm-panel { background:var(--card); border:1px solid var(--line); border-radius:16px; overflow:auto; height:640px; }
    .hm-empty { padding:18px; }
    .hm-empty h3 { margin:0 0 4px; font-size:16px; font-weight:700; }
    .hm-empty p { margin:0 0 12px; color:var(--muted); font-size:13px; }
    .hm-item { display:flex; align-items:center; gap:10px; width:100%; padding:10px; border:1px solid var(--line); border-radius:12px;
               background:#fff; margin-bottom:8px; cursor:pointer; text-align:left; color:var(--ink); }
    .hm-item:hover { background:#f6efe3; }
    .hm-cover { position:relative; height:170px; background:linear-gradient(135deg,#7a3a2a,#3a2018); display:flex; align-items:center; justify-content:center; font-size:48px; }
    .hm-cover img { width:100%; height:100%; object-fit:cover; display:block; }
    .hm-close { position:absolute; top:10px; right:10px; width:30px; height:30px; border-radius:50%; border:0; background:#fff; cursor:pointer;
                font-size:18px; line-height:1; color:#3a2a20; box-shadow:0 2px 8px rgba(0,0,0,.3); }
    .hm-body { padding:14px 16px 18px; }
    .hm-badge { display:inline-block; font-size:11px; font-weight:700; letter-spacing:.06em; text-transform:uppercase; padding:3px 8px; border-radius:999px; color:#fff; }
    .hm-body h2 { margin:8px 0 2px; font-size:22px; font-weight:700; color:var(--ink); }
    .hm-rate { font-size:13px; color:var(--muted); }
    .hm-desc { margin:10px 0; font-size:13px; line-height:1.6; color:#4a3a2f; white-space:pre-line; max-height:150px; overflow:auto; }
    .hm-stats { display:grid; grid-template-columns:1fr 1fr; gap:8px; background:#f4ecdf; border-radius:12px; padding:10px 12px; margin:10px 0; }
    .hm-stats small { display:block; color:var(--muted); font-size:11px; }
    .hm-stats b { font-size:15px; }
    .hm-actions { display:grid; grid-template-columns:1fr 1fr; gap:8px; }
    .hm-btn { display:inline-flex; align-items:center; justify-content:center; gap:6px; border:0; border-radius:10px; padding:11px 10px;
              font-size:13px; font-weight:700; cursor:pointer; text-decoration:none; }
    .hm-btn.brown { background:var(--brown); color:#fff; }
    .hm-btn.gold { background:var(--gold); color:#3a2a20; }
    .hm-btn.ghost { background:#fff; border:1px solid var(--line); color:var(--ink); }
    .hm-share { display:flex; align-items:center; gap:10px; width:100%; margin-top:12px; padding:12px; border:1px solid var(--line);
                border-radius:12px; background:#fff; cursor:pointer; text-align:left; color:var(--ink); font-size:13px; }
    .hm-share small { display:block; color:var(--muted); }
    .hm-form { margin-top:12px; border:1px solid var(--line); border-radius:12px; padding:12px; background:#fff; font-size:13px; }
    .hm-form textarea { width:100%; min-height:84px; border:1px solid var(--line); border-radius:10px; padding:8px; font-size:13px; color:var(--ink); resize:vertical; }
    .hm-thumbs { display:flex; gap:8px; flex-wrap:wrap; margin-bottom:8px; }
    .hm-thumb { position:relative; width:60px; height:60px; }
    .hm-thumb img { width:100%; height:100%; object-fit:cover; border-radius:10px; }
    .hm-thumb button { position:absolute; top:-6px; right:-6px; width:18px; height:18px; border-radius:50%; border:0; background:#c0392b; color:#fff; font-size:12px; line-height:18px; cursor:pointer; }
    .hm-add { width:60px; height:60px; border:1.5px dashed #c9b79c; border-radius:10px; background:#faf4ea; font-size:24px; color:var(--muted); cursor:pointer; }
    .hm-stars { display:flex; gap:4px; margin:6px 0; }
    .hm-stars button { background:none; border:0; font-size:26px; cursor:pointer; color:#d8cdb9; padding:0; }
    .hm-stars button.on { color:#f5a623; }
    .hm-done { margin-top:12px; background:#ecf7ee; border:1px solid #bfe3c6; border-radius:12px; padding:12px; font-size:13px; }
    .hm-err { color:#b3261e; font-size:12px; min-height:16px; margin:4px 0; }

    .hm-modal { position:fixed; inset:0; z-index:2000; background:rgba(0,0,0,.8); display:none; align-items:center; justify-content:center; padding:16px; }
    .hm-modal.open { display:flex; }
    .hm-modal iframe { width:100%; max-width:1000px; height:70vh; border:0; border-radius:12px; background:#000; }
    .hm-modal-close { position:absolute; top:14px; right:20px; font-size:34px; color:#fff; background:none; border:0; cursor:pointer; }

        /* ===== Buku Jurnal ===== */
    .hm-toast { z-index:1600; }
    .bk-layer { position:absolute; inset:0; z-index:1500; display:flex; flex-direction:column; background:rgba(36,20,12,.62);
                backdrop-filter:blur(3px); opacity:0; transition:opacity .4s ease; }
    .bk-layer[hidden] { display:none; }
    .bk-layer.show { opacity:1; }
    .bk-area { flex:1; min-height:0; display:flex; align-items:center; justify-content:center; }
    .bk-stage { width:900px; height:560px; flex:none; }
    .bk-swing { width:100%; height:100%; }
    .bk-swing.swing { animation:bkSwing 1s cubic-bezier(.2,.9,.25,1.05) both; }
    @keyframes bkSwing {
        0%   { opacity:0; transform:translateY(140px) rotateX(40deg) rotateZ(-10deg) scale(.55); }
        60%  { opacity:1; transform:translateY(-14px) rotateX(-4deg) rotateZ(2deg) scale(1.02); }
        100% { opacity:1; transform:none; }
    }
    .bk-book { position:relative; width:100%; height:100%; perspective:2600px; transition:transform 1s cubic-bezier(.5,.05,.2,1); }
    .bk-book.closed { transform:translateX(-25%); }
    .bk-leather { position:absolute; top:-14px; bottom:-14px; width:calc(50% + 14px);
                  background:linear-gradient(135deg,#7a4a2e,#4a2616); box-shadow:0 30px 60px rgba(0,0,0,.5); }
    .bk-leather.r { left:50%; border-radius:0 18px 18px 0; }
    .bk-leather.l { right:50%; border-radius:18px 0 0 18px; transition:opacity .6s; }
    .bk-book.closed .bk-leather.l { opacity:0; }

    .bk-sheet { position:absolute; top:0; left:50%; width:50%; height:100%; transform-origin:left center;
                transform-style:preserve-3d; transition:transform 1.05s cubic-bezier(.45,.05,.2,1); }
    .bk-sheet.flipped { transform:rotateY(-180deg); }
    .bk-face { position:absolute; inset:0; backface-visibility:hidden; -webkit-backface-visibility:hidden; overflow:hidden;
               padding:26px 28px 60px; background:radial-gradient(circle at 20% 15%,#fffaf0,#f3e4c6 90%); color:#4a2a18; }
    .bk-face.front { border-radius:0 10px 10px 0; box-shadow:inset 16px 0 22px -14px rgba(60,30,10,.35); }
    .bk-face.back  { transform:rotateY(180deg); border-radius:10px 0 0 10px; box-shadow:inset -16px 0 22px -14px rgba(60,30,10,.35); }
    .bk-h { font-family:Georgia,serif; font-size:24px; margin:0 0 8px; color:#4a2a18; }
    .bk-hand { font-family:'Segoe Script','Bradley Hand','Comic Sans MS',cursive; }
    .bk-nav { position:absolute; bottom:16px; border:0; border-radius:999px; padding:9px 16px; font-size:13px; font-weight:700;
              cursor:pointer; background:#6b3a28; color:#fff; transition:transform .15s; }
    .bk-nav:hover { transform:translateY(-2px); }
    .bk-nav.p { left:26px; background:#eadfce; color:#3a2a20; }
    .bk-nav.n { right:26px; }
    .bk-bar { display:flex; gap:8px; justify-content:center; flex-wrap:wrap; padding:10px 12px 14px; }
    .bk-bar [hidden] { display:none; }
    .bk-chip { position:absolute; top:12px; left:50%; transform:translateX(-50%); z-index:700; background:#fffdf8;
               border:1px solid var(--line); border-radius:999px; padding:6px 6px 6px 16px; display:flex; gap:8px; align-items:center;
               font-size:13px; box-shadow:0 8px 22px rgba(0,0,0,.3); max-width:92%; }
    .bk-chip[hidden] { display:none; }
    .bk-chip .hm-btn { padding:8px 12px; }

    .bk-ta { width:100%; height:110px; border:1px solid var(--line); border-radius:10px; padding:8px; font:13px/1.5 inherit;
             background:#fffdf5; resize:none; color:var(--ink); }
    .bk-jphotos { display:flex; gap:12px; flex-wrap:wrap; margin-top:10px; }
    .bk-ph { background:#fff; padding:6px 6px 22px; box-shadow:0 4px 10px rgba(0,0,0,.25); transform:rotate(var(--rot,0deg)); position:relative; }
    .bk-ph img { width:100%; height:100%; object-fit:cover; display:block; }
    .fr-polos .bk-ph { padding:0; }
    .fr-bulat .bk-ph { padding:4px; border-radius:50%; background:#f6c453; }
    .fr-bulat .bk-ph img { border-radius:50%; }
    .fr-tape .bk-ph::before { content:''; position:absolute; top:-9px; left:50%; width:54px; height:18px;
                              transform:translateX(-50%) rotate(-4deg); background:rgba(246,196,83,.8); }
        .bk-stlayer { position:absolute; inset:0; pointer-events:none; }

    /* Foto polaroid + selotip di halaman Sejarah Singkat */
    .bk-pol { position:relative; display:block; width:210px; margin:10px auto 14px; padding:8px 8px 26px;
              background:#fff; transform:rotate(-2.5deg); border-radius:2px;
              box-shadow:0 6px 14px rgba(60,30,10,.3), 0 1px 2px rgba(0,0,0,.2); }
    .bk-pol img { display:block; width:100%; height:118px; object-fit:cover; background:#eadfce; }
    .bk-pol figcaption { position:absolute; left:10px; right:10px; bottom:5px; text-align:center; font-size:12px;
                         color:#6b4a30; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;
                         font-family:'Segoe Script','Bradley Hand','Comic Sans MS',cursive; }
    .bk-pol::before, .bk-pol::after { content:''; position:absolute; width:54px; height:20px; z-index:2;
                         background:rgba(246,196,83,.75); box-shadow:0 1px 3px rgba(0,0,0,.2);
                         background-image:repeating-linear-gradient(90deg,rgba(255,255,255,.25) 0 3px,transparent 3px 6px); }
    .bk-pol::before { top:-9px; left:-16px; transform:rotate(-38deg); }
        .bk-pol::after  { top:-9px; right:-16px; transform:rotate(38deg); }

    /* Polaroid besar di tengah halaman sejarah */
    .bk-polwrap { display:flex; align-items:center; justify-content:center; height:380px; }
    .bk-pol.big { width:340px; margin:0; padding:10px 10px 40px; transform:rotate(-2deg); }
    .bk-pol.big img { height:270px; }
    .bk-pol.big figcaption { left:12px; right:12px; bottom:8px; font-size:16px; }
    .bk-pol.big::before, .bk-pol.big::after { width:70px; height:24px; top:-12px; }
    .bk-pol.big::before { left:-22px; }
    .bk-pol.big::after  { right:-22px; }
    .bk-pol-ph { height:270px; display:flex; align-items:center; justify-content:center; font-size:90px;
                 background:linear-gradient(135deg,#7a3a2a,#3a2018); }

    /* Halaman galeri */
    .bk-gal .hm-thumbs { gap:14px; margin:16px 0; }
    .bk-gal .hm-thumb, .bk-gal .hm-add { width:120px; height:120px; }
    .bk-gal .hm-thumb button { width:24px; height:24px; line-height:24px; font-size:15px; }
    .bk-stk { position:absolute; font-size:44px; line-height:1; cursor:grab; user-select:none; touch-action:none; pointer-events:auto; z-index:5;
              transform:translate(-50%,-50%) rotate(var(--r,0deg)) scale(var(--s,1)); filter:drop-shadow(0 3px 3px rgba(0,0,0,.25));
              transition:filter .15s; }
    .bk-stk:hover { filter:drop-shadow(0 7px 6px rgba(0,0,0,.3)); }
    .bk-stk.pop { animation:stkPop .5s cubic-bezier(.3,1.6,.5,1); }
    .bk-stk.sel { outline:2px dashed #c0392b; outline-offset:4px; border-radius:8px; }
    .bk-stk.drag { cursor:grabbing; }
    @keyframes stkPop { 0% { opacity:0; transform:translate(-50%,-50%) scale(.2) rotate(-40deg); } }
    .bk-tray { display:grid; grid-template-columns:repeat(6,1fr); gap:6px; margin:6px 0 10px; }
    .bk-tray button { font-size:24px; background:#fffdf5; border:1px solid var(--line); border-radius:10px; padding:4px; cursor:pointer; transition:transform .15s; }
    .bk-tray button:hover { transform:translateY(-3px) rotate(-6deg) scale(1.12); }
    .bk-chips { display:flex; gap:6px; flex-wrap:wrap; margin:6px 0 10px; }
    .bk-chips button { border:1px solid var(--line); background:#fffdf5; border-radius:999px; padding:6px 12px; font-size:12px; cursor:pointer; color:var(--ink); }
    .bk-chips button.on { background:#6b3a28; color:#fff; border-color:#6b3a28; }
    .bk-yay { background:#fff3c4; border:1px solid #f1d27a; border-radius:12px; padding:10px 12px; font-size:15px; margin-bottom:10px;
              animation:stkPop .6s cubic-bezier(.3,1.6,.5,1); }

        /* ===== Memories Book Recap ===== */
    .rc-hero { position:relative; display:flex; align-items:center; gap:28px; width:100%; margin:0 0 14px; padding:20px 28px;
               border:1px solid var(--line); border-radius:18px; cursor:pointer; text-align:left; color:var(--ink); overflow:hidden;
               background:radial-gradient(circle at 14% 50%,rgba(246,196,83,.5),transparent 55%),linear-gradient(135deg,#fff7e6,#f6e7c9); }
    .rc-book3d { position:relative; flex:none; width:150px; height:190px; border-radius:6px 14px 14px 6px;
                 background:linear-gradient(135deg,#a4262a,#6a1115 70%,#4d0b0e);
                 box-shadow:inset 10px 0 14px rgba(0,0,0,.35),0 18px 30px rgba(80,10,10,.45),0 0 28px rgba(246,196,83,.55);
                 transform:perspective(700px) rotateY(-16deg) rotateZ(-2deg); animation:rcFloat 3.6s ease-in-out infinite;
                 display:flex; flex-direction:column; align-items:center; justify-content:center; text-align:center; color:#f3d27a; }
    .rc-book3d::before { content:''; position:absolute; inset:9px 9px 9px 14px; border:1.5px solid #d4a73a; border-radius:4px 10px 10px 4px; }
    .rc-clasp { position:absolute; right:-8px; top:44%; width:18px; height:32px; border-radius:4px; background:linear-gradient(#f6d77a,#b9892a);
                box-shadow:0 2px 6px rgba(0,0,0,.4); }
    .rc-hero:hover .rc-book3d { animation:none; transform:perspective(700px) rotateY(-4deg) translateY(-6px) scale(1.05); transition:transform .35s; }
    @keyframes rcFloat {
        0%,100% { transform:perspective(700px) rotateY(-16deg) rotateZ(-2deg) translateY(0); }
        50%     { transform:perspective(700px) rotateY(-16deg) rotateZ(-2deg) translateY(-9px); }
    }
    .rc-t1 { font:italic 700 18px/1.15 Georgia,serif; margin-top:8px; position:relative; }
    .rc-t2 { font-size:11px; letter-spacing:.35em; margin-top:6px; position:relative; }
    .rc-spark { position:absolute; color:#e0b84a; animation:rcTw 2.4s ease-in-out infinite; pointer-events:none; }
    @keyframes rcTw { 0%,100% { opacity:.15; transform:scale(.6); } 50% { opacity:1; transform:scale(1.2); } }
    .rc-hero-text b { display:block; font-size:22px; font-family:Georgia,serif; }
    .rc-hero-text span { display:block; }
    .rc-pill { display:inline-block !important; margin-top:12px; background:#6b3a28; color:#fff; border-radius:999px; padding:9px 16px; font-size:13px; font-weight:700; }

    .rc-layer { position:fixed; inset:0; z-index:1800; display:flex; flex-direction:column; background:rgba(36,12,10,.8);
                backdrop-filter:blur(3px); opacity:0; transition:opacity .4s ease; }
    .rc-layer[hidden] { display:none; }
    .rc-layer.show { opacity:1; }
    #rc-book .bk-leather { background:linear-gradient(135deg,#8e1b1f,#4d0b0e); }
    .bk-leather.r { transition:opacity .6s; }
    .bk-book.ended { transform:translateX(25%); }
    .bk-book.ended .bk-leather.r { opacity:0; }
    .rc-page .bk-stk { cursor:default; pointer-events:none; }
        .rc-no { position:absolute; bottom:18px; left:26px; color:#a88a68; font-size:12px; }

    /* ===== Kartu Memories Book di dalam peta ===== */
    .hm-dock { position:absolute; top:12px; left:12px; z-index:500; display:flex; align-items:flex-start; gap:12px;
               max-width:calc(100% - 84px); pointer-events:none; }
    .hm-dock > * { pointer-events:auto; }
    .hm-dock .hm-legend { position:relative; top:auto; left:auto; z-index:auto; flex:none; }

    .rm-mini { position:relative; display:flex; align-items:center; gap:16px; flex:none; width:310px; padding:14px 16px 14px 16px;
               border:1px solid var(--line); border-radius:14px; cursor:pointer; text-align:left; color:var(--ink); font-family:inherit;
               background:radial-gradient(circle at 16% 50%,rgba(246,196,83,.45),transparent 60%),rgba(255,250,238,.97);
               box-shadow:0 6px 18px rgba(0,0,0,.18); overflow:hidden;
               animation:rmIn .7s cubic-bezier(.2,.9,.3,1.2) .2s backwards;
               transition:transform .25s ease, box-shadow .25s ease; }
    .rm-mini:hover { transform:translateY(-3px); box-shadow:0 14px 28px rgba(80,20,10,.3); }
    @keyframes rmIn { 0% { opacity:0; transform:translateX(-26px) scale(.92); } 100% { opacity:1; transform:none; } }

    .rm-sp { position:absolute; color:#e0b84a; pointer-events:none; animation:rmTw 2.4s ease-in-out infinite; }
    @keyframes rmTw { 0%,100% { opacity:.15; transform:scale(.6); } 50% { opacity:1; transform:scale(1.2); } }

    .rm-stage { position:relative; flex:none; width:80px; height:106px; perspective:520px; }
    .rm-shadow { position:absolute; left:50%; bottom:-10px; width:72px; height:12px; margin-left:-36px; border-radius:50%;
                 background:radial-gradient(ellipse,rgba(60,15,10,.55),transparent 70%); animation:rmShadow 3.4s ease-in-out infinite; }
    @keyframes rmShadow { 0%,100% { transform:scale(1); opacity:.9; } 50% { transform:scale(.7); opacity:.4; } }

    .rm-bk { position:absolute; inset:0; transform-style:preserve-3d; transform:rotateY(-20deg) rotateZ(-2deg);
             animation:rmFloat 3.4s ease-in-out infinite; }
    @keyframes rmFloat {
        0%,100% { transform:rotateY(-20deg) rotateZ(-2deg) translateY(0); }
        50%     { transform:rotateY(-20deg) rotateZ(-2deg) translateY(-7px); }
    }
    .rm-mini:hover .rm-bk { animation-play-state:paused; }

    .rm-pages { position:absolute; inset:4px -5px 4px 5px; border-radius:2px 6px 6px 2px; transform:translateZ(-2px);
                background:repeating-linear-gradient(90deg,#fffaf0 0 2px,#e4d3b3 2px 3px); box-shadow:0 2px 6px rgba(0,0,0,.25); }
    .rm-cov { position:absolute; inset:0; border-radius:3px 9px 9px 3px; transform-origin:left center; overflow:hidden;
              transition:transform .7s cubic-bezier(.4,.1,.2,1);
              background:linear-gradient(135deg,#a4262a,#6a1115 70%,#4d0b0e);
              box-shadow:inset 6px 0 9px rgba(0,0,0,.35),0 8px 16px rgba(80,10,10,.4);
              display:flex; flex-direction:column; align-items:center; justify-content:center; text-align:center; color:#f3d27a; }
    .rm-cov::before { content:''; position:absolute; inset:5px 5px 5px 8px; border:1px solid #d4a73a; border-radius:2px 6px 6px 2px; }
    .rm-mini:hover .rm-cov { transform:rotateY(-48deg); }
    .rm-ic { width:26px; height:26px; position:relative; }
    .rm-t { font:italic 700 11px/1.15 Georgia,serif; margin-top:5px; position:relative; }
    .rm-shine { position:absolute; top:0; bottom:0; left:-60%; width:40%; transform:skewX(-12deg);
                background:linear-gradient(100deg,transparent,rgba(255,255,255,.38),transparent); animation:rmShine 4s ease-in-out infinite 1s; }
    @keyframes rmShine { 0%,55% { left:-60%; } 100% { left:130%; } }
    .rm-clasp { position:absolute; right:-5px; top:44%; width:9px; height:18px; border-radius:2px; transition:opacity .3s;
                background:linear-gradient(#f6d77a,#b9892a); box-shadow:0 1px 4px rgba(0,0,0,.4); }
    .rm-mini:hover .rm-clasp { opacity:0; }

    .rm-txt { display:flex; flex-direction:column; min-width:0; }
    .rm-txt b { font:700 17px/1.2 Georgia,serif; }
    .rm-desc { font-size:12px; color:var(--muted); margin-top:3px; line-height:1.4; }
    #rc-sub { display:block; font-size:12px; font-weight:700; color:#8a3a1a; margin-top:6px; }
    .rm-pill { align-self:flex-start; margin-top:8px; background:#6b3a28; color:#fff; border-radius:999px; padding:6px 12px;
               font-size:12px; font-weight:700; transition:background .2s, transform .2s; }
    .rm-mini:hover .rm-pill { background:#8e1b1f; transform:translateX(3px); }

    @media (max-width:700px) {
        .hm-dock { flex-direction:column; max-width:calc(100% - 24px); }
        .rm-mini { width:auto; }
        .rm-desc { display:none; }
    }
    @media (prefers-reduced-motion: reduce) {
        .rm-bk, .rm-shadow, .rm-shine, .rm-sp, .rm-mini { animation:none; }
    }

    #rc-swing { position:relative; }
    #rc-book { touch-action:none; user-select:none; -webkit-user-select:none; cursor:grab; }
    #rc-book.dragging { cursor:grabbing; }
    #rc-book img { -webkit-user-drag:none; }
    .rc-hint { position:absolute; top:235px; left:675px; width:220px; margin-left:-110px; z-index:2000;
               pointer-events:none; text-align:center; transition:left .6s ease; }
    .rc-hint.c { left:450px; }
    .rc-hint[hidden] { display:none; }
    .rc-hand { width:58px; height:58px; filter:drop-shadow(0 4px 6px rgba(0,0,0,.45)); animation:rcSwipe 2.2s ease-in-out infinite; }
    .rc-hint-t { display:inline-block; margin-top:8px; background:rgba(36,12,10,.85); color:#f6e7c1; font-size:12px;
                 padding:5px 12px; border-radius:999px; }
    @keyframes rcSwipe {
        0%   { opacity:0; transform:translateX(80px) rotate(8deg); }
        15%  { opacity:1; }
        70%  { opacity:1; transform:translateX(-100px) rotate(-12deg); }
        100% { opacity:0; transform:translateX(-120px) rotate(-12deg); }
    }
        /* Area teks sejarah yang bisa di-scroll */
    .bk-scroll { position:absolute; left:28px; right:22px; top:74px; bottom:70px; overflow-y:auto; overflow-x:hidden;
    padding-right:8px; overscroll-behavior:contain; scrollbar-width:thin; scrollbar-color:#c9a77a transparent; }
    .bk-scroll::-webkit-scrollbar { width:6px; }
    .bk-scroll::-webkit-scrollbar-thumb { background:#c9a77a; border-radius:6px; }
    .bk-scroll::-webkit-scrollbar-track { background:transparent; }
    .bk-scroll .hm-desc { margin-top:0; }

    /* Ulasan pengunjung */
    .rv-title { font-family:Georgia,serif; font-size:15px; margin:14px 0 8px; color:#4a2a18; border-top:1px dashed #d8c5a0; padding-top:10px; }
    .rv-list { display:flex; flex-direction:column; gap:8px; }
    .rv-item { display:flex; gap:10px; align-items:flex-start; background:#fffdf5; border:1px solid #eadfce; border-radius:10px; padding:8px 10px; }
    .rv-item img { width:46px; height:46px; object-fit:cover; border-radius:8px; flex:none; }
    .rv-body { min-width:0; flex:1; }
    .rv-top { display:flex; justify-content:space-between; align-items:center; gap:8px; }
    .rv-top b { font-size:13px; color:#3a2a20; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
    .rv-stars { color:#f5a623; font-size:13px; flex:none; }
    .rv-text { margin:3px 0 0; font-size:12.5px; line-height:1.45; color:#5a4636; display:-webkit-box; -webkit-line-clamp:2; line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; }
    .rv-empty { font-size:12.5px; color:#8a7a6a; }

    @media (max-width: 1023px) {
        .hm-grid, .hm-grid.has-panel { grid-template-columns:1fr; }
        .hm-mapbox { height:460px; }
        .hm-panel { height:auto; }
    }
</style>

<div class="hm" id="hm-root" data-sites="{{ json_encode($mapSites) }}" data-games="{{ $gamesUrl }}"
     data-visits="{{ json_encode($myVisits) }}" data-csrf="{{ csrf_token() }}">
    <header class="hm-head">
        <div>
            <h1>Peta Cagar Budaya</h1>
            <p>Temukan jejak sejarah Palembang di sekitarmu</p>
        </div>
        <div class="hm-head-right">
            <div class="hm-search">
                <input id="hm-search" type="search" placeholder="Cari lokasi cagar budaya..." autocomplete="off">
                <div id="hm-results" class="hm-results" hidden></div>
            </div>
            <div id="hm-score" class="hm-score"></div>
        </div>
    </header>

            <div id="rc-layer" class="rc-layer" hidden>
        <div id="rc-area" class="bk-area">
            <div id="rc-stage" class="bk-stage">
                <div id="rc-swing" class="bk-swing">
                                        <div id="rc-book" class="bk-book closed"></div>
                    <div id="rc-hint" class="rc-hint" hidden>
                        <svg class="rc-hand" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">
                            <g fill="#fff" stroke="#4a2a18" stroke-width="2.5" stroke-linejoin="round">
                                <rect x="26" y="6" width="11" height="30" rx="5.5"/>
                                <path d="M18 34a6 6 0 0 1 10-4h9l10 4a7 7 0 0 1 5 7v8c0 7-5 12-12 12H30c-6 0-9-3-12-8l-6-9a5 5 0 0 1 8-6l3 3z"/>
                            </g>
                        </svg>
                        <span class="rc-hint-t">Geser untuk membuka halaman</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="bk-bar">
            <button id="rc-close" type="button" class="hm-btn ghost">✕ Tutup</button>
        </div>
    </div>

    <div class="hm-grid">
        <div class="hm-mapbox">
            <div id="heritage-map"></div>
            <div class="hm-dock">
                <div id="hm-legend" class="hm-legend"></div>

                <button id="rc-open" type="button" class="rm-mini">
                    <span class="rm-sp" style="left:112px;top:8px;font-size:13px">✦</span>
                    <span class="rm-sp" style="left:12px;top:92px;font-size:10px;animation-delay:1s">✦</span>
                    <span class="rm-stage">
                        <span class="rm-shadow"></span>
                        <span class="rm-bk">
                            <span class="rm-pages"></span>
                            <span class="rm-cov">
                                <svg class="rm-ic" viewBox="0 0 32 32" fill="none" stroke="#f3d27a" stroke-width="1.6" xmlns="http://www.w3.org/2000/svg"><circle cx="16" cy="16" r="12"/><path d="M16 7l3 9-3 9-3-9z" fill="#f3d27a" stroke="none"/><circle cx="16" cy="16" r="1.6" fill="#6a1115" stroke="none"/></svg>
                                <span class="rm-t">Memories<br>Book</span>
                                <span class="rm-shine"></span>
                            </span>
                            <span class="rm-clasp"></span>
                        </span>
                    </span>
                    <span class="rm-txt">
                        <b>Memories Book</b>
                        <span class="rm-desc">Kilas balik jurnal perjalananmu di Palembang.</span>
                        <span id="rc-sub"></span>
                        <span class="rm-pill">Buka Buku ›</span>
                    </span>
                </button>
            </div>
                        <div id="hm-toast" class="hm-toast" hidden></div>

            <div id="bk-chip" class="bk-chip" hidden></div>

            <div id="bk-layer" class="bk-layer" hidden>
                <div id="bk-area" class="bk-area">
                    <div id="bk-stage" class="bk-stage">
                        <div id="bk-swing" class="bk-swing">
                            <div id="bk-book" class="bk-book closed"></div>
                        </div>
                    </div>
                </div>
                <div class="bk-bar">
                    <a id="bk-nav-link" class="hm-btn brown" target="_blank" rel="noopener" href="#">➤ Navigasi Rute</a>
                    <a id="bk-games" class="hm-btn gold" href="#">🎮 Mainkan Games</a>
                    <button id="bk-tour" type="button" class="hm-btn ghost" hidden>🕶️ Kunjungi Secara Digital</button>
                    <button id="bk-close" type="button" class="hm-btn ghost">✕ Tutup Buku</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="tour-modal" class="hm-modal">
    <button id="tour-close" class="hm-modal-close" type="button">&times;</button>
    <iframe id="tour-frame" allowfullscreen loading="lazy"></iframe>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
(() => {
    const L = window.L;   // kunci satu salinan Leaflet; script lain tidak bisa menimpanya lagi
    const root = document.getElementById('hm-root');
    const sites = JSON.parse(root.dataset.sites);
    const GAMES_URL = root.dataset.games;
    const $ = (id) => document.getElementById(id);
    const esc = (s) => String(s ?? '').replace(/[&<>"']/g, (c) => (
        { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]
    ));

    /* ---------- Kategori & pengaturan ---------- */
        const CATS = {
        keraton:   { label: 'Keraton & Kesultanan', color: '#d9792b' },
        arkeologi: { label: 'Situs Arkeologi Sriwijaya', color: '#7c4dbd' },
        museum:    { label: 'Museum', color: '#2a6fcf' },
        religi:    { label: 'Religi & Tempat Ibadah', color: '#0f9d8a' },
        kolonial:  { label: 'Bangunan Kolonial', color: '#b3472f' },
        kampung:   { label: 'Kampung Budaya', color: '#d6336c' },
        monumen:   { label: 'Monumen & Ikon Kota', color: '#b08900' },
        lainnya:   { label: 'Lainnya', color: '#7a7a7a' }
    };
    const VISITED_COLOR = '#16a34a';   // warna pin setelah dikunjungi
    const NEARBY_METERS = 300;         // jarak untuk bonus "berada di lokasi"
    const catKey = (s) => (CATS[s.category] ? s.category : 'lainnya');
    const catOf = (s) => CATS[catKey(s)];

        /* ---------- Penyimpanan kunjungan (database lewat server) ---------- */
    const CSRF = root.dataset.csrf;
    let visits = {};
    try { visits = JSON.parse(root.dataset.visits) || {}; } catch (e) { visits = {}; }
    if (Array.isArray(visits)) visits = {};   // PHP mengirim [] kalau kosong

    async function api(method, url, body) {
        const res = await fetch(url, {
            method,
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF },
            body: JSON.stringify(body)
        });
        if (!res.ok) throw new Error('HTTP ' + res.status);
        return res.json();
    }

        // Simpan pengalaman (cerita, bintang, foto) ke server. Melempar error kalau gagal.
    let pendingSave = null;
    async function persistExperience(site, entry) {
        const data = await api('POST', `/visits/${site.slug}`, {
            story: entry.story, rating: entry.rating, nearby: entry.nearby, photos: entry.photos
        });
        return data.visit;
    }

    // Simpan hiasan (stiker + bingkai) ke server, ditunda 0,6 detik supaya tidak spam
    let decorTimer;
    const save = () => {
        const s = sites[BOOK.idx];
        clearTimeout(decorTimer);
        if (!s) return true;
        decorTimer = setTimeout(() => {
            const v = visits[s.slug];
            if (!v) return;
            // tunggu dulu kalau pengalaman masih dalam proses disimpan
            Promise.resolve(pendingSave).catch(() => {}).then(() =>
                api('PATCH', `/visits/${s.slug}/decor`, { frame: v.frame || 'polaroid', stickers: v.stickers || [] })
            ).catch((e) => console.error('Simpan hiasan gagal:', e));
        }, 600);
        return true;
    };

    const calcPoints = ({ story, photos, nearby }) =>
        2 + (photos.length >= 2 ? 1 : 0) + (story.length >= 100 ? 1 : 0) + (nearby ? 1 : 0);

    function compressImage(file, max = 800, quality = 0.7) {
        return new Promise((resolve, reject) => {
            const reader = new FileReader();
            reader.onerror = reject;
            reader.onload = () => {
                const img = new Image();
                img.onerror = reject;
                img.onload = () => {
                    const ratio = Math.min(1, max / Math.max(img.width, img.height));
                    const c = document.createElement('canvas');
                    c.width = Math.round(img.width * ratio);
                    c.height = Math.round(img.height * ratio);
                    c.getContext('2d').drawImage(img, 0, 0, c.width, c.height);
                    resolve(c.toDataURL('image/jpeg', quality));
                };
                img.src = reader.result;
            };
            reader.readAsDataURL(file);
        });
    }

    const fmtDist = (m) => (m < 1000 ? `${Math.round(m)} m` : `${(m / 1000).toFixed(1).replace('.', ',')} km`);
    const fmtTime = (s) => {
        const m = Math.max(1, Math.round(s / 60));
        return m < 60 ? `${m} menit` : `${Math.floor(m / 60)} jam ${m % 60} menit`;
    };

    let toastTimer;
    const toast = (msg) => {
        const t = $('hm-toast');
        t.textContent = msg;
        t.hidden = false;
        clearTimeout(toastTimer);
        toastTimer = setTimeout(() => { t.hidden = true; }, 4500);
    };

    /* ---------- Peta ---------- */
    const satellite = L.layerGroup([
        L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
            maxNativeZoom: 18, maxZoom: 19, detectRetina: true, attribution: 'Tiles &copy; Esri'
        }),
        L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/Reference/World_Boundaries_and_Places/MapServer/tile/{z}/{y}/{x}', {
            maxNativeZoom: 18, maxZoom: 19
        })
    ]);
        const voyager = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19, attribution: '&copy; OpenStreetMap contributors'
    });
    const dark = L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
        subdomains: 'abcd', maxZoom: 20, attribution: '&copy; OpenStreetMap &copy; CARTO'
    });

        const map = L.map('heritage-map', { layers: [voyager], zoomControl: false, zoomSnap: 0.25 })
        .setView([-2.9905, 104.7600], 13);
        L.control.layers({ 'Peta': voyager, 'Satelit': satellite }, null, { position: 'topright' }).addTo(map);

    /* ---------- Ikon ---------- */
    const pinIcon = (color, visited, active) => {
        const fill = visited ? VISITED_COLOR : color;
        const inner = visited
            ? `<circle cx="17" cy="16.5" r="7.5" fill="#fff"/><path d="M13 16.5l3 3 5-6" fill="none" stroke="${VISITED_COLOR}" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>`
            : `<circle cx="17" cy="16.5" r="6.5" fill="#fff"/>`;
        return L.divIcon({
            className: '', iconSize: [34, 46], iconAnchor: [17, 45],
            html: `<div style="transform-origin:50% 100%;transform:scale(${active ? 1.3 : 1});transition:transform .2s;filter:drop-shadow(0 4px 4px rgba(0,0,0,.45))">
                     <svg width="34" height="46" viewBox="0 0 34 46" xmlns="http://www.w3.org/2000/svg">
                       <path d="M17 1C8.2 1 1 8 1 16.7 1 28.5 17 45 17 45s16-16.5 16-28.3C33 8 25.8 1 17 1z" fill="${fill}" stroke="rgba(0,0,0,.35)" stroke-width="1.5"/>
                       ${inner}
                     </svg></div>`
        });
    };
    const personIcon = L.divIcon({
        className: '', iconSize: [40, 40], iconAnchor: [20, 20],
        html: `<div class="me-wrap"><div class="me-pulse"></div><div class="me-dot">
                 <svg viewBox="0 0 24 24" width="16" height="16" fill="#fff"><circle cx="12" cy="7" r="4"/><path d="M4 21c0-4.4 3.6-8 8-8s8 3.6 8 8z"/></svg>
               </div></div>`
    });

    /* ---------- State ---------- */
    let userLatLng = null, userMarker = null, userAccuracy = null;
    let activeIdx = null;
    let routeLine = null, routeToken = 0, lastOrigin = null, lastListPos = null, routing = false;
    const offCats = new Set();
    const panel = $('hm-panel');
    const grid = document.querySelector('.hm-grid');
    function showPanel(show) {
                // panel samping dihapus; detail kini tampil sebagai buku di atas peta
        map.invalidateSize({ animate: false });   // supaya peta menyesuaikan lebar baru
    }
    /* ---------- Skor & legenda ---------- */
    function updateScore() {
        const done = sites.filter((s) => visits[s.slug]);
        const pts = done.reduce((n, s) => n + (visits[s.slug].points || 0), 0);
                $('hm-score').innerHTML = `⭐ <b>${pts}</b> poin &nbsp;·&nbsp; 📍 ${done.length}/${sites.length} tempat`;
        $('rc-sub').textContent = done.length
            ? `${done.length} dari ${sites.length} kenangan tersimpan`
            : 'Belum ada kenangan tersimpan.';
    }

    function renderLegend() {
        const used = new Set(sites.map(catKey));
        $('hm-legend').innerHTML = '<b style="display:block;margin-bottom:6px">Kategori</b>'
            + Object.entries(CATS).filter(([k]) => used.has(k)).map(([k, c]) =>
                `<button type="button" data-cat="${k}" class="hm-legend-item${offCats.has(k) ? ' off' : ''}">
                   <span class="hm-dot" style="background:${c.color}"></span>${esc(c.label)}</button>`).join('');
        $('hm-legend').querySelectorAll('[data-cat]').forEach((b) => {
            b.onclick = () => {
                const k = b.dataset.cat;
                if (offCats.has(k)) offCats.delete(k); else offCats.add(k);
                markers.forEach((m, i) => { if (offCats.has(catKey(sites[i]))) map.removeLayer(m); else m.addTo(map); });
                renderLegend();
            };
        });
    }

    /* ---------- Buku Jurnal ---------- */
    const BOOK = { idx: null, pos: 0, sel: null, fresh: null, draft: null, t: null };
    const STICKERS = [
        ['⭐', 'Bintang'], ['🌸', 'Bunga'], ['🌼', 'Bunga kuning'], ['🌉', 'Jembatan Ampera'], ['🍤', 'Pempek'], ['🍜', 'Mie'],
        ['📸', 'Kamera'], ['❤️', 'Hati'], ['✨', 'Kilau'], ['🦋', 'Kupu-kupu'], ['🏛️', 'Bangunan'], ['🎀', 'Pita']
    ];
    const FRAMES = [['polaroid', 'Polaroid'], ['polos', 'Polos'], ['bulat', 'Bulat'], ['tape', 'Selotip']];
    let lastStats = { dist: '—', time: '—' };
    const fmtDate = (t) => new Date(t).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });

    function renderEmpty() { hideChip(); }
    function renderDetail(i) { openBook(i); }

    const setStats = (dist, time) => {
        lastStats = { dist, time };
        document.querySelectorAll('[data-dist]').forEach((e) => { e.textContent = dist; });
        document.querySelectorAll('[data-time]').forEach((e) => { e.textContent = time; });
        if (!$('bk-chip').hidden) showChip();
    };

    function hideChip() { $('bk-chip').hidden = true; }
    function showChip() {
        const chip = $('bk-chip');
        if (activeIdx === null) { chip.hidden = true; return; }
        const s = sites[activeIdx];
        chip.innerHTML = `<span><b>${esc(s.name)}</b> · ${esc(lastStats.dist)} · ${esc(lastStats.time)}</span>
            <button type="button" class="hm-btn brown" data-reopen>📖 Buka Buku</button>
            <button type="button" class="hm-btn ghost" data-drop>✕</button>`;
        chip.hidden = false;
        chip.querySelector('[data-reopen]').onclick = () => openBook(activeIdx);
        chip.querySelector('[data-drop]').onclick = deselect;
    }

    function fitBook() {
        const a = $('bk-area');
        if (!a || !a.clientWidth) return;
        const sc = Math.max(0.2, Math.min(1, (a.clientWidth - 16) / 960, (a.clientHeight - 8) / 610));
        $('bk-stage').style.transform = `scale(${sc})`;
    }
    window.addEventListener('resize', fitBook);

    function applyPos() {
        const book = $('bk-book');
        book.classList.toggle('closed', BOOK.pos === 0);
        book.querySelectorAll('.bk-sheet').forEach((sh) => {
            const n = Number(sh.dataset.sheet), flipped = n < BOOK.pos, was = sh.classList.contains('flipped');
            sh.classList.toggle('flipped', flipped);
            const z = flipped ? 10 + n : 10 - n;
            if (flipped || !was) sh.style.zIndex = z; else setTimeout(() => { sh.style.zIndex = z; }, 500);
        });
    }
    const go = (p) => { BOOK.pos = p; applyPos(); };

        function bookHTML(i) {
        const s = sites[i], c = catOf(s);
        const cover = s.photos[0]
            ? `<img src="${esc(s.photos[0])}" alt="" style="width:100%;height:100%;object-fit:cover">`
            : '<span style="font-size:64px">🏛️</span>';
        const rating = s.rating ? `★ ${Number(s.rating).toFixed(1)} (${s.reviews} ulasan)` : 'Belum ada ulasan';

        // ukuran teks menyesuaikan panjang sejarah supaya muat satu halaman tanpa scroll
        const fs = s.desc.length > 650 ? 14 : (s.desc.length > 420 ? 15 : 16.5);
        const polaroid = `<figure class="bk-pol big">
            ${s.photos[0]
                ? `<img src="${esc(s.photos[0])}" alt="${esc(s.name)}" onerror="this.style.display='none'">`
                : '<div class="bk-pol-ph">🏛️</div>'}
            <figcaption>${esc(s.name)}</figcaption>
        </figure>`;

        return `
        <div class="bk-leather r"></div><div class="bk-leather l"></div>

        <div class="bk-sheet" data-sheet="0">
            <div class="bk-face front">
                <div style="height:225px;border-radius:12px;overflow:hidden;background:linear-gradient(135deg,#7a3a2a,#3a2018);display:flex;align-items:center;justify-content:center;box-shadow:0 6px 16px rgba(0,0,0,.3);transform:rotate(-1deg)">${cover}</div>
                <span class="hm-badge" style="background:${c.color};margin-top:14px">${esc(c.label)}</span>
                <h2 class="bk-h" style="font-size:30px;margin-top:8px">${esc(s.name)}</h2>
                <div class="hm-rate">${rating}${s.era ? ' · ' + esc(s.era) : ''}</div>
                <div class="hm-stats">
                    <div><small>Jarak dari lokasi kamu</small><b data-dist>${esc(lastStats.dist)}</b></div>
                    <div><small>Estimasi waktu</small><b data-time>${esc(lastStats.time)}</b></div>
                </div>
                <button type="button" class="bk-nav n" data-go="1">Buka ›</button>
            </div>
            <div class="bk-face back">
                <h3 class="bk-h bk-hand">✦ Sejarah Singkat</h3>
                ${s.era ? `<div class="hm-rate">${esc(s.era)}</div>` : ''}
                <div class="bk-polwrap">${polaroid}</div>
                <button type="button" class="bk-nav p" data-go="0">‹ Sampul</button>
            </div>
        </div>

        <div class="bk-sheet" data-sheet="1">
            <div class="bk-face front">
                <h3 class="bk-h bk-hand">📜 Kisah Tempat Ini</h3>
                    <div class="bk-scroll">
                    <p class="hm-desc" style="max-height:none;overflow:visible;font-size:15px;line-height:1.7;font-family:Georgia,serif">${esc(s.desc)}</p>
                    <div class="rv-title">💬 Ulasan Pengunjung</div>
                    <div class="rv-list" data-reviews><div class="rv-empty">Memuat ulasan…</div></div>
                </div>
                <button type="button" class="bk-nav n" data-go="2">Lanjut ›</button>
            </div>
            <div class="bk-face back bk-gal" data-gallery-page></div>
        </div>

        <div class="bk-sheet" data-sheet="2">
            <div class="bk-face front" data-form-page></div>
            <div class="bk-face back" data-journal-page></div>
        </div>

        <div class="bk-sheet" data-sheet="3">
            <div class="bk-face front" data-deco-page></div>
        </div>`;
    }

        /* ---------- Ulasan pengunjung (3 terbaru, hanya yang punya foto) ---------- */
    const reviewCache = {};

    function renderReviews(list) {
        const box = document.querySelector('[data-reviews]');
        if (!box) return;
        if (!list || !list.length) {
            box.innerHTML = '<div class="rv-empty">Belum ada ulasan dengan foto. Jadilah yang pertama!</div>';
            return;
        }
        box.innerHTML = list.map((r) => `
            <div class="rv-item">
                <img src="${esc(r.photo)}" alt="" onerror="this.style.display='none'">
                <div class="rv-body">
                    <div class="rv-top">
                        <b>${esc(r.name)}</b>
                        ${r.rating ? `<span class="rv-stars">${'★'.repeat(r.rating)}${'☆'.repeat(5 - r.rating)}</span>` : ''}
                    </div>
                    ${r.story ? `<p class="rv-text">${esc(r.story)}</p>` : ''}
                </div>
            </div>`).join('');
    }

    async function loadReviews(i) {
        const slug = sites[i].slug;
        if (reviewCache[slug]) renderReviews(reviewCache[slug]);
        try {
            const res = await fetch(`/visits/${slug}/reviews`, { headers: { 'Accept': 'application/json' } });
            if (!res.ok) throw new Error('HTTP ' + res.status);
            reviewCache[slug] = await res.json();
            if (BOOK.idx === i) renderReviews(reviewCache[slug]);
        } catch (e) {
            console.error('Ulasan gagal dimuat:', e);
            if (BOOK.idx === i && !reviewCache[slug]) {
                const box = document.querySelector('[data-reviews]');
                if (box) box.innerHTML = '<div class="rv-empty">Ulasan belum bisa dimuat.</div>';
            }
        }
    }

    function openBook(i) {
        const layer = $('bk-layer'), s = sites[i], v = visits[s.slug];
        clearTimeout(BOOK.t);
        BOOK.idx = i; BOOK.pos = 0; BOOK.sel = null; BOOK.fresh = null;
        BOOK.draft = { photos: v ? [...v.photos] : [], rating: v ? v.rating : 0, story: v ? v.story : '' };
        if (!userLatLng) setStats('—', '—');
        hideChip();

        $('bk-book').innerHTML = bookHTML(i);
        $('bk-nav-link').href = `https://www.google.com/maps/dir/?api=1&destination=${s.lat},${s.lng}`;
        $('bk-games').href = GAMES_URL;
        $('bk-tour').hidden = !s.tour;
        $('bk-tour').onclick = () => openTour(s.tour);

        layer.hidden = false;
        fitBook();
        renderFormPage(); renderJournal(); renderDeco();
        applyPos();
        loadReviews(i);

        const sw = $('bk-swing');
        sw.classList.remove('swing'); void sw.offsetWidth; sw.classList.add('swing');
        requestAnimationFrame(() => layer.classList.add('show'));
        BOOK.t = setTimeout(() => { if (BOOK.idx === i && BOOK.pos === 0 && !layer.hidden) go(1); }, 1500);
    }

    function closeBook() {
        const layer = $('bk-layer');
        clearTimeout(BOOK.t);
        layer.classList.remove('show');
        setTimeout(() => { if (!layer.classList.contains('show')) layer.hidden = true; }, 400);
        showChip();
    }

    $('bk-book').addEventListener('click', (e) => {
        const g = e.target.closest('[data-go]');
        if (g) go(Number(g.dataset.go));
    });
    $('bk-close').onclick = closeBook;
    document.addEventListener('keydown', (e) => { if (e.key === 'Escape' && !$('bk-layer').hidden) closeBook(); });

        /* --- Halaman galeri (kiri) & pengalaman (kanan) --- */
    function renderFormPage() {
        const s = sites[BOOK.idx], d = BOOK.draft;
        const gal = document.querySelector('[data-gallery-page]');
        const pg = document.querySelector('[data-form-page]');

        gal.innerHTML = `
            <h3 class="bk-h bk-hand">📸 Galeri Fotomu</h3>
            <p class="hm-rate" style="font-size:14px;line-height:1.6;margin:0">Tambahkan hingga 3 foto kenanganmu di ${esc(s.name)}.</p>
            <div class="hm-thumbs" data-thumbs></div>
            <input data-file type="file" accept="image/*" multiple hidden>
            <button type="button" class="bk-nav p" data-go="1">‹ Kembali</button>`;

        pg.innerHTML = `
            <h3 class="bk-h bk-hand">✍️ Pengalamanmu</h3>
            <textarea class="bk-ta" style="height:190px;font-size:14px" data-story placeholder="Tulis pengalamanmu di sini... (singkat pun boleh!)">${esc(d.story)}</textarea>
            <div style="color:var(--muted);margin-top:8px;font-size:13px">Seberapa seru tempat ini?</div>
            <div class="hm-stars" data-stars></div>
            <div class="hm-err" data-err></div>
                        <button type="button" class="bk-nav n" data-save>Next ›</button>`;

        const thumbs = gal.querySelector('[data-thumbs]'), fileEl = gal.querySelector('[data-file]');
        const starsEl = pg.querySelector('[data-stars]'), err = pg.querySelector('[data-err]');

        const drawThumbs = () => {
            thumbs.innerHTML = d.photos.map((p, k) => `<div class="hm-thumb"><img src="${esc(p)}" alt=""><button type="button" data-rm="${k}">&times;</button></div>`).join('')
                + (d.photos.length < 3 ? '<button type="button" class="hm-add" data-add>+</button>' : '');
            thumbs.querySelectorAll('[data-rm]').forEach((b) => { b.onclick = () => { d.photos.splice(Number(b.dataset.rm), 1); drawThumbs(); }; });
            const add = thumbs.querySelector('[data-add]');
            if (add) add.onclick = () => fileEl.click();
        };
        const drawStars = () => {
            starsEl.innerHTML = [1, 2, 3, 4, 5].map((n) => `<button type="button" data-n="${n}" class="${n <= d.rating ? 'on' : ''}">★</button>`).join('');
            starsEl.querySelectorAll('[data-n]').forEach((b) => { b.onclick = () => { d.rating = Number(b.dataset.n); drawStars(); }; });
        };
        drawThumbs(); drawStars();

        pg.querySelector('[data-story]').oninput = (e) => { d.story = e.target.value; };
        fileEl.onchange = async (e) => {
            const files = [...e.target.files].slice(0, Math.max(0, 3 - d.photos.length));
            for (const f of files) { try { d.photos.push(await compressImage(f)); } catch (x) { /* lewati file rusak */ } }
            e.target.value = '';
            drawThumbs();
        };

                let saving = false;
        pg.querySelector('[data-save]').onclick = async () => {
            if (saving) return;
            const story = d.story.trim();
            if (!d.photos.length && !story && !d.rating) { err.textContent = 'Isi salah satu dulu ya: foto, cerita, atau bintang.'; return; }
            err.textContent = '';
            const old = visits[s.slug];

            // tidak ada perubahan: langsung ke halaman berikutnya tanpa kirim ke server
            const same = old && (old.story || '') === story && (old.rating || 0) === (d.rating || 0)
                && JSON.stringify(old.photos || []) === JSON.stringify(d.photos);
            if (same) { go(3); return; }

            saving = true;
            const nearby = !!userLatLng && map.distance(userLatLng, [s.lat, s.lng]) <= NEARBY_METERS;
            const entry = {
                story, photos: [...d.photos], rating: d.rating || 0, nearby, points: nearby ? 15 : 10,
                stickers: old ? (old.stickers || []) : [], frame: old ? (old.frame || 'polaroid') : 'polaroid',
                at: old ? old.at : Date.now()
            };

            // tampilkan hasilnya dulu dan langsung balik halaman, simpan ke server di belakang layar
            visits[s.slug] = { ...entry };
            refreshPin(BOOK.idx);
            updateScore();
            renderJournal(); renderDeco();
            requestAnimationFrame(() => go(3));
            toast(`🎉 Kamu dapat +${entry.points} poin dari ${s.name}!`);

            try {
                pendingSave = persistExperience(s, entry);
                const saved = await pendingSave;
                const cur = visits[s.slug] || {};
                visits[s.slug] = {
                    ...saved,
                    stickers: cur.stickers || saved.stickers || [],
                    frame: cur.frame || saved.frame || 'polaroid'
                };
                d.photos = [...(saved.photos || d.photos)];
                updateScore();
                delete reviewCache[s.slug];
                loadReviews(BOOK.idx);
                if (saved.points != null && saved.points !== entry.points) { renderJournal(); renderDeco(); }
            } catch (e) {
                console.error('Simpan gagal:', e);
                if (old) visits[s.slug] = old; else delete visits[s.slug];
                refreshPin(BOOK.idx);
                updateScore();
                renderFormPage(); renderJournal(); renderDeco();
                go(2);
                toast('Gagal menyimpan. Pastikan kamu sudah login, lalu coba lagi.');
            } finally {
                saving = false;
                pendingSave = null;
            }
        };
    }

    /* --- Halaman jurnal (kiri) --- */
    function renderJournal() {
        const s = sites[BOOK.idx], v = visits[s.slug], pg = document.querySelector('[data-journal-page]');
        if (!v) {
            pg.innerHTML = `<h3 class="bk-h bk-hand">My Palembang Journey</h3>
                <p class="hm-rate" style="font-size:14px;line-height:1.6">Isi pengalamanmu di halaman sebelumnya, lalu jurnal ini akan terisi. Setelah itu kamu bisa menghiasnya dengan stiker.</p>
            <button type="button" class="bk-nav p" data-go="2">‹ Kembali</button>`;
            return;
        }
        pg.innerHTML = `
            <div class="bk-hand" style="color:#8a6a4a;font-size:12px">${fmtDate(v.at)}</div>
            <h3 class="bk-h bk-hand">Hari ini aku mengunjungi ${esc(s.name)}</h3>
            <div class="bk-jphotos fr-${esc(v.frame || 'polaroid')}" data-jphotos>
                ${v.photos.map((p, k) => `<div class="bk-ph" style="--rot:${[-3, 2, -1.5][k % 3]}deg;width:118px;height:118px"><img src="${esc(p)}" alt=""></div>`).join('')}
            </div>
            ${v.story ? `<p class="bk-hand" style="font-size:15px;line-height:1.6;white-space:pre-line;margin-top:12px;max-height:130px;overflow:auto">${esc(v.story)}</p>` : ''}
            <div style="color:#f5a623;font-size:20px;margin-top:6px">${'★'.repeat(v.rating)}${'☆'.repeat(5 - v.rating)} <small style="color:#8a6a4a">+${v.points} poin</small></div>
            <div class="bk-stlayer" data-stlayer></div>
            <button type="button" class="bk-nav p" data-go="2">‹ Kembali</button>`;
        drawStickers();
    }

    function drawStickers() {
        const lay = document.querySelector('[data-stlayer]'), v = visits[sites[BOOK.idx].slug];
        if (!lay || !v) return;
        const fresh = BOOK.fresh; BOOK.fresh = null;
        lay.innerHTML = (v.stickers || []).map((k, n) =>
            `<div class="bk-stk${n === fresh ? ' pop' : ''}${BOOK.sel === n ? ' sel' : ''}" data-n="${n}" style="left:${k.x}%;top:${k.y}%;--r:${k.r}deg;--s:${k.s}">${k.e}</div>`).join('');
        lay.querySelectorAll('.bk-stk').forEach((el) => { el.onpointerdown = (ev) => startDrag(ev, el); });
    }

    function selectSticker(n) {
        BOOK.sel = n;
        document.querySelectorAll('.bk-stk').forEach((el) => el.classList.toggle('sel', Number(el.dataset.n) === n));
    }

    function startDrag(ev, el) {
        ev.preventDefault();
        const v = visits[sites[BOOK.idx].slug], n = Number(el.dataset.n), k = v.stickers[n];
        selectSticker(n);
        const rect = el.parentElement.getBoundingClientRect();
        el.setPointerCapture(ev.pointerId);
        el.classList.add('drag');
        const move = (e) => {
            k.x = Math.min(96, Math.max(4, ((e.clientX - rect.left) / rect.width) * 100));
            k.y = Math.min(96, Math.max(4, ((e.clientY - rect.top) / rect.height) * 100));
            el.style.left = k.x + '%'; el.style.top = k.y + '%';
        };
        const up = () => {
            el.classList.remove('drag');
            el.removeEventListener('pointermove', move);
            el.removeEventListener('pointerup', up);
            el.removeEventListener('pointercancel', up);
            save(visits);
        };
        el.addEventListener('pointermove', move);
        el.addEventListener('pointerup', up);
        el.addEventListener('pointercancel', up);
    }

    /* --- Halaman hias (kanan) --- */
    function renderDeco() {
        const s = sites[BOOK.idx], v = visits[s.slug], pg = document.querySelector('[data-deco-page]');
        const done = sites.filter((x) => visits[x.slug]).length;
        pg.innerHTML = `
            ${v ? `<div class="bk-yay">🎉 Yay! <b>+${v.points} poin</b> · 📍 ${done}/${sites.length} tempat terkumpul</div>`
                : '<p class="hm-rate" style="font-size:13px">Isi pengalamanmu dulu, lalu kamu bisa menghias jurnal di sini.</p>'}
            <b style="font-size:13px">Stiker</b>
            <div class="bk-tray">${STICKERS.map(([e, n]) => `<button type="button" data-stk="${e}" title="${esc(n)}">${e}</button>`).join('')}</div>
            <b style="font-size:13px">Bingkai foto</b>
            <div class="bk-chips">${FRAMES.map(([k, n]) => `<button type="button" data-fr="${k}" class="${v && (v.frame || 'polaroid') === k ? 'on' : ''}">${n}</button>`).join('')}</div>
            <b style="font-size:13px">Stiker terpilih</b>
            <div class="bk-chips">
                <button type="button" data-tool="rot">⟳ Putar</button><button type="button" data-tool="big">＋ Besar</button>
                <button type="button" data-tool="small">－ Kecil</button><button type="button" data-tool="del">🗑 Hapus</button>
            </div>
            <small style="color:var(--muted)">Seret stiker pada halaman jurnal untuk memindahkannya.</small>
            <button type="button" class="bk-nav n" data-finish>Selesai ✓</button>`;

        const need = () => { if (!visits[s.slug]) { toast('Isi pengalamanmu dulu ya.'); return false; } return true; };

        pg.querySelectorAll('[data-stk]').forEach((b) => {
            b.onclick = () => {
                if (!need()) return;
                const st = visits[s.slug].stickers = visits[s.slug].stickers || [];
                st.push({ e: b.dataset.stk, x: 25 + Math.random() * 50, y: 62 + Math.random() * 26, r: Math.round(Math.random() * 30 - 15), s: 1 });
                BOOK.fresh = st.length - 1; BOOK.sel = st.length - 1;
                save(visits); drawStickers();
            };
        });
        pg.querySelectorAll('[data-fr]').forEach((b) => {
            b.onclick = () => {
                if (!need()) return;
                visits[s.slug].frame = b.dataset.fr; save(visits);
                const jp = document.querySelector('[data-jphotos]');
                if (jp) jp.className = 'bk-jphotos fr-' + b.dataset.fr;
                renderDeco();
            };
        });
        pg.querySelectorAll('[data-tool]').forEach((b) => {
            b.onclick = () => {
                if (!need()) return;
                const st = visits[s.slug].stickers || [], n = BOOK.sel, k = st[n];
                if (n === null || !k) { toast('Pilih stiker di jurnal dulu.'); return; }
                const t = b.dataset.tool;
                if (t === 'del') { st.splice(n, 1); BOOK.sel = null; save(visits); drawStickers(); return; }
                if (t === 'rot') k.r = (k.r + 15) % 360;
                if (t === 'big') k.s = Math.min(2.5, +(k.s + 0.2).toFixed(2));
                if (t === 'small') k.s = Math.max(0.5, +(k.s - 0.2).toFixed(2));
                const el = document.querySelector(`.bk-stk[data-n="${n}"]`);
                if (el) { el.style.setProperty('--r', k.r + 'deg'); el.style.setProperty('--s', k.s); }
                save(visits);
            };
        });
        pg.querySelector('[data-finish]').onclick = closeBook;
    }

        /* ---------- Memories Book Recap ---------- */
    const RC = { pos: 0, sheets: 0, t: null, t2: null, hint: false, seen: false };
    const rcIsOpen = () => !$('rc-layer').hidden;

    function rcPage(s, v, no) {
        const c = catOf(s);
        return `
            <div class="bk-hand" style="color:#8a6a4a;font-size:12px">${fmtDate(v.at)}</div>
            <h3 class="bk-h bk-hand">${esc(s.name)}</h3>
            <span class="hm-badge" style="background:${c.color}">${esc(c.label)}</span>
            <div class="bk-jphotos fr-${esc(v.frame || 'polaroid')}">
                ${(v.photos || []).map((p, k) => `<div class="bk-ph" style="--rot:${[-3, 2, -1.5][k % 3]}deg;width:118px;height:118px"><img src="${esc(p)}" alt=""></div>`).join('')}
            </div>
            ${v.story ? `<p class="bk-hand" style="font-size:15px;line-height:1.6;white-space:pre-line;margin-top:12px;max-height:110px;overflow:auto">${esc(v.story)}</p>` : ''}
            ${v.rating ? `<div style="color:#f5a623;font-size:20px;margin-top:6px">${'★'.repeat(v.rating)}${'☆'.repeat(5 - v.rating)}</div>` : ''}
            <div class="bk-stlayer">${(v.stickers || []).map((k) => `<div class="bk-stk" style="left:${k.x}%;top:${k.y}%;--r:${k.r}deg;--s:${k.s}">${k.e}</div>`).join('')}</div>
            <small class="rc-no">${no}</small>`;
    }

    function rcBuild() {
        const done = sites.filter((s) => visits[s.slug]).map((s) => ({ s, v: visits[s.slug] }))
            .sort((a, b) => (a.v.at || 0) - (b.v.at || 0));
        if (!done.length) return 0;
        const left = sites.length - done.length;

        const cover = `<div style="height:100%;display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;border:2px solid #d4a73a;border-radius:8px;color:#f3d27a">
            <div style="font-size:46px">🧭</div>
            <h2 class="bk-h" style="color:#f3d27a;font-size:34px;font-style:italic;margin:14px 0 6px">Memories Book</h2>
            <div style="letter-spacing:.4em;font-size:15px">— RECAP —</div>
            <div style="margin-top:22px;font-size:13px;color:#e8c777">${done.length} dari ${sites.length} tempat sudah dikunjungi</div></div>`;
        const end = `<div style="height:100%;display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center">
            <div style="font-size:48px">${left ? '🧭' : '🎉'}</div>
            <h3 class="bk-h bk-hand" style="margin-top:12px">${left ? 'Petualanganmu belum selesai' : 'Semua tempat sudah dikunjungi!'}</h3>
            <p class="hm-rate" style="font-size:14px;line-height:1.6">${left ? `Masih ada ${left} tempat cagar budaya yang menunggu untuk kamu jelajahi.` : 'Kamu sudah mengumpulkan semua kenangan di Palembang.'}</p></div>`;

        const faces = [cover, ...done.map((x, k) => rcPage(x.s, x.v, k + 1)), end];
        if (faces.length % 2) faces.push('<div class="bk-hand" style="height:100%;display:flex;align-items:center;justify-content:center;font-size:34px;color:#c9b08a">✦</div>');

        RC.sheets = faces.length / 2;
        let html = '<div class="bk-leather r"></div><div class="bk-leather l"></div>';
        for (let j = 0; j < RC.sheets; j++) {
            html += `<div class="bk-sheet" data-sheet="${j}">
                <div class="bk-face front rc-page"${j === 0 ? ' style="background:linear-gradient(135deg,#a4262a,#5a0d10);color:#f3d27a;padding:20px"' : ''}>${faces[2 * j]}</div>
                <div class="bk-face back rc-page">${faces[2 * j + 1]}</div></div>`;
        }
        $('rc-book').innerHTML = html;
        return done.length;
    }

    function rcFit() {
        const a = $('rc-area');
        if (!a || !a.clientWidth) return;
        const sc = Math.max(0.2, Math.min(1.1, (a.clientWidth - 16) / 960, (a.clientHeight - 8) / 610));
        $('rc-stage').style.transform = `scale(${sc})`;
    }

    function rcApply() {
        const book = $('rc-book');
        book.classList.toggle('closed', RC.pos === 0);
        book.classList.toggle('ended', RC.pos === RC.sheets);
        book.querySelectorAll('.bk-sheet').forEach((sh) => {
            const n = Number(sh.dataset.sheet), flipped = n < RC.pos, was = sh.classList.contains('flipped');
            sh.classList.toggle('flipped', flipped);
            const z = flipped ? 100 + n : 100 - n;
            if (flipped || !was) sh.style.zIndex = z; else setTimeout(() => { sh.style.zIndex = z; }, 500);
        });
        const h = $('rc-hint');
        h.hidden = !RC.hint || RC.pos >= RC.sheets;
        h.classList.toggle('c', RC.pos === 0);
    }

    function rcGo(p) {
        clearTimeout(RC.t);
        RC.pos = Math.max(0, Math.min(RC.sheets, p));
        rcApply();
    }

    function rcOpenBook() {
        if (!rcBuild()) { toast('Belum ada kenangan. Klik pin lokasi dan isi pengalamanmu dulu ya.'); return; }
        const layer = $('rc-layer');
        RC.pos = 0;
        layer.hidden = false;
        rcFit();
        rcApply();
        const sw = $('rc-swing');
        sw.classList.remove('swing'); void sw.offsetWidth; sw.classList.add('swing');
        requestAnimationFrame(() => layer.classList.add('show'));
        clearTimeout(RC.t);
        RC.t = setTimeout(() => { if (rcIsOpen() && RC.pos === 0) rcGo(1); }, 1400);
        RC.seen = false; RC.hint = false;
        clearTimeout(RC.t2);
        RC.t2 = setTimeout(() => { if (rcIsOpen() && !RC.seen) { RC.hint = true; rcApply(); } }, 2600);
    }

    function rcCloseBook() {
        const layer = $('rc-layer');
        clearTimeout(RC.t);
        layer.classList.remove('show');
        setTimeout(() => { if (!layer.classList.contains('show')) layer.hidden = true; }, 400);
    }

    $('rc-open').onclick = rcOpenBook;
    $('rc-close').onclick = rcCloseBook;
        /* Seret kertas untuk membalik halaman */
    const rcBookEl = $('rc-book');
    let rcDrag = null;

    rcBookEl.addEventListener('pointerdown', (e) => {
        if (e.button > 0) return;
        const rect = rcBookEl.getBoundingClientRect();
        const dir = e.clientX >= rect.left + rect.width / 2 ? 1 : -1;   // kanan = maju, kiri = mundur
        const idx = dir === 1 ? RC.pos : RC.pos - 1;
        if (idx < 0 || idx >= RC.sheets) return;
        const sh = rcBookEl.querySelector(`.bk-sheet[data-sheet="${idx}"]`);
        if (!sh) return;
        e.preventDefault();
        clearTimeout(RC.t);
        RC.seen = true; RC.hint = false; $('rc-hint').hidden = true;
        rcDrag = { dir, sh, x0: e.clientX, pw: rect.width / 2, p: dir === 1 ? 0 : 1, moved: false };
        sh.style.transition = 'none';
        sh.style.zIndex = 1000;
        rcBookEl.classList.add('dragging');
        rcBookEl.setPointerCapture(e.pointerId);
    });

    rcBookEl.addEventListener('pointermove', (e) => {
        if (!rcDrag) return;
        const d = rcDrag, dx = e.clientX - d.x0;
        if (Math.abs(dx) > 5) d.moved = true;
        d.p = Math.min(1, Math.max(0, (d.dir === 1 ? 0 : 1) - dx / (d.pw * 1.4)));
        d.sh.style.transform = `rotateY(${-180 * d.p}deg)`;
    });

    const rcRelease = () => {
        if (!rcDrag) return;
        const d = rcDrag; rcDrag = null;
        rcBookEl.classList.remove('dragging');
        let target = RC.pos;
        if (!d.moved) target = RC.pos + d.dir;                          // ketuk singkat
        else if (d.dir === 1 && d.p > 0.3) target = RC.pos + 1;
        else if (d.dir === -1 && d.p < 0.7) target = RC.pos - 1;
        d.sh.style.transition = '';
        d.sh.style.transform = '';
        rcGo(target);
        d.sh.style.zIndex = 1000;                                       // tetap di atas sampai animasi selesai
        setTimeout(rcApply, 700);
    };
    rcBookEl.addEventListener('pointerup', rcRelease);
    rcBookEl.addEventListener('pointercancel', rcRelease);
    window.addEventListener('resize', () => { if (rcIsOpen()) rcFit(); });
    document.addEventListener('keydown', (e) => {
        if (!rcIsOpen()) return;
        if (e.key === 'ArrowRight') rcGo(RC.pos + 1);
        if (e.key === 'ArrowLeft') rcGo(RC.pos - 1);
        if (e.key === 'Escape') rcCloseBook();
    });

    /* ---------- Rute ---------- */
    function clearRoute() {
        routeToken++;
        routing = false;
        if (routeLine) { map.removeLayer(routeLine); routeLine = null; }
    }

    async function fetchJson(url, ms = 5000) {
        const ctrl = new AbortController();
        const timer = setTimeout(() => ctrl.abort(), ms);
        try {
            const res = await fetch(url, { signal: ctrl.signal });
            return await res.json();
        } finally {
            clearTimeout(timer);
        }
    }

    async function drawRoute(i, refit = true) {
        const s = sites[i], dest = L.latLng(s.lat, s.lng), token = ++routeToken;
        if (routeLine) { map.removeLayer(routeLine); routeLine = null; }
        setStats('Menghitung…', '…');
        lastOrigin = userLatLng;
        routing = true;

        const straight = map.distance(userLatLng, dest);
        let coords = [userLatLng, dest], meters = straight, seconds = null, note = '';

        if (straight > 100000) {
            note = 'Lokasimu jauh dari Palembang, jadi ditampilkan garis lurus.';
        } else {
            try {
                const path = `${userLatLng.lng},${userLatLng.lat};${s.lng},${s.lat}?overview=full&geometries=geojson`;
                const servers = [
                    'https://router.project-osrm.org/route/v1/driving/',
                    'https://routing.openstreetmap.de/routed-car/route/v1/driving/'
                ];
                let json = null;
                for (const base of servers) {
                    try {
                        const j = await fetchJson(base + path);
                        if (j.code === 'Ok' && j.routes.length) { json = j; break; }
                    } catch (e) { /* coba server berikutnya */ }
                }
                if (!json) throw new Error('no route');
                const r = json.routes[0];
                coords = r.geometry.coordinates.map(([lng, lat]) => [lat, lng]);
                meters = r.distance;
                seconds = r.duration;
            } catch (err) {
                seconds = straight / (30000 / 3600);
                note = 'Rute jalan tidak tersedia, memakai garis lurus (perkiraan).';
            }
        }

        if (token !== routeToken) return;
        routing = false;

                setStats(fmtDist(meters), seconds !== null ? `${fmtTime(seconds)} 🚗` : '—');
        if (note) toast(note);

        try {
            routeLine = L.polyline(coords, {
                color: '#2f6fed', weight: 5, opacity: 0.9,
                dashArray: coords.length === 2 ? '3 9' : '10 8'
            }).addTo(map);
            if (refit) map.fitBounds(routeLine.getBounds(), { padding: [70, 70], maxZoom: 16 });
        } catch (err) {
            routeLine = null;
            console.error('Gagal menggambar garis rute:', err, coords.slice(0, 3));
        }
    }

    /* ---------- Pilih & lepas lokasi ---------- */
    function refreshPin(i) {
        markers[i].setIcon(pinIcon(catOf(sites[i]).color, !!visits[sites[i].slug], activeIdx === i));
    }

    function selectSite(i) {
        const prev = activeIdx;
        activeIdx = i;
        if (prev !== null && prev !== i) refreshPin(prev);
        refreshPin(i);
        showPanel(true);
        renderDetail(i);
        if (userLatLng) {
            drawRoute(i);
        } else {
            clearRoute();
            map.flyTo([sites[i].lat, sites[i].lng], Math.max(map.getZoom(), 15), { duration: 1 });
            toast('Izinkan akses lokasi untuk melihat jarak dan rute.');
        }
    }

    function deselect() {
        const prev = activeIdx;
        activeIdx = null;
        clearRoute();
        if (prev !== null) refreshPin(prev);
        renderEmpty();
    }

    /* ---------- Marker ---------- */
    const markers = sites.map((s, i) => {
        const m = L.marker([s.lat, s.lng], { icon: pinIcon(catOf(s).color, !!visits[s.slug], false), riseOnHover: true }).addTo(map);
        m.bindTooltip(`
            <div style="display:flex;gap:8px;align-items:center;max-width:240px">
                ${s.photos[0] ? `<img src="${esc(s.photos[0])}" alt="" style="width:52px;height:52px;object-fit:cover;border-radius:8px">` : '<span style="font-size:28px">🏛️</span>'}
                <div><b style="font-size:13px">${esc(s.name)}</b><br>
                <span style="color:#7b6a5d">${esc(catOf(s).label)}</span><br>
                <span style="color:#7b6a5d">Klik untuk detail &amp; rute</span></div>
            </div>`, { direction: 'top', offset: [0, -44], opacity: 1, className: 'hm-tip' });
        m.on('click', () => selectSite(i));
        return m;
    });

    const bounds = sites.map((s) => [s.lat, s.lng]);
    if (bounds.length > 1) map.fitBounds(bounds, { padding: [60, 60], maxZoom: 15 });
    setTimeout(() => map.invalidateSize(), 200);

    /* ---------- Lokasi pengguna ---------- */
    map.on('locationfound', (e) => {
        userLatLng = e.latlng;
                if (!userMarker) {
            userMarker = L.marker(e.latlng, { icon: personIcon, zIndexOffset: 1000 }).addTo(map).bindTooltip('Lokasimu');
        } else {
            userMarker.setLatLng(e.latlng);
        }
        try {
            if (!userAccuracy) {
                userAccuracy = L.circle(e.latlng, { radius: e.accuracy, color: '#2563eb', weight: 1, fillOpacity: 0.08 }).addTo(map);
            } else {
                userAccuracy.setLatLng(e.latlng).setRadius(e.accuracy);
            }
        } catch (err) {
            console.error('Lingkaran akurasi gagal:', err, e.latlng, e.accuracy);
        }
        if (activeIdx === null) {
            if (!lastListPos || map.distance(lastListPos, userLatLng) > 100) { lastListPos = userLatLng; renderEmpty(); }
        } else if (!routing && (!lastOrigin || map.distance(lastOrigin, userLatLng) > 150)) {
            drawRoute(activeIdx, !lastOrigin);
        }
    });
    map.on('locationerror', () => toast('Lokasi tidak bisa diakses. Izinkan akses lokasi di browser.'));

    const startLocate = () => map.locate({ watch: true, enableHighAccuracy: true });
    startLocate();

    const LocateCtl = L.Control.extend({
        options: { position: 'bottomright' },
        onAdd() {
            const b = L.DomUtil.create('button', 'hm-locate');
            b.type = 'button';
            b.title = 'Ke lokasiku';
            b.innerHTML = '🧍';
            L.DomEvent.disableClickPropagation(b);
            b.onclick = () => {
                if (userLatLng) { map.flyTo(userLatLng, 16); } else { map.stopLocate(); startLocate(); }
            };
            return b;
        }
    });
    map.addControl(new LocateCtl());                       // ditambah dulu supaya berada di bawah tombol zoom
    L.control.zoom({ position: 'bottomright' }).addTo(map);

    /* ---------- Pencarian ---------- */
    const input = $('hm-search'), results = $('hm-results');
    input.addEventListener('input', () => {
        const q = input.value.trim().toLowerCase();
        if (!q) { results.hidden = true; return; }
        const found = sites.map((s, i) => ({ s, i }))
            .filter(({ s }) => `${s.name} ${catOf(s).label} ${s.era}`.toLowerCase().includes(q)).slice(0, 6);
        results.innerHTML = found.length
            ? found.map(({ s, i }) => `<button type="button" data-i="${i}">${esc(s.name)} <small style="color:#7b6a5d">· ${esc(catOf(s).label)}</small></button>`).join('')
            : '<div style="padding:10px 14px;font-size:13px;color:#7b6a5d">Tidak ada hasil</div>';
        results.hidden = false;
        results.querySelectorAll('[data-i]').forEach((b) => {
            b.onclick = () => { results.hidden = true; input.value = sites[b.dataset.i].name; selectSite(Number(b.dataset.i)); };
        });
    });
    document.addEventListener('click', (e) => { if (!e.target.closest('.hm-search')) results.hidden = true; });

    /* ---------- Kunjungan digital ---------- */
    function openTour(url) {
        $('tour-frame').src = url;
        $('tour-modal').classList.add('open');
    }
    $('tour-close').onclick = () => {
        $('tour-frame').src = '';
        $('tour-modal').classList.remove('open');
    };

    /* ---------- Mulai ---------- */
    renderLegend();
    updateScore();
    renderEmpty();
})();
</script>