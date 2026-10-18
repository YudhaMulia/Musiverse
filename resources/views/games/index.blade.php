@extends('layouts.games')

@section('title', 'Games')

@section('content')

    {{-- 1. Hero paling atas --}}
    @include('games.partials.hero')

    <section class="games" id="daftar-game">
        {{-- Judul bagian --}}
        <header class="section-head reveal">
            <span class="section-head__eyebrow">Arena Permainan</span>
            <h2 class="section-head__title">Pilih Permainanmu</h2>
            <div class="ornament" aria-hidden="true"><span></span></div>
            <p>
                Tiga cara seru mengenal budaya Palembang. Lawan bot untuk berlatih,
                atau buat ruangan dan tantang temanmu.
            </p>
        </header>

        {{-- 2. Card Musiverse Match --}}
        @include('games.partials.card-match')

        {{-- 3. Card Musiverse Quiz + teks lanjutannya --}}
        @include('games.partials.card-quiz')

        {{-- 4. Card Musiverse Puzzle --}}
        @include('games.partials.card-puzzle')
    </section>

    {{-- Form mengambang (modal) --}}
    @include('games.partials.modal-gabung')
    @guest
        @include('games.partials.modal-login')
    @endguest

@endsection

@push('scripts')
    <script src="{{ asset('js/suara.js') }}"></script>
    <script src="{{ asset('js/games.js') }}"></script>
@endpush