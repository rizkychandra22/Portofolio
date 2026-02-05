<div>
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
                        <i class="fas fa-spinner fa-spin"></i> {{ app()->getLocale() == 'id' ? 'Mengirim...' : 'Sending...' }}
                    </span>
                </button>
            </div>
        </div>
    </form>
</div>
