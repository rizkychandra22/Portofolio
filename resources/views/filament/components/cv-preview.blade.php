@php
    use Illuminate\Support\Facades\Storage;
@endphp

<style>
    /* Force the ViewField wrapper to take full width */
    [data-field-wrapper] :where(.fi-fo-view) {
        width: 100% !important;
    }
    .cv-preview-wrapper {
        width: 100%;
    }
</style>

<div class="cv-preview-wrapper" style="width: 100%;">
    <label class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 block">
        File CV Aktif Saat Ini:
    </label>
    
    @if ($path && $url)
        <div class="p-4 bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm space-y-3" style="width: 100%;">
            <div class="rounded-md overflow-hidden border border-gray-200 dark:border-gray-700 bg-white" style="width: 100%; height: clamp(720px, 82vh, 1400px);">
                <iframe
                    src="{{ $url }}#toolbar=1&navpanes=0&zoom=page-width"
                    title="Preview CV"
                    style="display: block; border: 0; width: 100%; height: 100%;"
                ></iframe>
            </div>
        </div>
    @else
        <div class="flex flex-col items-center justify-center p-6 rounded-lg border border-dashed border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900" style="width: 100%;">
            <x-filament::icon icon="heroicon-o-document-minus" class="w-10 h-10 text-gray-400 mb-2" />
            <span class="text-gray-500 text-sm italic">Belum ada file CV yang diunggah</span>
        </div>
    @endif
</div>
