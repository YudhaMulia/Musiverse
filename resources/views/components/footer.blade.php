<footer class="mv-footer">
    <div class="mv-footer__ornamen" aria-hidden="true"><span></span></div>

    <div class="mv-footer__inner">

        {{-- Merek + keterangan --}}
        <div class="mv-footer__merek">
            <a href="{{ url('/') }}" class="mv-footer__logo">
                <img src="{{ asset('images/logo-musiverse.webp') }}" alt="">
                <span>Musiverse</span>
            </a>
            <p class="mv-footer__slogan">Budaya Kito, Kebanggaan Galo-Galo!</p>
            <p class="mv-footer__tentang">
                Museum digital yang membawa warisan budaya Palembang ke layar yang kamu pegang setiap hari.
            </p>
        </div>

        {{-- Misi --}}
        <div class="mv-footer__misi">
            <h3>Misi Kami</h3>
            <ul>
                <li>Mengenalkan budaya Palembang lewat museum digital.</li>
                <li>Mengajak mengunjungi situs lewat peta dan audio tour.</li>
                <li>Menjaga ingatan lewat permainan yang menyenangkan.</li>
            </ul>
        </div>
    </div>

    {{-- Baris bawah --}}
    <div class="mv-footer__bawah">
        <div class="mv-footer__bawah-isi">
            <span>&copy; {{ date('Y') }} Musiverse. Seluruh hak cipta dilindungi.</span>
            <span class="mv-footer__cinta">Dibuat dengan <b>&hearts;</b> untuk warisan Palembang</span>
        </div>
    </div>
</footer>