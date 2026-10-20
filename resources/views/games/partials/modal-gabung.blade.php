{{-- =========================================================
     MODAL GABUNG RUANGAN (kartu emas mengambang)
     CSS: public/css/musiverse.css  -> blok "V7 - MODAL GABUNG"
     ========================================================= --}}
<dialog class="modal modal--gabung" id="modal-gabung">
    <form method="POST" action="{{ route('rooms.gabung') }}" class="modal__box">
        @csrf
        <button type="button" class="modal__close" data-close aria-label="Tutup">&times;</button>

        {{-- Logo Musiverse dengan kilau emas (pengganti judul "Gabung Ruangan") --}}
        <div class="modal-logo">
            <img src="{{ asset('images/logo-musiverse.png') }}" alt="" class="modal-logo__img">
            <h3 class="modal-logo__text">Musiverse</h3>
        </div>

        <label for="kode-ruangan" class="modal__label">Masukkan kode ruangan dari temanmu</label>
        <input type="text" id="kode-ruangan" name="code" class="input-kode"
                    value="{{ old('code') }}"
                    maxlength="6" placeholder="BDY7K2" autocomplete="off" required autofocus>

        @error('code')
            <p role="alert" style="color:#b3261e;font-weight:600;margin:.5rem 0 0;">{{ $message }}</p>
        @enderror

        <p class="modal__hint">Kode terdiri dari 6 huruf atau angka.</p>

        {{-- Tombol bergaya sama seperti di kartu Musiverse Match --}}
        <x-btn-play label="Gabung Sekarang" type="submit" class="btn-play--block" />
    </form>
</dialog>

{{-- Kalau kode salah, halaman dimuat ulang. Buka lagi modalnya supaya pesan error terlihat --}}
@if ($errors->has('code'))
    <script>document.getElementById('modal-gabung').showModal();</script>
@endif