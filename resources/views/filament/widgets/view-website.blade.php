<x-filament-widgets::widget>
    <x-filament::card>
        <div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
            <a
                href="{{ $this->getWebsiteUrl() }}"
                target="_blank"
                rel="noopener noreferrer"
                class="flex items-center gap-x-3 hover:opacity-90">
                <h3 class="text-lg font-medium">Web Portofolio</h3>
            </a>

            <div>
                <x-filament::link 
                    href="{{ $this->getWebsiteUrl() }}" 
                    target="_blank" 
                    icon="heroicon-m-eye"
                    color="primary">
                    Lihat Website
                </x-filament::link>
            </div>
        </div>
    </x-filament::card>
</x-filament-widgets::widget>