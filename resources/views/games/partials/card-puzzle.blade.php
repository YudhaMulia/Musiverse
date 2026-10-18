<article class="game-card game-card--art-left reveal" data-tilt>
    <div class="game-card__art" style="background-image: url('{{ asset('images/games/puzzle.webp') }}')"></div>

    <div class="game-card__content">
        <h2 class="game-title game-title--stack">
            <span class="game-title--light">Musiverse</span>
            <span>Puzzle</span>
        </h2>

        <p class="game-desc">
            Setiap gambar menyimpan satu kata budaya Palembang. Amati selama 5 detik,
            lalu jadilah yang tercepat menekan tombol merah! Salah menebak? Kesempatanmu
            hilang dan lawan bisa merebutnya. Hanya yang jeli dan cepat yang jadi juara!
        </p>

        <div class="btn-row">
            <x-btn-play label="Main Sendiri" :href="route('games.puzzle.play', ['solo' => 1])" />
            @auth
                <x-btn-play label="Main Bersama" :href="route('games.room', 'puzzle')" />
            @else
                <x-btn-play label="Main Bersama" data-open="modal-login"
                            data-kembali="{{ route('games.room', 'puzzle', false) }}" />
            @endauth
        </div>

        <ul class="badges">
            <li>10 Soal</li>
            <li>Tombol Rebutan</li>
            <li>2&ndash;4 Pemain</li>
        </ul>
    </div>
</article>
