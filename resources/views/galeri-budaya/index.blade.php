@extends('layouts.games')

@section('title', 'Galeri Budaya')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/galeri.css') }}">
@endpush

@section('content')

    {{-- ===== 1. HERO: 3 budaya populer Palembang ===== --}}
    @if ($unggulan->isNotEmpty())
    <section class="gb-hero" data-galeri-hero data-navbar-gelap>
        <h1 class="gb-sr">Galeri Budaya</h1>

        {{-- Bagian besar: satu slide per budaya, hanya satu yang tampil --}}
        <div class="gb-utama">
            @foreach ($unggulan as $item)
                <article class="gb-slide {{ $loop->first ? 'is-aktif' : '' }}"
                         data-slide
                         aria-hidden="{{ $loop->first ? 'false' : 'true' }}">

                    <div class="gb-slide__art">
                        <img src="{{ $item->image_url }}" alt="{{ $item->nama }}">
                    </div>

                    <div class="gb-wadah gb-slide__baris">
                        <div class="gb-slide__isi">
                            <span class="gb-eyebrow">Budaya Populer Palembang</span>

                            <div class="gb-baris-atas">
                                <span class="gb-label">{{ $item->nama_kategori }}</span>
                                <span class="gb-hitung">{{ $loop->iteration }} / {{ $loop->count }}</span>
                            </div>

                            <h2 class="gb-slide__judul">{{ $item->nama }}</h2>
                            <p class="gb-slide__desk">{{ $item->deskripsi_singkat }}</p>

                            @if ($item->asal_daerah)
                                <p class="gb-slide__asal">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 21s-7-6.2-7-11a7 7 0 0 1 14 0c0 4.8-7 11-7 11z"/><circle cx="12" cy="10" r="2.5"/></svg>
                                    {{ $item->asal_daerah }}
                                </p>
                            @endif
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        {{-- Tiga card kecil: ditekan untuk mengganti slide besar --}}
        <div class="gb-wadah gb-pilih">
            @foreach ($unggulan as $item)
                <button type="button"
                        class="gb-thumb {{ $loop->first ? 'is-aktif' : '' }}"
                        data-pilih
                        aria-pressed="{{ $loop->first ? 'true' : 'false' }}">
                    <span class="gb-thumb__foto"><img src="{{ $item->image_url }}" alt=""></span>
                    <span class="gb-thumb__teks">
                        <span class="gb-thumb__nama">{{ $item->nama }}</span>
                        <span class="gb-thumb__info">{{ $item->nama_kategori }}</span>
                    </span>
                </button>
            @endforeach
        </div>
    </section>
    @endif

    {{-- ===== 2. KATEGORI: satu bagian per kategori, kartu miring ===== --}}
    @foreach (\App\Models\MuseumItem::KATEGORI as $kode => $namaKategori)
        @continue(! isset($perKategori[$kode]))

        @php
            $daftar  = $perKategori[$kode]->values();
            $jumlah  = $daftar->count();
            $separuh = intdiv($jumlah, 2);
        @endphp

        {{-- Garis pemisah emas --}}
        <div class="gb-pemisah" aria-hidden="true"><span></span><span></span><span></span></div>

        <section class="gb-kategori" id="kategori-{{ $kode }}" data-karusel>
            <header class="gb-kat__kepala">
                <span class="gb-eyebrow">Koleksi</span>
                <h2 class="gb-kat__judul">{{ $namaKategori }}</h2>
                <p class="gb-kat__sub">{{ \App\Models\MuseumItem::KATEGORI_DESKRIPSI[$kode] ?? '' }}</p>
            </header>

            <div class="gb-panggung" data-panggung tabindex="0" aria-label="Koleksi {{ $namaKategori }}">

                @foreach ($daftar as $i => $item)
                    <article class="gb-kartu" data-kartu data-pos="{{ $i > $separuh ? $i - $jumlah : $i }}">
                        <img class="gb-kartu__gambar" src="{{ $item->image_url }}" alt="{{ $item->nama }}" loading="lazy" decoding="async">
                        <div class="gb-kartu__isi">
                            <span class="gb-label">{{ $namaKategori }}</span>
                            <h3 class="gb-kartu__nama">{{ $item->nama }}</h3>
                            @if ($item->asal_daerah)
                                <p class="gb-kartu__asal">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 21s-7-6.2-7-11a7 7 0 0 1 14 0c0 4.8-7 11-7 11z"/><circle cx="12" cy="10" r="2.5"/></svg>
                                    {{ $item->asal_daerah }}
                                </p>
                            @endif
                            <p class="gb-kartu__desk">{{ $item->deskripsi_singkat }}</p>
                        </div>
                    </article>
                @endforeach

            </div>

            <p class="gb-hitung-kat" data-hitung>1 / {{ $jumlah }}</p>
            
            {{-- Panel cerita: penjelasan mendalam, berganti mengikuti kartu tengah --}}
            <div class="gb-cerita-wadah">
                @foreach ($daftar as $i => $item)
                    @php
                        // Pisahkan paragraf di tiap baris kosong. Kalau belum diisi, pakai deskripsi singkat.
                        $paragraf = $item->deskripsi_lengkap
                            ? preg_split('/\R{2,}/', trim($item->deskripsi_lengkap))
                            : [$item->deskripsi_singkat];
                    @endphp
                    <article class="gb-cerita {{ $i === 0 ? 'is-aktif' : '' }}" data-cerita>
                        <header class="gb-cerita__kepala">
                            <span class="gb-eyebrow">Cerita di balik</span>
                            <h3 class="gb-cerita__judul">{{ $item->nama }}</h3>
                            @if ($item->asal_daerah)
                                <p class="gb-cerita__asal">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 21s-7-6.2-7-11a7 7 0 0 1 14 0c0 4.8-7 11-7 11z"/><circle cx="12" cy="10" r="2.5"/></svg>
                                    {{ $item->asal_daerah }}
                                </p>
                            @endif
                        </header>
                        <div class="gb-cerita__teks">
                            @foreach ($paragraf as $p)
                                <p>{{ $p }}</p>
                            @endforeach
                        </div>
                    </article>
                @endforeach
            </div>
        </section>
    @endforeach

    <div class="gb-akhir"></div>

@endsection

@push('scripts')
    <script src="{{ asset('js/galeri.js') }}"></script>
@endpush