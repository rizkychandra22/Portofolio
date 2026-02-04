<div>
    <section id="resume" class="resume section">
        <div class="container section-title" data-aos="fade-up">
            <h2>Resume</h2>
            <p>
                {{ app()->getLocale() == 'id' 
                    ? 'Rangkuman perjalanan profesional dan akademik saya dalam membangun solusi digital. Berfokus pada pengembangan sistem informasi yang efisien, terukur, dan berdampak positif bagi operasional bisnis maupun institusi.'
                    : 'A summary of my professional and academic journey in building digital solutions. Focused on developing efficient, scalable information systems that positively impact business and institutional operations.'
                }}
            </p>
        </div>
        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="row gy-4">
                <div class="col-lg-4">
                    <div class="resume-side" data-aos="fade-right" data-aos-delay="100">
                        <div class="profile-img mb-4">
                            <img src="{{ $imageResume->foto_resume ?? '/snapfolio/assets/img/content/foto-ijazah.jpg' }}" crossorigin="anonymous" alt="Rizky Chandra" class="img-fluid rounded shadow-sm" fetchpriority="high">
                        </div>
                        {!! app()->getLocale() == 'id' ?
                            '   
                                <h3>Ringkasan Profesional</h3>
                                <p>Web Developer yang berfokus pada solusi backend dengan pengalaman membangun sistem informasi manajemen yang skalabel. Ahli dalam Laravel & Livewire, serta berdedikasi menciptakan sistem yang efisien untuk digitalisasi proses bisnis.</p>
                                <h3 class="mt-4">Informasi Kontak</h3>
                            ' : '
                                <h3>Professional Summary</h3>
                                <p>Web Developer focused on backend solutions with experience building scalable management information systems. Expert in Laravel & Livewire, and dedicated to creating efficient systems for digitizing business processes.</p>
                                <h3 class="mt-4">Contact Information</h3>
                            '
                        !!}
                        <ul class="contact-info list-unstyled">
                            <li><i class="bi bi-geo-alt"></i> {{ $sosialMedia->{'address_' . app()->getLocale()} }}</li>
                            <li><i class="bi bi-envelope"></i> {{ $sosialMedia->email }}</li>
                            <li><i class="bi bi-linkedin"></i> {{ $sosialMedia->linkedin }}</li>
                            <li><i class="bi bi-github"></i> {{ $sosialMedia->github }}</li>
                        </ul>

                        <div class="skills-animation mt-4">
                            <h3>{{ app()->getLocale() == 'id' ? 'Keahlian Teknis' : 'Technical Expertise' }}</h3>
                            <div class="skill-item">
                                <div class="d-flex justify-content-between">
                                    <span>Backend PHP (Laravel & CodeIgniter)</span>
                                    <span>80%</span>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            <div class="skill-item">
                                <div class="d-flex justify-content-between">
                                    <span>Database (Postgre/MySQL/SQLite)</span>
                                    <span>70%</span>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            <div class="skill-item">
                                <div class="d-flex justify-content-between">
                                    <span>Frontend (HTML/CSS/JS/Bootstrap)</span>
                                    <span>90%</span>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: 90%" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            <div class="skill-item">
                                <div class="d-flex justify-content-between">
                                    <span>Interactive UI (React/Vue/Livewire)</span>
                                    <span>60%</span>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 ps-4 ps-lg-5">
                    <div class="resume-section" data-aos="fade-up">
                        <h3><i class="bi bi-briefcase me-2"></i>{{ app()->getLocale() == 'id' ? 'Ringkasan Profesional' : 'Professional Summary' }}</h3>
                        <div class="resume-item">
                            <h4>Web Developer</h4>
                            <h5>2023 - 2024</h5>
                            <p class="company"><i class="bi bi-building"></i> SDN Caringin Ngumbang & CV Kormaras</p>
                            <ul>
                                {!! app()->getLocale() =='id' ?
                                    '   
                                        <li>Mengembangkan Sistem Informasi Keuangan Sekolah untuk akurasi pendataan transaksi.</li>
                                        <li>Membangun aplikasi Manajemen Stok Gudang menggunakan Laravel untuk efisiensi kontrol inventaris.</li>
                                        <li>Menerapkan arsitektur database yang optimal dan memastikan keamanan data sistem.</li>
                                        <li>Bekerja sama dengan stakeholder untuk menerjemahkan kebutuhan bisnis menjadi fitur teknis.</li>
                                    ' : '
                                        <li>Developing a School Financial Information System for accurate transaction data recording.</li>
                                        <li>Building a Warehouse Stock Management application using Laravel for efficient inventory control.</li>
                                        <li>Implement optimal database architecture and ensure system data security.</li>
                                        <li>Work with stakeholders to translate business needs into technical features.</li>
                                    '
                                !!}
                            </ul>
                        </div>
                        <div class="resume-item">
                            <h4>Independent Project: Laravel Tracking System</h4>
                            <h5>2024 - 2025</h5>
                            <p class="company"><i class="bi bi-code-slash"></i> Personal Development</p>
                            <ul>
                                {!! app()->getLocale() == 'id' ?
                                    '   
                                        <li>Merancang sistem pelacakan data real-time menggunakan Laravel Framework.</li>
                                        <li>Mengoptimalkan performa maps lokasi yang real-time menggunakan Google Maps API.</li>
                                    ' : '
                                        <li>Designing a real-time data tracking system using the Laravel Framework.</li>
                                        <li>Optimizes real-time location map performance using the Google Maps API.</li>
                                    '
                                !!}
                            </ul>
                        </div>
                    </div>

                    <div class="resume-section" data-aos="fade-up" data-aos-delay="100">
                        <h3><i class="bi bi-mortarboard me-2"></i>{{ app()->getLocale() == 'id' ? 'Pendidikan & Pengalaman Kampus' : 'Education & Campus Experience' }}</h3>
                        <div class="resume-item">
                            <h4>{{ app()->getLocale() == 'id' ? 'Sarjana Teknik Informatika (S.Kom)' : 'Bachelor of Informatics Engineering (S.Kom)' }}</h4>
                            <h5>2021 - 2025</h5>
                            <p class="company"><i class="bi bi-building"></i> @lang('translate.kampus')</p>
                            <p>{{ app()->getLocale() == 'id' 
                                ? 'Lulus dengan IPK 3.28. Berfokus pada rekayasa perangkat lunak dan pengembangan sistem informasi.'
                                : 'Graduated with a GPA of 3.28. Focused on software engineering and information systems development.' 
                                }}
                            </p>
                        </div>

                        <div class="resume-item">
                            <h4>{{ app()->getLocale() == 'id' ? 'Pengembangan Sumber Daya Mahasiswa (PSDM)' : 'Student Resource Development (PSDM)' }}</h4>
                            <h5>{{ app()->getLocale() == 'id' ? 'Satu' : 'One' }} Periode</h5>
                            <p class="company"><i class="bi bi-building"></i> {{ __('translate.kampus') }}</p>
                            <p>{{ app()->getLocale() == 'id' 
                                ? 'Mengelola koordinasi tim dan strategi pengembangan potensi anggota dalam lingkup organisasi mahasiswa teknik informatika.' 
                                : 'Manage team coordination and strategies for developing member potential within the scope of the informatics engineering student organization.'
                                }}
                            </p>
                        </div>
                        
                        <div class="resume-item">
                            <h4>{{ app()->getLocale() == 'id' ? 'Aktivitas Ekstra: Lingkung Seni Sunda' : 'Extra Activities: Sundanese Arts Circle' }}</h4>
                            <h5>{{ app()->getLocale() == 'id' ? 'Dua' : 'Two' }} Periode</h5>
                            <p class="company"><i class="bi bi-building"></i> @lang('translate.kampus')</p>
                            <p>{{ app()->getLocale() == 'id' 
                                ? 'Berpartisipasi aktif dalam pelestarian budaya lokal, menunjukkan keseimbangan antara disiplin teknis dan kreativitas seni musik.'
                                : 'Actively participate in the preservation of local culture, demonstrating a balance between technical discipline and musical artistic creativity.'
                                }}
                            </p>
                        </div>
                    </div>

                    <div class="resume-section" data-aos="fade-up" data-aos-delay="200">
                        <h3><i class="bi bi-trophy me-2"></i>{{ app()->getLocale() == 'id' ? 'Sertifikasi Penghargaan' : 'Award Certification' }}</h3>
                        <div class="resume-item">
                            <h4>{{ app()->getLocale() == 'id' ? 'Tim Pelaksana Program PPK Ormawa' : 'PPK Ormawa Program Implementation Team' }}</h4>
                            <h5>Juni 2023 - November 2023</h5>
                            <p class="company"><i class="bi bi-building"></i> Kemendikbudristek & {{ __('translate.kampus') }}</p>
                            <ul>
                                {!! app()->getLocale() == 'id' ? 
                                    '
                                        <li>Terpilih sebagai tim pelaksana dalam Program Penguatan Kapasitas Organisasi Kemahasiswaan (PPK Ormawa) 2023.</li>
                                        <li>Berkontribusi dalam pelaksanaan program pengabdian dan penguatan organisasi melalui Himpunan Mahasiswa Teknik Informatika.</li>
                                    ' : '
                                        <li>Selected as an implementing team member in the 2023 Student Organization Capacity Building Program (PPK Ormawa).</li>
                                        <li>Contributed to the implementation of community service and organizational strengthening programs through the Informatics Engineering Student Association.</li>
                                    '
                                !!}
                            </ul>
                        </div>
                        <div class="resume-item">
                            <h4>{{ app()->getLocale() == 'id' ? 'Pelatihan Pemograman Mobile' : 'Mobile Programming Training' }}</h4>
                            <h5>September 2023</h5>
                            <p class="company"><i class="bi bi-patch-check"></i> {{ app()->getLocale() == 'id' ? 'Departemen Teknik Informatika (UMMI)' : 'Informatics Engineering Department (UMMI)' }}</p>
                            <ul>
                                {!! app()->getLocale() == 'id' ? 
                                    '
                                        <li>Menyelesaikan pelatihan intensif mengenai pengembangan aplikasi mobile.</li>
                                        <li>Memahami fundamental pemrograman mobile sebagai bagian dari pengembangan keahlian software engineering.</li>
                                    ' : '
                                        <li>Complete intensive training on mobile application development.</li>
                                        <li>Understand the fundamentals of mobile programming as part of developing software engineering skills.</li>
                                    '
                                !!}
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
