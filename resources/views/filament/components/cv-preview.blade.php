@php
    use Illuminate\Support\Facades\Storage;
    $previewImage = $imageUrl ?? ($url ? str_replace('.pdf', '.jpg', $url) : null);
@endphp

<style>
    [data-field-wrapper] :where(.fi-fo-view) { width: 100% !important; }
    
    /* Desktop: Sembunyikan gambar, tampilkan iframe */
    @media (min-width: 1024px) {
        .cv-mobile-preview { display: none !important; }
        .cv-desktop-preview { display: block !important; }
    }

    /* Mobile: Sembunyikan iframe, tampilkan gambar */
    @media (max-width: 1023px) {
        .cv-mobile-preview { display: block !important; }
        .cv-desktop-preview { display: none !important; }
    }
</style>

<div class="cv-preview-wrapper" style="width: 100%;">
    <label class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 block">
        File CV Aktif Saat Ini:
    </label>
    
    @if ($path && $url)
        <div class="p-4 bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm" style="width: 100%;">
            
            {{-- TAMPILAN LAPTOP (Iframe) --}}
            <div class="cv-desktop-preview rounded-md overflow-hidden border border-gray-200 bg-white" style="width: 100%; height: 750px;">
                <iframe
                    src="{{ $url }}#toolbar=1&navpanes=0&zoom=page-width"
                    title="Preview CV"
                    style="display: block; border: 0; width: 100%; height: 100%;"
                ></iframe>
            </div>

            {{-- TAMPILAN HP (Gambar JPG) --}}
            <div class="cv-mobile-preview hidden" style="width: 100%;">
                <div class="rounded-lg overflow-hidden border-2 border-gray-200 shadow-md bg-white mb-4">
                    <img 
                        src="{{ $previewImage }}" 
                        alt="CV Preview Mobile" 
                        class="w-full h-auto"
                        onerror="this.onerror=null;this.src='https://placehold.co/400x600?text=Preview+Tersedia+di+Desktop';"
                    >
                </div>
                <x-filament::button 
                    href="{{ $url }}" 
                    tag="a" 
                    target="_blank" 
                    icon="heroicon-m-arrow-top-right-on-square"
                    class="w-full"
                >
                    Download / Buka PDF
                </x-filament::button>
            </div>

        </div>
    @else
        <div class="flex flex-col items-center justify-center p-6 rounded-lg border border-dashed border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900" style="width: 100%;">
            <x-filament::icon icon="heroicon-o-document-minus" class="w-10 h-10 text-gray-400 mb-2" />
            <span class="text-gray-500 text-sm italic">Belum ada file CV yang diunggah</span>
        </div>
    @endif
</div>