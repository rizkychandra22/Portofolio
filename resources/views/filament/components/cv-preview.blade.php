@php
    use Illuminate\Support\Facades\Storage;
    $previewImage = $imageUrl ?? str_replace('.pdf', '.jpg', $url);
@endphp

<style>
    [data-field-wrapper] :where(.fi-fo-view) {
        width: 100% !important;
    }
    .cv-preview-wrapper {
        width: 100%;
    }

    /* Sembunyikan iframe di layar kecil (HP) karena biasanya tidak jalan */
    @media (max-width: 768px) {
        .iframe-container {
            display: none !important;
        }
        .mobile-preview-container {
            display: block !important;
        }
    }

    /* Sembunyikan preview gambar di layar besar (Desktop) */
    @media (min-width: 769px) {
        .mobile-preview-container {
            display: none !important;
        }
    }
</style>

<div class="cv-preview-wrapper" style="width: 100%;">
    <label class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 block">
        File CV Aktif Saat Ini:
    </label>
    
    @if ($path && $url)
        <div class="p-4 bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm space-y-3" style="width: 100%;">
            
            {{-- DESKTOP VIEW: Iframe Mewah --}}
            <div class="iframe-container rounded-md overflow-hidden border border-gray-200 dark:border-gray-700 bg-white" style="width: 100%; height: clamp(720px, 82vh, 1400px);">
                <iframe
                    src="{{ $url }}#toolbar=1&navpanes=0&zoom=page-width"
                    title="Preview CV"
                    style="display: block; border: 0; width: 100%; height: 100%;"
                ></iframe>
            </div>

            {{-- MOBILE VIEW: Gambar Preview (Cloudinary JPG) --}}
            <div class="mobile-preview-container hidden" style="width: 100%;">
                <div class="rounded-lg overflow-hidden border border-gray-300 shadow-lg bg-white mb-4">
                    <img 
                        src="{{ $previewImage }}" 
                        alt="CV Preview Mobile" 
                        class="w-full h-auto"
                        onerror="this.onerror=null;this.src='https://placehold.co/400x600?text=PDF+Preview+Ready';"
                    >
                </div>
                <x-filament::button 
                    href="{{ $url }}" 
                    tag="a" 
                    target="_blank" 
                    icon="heroicon-m-arrow-top-right-on-square"
                    class="w-full"
                >
                    Buka / Download Full PDF
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