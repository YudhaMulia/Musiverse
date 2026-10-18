{{-- =========================================================
    PERMAINAN MUSIVERSE MATCH (6x6 kartu, 18 pasang acak dari 32)
     Dibuka dari tombol "Mulai" di ruang tunggu atau "Single Player".
     CSS: public/css/match.css | JS: public/js/match.js
     Catatan: sementara lawan = bot (multiplayer sungguhan butuh Pusher).
     ========================================================= --}}
@extends('layouts.permainan')

@section('title', 'Musiverse Match')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/match.css') }}">
@endpush

@section('content')
<div class="arena" data-match
     data-nama="{{ $namaPemain }}"
     data-avatar-url="{{ asset('images/games/avatar') }}"
     data-belakang="{{ asset('images/games/match/belakang.svg') }}"
     data-keluar="{{ route('games.index') }}"
     data-url-sinkron="{{ route('rooms.sinkron', ['room' => '__KODE__']) }}"
     data-url-keluar="{{ route('rooms.keluar', ['room' => '__KODE__']) }}"
     data-rekap="{{ route('games.match.rekap') }}"
     data-pusher-key="{{ config('broadcasting.connections.pusher.key') }}"
     data-pusher-cluster="{{ config('broadcasting.connections.pusher.options.cluster') }}">

    {{-- Baris atas: keluar | status giliran | jam pasir --}}
    <header class="arena-atas">
        <button type="button" class="tombol-keluar" data-buka-keluar>&larr; Keluar</button>

        <p class="arena-status" data-status aria-live="polite">Bersiap...</p>

        <div class="jam-pasir" data-jam title="Sisa waktu permainan">
            <svg viewBox="0 0 40 48" aria-hidden="true">
                <rect x="5" y="2" width="30" height="5" rx="2" class="jam-pasir__kayu"/>
                <rect x="5" y="41" width="30" height="5" rx="2" class="jam-pasir__kayu"/>
                <path d="M9 7 H31 Q31 19 22 24 Q31 29 31 41 H9 Q9 29 18 24 Q9 19 9 7Z" class="jam-pasir__kaca"/>
                <path d="M12 10 H28 Q27 18 20 22 Q13 18 12 10Z" class="jam-pasir__atas"/>
                <path d="M11 39 Q13 31 20 29 Q27 31 29 39Z" class="jam-pasir__bawah"/>
                <path d="M20 22 V36" class="jam-pasir__aliran"/>
            </svg>
            <span data-waktu>10:00</span>
        </div>
    </header>

    {{-- Meja permainan: pemain lain di atas/kiri/kanan, kamu di bawah --}}
    <div class="arena-meja">
        <div class="kursi kursi--atas"  data-kursi="atas"></div>
        <div class="kursi kursi--kiri"  data-kursi="kiri"></div>

        <div class="papan-wadah">
            <div class="papan" data-papan aria-label="Papan kartu 6 kali 6"></div>
        </div>

        <div class="kursi kursi--kanan" data-kursi="kanan"></div>
        <div class="kursi kursi--bawah" data-kursi="bawah"></div>
    </div>

    {{-- Pemberitahuan singkat saat pasangan ditemukan --}}
    <div class="sorotan" data-sorotan hidden></div>
</div>

{{-- Popup: yakin keluar? --}}
<dialog class="g-dialog" id="dialog-keluar">
    <div class="g-dialog__kotak">
        <p class="g-dialog__judul">Yakin ingin keluar?</p>
        <p class="g-dialog__teks">Permainan akan berakhir dan skormu tidak disimpan.</p>
        <div class="g-dialog__tombol">
            <a href="{{ route('games.index') }}" class="g-btn g-btn--marun" data-keluar-link>Keluar</a>
            <button type="button" class="g-btn g-btn--emas" data-main-lagi>Lanjut Main</button>
        </div>
    </div>
</dialog>

{{-- Popup: hasil akhir --}}
<dialog class="g-dialog" id="dialog-hasil">
    <div class="g-dialog__kotak">
        <p class="g-dialog__judul" data-hasil-judul>Permainan Selesai</p>
        <p class="g-dialog__teks" data-hasil-alasan></p>
        <ol class="peringkat" data-peringkat></ol>
        <div class="g-dialog__tombol">
            <a href="{{ route('games.index') }}" class="g-btn g-btn--marun">Kembali</a>
            <button type="button" class="g-btn g-btn--emas" data-main-lagi>Main Lagi</button>
        </div>
    </div>
</dialog>

{{-- Data kartu untuk JavaScript --}}
<script type="application/json" id="data-kartu">@json($kartu)</script>
@endsection

@push('scripts')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pusher/8.4.0/pusher.min.js"></script>
    <script src="{{ asset('js/ruang-sesi.js') }}"></script>
    <script src="{{ asset('js/emote.js') }}"></script>      
    <script src="{{ asset('js/match.js') }}"></script>
@endpush
