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
                    <div class="card-header bg-white">
                        <h4><i class="fas fa-list mr-2"></i> {{ $page }}</h4>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-hover table-md">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Project</th>
                                    <th>Kategori</th>
                                    <th>Tanggal</th>
                                    <th class="text-center">Konten</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($portofolios as $i => $item)
                                <tr>
                                    <td>{{ $i+1 }}</td>
                                    <td><strong>{{ $item->name_project_id }}</strong></td>
                                    <td>
                                        <span class="badge badge-info">
                                            {{ $item->category->name_category_id }}
                                        </span>
                                    </td>
                                    <td><strong>{{ $item->date_project }}</strong></td>
                                    <td class="text-center">
                                        <span class="badge badge-success mr-1">
                                            <i class="fas fa-images"></i> {{ $item->images->count() }}
                                        </span>
                                        <span class="badge badge-warning">
                                            <i class="fas fa-star"></i>
                                            {{ $item->descriptions->where('type','feature')->count() }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <button
                                            wire:click="loadDetail({{ $item->id }})"
                                            data-toggle="modal"
                                            data-target="#modalDetailControl"
                                            class="btn btn-primary btn-sm px-3">
                                            <i class="fas fa-cog mr-1"></i> Kelola Detail
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- MODAL DETAIL CONTROL --}}
    <div wire:ignore.self
         class="modal fade"
         id="modalDetailControl"
         tabindex="-1"
         role="dialog"
         aria-hidden="true">

        <div class="modal-dialog modal-lg overflow-auto" role="document">
            <div class="modal-content">

                {{-- ================= HEADER ================= --}}
                <div class="modal-header bg-warning">
                    <h5 class="modal-title text-white">
                        <i class="fas fa-edit mr-2"></i>
                        Detail Konten: {{ $selectedProjectName }}
                    </h5>
                    <button type="button"
                            class="close text-white"
                            data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                {{-- ================= BODY ================= --}}
                <div class="modal-body">

                    {{-- ALERT --}}
                    @include('partials.modal-alert-detail')

                    <div class="row">

                        {{-- ================= SIDEBAR ================= --}}
                        <div class="col-md-3 border-right">
                            <div class="nav nav-pills flex-column">
                                <a href="#"
                                   wire:click.prevent="$set('activeTab','tab-meta')"
                                   class="nav-link mb-2 {{ $activeTab=='tab-meta' ? 'active' : '' }}">
                                    <i class="fas fa-file-alt mr-2"></i> Meta & Deskripsi
                                </a>

                                <a href="#"
                                   wire:click.prevent="$set('activeTab','tab-images')"
                                   class="nav-link mb-2 {{ $activeTab=='tab-images' ? 'active' : '' }}">
                                    <i class="fas fa-images mr-2"></i> Galeri Slider
                                </a>

                                <a href="#"
                                   wire:click.prevent="$set('activeTab','tab-features')"
                                   class="nav-link {{ $activeTab=='tab-features' ? 'active' : '' }}">
                                    <i class="fas fa-star mr-2"></i> Fitur Project
                                </a>
                            </div>
                        </div>

                        {{-- ================= CONTENT ================= --}}
                        <div class="col-md-9">

                            {{-- ===== TAB META ===== --}}
                            @if($activeTab == 'tab-meta')
                                <form wire:submit.prevent="saveMetadata">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Tanggal Project</label>
                                                <input type="date"
                                                       wire:model="date_project"
                                                       class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label>Link Project</label>
                                                <input type="url"
                                                       wire:model="link_project"
                                                       class="form-control"
                                                       placeholder="https://...">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Deskripsi</label>
                                        <textarea wire:model="description_overview"
                                                  class="form-control"
                                                  rows="5"
                                                  placeholder="Deskripsi umum project..."></textarea>
                                    </div>

                                    <div class="d-flex justify-content-end">
                                        <button class="btn btn-info shadow-sm">
                                            <i class="fas fa-save mr-1"></i> Simpan
                                        </button>
                                    </div>
                                </form>
                            @endif

                            {{-- ===== TAB GALERI ===== --}}
                            @if($activeTab == 'tab-images')
                                <div class="row">

                                    {{-- INPUT --}}
                                    <div class="col-md-5 border-right">
                                        <h6 class="font-weight-bold">Upload Gambar</h6>
                                        <hr>

                                        <input type="file"
                                               wire:model="new_gallery_images"
                                               multiple
                                               class="form-control form-control-sm">

                                        <div wire:loading
                                             wire:target="new_gallery_images"
                                             class="text-primary small mt-2">
                                            <i class="fas fa-spinner fa-spin"></i> Memproses...
                                        </div>

                                        @if($new_gallery_images)
                                            <div class="row mt-3">
                                                @foreach($new_gallery_images as $img)
                                                    <div class="col-4 mb-2">
                                                        <img src="{{ $img->temporaryUrl() }}"
                                                             class="img-fluid rounded border">
                                                    </div>
                                                @endforeach
                                            </div>

                                            <button wire:click="uploadGallery"
                                                    class="btn btn-success btn-block mt-2 shadow-sm">
                                                <i class="fas fa-upload mr-1"></i> Upload
                                            </button>
                                        @endif
                                    </div>

                                    {{-- DATA --}}
                                    <div class="col-md-7">
                                        <h6 class="font-weight-bold text-center">Galeri Terpasang</h6>
                                        <hr>

                                        @if($currentGallery->count())
                                            <div class="row">
                                                @foreach($currentGallery as $img)
                                                    <div class="col-4 mb-3 position-relative">
                                                        <img src="{{ $img->image_path }}"
                                                             class="img-fluid rounded shadow-sm">
                                                        <button
                                                            wire:click="deleteImage({{ $img->id }})"
                                                            onclick="return confirm('Hapus gambar ini?')"
                                                            class="btn btn-outline-danger btn-sm position-absolute"
                                                            style="top:5px; right:5px;">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <div class="text-muted small text-center py-5">
                                                <i class="fas fa-images fa-2x mb-2"></i>
                                                <p>Belum ada galeri</p>
                                            </div>
                                        @endif
                                    </div>

                                </div>
                            @endif

                            {{-- ===== TAB FITUR ===== --}}
                            @if($activeTab == 'tab-features')
                                <div class="row">

                                    {{-- INPUT --}}
                                    <div class="col-md-5 border-right">
                                        <h6 class="font-weight-bold">
                                            {{ $editingFeatureId ? 'Edit Fitur' : 'Tambah Fitur' }}
                                        </h6>
                                        <hr>

                                        <div class="form-group">
                                            <label>Icon</label>
                                            <input type="text"
                                                   wire:model="f_icon"
                                                   class="form-control form-control-sm"
                                                   placeholder="fas fa-code">
                                        </div>

                                        <div class="form-group">
                                            <label>Nama Fitur</label>
                                            <input type="text"
                                                   wire:model="f_title"
                                                   class="form-control form-control-sm">
                                        </div>

                                        <div class="form-group">
                                            <label>Deskripsi</label>
                                            <textarea wire:model="f_content"
                                                      class="form-control form-control-sm"
                                                      rows="3"></textarea>
                                        </div>

                                        <button
                                            wire:click="{{ $editingFeatureId ? 'updateFeature' : 'addFeature' }}"
                                            class="btn btn-info btn-block shadow-sm">
                                            <i class="fas {{ $editingFeatureId ? 'fa-save' : 'fa-plus' }} mr-1"></i>
                                            {{ $editingFeatureId ? 'Update' : 'Tambah' }}
                                        </button>
                                    </div>

                                    {{-- LIST --}}
                                    <div class="col-md-7">
                                        <h6 class="font-weight-bold text-center">Daftar Fitur</h6>
                                        <hr>

                                        @if($currentFeatures->count())
                                            <div class="list-group list-group-flush">
                                                @foreach($currentFeatures as $feat)
                                                    <div class="list-group-item d-flex justify-content-between">
                                                        <div>
                                                            <i class="{{ $feat->icon }} mr-2"></i>
                                                            <strong>{{ $feat->title_id }}</strong>
                                                            <p class="small text-muted mb-0">
                                                                {{ $feat->content_id }}
                                                            </p>
                                                        </div>
                                                        <div>
                                                            <button wire:click="editFeature({{ $feat->id }})"
                                                                    class="btn btn-outline-warning btn-sm mb-1">
                                                                <i class="fas fa-edit"></i>
                                                            </button>
                                                            <button wire:click="removeFeature({{ $feat->id }})"
                                                                    onclick="return confirm('Hapus fitur?')"
                                                                    class="btn btn-outline-danger btn-sm mb-1">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <div class="text-muted small text-center py-5">
                                                <i class="fas fa-star fa-2x mb-2"></i>
                                                <p>Belum ada fitur</p>
                                            </div>
                                        @endif
                                    </div>

                                </div>
                            @endif

                        </div>
                    </div>
                </div>

                {{-- ================= FOOTER ================= --}}
                <div class="modal-footer text-dark">
                    <button type="button"
                            class="btn btn-light shadow-sm"
                            data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i> Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
