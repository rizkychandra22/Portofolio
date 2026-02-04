<div>
    <section class="section">
        <div class="section-header">
            <h1>{{ $title }}</h1>
        </div>

        <div class="row">
            {{-- Alert Message --}}
            <div class="col-12">
                @if(session()->has('info'))
                    <div class="alert alert-success alert-dismissible show fade alert-auto-hide">
                        <div class="alert-body">
                            <button class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                            <strong>Berhasil!</strong> {{ session('info') }}
                        </div>
                    </div>
                @endif

                @if (session()->has('success') || session()->has('danger'))
                    <div x-data="{ show: true }" 
                         x-show="show" 
                         x-init="setTimeout(() => show = false, 3000)"
                         x-transition:leave="transition ease-in duration-500"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0"
                         class="alert alert-{{ session()->has('success') ? 'success' : 'danger' }} alert-dismissible show fade mb-4">
                        <div class="alert-body">
                            <button class="close" @click="show = false"><span>&times;</span></button>
                            {{ session('success') ?? session('danger') }}
                        </div>
                    </div>
                @endif
            </div>

            <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>{{ $page }}</h4>
                        {{-- <div class="card-header-action">
                            <div class="btn-group">
                                <a href="" class="btn btn-success">
                                    <i class="fas fa-print mr-1"></i> Cetak
                                </a>
                                <a href="" class="btn btn-success">
                                    <i class="fas fa-print mr-1"></i> Cetak
                                </a>
                            </div>
                        </div> --}}
                    </div>

                    <div class="card-body">
                        <i><b><code>Selamat datang, {{ Auth::user()->name }}</code></b></i>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
