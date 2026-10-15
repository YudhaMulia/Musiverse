<dialog class="modal" id="modal-gabung">
    <form method="POST" action="#" class="modal__box">
        @csrf
        <div class="modal__head">
            <h3>Gabung Ruangan</h3>
            <button type="button" class="modal__close" data-close aria-label="Tutup">&times;</button>
        </div>

        <label for="kode-ruangan" class="modal__label">Masukkan kode ruangan dari temanmu</label>
        <input type="text" id="kode-ruangan" name="code" class="input-kode"
               maxlength="6" placeholder="BDY7K2" autocomplete="off" required>

        <p class="modal__hint">Kode terdiri dari 6 huruf atau angka.</p>

        <button type="submit" class="btn-gold btn-block">Gabung Sekarang</button>
    </form>
</dialog>
