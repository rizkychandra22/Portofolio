<div>
    <section id="about" class="about section">
        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="row">
                <div class="col-lg-5" data-aos="zoom-in" data-aos-delay="200">
                    <div class="profile-card">
                        <div class="profile-header">
                            <div class="profile-image">
                                <img src="{{ $imageAbout?->foto_about ? \App\Support\CloudinaryUrl::fromPath($imageAbout->foto_about) : asset('snapfolio/assets/img/content/foto-about.jpg') }}" crossorigin="anonymous" alt="Profile Image" class="img-fluid" fetchpriority="high">
                            </div>
                            <div class="profile-badge">
                                <i class="fas fa-check-circle"></i>
                            </div>
                        </div>
                        <div class="profile-content">
                            <h3>Rizky Chandra Khusuma</h3>
                            <p class="profession">Web Developer &amp; Full-Stack Developer</p>

                            <div class="contact-links">
                                <a href="mailto:{{ $sosialMedia->email ?? '' }}" target="_blank" class="contact-item">
                                    <i class="bi bi-envelope"></i>
                                    {{ $sosialMedia->email ?? '' }}
                                </a>
                                <a href="https://wa.me/{{ $sosialMedia->phone ?? '' }}" target="_blank" class="contact-item">
                                    <i class="bi bi-telephone"></i>
                                    {{ $sosialMedia->phone ?? '' }}
                                </a>
                                <a href="https://google.com/maps/search/?api=1&query={{ $sosialMedia->address_id ?? '' }}" target="_blank" class="contact-item text-start">
                                    <i class="bi bi-geo-alt"></i>
                                    {{ $sosialMedia->{'address_' . app()->getLocale()} ?? '' }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7" data-aos="fade-left" data-aos-delay="300">
                    <div class="about-content">
                        <div class="section-header">
                            <span class="badge-text">
                                {{ app()->getLocale() == 'id' ? 'Kenali Saya Lebih Dekat' : 'Get to Know Me' }}
                            </span>
                            <h2>{{ app()->getLocale() == 'id' ? 'Mengubah Kompleksitas Menjadi Solusi Digital.' : 'Transforming Complexity Into Digital Solutions.' }}</h2>
                        </div>
                        <div class="description">
                            <p>
                                {!! app()->getLocale() == 'id'
                                    ? 'Saya adalah Web Developer lulusan Teknik Informatika dengan spesialisasi <strong>Laravel</strong> dan <strong>CodeIgniter</strong>. Berfokus pada pengembangan sistem informasi yang efisien, saya berpengalaman membangun platform manajemen keuangan sekolah, stok gudang hingga sistem pelacakan yang skalabel.'
                                    : 'I am a Web Developer graduated in Informatics Engineering specializing in <strong>Laravel</strong> and <strong>CodeIgniter</strong>. Focused on developing efficient information systems, I have experience building school financial management platforms, warehouse stock, and scalable tracking systems.'
                                !!} 
                            </p>
                            <p>
                                {!! app()->getLocale() == 'id' 
                                    ? 'Saat ini, saya sedang mendalami <strong>Ekosistem Laravel</strong>, serta bahasa pemograman lain seperti <strong>Golang</strong>, <strong>Python</strong>, dan <strong>React</strong>. Saya berkomitmen pada standar <i>clean code</i> untuk menghadirkan sistem yang tidak hanya tangguh di sisi backend, tetapi juga intuitif bagi pengguna.'
                                    : "Currently, I am studying <strong>Laravel Ecosystem</strong>, as well as other programming languages such as <strong>Golang</strong>, <strong>Python</strong>, dan <strong>React</strong>. I'm committed to <i>clean code</i> standards to deliver a system that's not only robust on the backend, but also intuitive for users."
                                !!}
                            </p>
                        </div>
                        <div class="details-grid">
                            <div class="detail-row">
                                <div class="detail-item">
                                    <span class="detail-label">
                                        {{ app()->getLocale() == 'id' ? 'Spesialisasi' : 'Specialization' }}
                                    </span>
                                    <span class="detail-value">
                                        {{ app()->getLocale() == 'id' ? 'Full-Stack Web Development' : 'Full-Stack Web Development' }}
                                    </span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">
                                        {{ app()->getLocale() == 'id' ? 'Tingkat Pengalaman' : 'Experience Level' }}
                                    </span>
                                    <span class="detail-value">
                                        {{ app()->getLocale() == 'id' ? 'Junior - Professional Menengah' : 'Junior - Mid Professional' }}
                                    </span>
                                </div>
                            </div>
                            <div class="detail-row">
                                <div class="detail-item">
                                    <span class="detail-label">
                                        {{ app()->getLocale() == 'id' ? 'Pendidikan' : 'Education' }}
                                    </span>
                                    <span class="detail-value">
                                        {{ app()->getLocale() == 'id' ? 'S1 Teknik Informatika' : 'Bachelor of Informatics Engineering' }}
                                    </span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">
                                        {{ app()->getLocale() == 'id' ? 'Bahasa' : 'Language' }}
                                    </span>
                                    <span class="detail-value">
                                        {{ app()->getLocale() == 'id' ? 'Indonesia, Inggris (Pasif)' : 'Indonesian, English (Passive)' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="cta-section d-inline justify-content-center">
                            <a href="{{ route('view.cv') }}" target="_blank" class="btn btn-primary mt-2 mb-2 me-2">
                                <i class="fas fa-eye"></i>
                                {{ app()->getLocale() == 'id' ? 'Lihat CV' : "Show CV" }}
                            </a>
                            <a href="https://discord.com/users/{{ $sosialMedia->discord ?? '' }}" target="_blank" class="btn btn-outline mt-2 mb-2">
                                <i class="fas fa-comment-dots"></i>
                                {{ app()->getLocale() == 'id' ? 'Berdiskusi' : "Let's Talk" }}
                            </a>
                        </div>
                        <div class="cta-section">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="skills" class="skills section">
        <div class="container section-title" data-aos="fade-up">
            <h2>{{ app()->getLocale() == 'id' ? 'Keahlian' : 'Skill' }}</h2>
            <p>
                {{ app()->getLocale() == 'id'
                    ? 'Kombinasi teknologi yang saya gunakan untuk membangun solusi digital yang tangguh dan efisien.'
                    : 'The combination of technologies I use to build robust and efficient digital solutions.' 
                }}
            </p>
        </div>
        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="row">
                <div class="col-lg-6">
                    <div class="skills-category" data-aos="fade-up" data-aos-delay="200">
                        <h3>Front-end Development</h3>
                        <div class="skills-animation">
                            <div class="skill-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h4>HTML, CSS & Bootstrap</h4>
                                    <span class="skill-percentage">95%</span>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: 95%" aria-valuenow="95"></div>
                                </div>
                                <div class="skill-tooltip">
                                    {{ app()->getLocale() == 'id' 
                                        ? 'Mahir dalam membangun struktur web semantik (HTML5) dan desain responsif yang modern serta konsisten di berbagai perangkat menggunakan Bootstrap.' 
                                        : 'Proficient in building semantic web structures (HTML5) and modern, responsive designs that are consistent across devices using Bootstrap.' 
                                    }}
                                </div>
                            </div>
                            <div class="skill-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h4>JavaScript & Vue.js</h4>
                                    <span class="skill-percentage">60%</span>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: 60%" aria-valuenow="60"></div>
                                </div>
                                <div class="skill-tooltip">
                                    {{ app()->getLocale() == 'id' 
                                        ? 'Fokus pada pengembangan logika sisi klien, manipulasi DOM yang efisien, dan membangun antarmuka pengguna yang reaktif.' 
                                        : 'Focused on client-side logic development, efficient DOM manipulation, and building reactive user interfaces.' 
                                    }}
                                </div>
                            </div>
                            <div class="skill-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h4>Livewire & React</h4>
                                    <span class="skill-percentage">70%</span>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: 70%" aria-valuenow="70"></div>
                                </div>
                                <div class="skill-tooltip">
                                    {{ app()->getLocale() == 'id' 
                                        ? 'Spesialis dalam membangun aplikasi Single Page (SPA) yang dinamis menggunakan Livewire 3 dan arsitektur berbasis komponen pada React.' 
                                        : 'Specialist in building dynamic Single Page Applications (SPA) using Livewire 3 and component-based architecture in React.' 
                                    }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="skills-category" data-aos="fade-up" data-aos-delay="300">
                        <h3>Back-end Development</h3>
                        <div class="skills-animation">
                            <div class="skill-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h4>PHP (Laravel & CodeIgniter)</h4>
                                    <span class="skill-percentage">90%</span>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: 90%" aria-valuenow="90"></div>
                                </div>
                                <div class="skill-tooltip">
                                    {{ app()->getLocale() == 'id' 
                                        ? 'Berpengalaman luas dalam membangun aplikasi web enterprise, RESTful API, dan sistem backend yang aman serta terukur menggunakan ekosistem Laravel.' 
                                        : 'Extensive experience in building enterprise web applications, RESTful APIs, and secure, scalable backend systems using the Laravel ecosystem.' 
                                    }}
                                </div>
                            </div>
                            <div class="skill-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h4>Golang & Python</h4>
                                    <span class="skill-percentage">50%</span>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: 50%" aria-valuenow="50"></div>
                                </div>
                                <div class="skill-tooltip">
                                    {{ app()->getLocale() == 'id' 
                                        ? 'Memanfaatkan efisiensi konkurensi Go untuk layanan mikro (microservices) dan Python untuk otomatisasi serta pengolahan data.' 
                                        : 'Leveraging Go\'s concurrency efficiency for microservices and Python for automation and data processing.' 
                                    }}
                                </div>
                            </div>
                            <div class="skill-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h4>Database (PostgreSQL, MySQL & SQLite)</h4>
                                    <span class="skill-percentage">80%</span>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: 80%" aria-valuenow="80"></div>
                                </div>
                                <div class="skill-tooltip">
                                    {{ app()->getLocale() == 'id' 
                                        ? 'Ahli dalam perancangan skema relasional, optimasi query kompleks, dan manajemen integritas data untuk performa aplikasi yang tinggi.' 
                                        : 'Expert in relational schema design, complex query optimization, and data integrity management for high-performance applications.' 
                                    }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
