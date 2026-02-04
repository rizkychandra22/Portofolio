<div>
    <form wire:submit.prevent="send" class="php-email-form">
        <div class="row gy-4">
            <div class="col-md-6">
                <input type="text" wire:model.live="name" class="form-control" placeholder="{{ app()->getLocale() == 'id' ? 'Nama Anda' : 'Your Name' }}">
                @error('name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-md-6">
                <input type="email" class="form-control" wire:model.live="email" placeholder="{{ app()->getLocale() == 'id' ? 'Email Anda' : 'Your Email' }}">
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-12">
                <input type="text" class="form-control" wire:model.live="subject" placeholder="{{ app()->getLocale() == 'id' ? 'Judul Pesan' : 'Message Title' }}">
                @error('subject')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-12">
                <textarea class="form-control" wire:model.live="message" rows="6" placeholder="{{ app()->getLocale() == 'id' ? 'Pesan Anda' : 'Your Message' }}"></textarea>
                @error('message')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-12">
                <button
                    type="submit"
                    class="btn w-100 d-block text-center py-3"
                    style="font-weight:600"
                    wire:loading.attr="disabled"
                    wire:target="send">
                    <span wire:loading.remove wire:target="send">
                        {{ app()->getLocale() == 'id' ? 'Kirim Pesan' : 'Send Message' }}
                    </span>
                    <span wire:loading wire:target="send">
                        {{ app()->getLocale() == 'id' ? 'Mengirim...' : 'Sending...' }}
                    </span>
                </button>
                @if($error)
                    <div class="error-message mt-3">
                        {{ $errorMessage }}
                    </div>
                @endif
                @if($sent)
                    <div class="sent-message mt-3">
                        {{ app()->getLocale() == 'id'
                            ? 'Pesan Anda telah terkirim. Terima kasih!'
                            : 'Your message has been sent. Thank you!'
                        }}
                    </div>
                @endif
            </div>
        </div>
    </form>
</div>
