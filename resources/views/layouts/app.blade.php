<!DOCTYPE html>
<html class="dark" lang="id">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="web_standard" name="shell-type" />
    <title>@yield('title', 'Rediscover Heritage - Cagar Budaya Palembang')</title>

    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700&family=Noto+Serif:ital,wght@0,400;0,600;0,700;1,400&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    {{-- Navbar Musiverse: font & CSS khusus navbar --}}
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;800&family=Nunito+Sans:wght@400;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "inverse-primary": "#a83545",
                        "error": "#ffb4ab",
                        "inverse-surface": "#f4dde1",
                        "on-primary": "#ffffff",
                        "secondary-container": "#af8d11",
                        "primary-container": "#720921",
                        "tertiary": "#ffb3af",
                        "surface-container": "#291c1f",
                        "surface-variant": "#3f3134",
                        "primary-fixed-dim": "#ffb2b6",
                        "outline-variant": "#574142",
                        "surface-bright": "#443539",
                        "primary-fixed": "#ffdadb",
                        "primary": "#ffb2b6",
                        "on-secondary-container": "#342800",
                        "on-tertiary-fixed-variant": "#910618",
                        "on-error-container": "#ffdad6",
                        "on-primary-fixed": "#40000d",
                        "surface-container-lowest": "#160b0e",
                        "surface-tint": "#ffb2b6",
                        "surface-container-low": "#25181b",
                        "on-tertiary-fixed": "#410005",
                        "on-primary-container": "#ffebee",
                        "on-surface-variant": "#debfc0",
                        "on-error": "#690005",
                        "on-secondary-fixed": "#241a00",
                        "error-container": "#93000a",
                        "tertiary-fixed": "#ffdad7",
                        "surface-container-high": "#34262a",
                        "surface": "#1c1013",
                        "on-primary-fixed-variant": "#871c2f",
                        "tertiary-fixed-dim": "#ffb3af",
                        "on-tertiary-container": "#ff7672",
                        "on-background": "#f4dde1",
                        "on-surface": "#f4dde1",
                        "surface-container-highest": "#3f3134",
                        "background": "#1c1013",
                        "secondary": "#e9c349",
                        "outline": "#a58a8b",
                        "on-tertiary": "#68000d",
                        "secondary-fixed": "#ffe088",
                        "inverse-on-surface": "#3b2d30",
                        "on-secondary": "#3c2f00",
                        "on-secondary-fixed-variant": "#574500",
                        "surface-dim": "#1c1013",
                        "tertiary-container": "#760010",
                        "secondary-fixed-dim": "#e9c349"
                    },
                    borderRadius: {
                        DEFAULT: "0.125rem",
                        lg: "0.25rem",
                        xl: "0.5rem",
                        full: "0.75rem"
                    },
                    spacing: {
                        "space-lg": "1.5rem",
                        "space-xl": "2.5rem",
                        "margin-mobile": "1.25rem",
                        "margin": "3rem",
                        "space-sm": "0.5rem",
                        "gutter-mobile": "1rem",
                        "space-xs": "0.25rem",
                        "space-md": "1rem",
                        gutter: "1.5rem"
                    },
                    fontFamily: {
                        "display-lg": ["Noto Serif"],
                        "body-lg": ["Manrope"],
                        "headline-sm": ["Noto Serif"],
                        "headline-lg-mobile": ["Noto Serif"],
                        "label-sm": ["Space Grotesk"],
                        "title-lg": ["Noto Serif"],
                        "title-md": ["Noto Serif"],
                        "label-lg": ["Space Grotesk"],
                        "headline-lg": ["Noto Serif"],
                        "body-md": ["Manrope"],
                        "label-md": ["Space Grotesk"],
                        "display-lg-mobile": ["Noto Serif"],
                        "body-sm": ["Manrope"],
                        "headline-md": ["Noto Serif"]
                    },
                    fontSize: {
                        "display-lg": ["56px", { lineHeight: "68px", letterSpacing: "-0.02em", fontWeight: "700" }],
                        "body-lg": ["18px", { lineHeight: "28px", fontWeight: "400" }],
                        "headline-sm": ["22px", { lineHeight: "30px", fontWeight: "600" }],
                        "headline-lg-mobile": ["28px", { lineHeight: "36px", letterSpacing: "0em", fontWeight: "600" }],
                        "label-sm": ["10px", { lineHeight: "14px", letterSpacing: "0.1em", fontWeight: "600" }],
                        "title-lg": ["20px", { lineHeight: "28px", fontWeight: "600" }],
                        "title-md": ["17px", { lineHeight: "24px", fontWeight: "500" }],
                        "label-lg": ["14px", { lineHeight: "18px", letterSpacing: "0.08em", fontWeight: "600" }],
                        "headline-lg": ["40px", { lineHeight: "50px", letterSpacing: "-0.015em", fontWeight: "600" }],
                        "body-md": ["15px", { lineHeight: "24px", fontWeight: "400" }],
                        "label-md": ["12px", { lineHeight: "16px", letterSpacing: "0.06em", fontWeight: "500" }],
                        "display-lg-mobile": ["36px", { lineHeight: "44px", letterSpacing: "-0.01em", fontWeight: "700" }],
                        "body-sm": ["13px", { lineHeight: "20px", fontWeight: "400" }],
                        "headline-md": ["28px", { lineHeight: "36px", fontWeight: "600" }]
                    }
                }
            }
        };
    </script>

    <style>
        @layer base {
            html, body {
                margin: 0;
                padding: 0;
            }
            body {
                overscroll-behavior: none;
            }
            main > :first-child {
                margin-top: 0 !important;
            }
            main > :last-child {
                margin-bottom: 0 !important;
            }
        }
        ::-webkit-scrollbar {
            display: none;
        }
    </style>
</head>

<body class="bg-surface font-body-md text-on-surface min-h-screen selection:bg-primary-container selection:text-secondary">
    @include('components.header')

    <main class="w-full @yield('jarak_atas', 'pt-20') bg-gradient-to-b from-[#160b0e] via-[#1c1013] to-[#160b0e]">
        @yield('content')
    </main>

    @include('components.footer')

    

    {{-- Musik latar Gending Sriwijaya (lanjut terus saat pindah halaman) --}}
    @include('components.musik')

    <script>
        // Image Carousel Functionality
        class ImageCarousel {
            constructor() {
                this.slides = document.querySelectorAll('.carousel-slide');
                this.indicators = document.querySelectorAll('.carousel-indicator');
                this.prevBtn = document.querySelector('.carousel-prev');
                this.nextBtn = document.querySelector('.carousel-next');

                this.currentIndex = 0;
                this.autoPlayInterval = null;
                this.autoPlayDelay = 5000; // 5 seconds

                if (this.slides.length > 0) {
                    this.init();
                }
            }

            init() {
                // Bind button events
                if (this.prevBtn) {
                    this.prevBtn.addEventListener('click', () => this.goToPrevious());
                }
                if (this.nextBtn) {
                    this.nextBtn.addEventListener('click', () => this.goToNext());
                }

                // Bind indicator events
                this.indicators.forEach((indicator, index) => {
                    indicator.addEventListener('click', () => this.goToSlide(index));
                });

                // Start auto-play
                this.startAutoPlay();

                // Pause on hover
                const carouselContainer = document.querySelector('.carousel-slide')?.parentElement;
                if (carouselContainer) {
                    carouselContainer.addEventListener('mouseenter', () => this.stopAutoPlay());
                    carouselContainer.addEventListener('mouseleave', () => this.startAutoPlay());
                }
            }

            goToSlide(index) {
                this.currentIndex = (index + this.slides.length) % this.slides.length;
                this.updateCarousel();
                this.restartAutoPlay();
            }

            goToNext() {
                this.currentIndex = (this.currentIndex + 1) % this.slides.length;
                this.updateCarousel();
                this.restartAutoPlay();
            }

            goToPrevious() {
                this.currentIndex = (this.currentIndex - 1 + this.slides.length) % this.slides.length;
                this.updateCarousel();
                this.restartAutoPlay();
            }

            updateCarousel() {
                // Update slides
                this.slides.forEach((slide, index) => {
                    slide.classList.remove('opacity-100');
                    slide.classList.add('opacity-0');
                    if (index === this.currentIndex) {
                        slide.classList.remove('opacity-0');
                        slide.classList.add('opacity-100');
                    }
                });

                // Update indicators
                this.indicators.forEach((indicator, index) => {
                    indicator.classList.remove('bg-secondary', 'w-8');
                    indicator.classList.add('bg-secondary/50', 'hover:bg-secondary/75', 'w-2.5');

                    if (index === this.currentIndex) {
                        indicator.classList.remove('bg-secondary/50', 'hover:bg-secondary/75', 'w-2.5');
                        indicator.classList.add('bg-secondary', 'w-8');
                    }
                });
            }

            startAutoPlay() {
                this.autoPlayInterval = setInterval(() => {
                    this.goToNext();
                }, this.autoPlayDelay);
            }

            stopAutoPlay() {
                if (this.autoPlayInterval) {
                    clearInterval(this.autoPlayInterval);
                    this.autoPlayInterval = null;
                }
            }

            restartAutoPlay() {
                this.stopAutoPlay();
                this.startAutoPlay();
            }
        }

        // Initialize carousel when DOM is ready
        document.addEventListener('DOMContentLoaded', () => {
            new ImageCarousel();
        });
    </script>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    {{-- Navbar Musiverse: transparan -> gelap saat scroll, menu HP --}}
    <script src="{{ asset('js/app.js') }}"></script>
    {{-- Musik latar: lanjut terus saat pindah halaman --}}
    <script src="{{ asset('js/musik.js') }}"></script>
    @stack('scripts')
</body>
</html>