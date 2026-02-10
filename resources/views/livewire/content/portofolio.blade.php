<div>
    <section id="portfolio" class="portfolio section" style="min-height: 70vh;">
        <div class="container section-title" data-aos="fade-up">
            <h2>Portofolio</h2>
            <p>
                {{ app()->getLocale() == 'id' 
                    ? 'Kumpulan proyek pengembangan web yang berfokus pada efisiensi sistem, skalabilitas kode, dan solusi digital yang tepat guna.' 
                    : 'A collection of web development projects focused on system efficiency, code scalability, and effective digital solutions.' 
                }}
            </p>
        </div>
        
        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="isotope-layout" data-default-filter="*" data-layout="masonry" data-sort="original-order">
                <div class="row">
                    <div class="col-lg-3 filter-sidebar">
                        <div class="filters-wrapper" data-aos="fade-right" data-aos-delay="150">
                            <ul class="portfolio-filters isotope-filters">
                                <li data-filter="*" class="filter-active">
                                    {{ app()->getLocale() == 'id' ? 'Semua Proyek' : 'All Projects' }}
                                </li>
                                @foreach ($categories as $item)
                                    <li data-filter=".{{ $item->data_filter_category ?? '' }}">
                                        {{ $item->{'name_category_' . app()->getLocale()} ?? '' }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-9">
                        <div class="row gy-4 portfolio-container isotope-container" data-aos="fade-up" data-aos-delay="200">
                            @forelse ($portofolio as $item)    
                                <div class="col-lg-6 col-md-6 portfolio-item isotope-item {{ $item->category->data_filter_category ?? '' }}">
                                    <div class="portfolio-wrap">
                                        <img src="{{ Storage::url($item->image_project) ?? '' }}" crossorigin="anonymous" fetchpriority="high" class="img-fluid" alt="{{ $item->{'name_project_' . app()->getLocale()} ?? '' }}">
                                        <div class="portfolio-info">
                                            <div class="content">
                                                <span class="category">
                                                    {{ $item->category->{'name_category_' . app()->getLocale()} ?? '' }}
                                                </span>
                                                <h4>{{ $item->{'name_project_' . app()->getLocale()} ?? '' }}</h4>
                                                <div class="portfolio-links">
                                                    <a href="{{ Storage::url($item->image_project) ?? '' }}" crossorigin="anonymous" class="glightbox" 
                                                       title="{{ $item->category->{'name_category_' . app()->getLocale()} ?? '' }} | {{ $item->{'name_project_' . app()->getLocale()} ?? '' }}">
                                                       <i class="bi bi-plus-lg"></i>
                                                    </a>
                                                    <a href="{{ route('portofolio-detail', ['locale' => app()->getLocale(), 'id' => $item->id]) }}" title="Detail Proyek">
                                                        <i class="bi bi-arrow-right"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-lg-6 col-md-6 portfolio-item">
                                    <div class="portfolio-wrap" style="border: 2px dashed #444; background: rgba(255, 255, 255, 0.05); min-height: 200px; display: flex; align-items: center; justify-content: center; border-radius: 10px;">
                                        <div class="text-center p-4">
                                            <div class="mb-3">
                                                <i class="bi bi-file-earmark-x" style="font-size: 3rem; color: #888;"></i>
                                            </div>
                                            <h5 class="text-light">{{ app()->getLocale() == 'id' ? 'Belum Ada Proyek' : 'No Projects Yet' }}</h5>
                                            <p class="small text-white">
                                                {{ app()->getLocale() == 'id' 
                                                    ? 'Data proyek sedang dalam tahap persiapan atau belum diunggah.' 
                                                    : 'Project data is in preparation stage or has not been uploaded yet.' 
                                                }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
