<x-filament-panels::page>
    <form wire:submit.prevent="save" class="space-y-8"> 
        
        <div class="fi-form-content">
            {{ $this->form }}
        </div>
        
        <div class="border-t border-gray-100 dark:border-gray-800 flex justify-start">
            <x-filament::button type="submit" size="lg" style="margin-top: 15px">
                Simpan Foto Profile
            </x-filament::button>
        </div>
        
    </form>
</x-filament-panels::page>