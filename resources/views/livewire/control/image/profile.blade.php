<div>
    <section class="section">
        <div class="section-header">
            <h1>{{ $title }}</h1>
        </div>

        <div class="row">
            {{-- Alert Message --}}
            <div class="col-12">
                @include('partials.alert-global')
            </div>

            <div class="col-lg-12">
                <div class="card shadow-sm">
                    <form wire:submit.prevent="updateImages">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h4 class="mb-0">{{ $page }}</h4>

                            <button type="submit"
                                class="btn btn-primary btn-icon icon-left"
                                wire:loading.attr="disabled"
                                wire:target="updateImages,imageHome,imageAbout,imageResume">
                                
                                <span wire:loading.remove wire:target="updateImages">
                                    <i class="fas fa-save"></i> Simpan Content Foto
                                </span>

                                <span wire:loading wire:target="updateImages">
                                    <i class="fas fa-spinner fa-spin"></i> Memproses...
                                </span>
                            </button>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                @php
                                    $items = [
                                        ['label' => 'Foto Utama Home', 'model' => 'imageHome', 'existing' => $existingHome],
                                        ['label' => 'Foto Utama About', 'model' => 'imageAbout', 'existing' => $existingAbout],
                                        ['label' => 'Foto Utama Resume', 'model' => 'imageResume', 'existing' => $existingResume],
                                    ];
                                @endphp

                                @foreach ($items as $item)
                                    <div class="col-md-4 mb-4 text-center {{ !$loop->last ? 'border-right' : '' }}">
                                        <label class="font-weight-bold d-block mb-3">{{ $item['label'] }}</label>

                                        {{-- PREVIEW LOGIC --}}
                                        <div class="d-flex justify-content-center mb-3">
                                            {{-- Perbaikan: Menggunakan variabel dinamis untuk pratinjau --}}
                                            @if ($this->{$item['model']})
                                                <img src="{{ $this->{$item['model']}->temporaryUrl() }}"
                                                     class="img-thumbnail shadow-sm"
                                                     style="width:300px;height:300px;object-fit:cover"
                                                     crossorigin="anonymous">
                                            @elseif ($item['existing'])
                                                <img src="{{ $item['existing'] }}"
                                                     class="img-thumbnail shadow-sm"
                                                     style="width:300px;height:300px;object-fit:cover"
                                                     crossorigin="anonymous">
                                            @else
                                                <div class="img-thumbnail d-flex align-items-center justify-content-center text-muted bg-light"
                                                     style="width:300px;height:300px">
                                                    <div>
                                                        <i class="fas fa-image fa-3x mb-2"></i>
                                                        <div>No Image</div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>

                                        {{-- INPUT --}}
                                        <div class="px-3">
                                            <div class="custom-file text-left">
                                                <input type="file" 
                                                       class="custom-file-input" 
                                                       id="input-{{ $item['model'] }}"
                                                       wire:model="{{ $item['model'] }}"
                                                       accept="image/*">
                                                <label class="custom-file-label" for="input-{{ $item['model'] }}">Pilih gambar...</label>
                                            </div>

                                            @error($item['model'])
                                                <small class="text-danger d-block mt-2 text-left">{{ $message }}</small>
                                            @enderror

                                            {{-- LOADING INDICATOR PER ITEM --}}
                                            <div wire:loading wire:target="{{ $item['model'] }}" class="mt-2 text-left">
                                                <i class="fas fa-spinner fa-spin text-primary"></i>
                                                <small class="text-muted">Memproses pratinjau...</small>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="card-footer bg-whitesmoke text-center">
                            <small class="text-muted">
                                <i class="fas fa-info-circle mr-1 texct-danger"></i> Format: <strong>JPG, PNG, WEBP</strong> — Maksimal <strong>2MB</strong>
                            </small>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

@push('scripts')
    <script>
        // Memastikan label custom-file-input terupdate namanya saat dipilih
        $(document).on('change', '.custom-file-input', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });

        // Reset nama label setelah Livewire selesai upload (kembali ke "Pilih gambar...")
        document.addEventListener('livewire:initialized', () => {
            @this.on('success', () => {
                $('.custom-file-label').removeClass("selected").html("Pilih gambar...");
            });
        });
    </script>
@endpush