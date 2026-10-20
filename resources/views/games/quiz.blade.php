{{-- =========================================================
     PERMAINAN MUSIVERSE QUIZ (15 soal pilihan ganda A-D)
     Dibuka dari tombol "Main Sendiri" di halaman Games.
     CSS: public/css/match.css (panel & tombol) + public/css/quiz.css
     JS : public/js/quiz.js
     Setelah selesai, hasil disimpan lalu pindah ke games/quiz-rekap.blade.php.
     Catatan: sementara lawan = bot (multiplayer sungguhan butuh Pusher).
     ========================================================= --}}
@extends('layouts.permainan')

@section('title', 'Musiverse Quiz')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/match.css') }}">
    <link rel="stylesheet" href="{{ asset('css/quiz.css') }}">
    {{-- Mulai mengunduh Pusher lebih awal, tanpa menghalangi tampilan --}}
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    <link rel="preload" as="script" href="https://cdnjs.cloudflare.com/ajax/libs/pusher/8.4.0/pusher.min.js">
@endpush

@php
    $namaPemain = auth()->check() ? auth()->user()->name : 'Pemain 1';
@endphp

@section('content')
<div class="arena arena--kuis" data-quiz
     data-nama="{{ $namaPemain }}"
     data-avatar-url="{{ asset('images/games/avatar') }}"
     data-keluar="{{ route('games.index') }}"
     data-url-sinkron="{{ route('rooms.sinkron', ['room' => '__KODE__']) }}"
     data-url-keluar="{{ route('rooms.keluar', ['room' => '__KODE__']) }}"
     data-rekap="{{ route('games.quiz.rekap') }}"
     data-pusher-key="{{ config('broadcasting.connections.pusher.key') }}"
     data-pusher-cluster="{{ config('broadcasting.connections.pusher.options.cluster') }}">

    {{-- Baris atas: keluar | status | nomor soal --}}
    <header class="arena-atas">
        <button type="button" class="tombol-keluar" data-buka-keluar>&larr; Keluar</button>

        <p class="arena-status" data-status aria-live="polite">Bersiap...</p>

        <p class="kuis-nomor" title="Nomor soal">
            Soal <b data-nomor>1</b>/<span data-total>15</span>
        </p>
    </header>

    <div class="kuis-tengah">
        {{-- Papan skor semua pemain (diisi oleh JavaScript) --}}
        <div class="kuis-skor" data-skor-bar aria-label="Skor pemain"></div>

        {{-- Kartu soal --}}
        <section class="kuis-kartu" aria-live="polite">
            <div class="kuis-waktu" data-waktu-wadah>
                <div class="kuis-waktu__jalur"><span class="kuis-waktu__isi" data-bar></span></div>
                <span class="kuis-waktu__angka" data-detik>20</span>
            </div>

            <p class="kuis-kategori" data-kategori></p>
            <h1 class="kuis-tanya" data-tanya></h1>

            <div class="kuis-pilihan" data-pilihan></div>

            {{-- Muncul setelah semua menjawab atau waktu habis --}}
            <div class="kuis-ungkap" data-ungkap hidden>
                <p class="kuis-ungkap__judul" data-ungkap-judul></p>
                <p class="kuis-ungkap__teks" data-ungkap-teks></p>
            </div>
        </section>

        <p class="kuis-petunjuk">Tip: tekan tombol <b>A</b>, <b>B</b>, <b>C</b>, atau <b>D</b> di keyboard untuk menjawab cepat.</p>
    </div>
</div>

{{-- Popup: yakin keluar? --}}
<dialog class="g-dialog" id="dialog-keluar">
    <div class="g-dialog__kotak">
        <p class="g-dialog__judul">Yakin ingin keluar?</p>
        <p class="g-dialog__teks">Permainan akan berakhir dan skormu tidak disimpan.</p>
        <div class="g-dialog__tombol">
            <a href="{{ route('games.index') }}" class="g-btn g-btn--marun" data-keluar-link>Keluar</a>
            <button type="button" class="g-btn g-btn--emas" data-tutup-dialog>Lanjut Main</button>
        </div>
    </div>
</dialog>

{{-- Data soal untuk JavaScript (15 soal acak dari database) --}}
<script type="application/json" id="data-soal">@json($soal)</script>
@endsection

@push('scripts')
    {{-- Pusher dimuat oleh quiz.js di belakang layar, supaya soal tampil lebih cepat --}}
    <script src="{{ asset('js/ruang-sesi.js') }}" defer></script>
    <script src="{{ asset('js/emote.js') }}" defer></script>
    <script src="{{ asset('js/quiz.js') }}" defer></script>
@endpush