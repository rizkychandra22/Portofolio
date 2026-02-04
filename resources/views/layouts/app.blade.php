@php
    $image = \App\Models\ImageProfile::first() ?? (object) ['foto_resume' => ''];
@endphp

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="referrer" content="no-referrer-when-downgrade">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
        
        <title>{{ $title ?? 'Dashboard' }} | {{ $page ?? 'Portofolio' }}</title>

        <link rel="icon" href="{{ $image->foto_resume ?? '/snapfolio/assets/img/content/foto-ijazah.jpg' }}" crossorigin="anonymous">
        <link rel="stylesheet" href="/!template-stisla/dist/assets/modules/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="/!template-stisla/dist/assets/modules/fontawesome/css/all.min.css">
        <link rel="stylesheet" href="/!template-stisla/dist/assets/modules/jqvmap/dist/jqvmap.min.css">
        <link rel="stylesheet" href="/!template-stisla/dist/assets/modules/summernote/summernote-bs4.css">
        <link rel="stylesheet" href="/!template-stisla/dist/assets/css/style.css">
        <link rel="stylesheet" href="/!template-stisla/dist/assets/css/components.css">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>

    <body>
        <div id="app">
            <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>
                <nav class="navbar navbar-expand-lg main-navbar">
                    <div class="form-inline mr-auto">
                        <ul class="navbar-nav mr-3">
                            <li><a href="" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
                        </ul>
                    </div>

                    <ul class="navbar-nav navbar-right">
                        <li class="nav-item d-flex align-items-center">
                            <div class="nav-link nav-link-lg nav-link-user d-flex align-items-center">
                                <img alt="Profile User" src="{{ $image->foto_resume ?? '/snapfolio/assets/img/content/foto-ijazah.jpg' }}" class="rounded-circle mr-2">
                                {{-- <div class="fas fa-user-circle mr-2" style="font-size: 1.2rem;"></div> --}}
                                <div class="d-flex font-weight-600">
                                    <b>{{ Auth::user()->name }}</b>
                                </div>
                            </div>
                        </li>
                    </ul>
                </nav>
                <div class="main-sidebar sidebar-style-2">
                    <aside id="sidebar-wrapper">
                        <div class="sidebar-brand">
                            <a href="">Portofolio</a>
                        </div>
                        <div class="sidebar-brand sidebar-brand-sm">
                            <a href="">PL</a>
                        </div>
                        <ul class="sidebar-menu">
                            <li class="menu-header">Dashboard</li>
                            <li class="{{ Route::is('user.home') ? 'active' : '' }}">
                                <a href="{{ route('user.home') }}" wire:navigate class="nav-link">
                                    <i class="fas fa-home"></i> <span>Dashboard</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('home', ['locale' => app()->getLocale() ]) }}" class="text-dark" target="_blank">
                                    <i class="fas fa-globe text-dark"></i> <span>Website Snapfolio</span>
                                </a>
                            </li>
                            <li class="menu-header">Menu Utama</li>
                            <li @class(['active' => request()->routeIs('content.profile')])>
                                <a href="{{ route('content.profile') }}" wire:navigate class="nav-link">
                                    <i class="fas fa-user-tie"></i> <span>Profile Content</span>
                                </a>
                            </li>
                            <li class="dropdown {{ request()->routeIs('content.portofolio') || request()->routeIs('detail.portofolio') ? 'open, active' : '' }}">
                                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                                    <i class="fas fa-image"></i> <span>Data Image</span>
                                </a>
                                <ul class="dropdown-menu" style="{{ request()->routeIs('content.portofolio') ? 'display: block;' : '' }}">
                                    <li @class(['active' => request()->routeIs('content.portofolio')])>
                                        <a href="{{ route('content.portofolio') }}" wire:navigate class="nav-link">
                                            Portofolio Content
                                        </a>
                                    </li>
                                </ul>
                                <ul class="dropdown-menu" style="{{ request()->routeIs('detail.portofolio') ? 'display: block;' : '' }}">
                                    <li @class(['active' => request()->routeIs('detail.portofolio')])>
                                        <a href="{{ route('detail.portofolio') }}" wire:navigate class="nav-link">
                                            Portofolio Detail
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
                                <a href="{{ route('logout') }}" class="btn btn-danger btn-xl btn-block btn-icon-split">
                                    <i class="fas fa-power-off"></i> Logout
                                </a>
                            </div>
                        </ul>
                    </aside>
                </div>

                <div class="main-content">
                    {{ $slot }}
                </div>

                <footer class="main-footer">
                    <div class="footer-left">
                        &copy; {{ date('Y') }} - Sistem Informasi Profil
                    </div>
                </footer>
            </div>
        </div>

        <script src="/!template-stisla/dist/assets/modules/jquery.min.js"></script>
        <script src="/!template-stisla/dist/assets/modules/popper.js"></script>
        <script src="/!template-stisla/dist/assets/modules/bootstrap/js/bootstrap.min.js"></script>
        <script src="/!template-stisla/dist/assets/modules/nicescroll/jquery.nicescroll.min.js"></script>
        <script src="/!template-stisla/dist/assets/js/stisla.js"></script>
    
        <script src="/!template-stisla/dist/assets/js/scripts.js"></script>
        <script src="/!template-stisla/dist/assets/js/custom.js"></script>
        
        @livewireScripts
        @stack('scripts')

        <script>
            document.addEventListener('livewire:navigated', () => {
                if (window.jQuery) {
                    console.log("Livewire Navigated: jQuery is ready!");
                    
                } else {
                    console.error("Livewire Navigated: jQuery failed to load!");
                }
            });
        </script>
    </body>
</html>