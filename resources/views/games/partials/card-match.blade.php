<article class="game-card game-card--art-right reveal" data-tilt>
    <div class="game-card__art" style="background-image: url('{{ asset('images/games/match.webp') }}')"></div>

    <div class="game-card__content">
        <h2 class="game-title">Musiverse Match</h2>

        <p class="game-desc">
            64 kartu tersembunyi menyimpan 32 pasang gambar budaya Palembang. Buka dua kartu,
            temukan pasangan yang sama, dan terus jalan selama tebakanmu tepat.
            Sekali meleset, giliran pindah ke lawan!
        </p>

        <div class="btn-row">
            <x-btn-play label="Single Player" data-solo="Musiverse Match" />
            <x-btn-play label="Multi Player" data-open="modal-buat" data-game="Musiverse Match" />
        </div>

        <ul class="badges">
            <li>8&times;8 Kartu</li>
            <li>2&ndash;4 Pemain</li>
            <li>Bergiliran</li>
        </ul>
    </div>
</article>
