@php
    use Illuminate\Support\Facades\Storage;
@endphp

<div class="flex justify-center mb-2">
    @if ($path)
        <div class="w-full aspect-square overflow-hidden rounded-lg border border-gray-700 shadow-sm bg-gray-800">
            <img
                src="{{ Storage::url($path) }}"
                class="w-full h-full object-cover object-center"
                alt="Preview Image"
            >
        </div>
    @else
        <div class="w-full aspect-square flex flex-col items-center justify-center rounded-lg border border-dashed border-gray-600 bg-gray-800">
            <x-filament::icon icon="heroicon-o-photo" class="w-8 h-8 text-gray-500 mb-2" />
            <span class="text-gray-500 text-xs italic">No Image</span>
        </div>
    @endif
</div>
