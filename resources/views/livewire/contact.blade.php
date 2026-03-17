<div>
    <section id="contact" class="contact section">
        <div class="container section-title" data-aos="fade-up" wire:ignore>
            <h2>{{ app()->getLocale() == 'id' ? 'Kontak' : 'Contact' }}</h2>
            <p>{{ app()->getLocale() == 'id' 
                ? 'Silakan hubungi saya untuk diskusi peluang kerja sama, pertanyaan teknis, atau sekadar berbagi ide mengenai pengembangan web.'
                : 'Please contact me to discuss collaboration opportunities, technical questions, or simply share ideas about web development.' 
                }}
            </p>
        </div>

        <div class="container">
            <div class="row g-4 g-lg-5">
                <div class="col-lg-5">
                    <div class="info-box" data-aos="fade-right" wire:ignore>
                        <div class="d-flex align-items-center mb-3">
                            <h3 class="mb-0">{{ app()->getLocale() == 'id' ? 'Informasi Kontak' : 'Contact Information' }}</h3>
                        </div>
                        <p>{{ app()->getLocale() == 'id'
                            ? 'Saya terbuka untuk peluang kerja sebagai Web Developer secara purnawaktu maupun proyek freelance.'
                            : 'I am open to job opportunities as a Web Developer either full-time or freelance projects.'
                            }}
                         </p>
                        <div class="info-item">
                            <div class="icon-box"><i class="fas fa-envelope"></i></div>
                            <div class="content">
                                <h4>Email</h4>
                                <p>{{ $sosialMedia->email ?? '' }}</p>
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="icon-box"><i class="fab fa-linkedin"></i></div>
                            <div class="content">
                                <h4>LinkedIn</h4>
                                <p>{{ $sosialMedia->linkedin ?? '' }}</p>
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="icon-box"><i class="fas fa-map-marker-alt"></i></div>
                            <div class="content">
                                <h4>Lokasi</h4>
                                <p>{{ $sosialMedia->{'address_' . app()->getLocale()} ?? '' }}</p>
                                <p>Indonesia <img src="{{ asset('template/assets/img/flag-id.png') ?? '' }}" alt="Indonesia"></p>
                            </div>
                        </div>

                        <iframe style="border-radius: 20px"
                            width="100%" 
                            height="200" 
                            loading="lazy" 
                            allowfullscreen 
                            src="https://www.google.com/maps?q={{ urlencode($sosialMedia->address_id ?? '') }}&output=embed">
                        </iframe>
                    </div>
                </div>

                {{-- SISI KANAN: FORM KIRIM PESAN --}}
                <div class="col-lg-7">
                    <div class="contact-form" data-aos="fade-left" wire:ignore.self>
                        <h3>{{ app()->getLocale() == 'id' ? 'Kirim Pesan' : 'Send Message' }}</h3>
                        <p>
                            {{ app()->getLocale() == 'id' 
                                ? 'Gunakan formulir di bawah ini untuk mengirimkan pesan langsung ke email saya.'
                                : 'Use the form below to send a message directly to my email.' 
                            }}
                        </p>

                        @livewire('form.contact')
                        
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.hook('commit', ({ component, succeed }) => {
            succeed(() => {
                setTimeout(() => {
                    if (typeof AOS !== 'undefined') {
                        AOS.refresh();
                    }
                }, 1);
            })
        })
    });
</script>
