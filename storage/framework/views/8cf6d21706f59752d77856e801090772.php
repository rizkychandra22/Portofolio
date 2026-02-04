<div>
    <section id="hero" class="hero section">
        <div class="background-elements">
            <div class="bg-circle circle-1"></div>
            <div class="bg-circle circle-2"></div>
        </div>
        <div class="hero-content">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6" data-aos="fade-right" data-aos-delay="100">
                        <div class="hero-text">
                            <h1>Porto<span class="accent-text">Folio</span></h1>
                            <h2>Rizky Chandra Khusuma</h2>
                            <p class="lead"><?php echo e(app()->getLocale() == 'id' ? 'Saya Seorang' : 'I am a'); ?> <span class="typed" data-typed-items="Web Developer, Back-end Developer, Front-end Developer, Full-Stack Developer"></span></p>
                            <p class="description">
                                <?php echo e(app()->getLocale() == 'id' 
                                    ? 'Pengembang website profesional dengan pengalaman lebih dari satu tahun dalam membangun aplikasi web secara efektif dan scalable untuk menciptakan solusi digital yang inovatif serta sesuai dengan kebutuhan pengguna.' 
                                    : 'Professional website developer with over a year of experience in building effective and scalable web applications to create innovative digital solutions that meet user needs.'); ?>

                            </p>
                            <div class="hero-actions">
                                <a href="<?php echo e(route('portofolio', ['locale' => app()->getLocale() ])); ?>" class="btn btn-primary">
                                    <?php echo e(app()->getLocale() == 'id' ? 'Lihat Proyek Saya' : 'View My Project'); ?>

                                </a>
                                <a href="<?php echo e(route('contact', ['locale' => app()->getLocale() ])); ?>" class="btn btn-outline">
                                    <?php echo e(app()->getLocale() == 'id' ? 'Hubungi Saya' : 'Contact Me'); ?>

                                </a>
                            </div>
                            <div class="social-links d-flex justify-content-center">
                                <a href="https://linkedin.com/in/<?php echo e($sosialMedia->linkedin ?? ''); ?>" target="_blank" class="linkedin"><i class="bi bi-linkedin"></i></a>
                                <a href="https://discord.com/users/<?php echo e($sosialMedia->discord ?? ''); ?>" target="_blank" class="discord"><i class="bi bi-discord"></i></a>
                                <a href="https://github.com/<?php echo e($sosialMedia->github ?? ''); ?>" target="_blank" class="google-plus"><i class="bi bi-github"></i></a>
                                <a href="https://instagram.com/<?php echo e($sosialMedia->instagram ?? ''); ?>" target="_blank" class="instagram"><i class="bi bi-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6" data-aos="fade-left" data-aos-delay="200">
                        <div class="hero-visual">
                            <div class="profile-container">
                                <div class="profile-background"></div>
                                <img src="<?php echo e($imageHome->foto_home ?? '/snapfolio/assets/img/content/foto1.jpg'); ?>" crossorigin="anonymous" alt="Rizky Chandra Khusuma" class="profile-image" fetchpriority="high">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php /**PATH D:\Github\Profile-Portofolio\resources\views/livewire/content/home.blade.php ENDPATH**/ ?>