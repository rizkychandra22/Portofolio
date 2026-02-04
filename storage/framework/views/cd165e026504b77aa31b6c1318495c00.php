<div class="header-container d-flex flex-column align-items-start">
    <nav id="navmenu" class="navmenu">
        <ul>
            <?php
                $currentLocale = app()->getLocale();
                $currentRoute = Route::currentRouteName();
                $routeParams = Route::current() ? Route::current()->parameters() : [];
            ?>

            <li>
                <a href="<?php echo e(route('home', ['locale' => $currentLocale])); ?>" class="<?php echo \Illuminate\Support\Arr::toCssClasses(['active' => request()->routeIs('home')]); ?>">
                    <i class="bi bi-house navicon"></i> <?php echo e(app()->getLocale() == 'id' ? 'Beranda' : 'Home'); ?>

                </a>
            </li>
            <li>
                <a href="<?php echo e(route('about', ['locale' => $currentLocale])); ?>" class="<?php echo \Illuminate\Support\Arr::toCssClasses(['active' => request()->routeIs('about')]); ?>">
                    <i class="bi bi-person navicon"></i> <?php echo e(app()->getLocale() == 'id' ? 'Tentang' : 'About'); ?>

                </a>
            </li>
            <li>
                <a href="<?php echo e(route('resume', ['locale' => $currentLocale])); ?>" class="<?php echo \Illuminate\Support\Arr::toCssClasses(['active' => request()->routeIs('resume')]); ?>">
                    <i class="bi bi-file-earmark-text navicon"></i> Resume
                </a>
            </li>
            <li>
                <a href="<?php echo e(route('portofolio', ['locale' => $currentLocale])); ?>" class="<?php echo \Illuminate\Support\Arr::toCssClasses(['active' => request()->routeIs('portofolio') || request()->routeIs('portofolio-detail')]); ?>">
                    <i class="bi bi-images navicon"></i> Portofolio
                </a>
            </li>
            <li>
                <a href="<?php echo e(route('contact', ['locale' => $currentLocale])); ?>" class="<?php echo \Illuminate\Support\Arr::toCssClasses(['active' => request()->routeIs('contact')]); ?>">
                    <i class="bi bi-envelope navicon"></i> <?php echo e(app()->getLocale() == 'id' ? 'Kontak' : 'Contact'); ?>

                </a>
            </li>

            
            <div class="d-flex justify-content-center align-items-center mt-3 gap-2">
                
                <a href="<?php echo e($currentRoute ? route($currentRoute, array_merge($routeParams, ['locale' => 'id'])) : url('/lang/id')); ?>"
                    class="<?php echo e(app()->getLocale() == 'id' ? 'text-primary' : ''); ?>">
                    <img src="<?php echo e(asset('snapfolio/assets/img/flag-id.png')); ?>" width="18" class="me-1"> 
                    <?php echo e(app()->getLocale() == 'id' ? 'Indonesia' : 'Indonesian'); ?>

                </a>
                <span class="text-muted">|</span>
                
                <a href="<?php echo e($currentRoute ? route($currentRoute, array_merge($routeParams, ['locale' => 'en'])) : url('/lang/en')); ?>"
                    class="<?php echo e(app()->getLocale() == 'en' ? 'text-primary' : ''); ?>">
                    <img src="<?php echo e(asset('snapfolio/assets/img/flag-gb.png')); ?>" width="18" class="me-1"> 
                    <?php echo e(app()->getLocale() == 'id' ? 'Inggris' : 'English'); ?>

                </a>
            </div>
        </ul>
    </nav>
    <div class="social-links text-center">
        <a href="https://linkedin.com/in/<?php echo e($sosialMedia->linkedin ?? ''); ?>" target="_blank" class="linkedin"><i class="bi bi-linkedin"></i></a>
        <a href="https://discord.com/users/<?php echo e($sosialMedia->discord ?? ''); ?>" target="_blank" class="discord"><i class="bi bi-discord"></i></a>
        <a href="https://tiktok.com/<?php echo e($sosialMedia->tiktok ?? ''); ?>" target="_blank" class="instagram"><i class="bi bi-tiktok"></i></a>
        <a href="https://github.com/<?php echo e($sosialMedia->github ?? ''); ?>" target="_blank" class="google-plus"><i class="bi bi-github"></i></a>
        <a href="https://instagram.com/<?php echo e($sosialMedia->instagram ?? ''); ?>" target="_blank" class="instagram"><i class="bi bi-instagram"></i></a>
    </div>
</div><?php /**PATH D:\Github\Profile-Portofolio\resources\views/partials/navigate.blade.php ENDPATH**/ ?>