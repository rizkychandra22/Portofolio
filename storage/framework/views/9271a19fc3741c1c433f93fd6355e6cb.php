<?php
    $image = \App\Models\ImageProfile::first();
    $sosialMedia = \App\Models\User::first();
?>

<!DOCTYPE html>
<html lang="<?php echo e(app()->getLocale()); ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta name="referrer" content="no-referrer-when-downgrade">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    
    <title><?php echo e($page ?? 'View'); ?> | <?php echo e($title ?? 'Portofolio Rizky Chandra'); ?></title>
    <meta name="description" content="Portfolio profesional Rizky Chandra Khusuma, seorang Web Developer yang ahli dalam Laravel, Livewire, dan desain web modern.">
    <meta name="keywords" content="Rizky Chandra, Rizky Chandra Khusuma, Web Developer Indonesia, Laravel Developer, Portofolio Software Engineer, Programmer, Jasa Pembuatan Website">
    <meta name="author" content="Rizky Chandra Khusuma">
    <meta name="robots" content="index, follow">

    
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo e(url()->current()); ?>">
    <meta property="og:title" content="<?php echo e($page ?? 'View'); ?> | <?php echo e($title ?? 'Portofolio'); ?>">
    <meta property="og:description" content="Lihat karya dan pengalaman kerja Rizky Chandra di Portofolio.">
    <meta property="og:image" content="<?php echo e($image->foto_home ?? asset('default-og.jpg')); ?>" crossorigin="anonymous">
    <meta property="og:site_name" content="Portofolio Rizky Chandra">

    
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="<?php echo e(url()->current()); ?>">
    <meta name="twitter:title" content="<?php echo e($title ?? 'Portofolio Rizky Chandra'); ?>">
    <meta name="twitter:description" content="Explore the portfolio of Rizky Chandra, a passionate web developer.">
    <meta name="twitter:image" content="<?php echo e($image->foto_home ?? asset('default-og.jpg')); ?>">

    
    <link rel="alternate" hreflang="id" href="<?php echo e(route(Route::currentRouteName(), array_merge(Route::current()->parameters(), ['locale' => 'id']))); ?>">
    <link rel="alternate" hreflang="en" href="<?php echo e(route(Route::currentRouteName(), array_merge(Route::current()->parameters(), ['locale' => 'en']))); ?>">
    <link rel="alternate" hreflang="x-default" href="<?php echo e(url('/lang/en')); ?>">

    
    <link href="<?php echo e($image->foto_resume ?? '/snapfolio/assets/img/content/foto-ijazah.jpg'); ?>" rel="icon" crossorigin="anonymous">

    
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    
    <link href="<?php echo e(asset('snapfolio/assets/vendor/bootstrap/css/bootstrap.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('snapfolio/assets/vendor/bootstrap-icons/bootstrap-icons.css')); ?>" rel="stylesheet">
    <link rel="stylesheet" href="/!template-stisla/dist/assets/modules/fontawesome/css/all.min.css">
    <link href="<?php echo e(asset('snapfolio/assets/vendor/aos/aos.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('snapfolio/assets/vendor/glightbox/css/glightbox.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('snapfolio/assets/vendor/swiper/swiper-bundle.min.css')); ?>" rel="stylesheet">

    
    <link href="<?php echo e(asset('snapfolio/assets/css/main.css')); ?>" rel="stylesheet">

    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>


    <style>
        /* Memastikan kontainer isotope mengisi ruang ketika tidak ada gambar */
        .isotope-container {
            min-height: 200px !important;
        }
    </style>
</head>

<body class="index-page d-flex flex-column min-vh-100">

    <header id="header" class="header dark-background d-flex flex-column justify-content-center">
        <i class="header-toggle d-xl-none bi bi-list"></i>
        <?php echo $__env->make('partials.navigate', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </header>

    <main class="main flex-fill">
        <?php echo e($slot); ?>

    </main>

    <footer id="footer" class="footer position-relative">
        <div class="container">
            <?php echo app()->getLocale() == 'id' ?
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
                '; ?>

        </div>
    </footer>

    <!-- Scroll Top -->
    <a href="" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" crossorigin="anonymous"></script>
    <script src="<?php echo e(asset('snapfolio/assets/vendor/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
    <script src="<?php echo e(asset('snapfolio/assets/vendor/aos/aos.js')); ?>"></script>
    <script src="<?php echo e(asset('snapfolio/assets/vendor/typed.js/typed.umd.js')); ?>"></script>
    <script src="<?php echo e(asset('snapfolio/assets/vendor/purecounter/purecounter_vanilla.js')); ?>"></script>
    <script src="<?php echo e(asset('snapfolio/assets/vendor/waypoints/noframework.waypoints.js')); ?>"></script>
    <script src="<?php echo e(asset('snapfolio/assets/vendor/isotope-layout/isotope.pkgd.min.js')); ?>"></script>
    <script src="<?php echo e(asset('snapfolio/assets/vendor/imagesloaded/imagesloaded.pkgd.min.js')); ?>"></script>
    <script src="<?php echo e(asset('snapfolio/assets/vendor/glightbox/js/glightbox.min.js')); ?>"></script>
    <script src="<?php echo e(asset('snapfolio/assets/vendor/swiper/swiper-bundle.min.js')); ?>"></script>
    <script src="<?php echo e(asset('snapfolio/assets/js/main.js')); ?>"></script>

    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>

    <?php echo $__env->yieldPushContent('scripts'); ?>

    <script>
        document.addEventListener('livewire:navigated', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
            const preloader = document.querySelector('#preloader');
            if (preloader) { preloader.remove(); }
            
            // 1. Re-init AOS (Animasi)
            if (typeof AOS !== 'undefined') {
                AOS.init({ duration: 600, easing: 'ease-in-out', once: true });
            }

            // 2. Re-init Glightbox (Popup Gambar)
            if (typeof GLightbox !== 'undefined') {
                GLightbox({ selector: '.glightbox' });
            }

            // 3. Re-init Swiper (Slider di Detail Project)
            if (typeof Swiper !== 'undefined') {
                document.querySelectorAll('.init-swiper').forEach(function(swiperElement) {
                    let configElement = swiperElement.querySelector('.swiper-config');
                    if (configElement) {
                        let config = JSON.parse(configElement.innerHTML.trim());
                        new Swiper(swiperElement, config);
                    }
                });
            }

            // 4. Re-init Isotope (Filter Portofolio)
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
            
            // Re-init PureCounter jika ada
            if (typeof PureCounter !== 'undefined') {
                new PureCounter();
            }
        });
    </script>
</body>
</html><?php /**PATH D:\Github\Profile-Portofolio\resources\views/layouts/blog.blade.php ENDPATH**/ ?>