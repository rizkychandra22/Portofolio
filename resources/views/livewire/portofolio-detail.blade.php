<div>
    <div class="page-title dark-background">
        <div class="container d-lg-flex justify-content-between align-items-center">
            <h1 class="mb-2 mb-lg-0">{{ app()->getLocale() == 'id' ? 'Detail Proyek' : 'Project Details' }}</h1>
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="{{ route('home', ['locale' => app()->getLocale() ]) }}">{{ app()->getLocale() == 'id' ? 'Beranda' : 'Home' }}</a></li>
                    <li><a href="{{ route('project', ['locale' => app()->getLocale() ]) }}">{{ app()->getLocale() == 'id' ? 'Proyek' : 'Project' }}</a></li>
                    <li class="current">{{ app()->getLocale() == 'id' ? 'Detail Proyek' : 'Project Details' }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <section id="portfolio-details" class="portfolio-details section">
        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="row gy-4">
                
                {{-- Bagian Slider Gambar (Galeri) --}}
                <div class="col-lg-8">
                    <div class="portfolio-details-slider swiper init-swiper">
                        <script type="application/json" class="swiper-config">
                            {
                                "loop": {{ ($portofolio->images ? $portofolio->images->count(): 0) + 1 > 3 ? 'true' : 'false' }},
                                "speed": 500,
                                "autoplay": {
                                    "delay": 5000
                                },
                                "slidesPerView": "auto",
                                "pagination": {
                                    "el": ".swiper-pagination",
                                    "type": "bullets",
                                    "clickable": true
                                }
                            }
                        </script>
                        
                        <div class="swiper-wrapper align-items-center">
                            {{-- Menampilkan Gambar Utama Project --}}
                            <div class="swiper-slide">
                                <a href="{{ \Illuminate\Support\Facades\Storage::disk('cloudinary')->url($portofolio->image_project) }}" class="glightbox" data-gallery="portfolio-gallery">
                                    <img src="{{ \Illuminate\Support\Facades\Storage::disk('cloudinary')->url($portofolio->image_project) }}" crossorigin="anonymous" alt="{{ $portofolio->{'name_project_' . app()->getLocale()} ?? '' }}" class="img-fluid" fetchpriority="high" decoding="async">
                                </a>
                            </div>

                            {{-- Menampilkan Gambar Tambahan dari Tabel portofolio_images --}}
                            @foreach($portofolio->images as $galeri)
                                <div class="swiper-slide">
                                    <a href="{{ \Illuminate\Support\Facades\Storage::disk('cloudinary')->url($galeri->image_path) }}" class="glightbox" data-gallery="portfolio-gallery">
                                        <img src="{{ \Illuminate\Support\Facades\Storage::disk('cloudinary')->url($galeri->image_path) }}" crossorigin="anonymous" class="img-fluid" loading="lazy" decoding="async">
                                    </a>
                                </div>
                            @endforeach
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>

                {{-- Bagian Informasi Proyek (Meta Content) --}}
                <div class="col-lg-4">
                    <div class="portfolio-info" data-aos="fade-left" data-aos-delay="200">
                        <h3>{{ app()->getLocale() == 'id' ? 'Informasi Proyek' : 'Project Information' }}</h3>
                        <ul>
                            <li><strong>{{ app()->getLocale() == 'id' ? 'Kategori' : 'Category' }}</strong>: 
                                {{ $portofolio->category->{'name_category_' . app()->getLocale()} ?? '' }}
                            </li>
                            <li><strong>{{ app()->getLocale() == 'id' ? 'Nama Proyek' : 'Project Name' }}</strong>: 
                                {{ $portofolio->{'name_project_' . app()->getLocale()} ?? '' }}
                            </li>
                            <li><strong>{{ app()->getLocale() == 'id' ? 'Tanggal Proyek' : 'Project Date' }}</strong>: 
                                {{ \Carbon\Carbon::parse($portofolio->date_project)->locale(app()->getLocale())->translatedFormat('d F Y') }}
                            </li>
                            <li><strong>{{ app()->getLocale() == 'id' ? 'URL Proyek' : 'Project URL' }}</strong>: 
                                @if($portofolio->link_project)
                                    <a href="{{ $portofolio->link_project ?? '' }}" target="_blank" class="btn-link text-primary">
                                        <i class="fa-solid fa-link me-2"> {{ app()->getLocale() == 'id' ? 'Kunjungi' : 'Preview' }}</i> 
                                    </a>
                                @else
                                    <span><code>{{ app()->getLocale() == 'id' ? 'Tidak Tersedia' : 'Not Available' }}</code></span>
                                @endif
                            </li>
                        </ul>
                    </div>
                </div>

                {{-- Bagian Deskripsi & Fitur --}}
                <div class="col-lg-12">
                    <div class="portfolio-description" data-aos="fade-up" data-aos-delay="300">
                        <h2>{{ app()->getLocale() == 'id' ? 'Ringkasan Proyek' : 'Project Overview' }}</h2>
                        @forelse($portofolio->descriptions->where('type', 'overview') as $desc)
                            {{-- <p>{!! nl2br(e($desc->{'content_' . app()->getLocale()})) !!}</p> --}}
                            {!! $desc->{'content_' . app()->getLocale()} !!}
                        @empty
                            @if(app()->getLocale() == 'id')
                                <p>Deskripsi proyek <code>{{ $portofolio->name_project_id }}</code> belum diunggah.</p>
                            @else
                                <p><code>{{ $portofolio->name_project_en }}</code> project description not yet uploaded.</p>
                            @endif
                        @endforelse

                        {{-- Menampilkan Fitur (Type: feature) --}}
                        <div class="features mt-4">
                            <h3>{{ app()->getLocale() == 'id' ? 'Fitur Utama' : 'Main Features' }}</h3>
                            <div class="row gy-3">
                                @forelse($portofolio->descriptions->where('type', 'feature') as $feature)
                                    <div class="col-md-6">
                                        <div class="feature-item" data-aos="fade-up" data-aos-delay="400">
                                            <div class="d-flex align-items-center" style="margin-top: -5px;">
                                                <i class="{{ $feature->icon ?? '' }} me-3"></i>
                                                <h4>{{ $feature->{'title_' . app()->getLocale()} ?? '' }}</h4>
                                            </div>
                                            {{-- <p>{{ $feature->{'content_' . app()->getLocale()} ?? '' }}</p> --}}
                                            {!! $feature->{'content_' . app()->getLocale()} !!}
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-md-6 text-center">
                                        <div class="feature-item" data-aos="fade-up" data-aos-delay="400">
                                            <i class="bi bi-file-earmark-x"></i>
                                            @if(app()->getLocale() == 'id')
                                                <p>Fitur proyek <code>{{ $portofolio->name_project_id ?? '' }}</code> belum diunggah.</p>
                                            @else
                                                <p><code>{{ $portofolio->name_project_en ?? '' }}</code> project feature not yet uploaded.</p>
                                            @endif
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>