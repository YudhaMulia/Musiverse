<article class="game-card game-card--art-right reveal" data-tilt>
    <div class="game-card__art" style="background-image: url('{{ asset('images/games/match.webp') }}')"></div>

    <div class="game-card__content">
        <h2 class="game-title">Musiverse Match</h2>

        <p class="game-desc">
            36 kartu tersembunyi menyimpan 18 pasang gambar budaya Palembang. Buka dua kartu,
            temukan pasangan yang sama, dan terus jalan selama tebakanmu tepat.
            Sekali meleset, giliran pindah ke lawan!
        </p>

        <div class="btn-row">
            <x-btn-play label="Main Sendiri" :href="route('games.match.play', ['solo' => 1])" />
            @auth
                <x-btn-play label="Main Bersama" :href="route('games.room', 'match')" />
            @else
                <x-btn-play label="Main Bersama" data-open="modal-login"
                            data-kembali="{{ route('games.room', 'match', false) }}" />
            @endauth
        </div>

        <ul class="badges">
            <li>6&times;6 Kartu</li>
            <li>2&ndash;4 Pemain</li>
            <li>Bergiliran</li>
        </ul>
    </div>
</article>
