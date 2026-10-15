@extends('layouts.app')

@section('title', 'Selamat Datang - Rediscover Heritage')
@section('jarak_atas', 'pt-0')

@section('content')
<div class="relative flex items-center justify-center min-h-screen bg-cover bg-center text-on-surface p-6 overflow-hidden" style="background-image: url('{{ asset('images/ampera.jpg') }}');">
    <!-- Overlay untuk memberikan efek sejarah dan membuat teks lebih mudah dibaca -->
    <div class="absolute inset-0 bg-black opacity-60"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-black opacity-70"></div>

    <div class="relative z-10 text-center flex flex-col items-center gap-6">
        <span class="material-symbols-outlined text-[96px] text-secondary-container animate-bounce-slow">travel_explore</span>
        <h1 class="text-headline-lg-mobile md:text-headline-lg font-bold text-on-surface leading-tight">
            Rediscover Heritage
        </h1>
        <h2 class="text-title-lg md:text-display-lg text-secondary-container -mt-4 mb-4 font-bold">
            Cagar Budaya Palembang
        </h2>
        <p class="text-body-md md:text-body-lg text-on-surface-variant max-w-xl mb-8">
            Jelajahi kekayaan sejarah dan budaya Palembang melalui warisan-warisan yang tak ternilai harganya.
            Sebuah perjalanan untuk memahami masa lalu, merayakan masa kini, dan melestarikan masa depan.
        </p>
        <a href="{{ route('home') }}" class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-secondary via-secondary-container to-primary-container text-on-primary font-label-lg uppercase tracking-wider rounded-full shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300 group">
            <span class="material-symbols-outlined mr-2 group-hover:rotate-6 transition-transform">travel_explore</span>
            Jelajahi Sekarang
        </a>
    </div>
</div>

<style>
    .animate-bounce-slow {
        animation: bounce-slow 5s infinite ease-in-out;
    }
    @keyframes bounce-slow {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-15px); }
    }
</style>
@endsection
