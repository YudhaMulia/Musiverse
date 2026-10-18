{{-- =========================================================
     PERMAINAN MUSIVERSE PUZZLE (tebak gambar, 10 soal, rebutan)
     Dibuka dari tombol "Main Sendiri" di halaman Games.
     CSS: public/css/match.css (panel & tombol) + public/css/puzzle.css
     JS : public/js/puzzle.js
     Setelah selesai, hasil disimpan lalu pindah ke games/puzzle-rekap.blade.php.
     Catatan: sementara lawan = bot (multiplayer sungguhan butuh Pusher).
     ========================================================= --}}
@extends('layouts.permainan')

@section('title', 'Musiverse Puzzle')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/match.css') }}">
    <link rel="stylesheet" href="{{ asset('css/puzzle.css') }}">
@endpush

@php
    $namaPemain = auth()->check() ? auth()->user()->name : 'Pemain 1';
@endphp

@section('content')
<div class="arena arena--puzzle" data-puzzle
     data-nama="{{ $namaPemain }}"
     data-avatar-url="{{ asset('images/games/avatar') }}"
     data-keluar="{{ route('games.index') }}"
     data-url-sinkron="{{ route('rooms.sinkron', ['room' => '__KODE__']) }}"
     data-url-keluar="{{ route('rooms.keluar', ['room' => '__KODE__']) }}"
     data-rekap="{{ route('games.puzzle.rekap') }}"
     data-pusher-key="{{ config('broadcasting.connections.pusher.key') }}"
     data-pusher-cluster="{{ config('broadcasting.connections.pusher.options.cluster') }}">

    {{-- Baris atas: keluar | status | nomor soal --}}
    <header class="arena-atas">
        <button type="button" class="tombol-keluar" data-buka-keluar>&larr; Keluar</button>

        <p class="arena-status" data-status aria-live="polite">Bersiap...</p>

        <p class="pz-nomor" title="Nomor soal">
            Soal <b data-nomor>1</b>/<span data-total>10</span>
        </p>
    </header>

    <div class="pz-tengah">
        {{-- Papan skor semua pemain (diisi oleh JavaScript) --}}
        <div class="pz-skor" data-skor-bar aria-label="Skor pemain"></div>

        {{-- Kartu gambar --}}
        <section class="pz-kartu" aria-live="polite">
            <div class="pz-waktu" data-waktu-wadah>
                <span class="pz-waktu__fase" data-fase>Mengamati</span>
                <div class="pz-waktu__jalur"><span class="pz-waktu__isi" data-bar></span></div>
                <span class="pz-waktu__angka" data-detik>5</span>
            </div>

            <div class="pz-gambar">
                <img data-gambar src="" alt="Gambar yang harus ditebak">
                {{-- Angka hitung mundur 5 detik pengamatan --}}
                <div class="pz-hitung" data-hitung>5</div>
            </div>

            {{-- Satu area tetap di bawah gambar. Isinya berganti-ganti:
                 tombol merah  ->  kolom ketik (kalau kamu tercepat)  ->  jawaban benar --}}
            <div class="pz-aksi">
                <button type="button" class="pz-tombol" data-tombol disabled>
                    <span data-tombol-teks>Tunggu...</span>
                </button>

                <form class="pz-form" data-form autocomplete="off" hidden>
                    <input type="text" class="pz-input" data-input maxlength="40"
                           placeholder="Ketik jawabanmu..." aria-label="Jawaban">
                    <button type="submit" class="g-btn g-btn--emas">Kirim</button>
                </form>

                <div class="pz-ungkap" data-ungkap hidden>
                    <p class="pz-ungkap__judul" data-ungkap-judul></p>
                    <p class="pz-ungkap__jawab" data-ungkap-jawab></p>
                </div>
            </div>

            <p class="pz-petunjuk">Tip: tekan <b>Spasi</b> di keyboard untuk menekan tombol merah.</p>
        </section>
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

{{-- Data soal untuk JavaScript (10 gambar acak dari folder) --}}
<script type="application/json" id="data-soal">@json($soal)</script>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pusher/8.4.0/pusher.min.js"></script>
    <script src="{{ asset('js/ruang-sesi.js') }}"></script>
    <script src="{{ asset('js/emote.js') }}"></script>  
    <script src="{{ asset('js/puzzle.js') }}"></script>
@endpush