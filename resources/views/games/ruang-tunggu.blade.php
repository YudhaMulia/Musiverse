{{-- =========================================================
     RUANG TUNGGU MULTIPLAYER
     Dibuka dari tombol "Multi Player" di kartu game.
     CSS: public/css/ruang-tunggu.css | JS: public/js/ruang-tunggu.js
     Data ruangan disimpan di tabel rooms & room_players
     (RoomController). Pemain lain bergabung lewat kode (langkah 6),
     update langsung tanpa refresh lewat Pusher (langkah 7).
     ========================================================= --}}
@extends('layouts.games')

@section('title', 'Ruang Tunggu ' . $namaGame)

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/ruang-tunggu.css') }}">
@endpush

@php
    // Data berikut dikirim dari RoomController@show:
    // $room, $namaGame, $state, $karakter, $urlMain, $alamat
    $tuanRumah = $state['tuanRumah'];
    $saya      = collect($state['pemain'])->firstWhere('kamu', true);
@endphp

@section('content')
<section class="lobby" data-lobby
         data-state="{{ json_encode($state) }}"
         data-avatar-url="{{ asset('images/games/avatar') }}"
         data-url-avatar="{{ route('rooms.avatar', $room) }}"
         data-url-bot="{{ route('rooms.bot', $room) }}"
         data-url-hapus="{{ route('rooms.pemain.hapus', [$room, '__ID__']) }}"
        data-url-mulai="{{ route('rooms.mulai', $room) }}"
         data-url-sinkron="{{ route('rooms.sinkron', $room) }}"
         data-url-games="{{ route('games.index') }}"
         data-pusher-key="{{ config('broadcasting.connections.pusher.key') }}"
         data-pusher-cluster="{{ config('broadcasting.connections.pusher.options.cluster') }}"
         data-channel="private-ruang.{{ $room->code }}"
         data-main="{{ $urlMain }}">

    {{-- Kartu besar (latar ruang tunggu). Latar halaman tetap terlihat di sekelilingnya --}}
    <div class="lobby-panel">

        {{-- Logo Musiverse: pita yang menempel di tepi atas kartu --}}
        <div class="lobby-logo">
            <img src="{{ asset('images/logo-musiverse.webp') }}" alt="" class="lobby-logo__img">
            <h1 class="lobby-logo__text">Musiverse</h1>
        </div>

        <div class="lobby-atas">
            <form method="POST" action="{{ route('rooms.keluar', $room) }}">
                @csrf
                <button type="submit" class="lobby__keluar">&larr; Keluar</button>
            </form>
            <p class="lobby__game">Ruang Tunggu &middot; {{ $namaGame }}</p>
        </div>

        {{-- Laptop: pemain di kiri, sisanya di kanan. HP: disusun dari atas ke bawah --}}
        <div class="lobby-grid">

            {{-- Daftar pemain (maksimal 4) --}}
            <div class="lobby-pemain">
                <div class="lobby-jumlah" aria-live="polite">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M9 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm7.5 0a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7ZM1 20c0-3.3 3.6-6 8-6s8 2.7 8 6v1H1v-1Zm17.5 1v-1c0-1.9-.8-3.6-2.2-4.9 3.5.2 6.7 2.2 6.7 4.9v1h-4.5Z" fill="currentColor"/></svg>
                    <span><span data-jumlah>{{ count($state['pemain']) }}</span>/{{ $state['maks'] }} Pemain</span>
                </div>

                {{-- Isi awal dari database (diperbarui oleh ruang-tunggu.js) --}}
                <div class="slot-grid" data-slots>
                    @for ($i = 0; $i < $state['maks']; $i++)
                        @php $p = $state['pemain'][$i] ?? null; @endphp
                        @if ($p)
                            <div class="slot slot--isi {{ $p['bot'] ? 'slot--bot' : '' }}">
                                <img class="slot__avatar" src="{{ asset('images/games/avatar/'.$p['avatar'].'.svg') }}" alt="">
                                <div class="slot__teks">
                                    <p class="slot__nama">{{ $p['nama'] }}</p>
                                    <span class="slot__tag">{{ $p['kamu'] ? 'Kamu' : ($p['bot'] ? 'Bot' : ($p['host'] ? 'Tuan rumah' : 'Pemain')) }}</span>
                                </div>
                            </div>
                        @else
                            <div class="slot slot--kosong">
                                <span class="slot__tanya">?</span>
                                <p class="slot__tunggu">Menunggu pemain<span>.</span><span>.</span><span>.</span></p>
                            </div>
                        @endif
                    @endfor
                </div>
            </div>

            {{-- Cara mengajak teman --}}
            <div class="lobby-info">
                <p class="lobby-info__judul">Ajak temanmu bergabung!</p>

                <div class="lobby-info__baris">
                    <div>
                        <p class="lobby-info__langkah"><span>1</span> Buka alamat ini</p>
                        <div class="lobby-kotak lobby-kotak--alamat">{{ $alamat }}</div>
                    </div>
                    <div>
                        <p class="lobby-info__langkah"><span>2</span> Tekan &ldquo;Masuk Ruangan&rdquo;, ketik kode</p>
                        <div class="lobby-kotak lobby-kotak--kode">
                            <span data-kode>{{ $room->code }}</span>
                            <button type="button" class="lobby-salin" data-salin aria-label="Salin kode">Salin</button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tombol utama (hanya tuan rumah) --}}
            <div class="lobby-aksi">
                <div class="lobby-aksi__tombol" data-aksi-host @unless ($tuanRumah) hidden @endunless>
                    <button type="button" class="g-btn g-btn--emas" data-mulai disabled>Mulai</button>
                    <button type="button" class="g-btn g-btn--marun" data-tambah-bot>+ Tambah Bot</button>
                </div>
                <p class="lobby-aksi__info" data-info>
                    {{ $tuanRumah ? 'Butuh minimal 2 pemain. Ajak teman atau tambahkan bot.' : 'Menunggu tuan rumah memulai permainan.' }}
                </p>
            </div>

            {{-- Pilih karakter --}}
            <div class="lobby-karakter">
                <p class="lobby-subjudul">Pilih Karaktermu</p>
                <div class="karakter-grid">
                    @foreach ($karakter as $no => $nama)
                        <button type="button" class="karakter" data-karakter="{{ $no }}"
                                aria-pressed="{{ $no === $saya['avatar'] ? 'true' : 'false' }}" title="{{ $nama }}">
                            <img src="{{ asset('images/games/avatar/' . $no . '.svg') }}" alt="{{ $nama }}">
                        </button>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pusher/8.4.0/pusher.min.js"></script>
    <script src="{{ asset('js/suara.js') }}"></script>
    <script src="{{ asset('js/emote.js') }}"></script>
    <script src="{{ asset('js/ruang-tunggu.js') }}"></script>
@endpush