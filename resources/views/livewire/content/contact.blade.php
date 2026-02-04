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
                            <div class="icon-box"><i class="bi bi-envelope"></i></div>
                            <div class="content">
                                <h4>Email</h4>
                                <p>{{ $sosialMedia->email ?? '' }}</p>
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="icon-box"><i class="bi bi-linkedin"></i></div>
                            <div class="content">
                                <h4>LinkedIn</h4>
                                <p>{{ $sosialMedia->linkedin ?? '' }}</p>
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="icon-box"><i class="bi bi-geo-alt"></i></div>
                            <div class="content">
                                <h4>Lokasi</h4>
                                <p>{{ $sosialMedia->{'address_' . app()->getLocale()} ?? '' }}</p>
                                <p>Indonesia <img src="{{ asset('snapfolio/assets/img/flag-id.png') ?? '' }}" alt="Indonesia"></p>
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

                        <form wire:submit.prevent="sendMessage" class="php-email-form">
                            <div class="row gy-4">
                                <div class="col-12">
                                    @if($sent)
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            {{ app()->getLocale() == 'id' ? 'Pesan Anda telah terkirim. Terima kasih!' : 'Your message has been sent. Thank you!' }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    @endif

                                    @if($error)
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            {{ $errorMessage }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    @endif
                                </div>

                                <div class="col-md-6" wire:key="name-field">
                                    <input type="text" wire:model.blur="name" class="form-control @error('name') is-invalid @enderror" placeholder="{{ app()->getLocale() == 'id' ? 'Nama Anda' : 'Your Name' }}">
                                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6" wire:key="email-field">
                                    <input type="email" wire:model.blur="email" class="form-control @error('email') is-invalid @enderror" placeholder="{{ app()->getLocale() == 'id' ? 'Email Anda' : 'Your Email' }}">
                                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-12" wire:key="subject-field">
                                    <input type="text" wire:model.blur="subject" class="form-control @error('subject') is-invalid @enderror" placeholder="{{ app()->getLocale() == 'id' ? 'Judul Pesan' : 'Message Title' }}">
                                    @error('subject') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-12" wire:key="message-field">
                                    <textarea wire:model.blur="message" class="form-control @error('message') is-invalid @enderror" rows="6" placeholder="{{ app()->getLocale() == 'id' ? 'Pesan Anda' : 'Your Message' }}"></textarea>
                                    @error('message') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-12">
                                    <button type="submit" wire:loading.attr="disabled" wire:target="sendMessage" class="btn w-100 d-block text-center py-3">
                                        <span wire:loading.remove wire:target="sendMessage">
                                            {{ app()->getLocale() == 'id' ? 'Kirim Pesan' : 'Send Message' }}
                                        </span>
                                        <span wire:loading wire:target="sendMessage">
                                            <i class="fas fa-spinner fa-spin me-2"></i> {{ app()->getLocale() == 'id' ? 'Mengirim...' : 'Sending...' }}
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    document.addEventListener('livewire:load', function () {
        Livewire.hook('message.processed', (message, component) => {
            AOS.refresh();
        });
    });
</script>