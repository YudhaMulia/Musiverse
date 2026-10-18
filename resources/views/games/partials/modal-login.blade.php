{{-- =========================================================
     MODAL AJAK MASUK (untuk tamu yang belum login)
     Memakai gaya yang sama dengan modal-gabung (class modal--gabung).
     CSS tambahan: blok "V8 - MODAL AJAK MASUK" di musiverse.css
     ========================================================= --}}
<dialog class="modal modal--gabung modal--ajak" id="modal-login" aria-labelledby="judul-ajak">
    <div class="modal__box">
        <button type="button" class="modal__close" data-close aria-label="Tutup">&times;</button>

        <div class="modal-logo">
            <span class="modal-logo__icon" aria-hidden="true"></span>
            <h3 class="modal-logo__text">Musiverse</h3>
        </div>

        <h4 class="modal__judul" id="judul-ajak">Main Bareng Itu Lebih Seru!</h4>
        <p class="modal__teks">
            Buat akun atau masuk dulu untuk membuka ruangan, ajak temanmu,
            dan buktikan siapa jagoan budaya Palembang.
        </p>

        <div class="modal__aksi">
            <x-btn-play label="Masuk" :href="route('login')" class="btn-play--block" data-link-auth />
            <a href="{{ route('register') }}" class="btn-daftar" data-link-auth>Daftar Akun Baru</a>
        </div>

        <p class="modal__hint">Mau coba dulu? Tombol &ldquo;Main Sendiri&rdquo; bisa dipakai tanpa akun.</p>
    </div>
</dialog>