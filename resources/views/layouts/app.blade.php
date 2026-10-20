<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="web_standard" name="shell-type" />
    <title>@hasSection('title')@yield('title') | Musiverse @else Musiverse | Budaya Palembang @endif</title>
    <link rel="icon" type="image/webp" href="{{ asset('images/logo-musiverse.webp') }}">

    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700&family=Noto+Serif:ital,wght@0,400;0,600;0,700;1,400&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    {{-- Navbar Musiverse: font & CSS khusus navbar --}}
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;800&family=Nunito+Sans:wght@400;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

    <script id="tailwind-config">
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        "primary": "#7A1C1C",
                        "primary-container": "#7A1C1C",
                        "primary-fixed": "#942626",
                        "primary-fixed-dim": "#7A1C1C",
                        "on-primary": "#F9F6F0",
                        "on-primary-container": "#F9F6F0",
                        "on-primary-fixed": "#F9F6F0",
                        "on-primary-fixed-variant": "#D4AF37",
                        "inverse-primary": "#B38B2D",

                        "secondary": "#D4AF37",
                        "secondary-container": "#B38B2D",
                        "secondary-fixed": "#E8CC6E",
                        "secondary-fixed-dim": "#D4AF37",
                        "on-secondary": "#4A1010",
                        "on-secondary-container": "#F9F6F0",
                        "on-secondary-fixed": "#4A1010",
                        "on-secondary-fixed-variant": "#4A1010",

                        "tertiary": "#B38B2D",
                        "tertiary-container": "#F6F1E7",
                        "tertiary-fixed": "#E8CC6E",
                        "tertiary-fixed-dim": "#B38B2D",
                        "on-tertiary": "#4A1010",
                        "on-tertiary-container": "#7A1C1C",
                        "on-tertiary-fixed": "#4A1010",
                        "on-tertiary-fixed-variant": "#7A1C1C",

                        "surface": "#F9F6F0",
                        "surface-dim": "#F0EADB",
                        "surface-bright": "#FFFFFF",
                        "surface-container-lowest": "#FFFFFF",
                        "surface-container-low": "#FDFBF7",
                        "surface-container": "#F5EFE4",
                        "surface-container-high": "#EFE7D8",
                        "surface-container-highest": "#E5DBC7",
                        "surface-variant": "#EFE6D6",
                        "surface-tint": "#D4AF37",
                        "on-surface": "#4A1010",
                        "on-surface-variant": "#783838",
                        "inverse-surface": "#7A1C1C",
                        "inverse-on-surface": "#F9F6F0",

                        "background": "#F9F6F0",
                        "on-background": "#4A1010",

                        "error": "#B02020",
                        "error-container": "#FDE8E8",
                        "on-error": "#FFFFFF",
                        "on-error-container": "#680A0A",

                        "outline": "#D4AF37",
                        "outline-variant": "#D9CEBA"
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
                background-color: #F9F6F0;
                color: #4A1010;
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
            width: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #F9F6F0;
        }
        ::-webkit-scrollbar-thumb {
            background: #D4AF37;
            border-radius: 3px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #B38B2D;
        }

        /* Hero content smooth transition */
        #hero-content {
            transition: opacity 300ms ease, transform 300ms ease;
        }
    </style>
    @stack('styles')
</head>

<body class="font-body-md text-on-surface min-h-screen selection:bg-primary selection:text-on-primary" style="
    background:
        radial-gradient(1100px 700px at 10% 35%, rgba(212, 175, 55, .13), transparent 60%),
        radial-gradient(900px 600px at 90% 75%, rgba(122, 28, 28, .06), transparent 60%),
        url('data:image/svg+xml,%3Csvg xmlns=%27http://www.w3.org/2000/svg%27 width=%2756%27 height=%2756%27 viewBox=%270 0 56 56%27%3E%3Cg fill=%27none%27 stroke=%27%23B38B2D%27 stroke-opacity=%27.14%27%3E%3Cpath d=%27M28 3 53 28 28 53 3 28Z%27/%3E%3Cpath d=%27M28 17 39 28 28 39 17 28Z%27/%3E%3C/g%3E%3Ccircle cx=%2728%27 cy=%2728%27 r=%272%27 fill=%27%23B38B2D%27 fill-opacity=%27.16%27/%3E%3C/svg%3E'),
        #F9F6F0;
">
    @include('components.header')

    <main class="w-full @yield('jarak_atas', 'pt-20') @yield('latar_main', 'bg-surface')">
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

                // Content elements (single elements that get updated)
                this.heroBadge = document.getElementById('hero-badge');
                this.heroTitle = document.getElementById('hero-title');
                this.heroDescription = document.getElementById('hero-description');

                // Slide data from hidden JSON element
                this.slideData = [];
                const dataEl = document.getElementById('carousel-data');
                if (dataEl && dataEl.dataset.slides) {
                    try {
                        this.slideData = JSON.parse(dataEl.dataset.slides);
                    } catch (e) {
                        console.warn('Carousel data parse error:', e);
                    }
                }

                this.currentIndex = 0;
                this.autoPlayInterval = null;
                this.autoPlayDelay = 5000; // 5 seconds
                this.isInitialLoad = true;

                if (this.slides.length > 0) {
                    this.init();
                }
            }

            init() {
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
                // Update slides (background images)
                this.slides.forEach((slide, index) => {
                    slide.classList.remove('opacity-100');
                    slide.classList.add('opacity-0');
                    if (index === this.currentIndex) {
                        slide.classList.remove('opacity-0');
                        slide.classList.add('opacity-100');
                    }
                });

                // Update content text (with smooth transition)
                if (this.slideData[this.currentIndex]) {
                    const data = this.slideData[this.currentIndex];

                    // Fade out
                    const contentEl = document.getElementById('hero-content');
                    if (contentEl) {
                        contentEl.style.opacity = '0';
                        // On initial load, don't translate - just fade
                        if (this.isInitialLoad) {
                            contentEl.style.transform = 'translateY(0)';
                        } else {
                            contentEl.style.transform = 'translateY(10px)';
                        }
                    }

                    // Update after brief delay for smooth transition
                    setTimeout(() => {
                        if (this.heroBadge && data.badge_text) {
                            this.heroBadge.innerHTML = `<span class="w-2 h-2 rounded-full bg-secondary animate-ping"></span> ${data.badge_text}`;
                        }
                        if (this.heroTitle && data.hero_title) {
                            this.heroTitle.textContent = data.hero_title;
                        }
                        if (this.heroDescription && data.hero_description) {
                            this.heroDescription.textContent = data.hero_description;
                        }

                        // Fade in
                        if (contentEl) {
                            contentEl.style.opacity = '1';
                            contentEl.style.transform = 'translateY(0)';
                        }

                        // Mark initial load as complete
                        if (this.isInitialLoad) {
                            this.isInitialLoad = false;
                        }
                    }, 150);
                }

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