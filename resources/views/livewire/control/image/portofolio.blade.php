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
                <div class="card shadow-sm border-{{ $isEdit ? 'warning' : 'primary' }}">
                    <form wire:submit.prevent="savePortofolio">
                        <div class="card-header">
                            <h4>{{ $page }}</h4>
                            <div class="card-header-action">
                                <div class="btn-group shadow-sm">
                                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modalCategory">
                                        <i class="fas fa-tags mr-1"></i> Kelola Kategori
                                    </button>
                                    @if($isEdit)
                                        <button type="button" wire:click="resetProjectForm" class="btn btn-danger">
                                            <i class="fas fa-times"></i> Batal
                                        </button>
                                    @endif
                                    <button type="submit" class="btn btn-primary" wire:loading.attr="disabled" wire:target="savePortofolio, image_project">
                                        <span wire:loading.remove wire:target="savePortofolio">
                                            <i class="fas fa-save mr-1"></i> 
                                            {{ $isEdit ? 'Update Project' : 'Simpan Project' }}
                                        </span>
                                        <span wire:loading wire:target="savePortofolio"><i class="fas fa-spinner fa-spin"></i> Memproses...</span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                {{-- INPUT DATA --}}
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Nama Project</label>
                                        {{-- SINKRON: Menggunakan name_project_id --}}
                                        <input type="text" wire:model="name_project_id" class="form-control @error('name_project_id') is-invalid @enderror" placeholder="Masukkan nama project...">
                                        @error('name_project_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Tanggal Project</label>
                                                <input type="date" wire:model="date_project" class="form-control @error('date_project') is-invalid @enderror">
                                                @error('date_project') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Kategori Project</label>
                                                <select wire:model="category_project_id" class="form-control @error('category_project_id') is-invalid @enderror">
                                                    <option value="">-- Pilih Kategori --</option>
                                                    @foreach($categories as $category)
                                                        <option value="{{ $category->id }}">{{ $category->name_category_id }}</option>
                                                    @endforeach
                                                </select>
                                                @error('category_project_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="font-weight-bold">Link Project (URL)</label>
                                        <input type="url" wire:model="link_project" class="form-control @error('link_project') is-invalid @enderror" placeholder="https://github.com/rizky/project-anda">
                                        @error('link_project') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                {{-- PRATINJAU GAMBAR --}}
                                <div class="col-md-5 text-center border-left">
                                    <label class="font-weight-bold">Gambar Project</label>
                                    <div class="d-flex justify-content-center mb-3 mt-2">
                                        @if ($image_project)
                                            <div class="position-relative">
                                                <img src="{{ $image_project->temporaryUrl() }}" class="img-thumbnail shadow border-primary" style="height: 180px; width: 320px; object-fit: cover;">
                                                <span class="badge badge-primary position-absolute" style="top: 10px; right: 10px;">Baru (Lokal)</span>
                                            </div>
                                        @elseif ($isEdit && $old_image_url)
                                            <div class="position-relative">
                                                <img src="{{ $old_image_url }}" class="img-thumbnail shadow border-warning" style="height: 180px; width: 320px; object-fit: cover;" crossorigin="anonymous">
                                                <span class="badge badge-warning position-absolute" style="top: 10px; right: 10px;">Lama (Server)</span>
                                            </div>
                                        @else
                                            <div class="bg-light text-muted d-flex align-items-center justify-content-center rounded img-thumbnail shadow-sm" style="height: 180px; width: 320px;">
                                                <div class="text-center">
                                                    <i class="fas fa-images fa-3x mb-2 text-secondary"></i>
                                                    <p class="mb-0 small">Belum Ada Gambar</p>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <div class="px-3">
                                        <div class="custom-file text-left">
                                            <input type="file" wire:model="image_project" class="custom-file-input" id="uploadProject" accept="image/*">
                                            <label class="custom-file-label" for="uploadProject">Pilih gambar project...</label>
                                        </div>
                                        <div wire:loading wire:target="image_project" class="text-primary small mt-2 text-left">
                                            <i class="fas fa-spinner fa-spin mr-1"></i> Memproses pratinjau...
                                        </div>
                                        @error('image_project') <span class="text-danger small">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">

                            {{-- TABEL DATA --}}
                            <div class="table-responsive">
                                <table class="table table-hover table-md">
                                    <thead class="bg-light">
                                        <tr>
                                            <th width="5%">#</th>
                                            <th>Gambar</th>
                                            <th>Detail Project</th>
                                            <th>Kategori</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($portofolios as $index => $item)
                                            <tr class="{{ $portofolio_id == $item->id ? 'table-warning' : '' }}">
                                                <td>{{ $index + 1 }}</td>
                                                <td>
                                                    <img src="{{ $item->image_project }}" class="rounded shadow-sm" style="width: 80px; height: 50px; object-fit: cover;" crossorigin="anonymous">
                                                </td>
                                                <td>
                                                    {{-- SINKRON: name_project_id --}}
                                                    <span class="font-weight-bold d-block">{{ $item->name_project_id }}</span>
                                                    <small class="text-muted"><i class="fas fa-calendar-alt mr-1"></i> {{ \Carbon\Carbon::parse($item->date_project)->format('d M Y') }}</small>
                                                </td>
                                                <td><span class="badge badge-info">{{ $item->category->name_category_id }}</span></td>
                                                <td class="text-center">
                                                    <button type="button" wire:click="editPortofolio({{ $item->id }})" class="btn btn-outline-warning btn-sm mr-1" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button type="button" wire:click="deletePortofolio({{ $item->id }})" class="btn btn-outline-danger btn-sm" onclick="confirm('Yakin ingin menghapus project ini?') || event.stopImmediatePropagation()" title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center text-muted py-4">Belum ada data project portofolio.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    {{-- MODAL CATEGORY --}}
    <div wire:ignore.self class="modal fade" id="modalCategory" tabindex="-1" role="dialog" aria-labelledby="categoryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg overflow-auto" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title text-white" id="categoryModalLabel"><i class="fas fa-tags mr-2"></i> Kelola Kategori Project</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" wire:click="resetCategoryForm">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @include('partials.modal-alert-category')
                    
                    <div class="row">
                        {{-- Kolom Kiri: Form Input/Edit Kategori --}}
                        <div class="col-md-5 border-right">
                            <h6 class="font-weight-bold">{{ $isEditCategory ? 'Edit Kategori' : 'Tambah Kategori Baru' }}</h6>
                            <hr>
                            <form wire:submit.prevent="storeCategory">
                                <div class="form-group">
                                    <label>Nama Kategori (ID)</label>
                                    {{-- SINKRON: name_category_id --}}
                                    <input type="text" wire:model="name_category_id" class="form-control" placeholder="Contoh: Web App">
                                    @error('name_category_id') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                                <div class="form-group">
                                    <label>Filter Class Project</label>
                                    <input type="text" wire:model="data_filter_category" class="form-control" placeholder="Contoh: filter-web">
                                    <small class="text-muted">Gunakan huruf kecil dan tanda hubung (-)</small>
                                    @error('data_filter_category') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                                <div class="mt-1 mb-3 d-flex justify-content-end">
                                    @if($isEditCategory)
                                        <button type="button" wire:click="resetCategoryForm" class="btn btn-light shadow-sm mr-2">
                                            Batal
                                        </button>
                                    @endif
                                    <button type="submit" class="btn btn-info shadow-sm" wire:loading.attr="disabled">
                                        <i class="fas fa-save mr-1"></i> {{ $isEditCategory ? 'Update' : 'Simpan' }}
                                    </button>
                                </div>
                            </form>
                        </div>

                        {{-- Kolom Kanan: List Kategori --}}
                        <div class="col-md-7">
                            <h6 class="font-weight-bold text-center">Daftar Kategori Tersedia</h6>
                            <hr>
                            <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                                <table class="table table-sm table-hover">
                                    <thead class="bg-light sticky-top">
                                        <tr>
                                            <th>Nama</th>
                                            <th>Filter</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($categories as $cat)
                                        <tr>
                                            <td>{{ $cat->name_category_id }}</td>
                                            <td><code>.{{ $cat->data_filter_category }}</code></td>
                                            <td class="text-center">
                                                <button wire:click="editCategory({{ $cat->id }})" class="btn btn-outline-warning btn-sm mr-1"><i class="fas fa-edit"></i></button>
                                                <button wire:click="deleteCategory({{ $cat->id }})" class="btn btn-outline-danger btn-sm" onclick="confirm('Hapus kategori ini juga akan menghapus project di dalamnya. Yakin?') || event.stopImmediatePropagation()"><i class="fas fa-trash"></i></button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer text-dark">
                    <button type="button" class="btn btn-light shadow-sm" data-dismiss="modal" wire:click="resetCategoryForm"><i class="fas fa-times mr-1"></i> Tutup</button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        // Update label nama file saat dipilih
        $(document).on('change', '.custom-file-input', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });

        // Reset nama label setelah sukses simpan
        document.addEventListener('livewire:initialized', () => {
            @this.on('success', () => {
                $('.custom-file-label').removeClass("selected").html("Pilih gambar project...");
            });
        });
    </script>
@endpush