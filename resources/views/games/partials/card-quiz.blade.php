<section class="quiz reveal">
    {{-- 3 panel diagonal, sejajar dengan lebar card --}}
    <div class="quiz__panels">
        <div class="quiz__panel quiz__panel--left">
            <img src="{{ asset('images/games/quiz-kiri.webp') }}" alt="Pemuda bertanjak sedang berpikir">
        </div>
        <div class="quiz__panel quiz__panel--center">
            <img src="{{ asset('images/games/quiz-tengah.webp') }}" alt="Papan soal dengan pilihan A, B, C, D">
        </div>
        <div class="quiz__panel quiz__panel--right">
            <img src="{{ asset('images/games/quiz-kanan.webp') }}" alt="Pemudi bersongket mengangkat tangan">
        </div>
    </div>

    {{-- Judul & tombol di bawah panel (seperti "Unique Gameplay") --}}
    <div class="quiz__head">
        <h2 class="game-title game-title--light quiz__title">Musiverse Quiz</h2>
        <div class="btn-row">
            <x-btn-play label="Single Player" data-solo="Musiverse Quiz" />
            <x-btn-play label="Multi Player" data-open="modal-buat" data-game="Musiverse Quiz" />
        </div>
    </div>

    {{-- Teks lanjutan Quiz --}}
    <div class="quiz__more">
        <p>
            15 pertanyaan acak seputar budaya Palembang siap menguji wawasanmu. Makin cepat
            dan tepat kau menjawab, makin besar poinmu. Salah? Tenang, poinmu tidak berkurang.
            Kau malah langsung tahu jawaban yang benar!
        </p>
        <ul class="badges badges--center">
            <li>15 Soal</li>
            <li>Bonus Kecepatan</li>
            <li>2&ndash;4 Pemain</li>
        </ul>
    </div>
</section>
