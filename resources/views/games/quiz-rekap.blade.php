{{-- =========================================================
     REKAP HASIL MUSIVERSE QUIZ
     Data diisi oleh public/js/quiz-rekap.js dari sessionStorage
     ('musiverse_hasil_quiz', disimpan oleh quiz.js).
     CSS: public/css/rekap.css (kartu & tombol, sama seperti rekap Match)
          + public/css/quiz-rekap.css (bagian khusus Quiz)
     ========================================================= --}}
@extends('layouts.permainan')

@section('title', 'Rekap Musiverse Quiz')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/rekap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/quiz-rekap.css') }}">
@endpush

@section('content')
<main class="rekap" data-rekap data-avatar-url="{{ asset('images/games/avatar') }}">

    {{-- Tampil kalau belum ada hasil permainan --}}
    <section class="rekap-kosong" data-kosong>
        <h1>Belum ada hasil permainan</h1>
        <p>Mainkan Musiverse Quiz sampai selesai, lalu rekapnya muncul di sini.</p>
        <a href="{{ route('games.index') }}" class="rekap-btn rekap-btn--emas">Ke Halaman Games</a>
    </section>

    {{-- Tampil kalau ada hasil (disembunyikan dulu, dibuka oleh JavaScript) --}}
    <div class="rekap-isi" data-isi hidden>

        {{-- 1. Ringkasan --}}
        <section class="rekap-kartu rekap-ringkasan">
            <div class="rekap-ringkasan__teks">
                <p class="rekap-judul-kecil">Musiverse Quiz</p>
                <h1 class="rekap-ucapan" data-ucapan>Permainan Selesai</h1>
                <p class="rekap-alasan" data-alasan></p>

                <div class="rekap-angka">
                    <div><strong data-peringkat-kamu>-</strong><span>Peringkat</span></div>
                    <div><strong data-poin-kamu>0</strong><span>Poin</span></div>
                </div>

                <div class="rekap-tombol">
                    <a href="{{ route('games.quiz.play', ['solo' => 1]) }}" class="rekap-btn rekap-btn--putih"
                    data-main-lagi data-url-bersama="{{ route('rooms.ulang', ['room' => '__KODE__']) }}">Main Lagi</a>
                    <a href="{{ route('games.index') }}" class="rekap-btn rekap-btn--garis"
                    data-kembali data-url-keluar="{{ route('rooms.keluar', ['room' => '__KODE__']) }}">Kembali ke Games</a>
                </div>
            </div>
            <img class="rekap-ringkasan__avatar" data-avatar-kamu alt="">
        </section>

        {{-- 2. Nilai: persentase soal yang kamu jawab benar --}}
        <section class="rekap-kartu rekap-bar-kartu">
            <h2 class="rekap-h2">Soal yang Kamu Jawab Benar</h2>
            <div class="rekap-bar">
                <div class="rekap-bar__isi" data-bar></div>
                <span class="rekap-bar__label" data-bar-label>0%</span>
            </div>
            <p class="rekap-catatan" data-bar-catatan></p>
        </section>

        {{-- 3. Statistik performa (milik kamu) --}}
        <section class="rekap-kartu rekap-statistik">
            <div class="rekap-baris-judul">
                <h2 class="rekap-h2">Statistik Performa</h2>
                <span class="rekap-catatan" data-total-soal>0 soal</span>
            </div>
            <ul class="rekap-chip-daftar">
                <li class="rekap-chip rekap-chip--benar"><b data-stat-benar>0</b> Benar</li>
                <li class="rekap-chip rekap-chip--salah"><b data-stat-salah>0</b> Salah / Habis Waktu</li>
                <li class="rekap-chip rekap-chip--waktu"><b data-stat-waktu>0</b> detik/soal</li>
                <li class="rekap-chip rekap-chip--runtun"><b data-stat-runtun>0</b> Benar Beruntun</li>
            </ul>
            <p class="rekap-catatan" data-rincian-poin></p>
        </section>

        {{-- 4. Peringkat semua pemain --}}
        <section class="rekap-kartu rekap-peringkat-kartu">
            <h2 class="rekap-h2">Peringkat Pemain</h2>
            <ol class="kr-peringkat" data-peringkat></ol>
        </section>

        {{-- 5. Penguasaan per kategori --}}
        <section class="rekap-kartu">
            <h2 class="rekap-h2">Penguasaan per Kategori</h2>
            <p class="rekap-catatan">Kategori budaya mana yang sudah kamu kuasai</p>
            <ul class="kr-kategori" data-kategori></ul>
        </section>

        {{-- 6. Review: semua soal, jawabanmu, dan penjelasannya --}}
        <section class="rekap-kartu rekap-review-kartu">
            <div class="rekap-baris-judul">
                <h2 class="rekap-h2">Review Soal</h2>
                <label class="kr-saring">
                    <input type="checkbox" data-hanya-salah> Hanya yang salah
                </label>
            </div>
            <p class="rekap-catatan">Klik sebuah soal untuk melihat jawabanmu dan penjelasannya</p>
            <div class="kr-review" data-review></div>
        </section>

    </div>
</main>
@endsection

@push('scripts')
    <script src="{{ asset('js/quiz-rekap.js') }}"></script>
@endpush