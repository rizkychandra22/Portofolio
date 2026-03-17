<div>
    @php
        $homeImageSource = ($imageHome?->foto_home)
            ? Storage::disk('cloudinary')->url($imageHome->foto_home)
            : asset('template/assets/img/content/foto-home.jpg');
        $isCloudinaryImage = str_contains($homeImageSource, '/upload/');
        $homeImageOptimized = $isCloudinaryImage
            ? str_replace('/upload/', '/upload/f_auto,q_auto,w_520,c_fill/', $homeImageSource)
            : $homeImageSource;
        $homeImageOptimizedSmall = $isCloudinaryImage
            ? str_replace('/upload/', '/upload/f_auto,q_auto,w_320,c_fill/', $homeImageSource)
            : $homeImageSource;
        $homeImageSrcSet = $isCloudinaryImage
            ? $homeImageOptimizedSmall . ' 320w, ' . $homeImageOptimized . ' 520w'
            : null;
    @endphp
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
                            <h1>{{ app()->getLocale() == 'id' ? 'Porto' : 'Port' }}<span class="accent-text">Folio</span></h1>
                            <h2>Rizky Chandra Khusuma</h2>
                            <p class="lead">{{ app()->getLocale() == 'id' ? 'Saya Seorang' : 'I am a' }} <span class="typed" data-typed-items="Web Developer, Back-end Developer, Front-end Developer, Full-Stack Developer"></span></p>
                            <p class="description">
                                {{ app()->getLocale() == 'id' 
                                    ? 'Pengembang website profesional dengan pengalaman lebih dari satu tahun dalam membangun aplikasi web secara efektif dan scalable untuk menciptakan solusi digital yang inovatif serta sesuai dengan kebutuhan pengguna.' 
                                    : 'Professional website developer with over a year of experience in building effective and scalable web applications to create innovative digital solutions that meet user needs.'
                                }}
                            </p>
                            <div class="hero-actions">
                                <a href="{{ route('project', ['locale' => app()->getLocale() ]) }}" class="btn btn-primary">
                                    {{ app()->getLocale() == 'id' ? 'Lihat Proyek Saya' : 'View My Project' }}
                                </a>
                                <a href="{{ route('contact', ['locale' => app()->getLocale() ]) }}" class="btn btn-outline">
                                    {{ app()->getLocale() == 'id' ? 'Hubungi Saya' : 'Contact Me' }}
                                </a>
                            </div>
                            <div class="social-links d-flex justify-content-center">
                                <a href="https://linkedin.com/in/{{ $sosialMedia->linkedin ?? '' }}" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn profile" class="linkedin"><i class="bi bi-linkedin"></i></a>
                                <a href="https://discord.com/users/{{ $sosialMedia->discord ?? '' }}" target="_blank" rel="noopener noreferrer" aria-label="Discord profile" class="discord"><i class="bi bi-discord"></i></a>
                                <a href="https://github.com/{{ $sosialMedia->github ?? '' }}" target="_blank" rel="noopener noreferrer" aria-label="GitHub profile" class="google-plus"><i class="bi bi-github"></i></a>
                                <a href="https://instagram.com/{{ $sosialMedia->instagram ?? '' }}" target="_blank" rel="noopener noreferrer" aria-label="Instagram profile" class="instagram"><i class="bi bi-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6" data-aos="fade-left" data-aos-delay="200">
                        <div class="hero-visual">
                            <div class="profile-container">
                                <div class="profile-background"></div>
                                <img src="{{ $homeImageOptimized }}" @if ($homeImageSrcSet) srcset="{{ $homeImageSrcSet }}" @endif crossorigin="anonymous" alt="Rizky Chandra Khusuma" class="profile-image" fetchpriority="high" decoding="async" width="400" height="400" sizes="(max-width: 576px) 78vw, (max-width: 992px) 350px, 400px">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
