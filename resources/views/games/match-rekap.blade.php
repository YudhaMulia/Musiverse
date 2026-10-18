{{-- =========================================================
     REKAP HASIL MUSIVERSE MATCH
     Data diisi oleh public/js/rekap.js dari sessionStorage
     ('musiverse_hasil_match', disimpan oleh match.js).
     CSS: public/css/rekap.css | JS: public/js/rekap.js
     ========================================================= --}}
@extends('layouts.permainan')

@section('title', 'Rekap Musiverse Match')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/rekap.css') }}">
@endpush

@section('content')
<main class="rekap" data-rekap data-avatar-url="{{ asset('images/games/avatar') }}">

    {{-- Tampil kalau belum ada hasil permainan --}}
    <section class="rekap-kosong" data-kosong>
        <h1>Belum ada hasil permainan</h1>
        <p>Mainkan Musiverse Match sampai selesai, lalu rekapnya muncul di sini.</p>
        <a href="{{ route('games.index') }}" class="rekap-btn rekap-btn--emas">Ke Halaman Games</a>
    </section>

    {{-- Tampil kalau ada hasil --}}
    <div class="rekap-isi" data-isi>

        {{-- 1. Ringkasan --}}
        <section class="rekap-kartu rekap-ringkasan">
            <div class="rekap-ringkasan__teks">
                <p class="rekap-judul-kecil">Musiverse Match</p>
                <h1 class="rekap-ucapan" data-ucapan>Permainan Selesai</h1>
                <p class="rekap-alasan" data-alasan></p>

                <div class="rekap-angka">
                    <div><strong data-peringkat-kamu>-</strong><span>Peringkat</span></div>
                    <div><strong data-pasang-kamu>0</strong><span>Pasangan</span></div>
                </div>

                <div class="rekap-tombol">
                    <a href="{{ route('games.match.play', ['solo' => 1]) }}" class="rekap-btn rekap-btn--putih"
                    data-main-lagi data-url-bersama="{{ route('rooms.ulang', ['room' => '__KODE__']) }}">Main Lagi</a>
                    <a href="{{ route('games.index') }}" class="rekap-btn rekap-btn--garis"
                    data-kembali data-url-keluar="{{ route('rooms.keluar', ['room' => '__KODE__']) }}">Kembali ke Games</a>
                </div>
            </div>
            <img class="rekap-ringkasan__avatar" data-avatar-kamu alt="">
        </section>

        {{-- 2. Nilai: persentase pasangan yang kamu temukan --}}
        <section class="rekap-kartu rekap-bar-kartu">
            <h2 class="rekap-h2">Pasangan yang Kamu Temukan</h2>
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
                <span class="rekap-catatan" data-total-tebakan>0 tebakan</span>
            </div>
            <ul class="rekap-chip-daftar">
                <li class="rekap-chip rekap-chip--benar"><b data-stat-benar>0</b> Benar</li>
                <li class="rekap-chip rekap-chip--salah"><b data-stat-salah>0</b> Meleset</li>
                <li class="rekap-chip rekap-chip--waktu"><b data-stat-waktu>0</b> detik/giliran</li>
                <li class="rekap-chip rekap-chip--runtun"><b data-stat-runtun>0</b> Benar Beruntun</li>
            </ul>
        </section>

        {{-- 4. Peringkat semua pemain --}}
        <section class="rekap-kartu rekap-peringkat-kartu">
            <h2 class="rekap-h2">Peringkat Pemain</h2>
            <ol class="rekap-peringkat" data-peringkat></ol>
        </section>

        {{-- 5. Review: semua pasangan kartu dan siapa penemunya --}}
        <section class="rekap-kartu rekap-review-kartu">
            <div class="rekap-baris-judul">
                <h2 class="rekap-h2">Review Pasangan</h2>
                <span class="rekap-catatan" data-total-review></span>
            </div>
            <p class="rekap-catatan">Semua pasangan kartu budaya dan siapa yang menemukannya</p>
            <ul class="rekap-review" data-review></ul>
        </section>

    </div>
</main>
@endsection

@push('scripts')
    <script src="{{ asset('js/rekap.js') }}"></script>
@endpush