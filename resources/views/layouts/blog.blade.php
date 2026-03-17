@php
    $image = \App\Models\ImageProfile::first();
    $sosialMedia = \App\Models\User::first();
    $defaultPreviewImage = $image?->foto_resume
        ? \Illuminate\Support\Facades\Storage::disk('cloudinary')->url($image->foto_resume)
        : asset('template/assets/img/content/foto-resume.jpg');
    $metaPreviewImage = $metaImage ?? $defaultPreviewImage;
    $isHomeRoute = request()->routeIs('home');
    $isAboutRoute = request()->routeIs('about');
    $isResumeRoute = request()->routeIs('resume');
    $isProjectRoute = request()->routeIs('project');
    $isProjectDetailRoute = request()->routeIs('project-detail');
@endphp

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="referrer" content="no-referrer-when-downgrade">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    {{-- SEO Dasar Google --}}
    <title>{{ $page ?? 'View' }} | {{ $title ?? 'Portofolio Rizky Chandra' }}</title>
    <meta name="description" content="{{ __('translate.seo_description') }}">
    <meta name="keywords" content="{{ __('translate.seo_keyword') }}">
    <meta name="author" content="Rizky Chandra Khusuma">
    <meta name="robots" content="index, follow">

    {{-- Open Graph Meta (Sosial Media) --}}
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $page ?? 'View' }} | {{ $title ?? 'Portofolio Rizky Chandra' }}">
    <meta property="og:description" content="@lang('translate.meta_description')">

    {{-- Instagram & Threads --}}
    <meta property="og:image" content="{{ $metaPreviewImage }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:site_name" content="Portofolio Rizky Chandra">

    {{-- Twitter --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ url()->current() }}">
    <meta name="twitter:title" content="{{ $title ?? 'Portofolio Rizky Chandra' }}">
    <meta name="twitter:description" content="Explore the portfolio of Rizky Chandra, a passionate web developer.">
    <meta name="twitter:image" content="{{ $metaPreviewImage }}">

    {{-- Link Alternate untuk SEO Multibahasa --}}
    <link rel="alternate" hreflang="id" href="{{ route(Route::currentRouteName(), array_merge(Route::current()->parameters(), ['locale' => 'id'])) }}">
    <link rel="alternate" hreflang="en" href="{{ route(Route::currentRouteName(), array_merge(Route::current()->parameters(), ['locale' => 'en'])) }}">
    <link rel="alternate" hreflang="x-default" href="{{ url('/lang/en') }}">
    <link rel="canonical" href="{{ url()->current() }}">

    {{-- Favicons --}}
    <link href="{{ $image?->foto_resume ? \Illuminate\Support\Facades\Storage::disk('cloudinary')->url($image->foto_resume) : asset('template/assets/img/content/foto-resume.jpg') }}" rel="icon" crossorigin="anonymous">

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" />

    {{-- Vendor CSS Files --}}
    @if (! $isHomeRoute)
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @endif
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('template/assets/vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/assets/vendor/aos/aos.css') }}">
    @if ($isProjectRoute || $isProjectDetailRoute)
        <link rel="stylesheet" href="{{ asset('template/assets/vendor/glightbox/css/glightbox.min.css') }}">
    @endif
    @if ($isProjectDetailRoute)
        <link rel="stylesheet" href="{{ asset('template/assets/vendor/swiper/swiper-bundle.min.css') }}">
    @endif

    {{-- Main CSS File --}}
    <link rel="stylesheet" href="{{ asset('template/assets/css/main.css') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @if (! $isHomeRoute)
        @livewireStyles
    @endif

    <style>
        /* Memastikan kontainer isotope mengisi ruang ketika tidak ada gambar */
        .isotope-container {
            min-height: 200px !important;
        }
    </style>
</head>

<body class="index-page d-flex flex-column min-vh-100">

    <header id="header" class="header dark-background d-flex flex-column justify-content-center">
        <i class="header-toggle d-xl-none bi bi-list" role="button" tabindex="0" aria-label="Toggle navigation menu" aria-controls="navmenu" aria-expanded="false"></i>
        @include('partials.navigate')
    </header>

    <main class="main flex-fill">
        {{ $slot }}
    </main>

    <footer id="footer" class="footer position-relative">
        <div class="container">
            {!! app()->getLocale() == 'id' ?
                '
                    <div class="copyright text-center">
                        <p>© <span>Hak Cipta</span> <strong class="px-1 sitename">Rizky_Chandra</strong> <span>Semua Hak Dilindungi Undang-Undang</span></p>
                    </div>
                    <div class="credits">
                        Dirancang dengan <strong><a href="https://bootstrapmade.com/">Bootstrap v5.0</a></strong>
                    </div>
                ' : '
                    <div class="copyright text-center">
                        <p>© <span>Copyright</span> <strong class="px-1 sitename">Rizky_Chandra</strong> <span>All Rights Reserved</span></p>
                    </div>
                    <div class="credits">
                        Designed with <strong><a href="https://bootstrapmade.com/">Bootstrap v5.0</a></strong>
                    </div>
                '
            !!}
        </div>
    </footer>

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" aria-label="Scroll to top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="{{ asset('template/assets/vendor/aos/aos.js') }}" defer></script>
    @if ($isHomeRoute)
        <script src="{{ asset('template/assets/vendor/typed.js/typed.umd.js') }}" defer></script>
    @endif
    @if ($isAboutRoute || $isResumeRoute)
        <script src="{{ asset('template/assets/vendor/waypoints/noframework.waypoints.js') }}" defer></script>
    @endif
    @if ($isProjectRoute || $isProjectDetailRoute)
        <script src="{{ asset('template/assets/vendor/glightbox/js/glightbox.min.js') }}" defer></script>
    @endif
    @if ($isProjectRoute)
        <script src="{{ asset('template/assets/vendor/isotope-layout/isotope.pkgd.min.js') }}" defer></script>
        <script src="{{ asset('template/assets/vendor/imagesloaded/imagesloaded.pkgd.min.js') }}" defer></script>
    @endif
    @if ($isProjectDetailRoute)
        <script src="{{ asset('template/assets/vendor/swiper/swiper-bundle.min.js') }}" defer></script>
    @endif
    
    <script src="{{ asset('template/assets/js/main.js') }}" defer></script>

    @if (! $isHomeRoute)
        @livewireScripts
    @endif
    @stack('scripts')

    @if (! $isHomeRoute)
        <script>
            document.addEventListener('livewire:navigated', () => {
                window.scrollTo({ top: 0, behavior: 'smooth' });
                
                // Reset UI State
                const preloader = document.querySelector('#preloader');
                if (preloader) { preloader.remove(); }

                // Re-init AOS (Animasi)
                if (typeof AOS !== 'undefined') {
                    AOS.init({ duration: 600, easing: 'ease-in-out', once: true });
                }

                // Re-init Glightbox
                if (typeof GLightbox !== 'undefined') {
                    GLightbox({ selector: '.glightbox' });
                }

                // Re-init Swiper
                if (typeof Swiper !== 'undefined') {
                    document.querySelectorAll('.init-swiper').forEach(function(swiperElement) {
                        let configElement = swiperElement.querySelector('.swiper-config');
                        if (configElement) {
                            let config = JSON.parse(configElement.innerHTML.trim());
                            new Swiper(swiperElement, config);
                        }
                    });
                }

                // Re-init Isotope
                if (typeof Isotope !== 'undefined') {
                    document.querySelectorAll('.isotope-layout').forEach(function(isotopeItem) {
                        let layout = isotopeItem.getAttribute('data-layout') ?? 'masonry';
                        let filter = isotopeItem.getAttribute('data-default-filter') ?? '*';
                        let sort = isotopeItem.getAttribute('data-sort') ?? 'original-order';
                        let container = isotopeItem.querySelector('.isotope-container');
                        
                        if (container) {
                            let initIsotope = new Isotope(container, {
                                itemSelector: '.isotope-item',
                                layoutMode: layout,
                                filter: filter,
                                sortBy: sort
                            });

                            isotopeItem.querySelectorAll('.isotope-filters li').forEach(function(filters) {
                                filters.addEventListener('click', function() {
                                    isotopeItem.querySelector('.isotope-filters .filter-active').classList.remove('filter-active');
                                    this.classList.add('filter-active');
                                    initIsotope.arrange({ filter: this.getAttribute('data-filter') });
                                }, false);
                            });
                        }
                    });
                }
            });
        </script>
    @endif
</body>
</html>
