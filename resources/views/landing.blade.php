@extends('layouts.app')

@section('title', 'Museum Digital Budaya Palembang')
@section('jarak_atas', 'pt-0')
@section('latar_main', 'bg-gradient-to-b from-[#160b0e] via-[#1c1013] to-[#160b0e]')

@section('content')
<div class="relative flex items-center justify-center min-h-screen p-6 overflow-hidden" data-navbar-gelap>
    {{-- Background Image Layer dengan Blur Halus (2.5px) & Exposure Optimal (0.68) agar Gambar Natural & Teks Super Kontras --}}
    <div class="absolute inset-0 bg-cover bg-center pointer-events-none transition-all duration-700"
         style="background-image: url('{{ asset('images/ampera.jpg') }}'); filter: blur(2.5px) brightness(0.68); transform: scale(1.06);">
    </div>

    {{-- Subtle Radial Ambient Scrim (Menyatu Alami dengan Foto Tanpa Membuat Kotak/Box) --}}
    <div class="absolute inset-0 pointer-events-none"
         style="background: radial-gradient(circle at center, rgba(35, 6, 6, 0.35) 0%, rgba(25, 4, 4, 0.2) 60%, rgba(20, 3, 3, 0.45) 100%);">
    </div>

    {{-- Content Area --}}
    <div class="relative z-10 text-center flex flex-col items-center gap-6 max-w-3xl mx-auto px-4 py-8">
        {{-- Ikon Warisan Budaya --}}
        <div class="w-16 h-16 rounded-full border-2 border-secondary flex items-center justify-center animate-bounce-slow"
             style="box-shadow: 0 4px 20px rgba(212, 175, 55, 0.5), 0 0 30px rgba(122, 28, 28, 0.4);">
            <span class="material-symbols-outlined text-[36px] text-secondary" style="filter: drop-shadow(0 2px 6px rgba(0,0,0,0.6));">travel_explore</span>
        </div>

        {{-- Judul Tanpa Background Box (Kontras Tajam Berkat Soft Blur & Multi-layer Text Shadow) --}}
        <div class="flex flex-col gap-2">
            <h1 class="text-4xl sm:text-6xl md:text-7xl font-serif font-extrabold text-[#F9F6F0] tracking-tight leading-tight text-hero-title">
                Rediscover Heritage
            </h1>
            <h2 class="text-xl sm:text-3xl font-serif text-secondary font-bold tracking-wide text-hero-sub">
                Cagar Budaya Palembang
            </h2>
        </div>

        {{-- Deskripsi Tanpa Background Box --}}
        <p class="text-base sm:text-lg md:text-xl text-[#F9F6F0] max-w-2xl leading-relaxed font-semibold text-hero-body">
            Jelajahi kekayaan sejarah dan budaya Palembang melalui warisan-warisan yang tak ternilai harganya. Sebuah perjalanan untuk memahami masa lalu, merayakan masa kini, dan melestarikan masa depan.
        </p>

        {{-- Tombol Aksi --}}
        <a href="{{ route('home') }}" class="inline-flex items-center justify-center px-9 py-4 bg-primary hover:bg-[#5A1414] text-[#F9F6F0] font-label-lg uppercase tracking-wider rounded-full shadow-[0_4px_25px_rgba(212,175,55,0.45)] hover:shadow-[0_6px_35px_rgba(212,175,55,0.7)] transform hover:scale-105 transition-all duration-300 group font-bold border-2 border-secondary">
            <span class="material-symbols-outlined mr-2 group-hover:rotate-6 transition-transform text-secondary">explore</span>
            Jelajahi Sekarang
        </a>
    </div>
</div>

<style>
    .text-hero-title {
        text-shadow: 0 2px 4px rgba(25, 4, 4, 0.9), 0 6px 18px rgba(25, 4, 4, 0.95), 0 14px 34px rgba(15, 2, 2, 0.98);
    }
    .text-hero-sub {
        text-shadow: 0 2px 4px rgba(25, 4, 4, 0.85), 0 4px 14px rgba(25, 4, 4, 0.92);
    }
    .text-hero-body {
        text-shadow: 0 1px 3px rgba(20, 3, 3, 0.92), 0 3px 12px rgba(20, 3, 3, 0.95);
    }
    .animate-bounce-slow {
        animation: bounce-slow 5s infinite ease-in-out;
    }
    @keyframes bounce-slow {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-8px); }
    }
</style>
@endsection
