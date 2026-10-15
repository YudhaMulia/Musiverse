<dialog class="modal" id="modal-buat">
    <form method="POST" action="#" class="modal__box">
        @csrf
        <div class="modal__head">
            <h3>Buat Ruangan <span data-game-name>Musiverse</span></h3>
            <button type="button" class="modal__close" data-close aria-label="Tutup">&times;</button>
        </div>

        <p class="modal__label">Maksimal pemain</p>
        <div class="pilih-pemain">
            <label><input type="radio" name="max_players" value="2"><span>2 Pemain</span></label>
            <label><input type="radio" name="max_players" value="3"><span>3 Pemain</span></label>
            <label><input type="radio" name="max_players" value="4" checked><span>4 Pemain</span></label>
        </div>

        <p class="modal__hint">Sistem akan membuat kode unik 6 karakter yang bisa kamu bagikan ke teman.</p>

        <button type="submit" class="btn-gold btn-block">Buat Ruangan &amp; Masuk Ruang Tunggu</button>
    </form>
</dialog>
