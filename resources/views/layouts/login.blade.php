@php
    $image = \App\Models\ImageProfile::first();
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Login User | Portofolio</title>
    <link rel="icon" href="{{ $image->foto_resume ?? '/snapfolio/assets/img/content/foto-ijazah.jpg' }}" crossorigin="anonymous">

    <link rel="stylesheet" href="/!template-stisla/dist/assets/modules/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/!template-stisla/dist/assets/modules/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="/!template-stisla/dist/assets/modules/bootstrap-social/bootstrap-social.css">

    <link rel="stylesheet" href="/!template-stisla/dist/assets/css/style.css">
    <link rel="stylesheet" href="/!template-stisla/dist/assets/css/components.css">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body>
    <div id="app">
        <section class="section">
            <div class="container mt-5">
                <div class="row">
                    <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                        <div class="card card-primary">
                            <div class="card-header justify-content-center">
                                <a href="{{ route('login') }}">
                                    <img src="{{ $image->foto_resume ?? '/snapfolio/assets/img/content/foto-ijazah.jpg' }}" crossorigin="anonymous" 
                                         alt="logo" width="100" class="shadow-light rounded-circle">
                                </a>
                            </div>
                            <div class="card-body" style="margin-top: -35px">
                                <hr>
                                
                                {{ $slot }}

                                <button onclick="window.location.href='{{ route('home', ['locale' => app()->getLocale()]) }}'" class="btn btn-success btn-lg btn-block">Go To Website</button>
                                <hr>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script src="/!template-stisla/dist/assets/modules/jquery.min.js"></script>
    <script src="/!template-stisla/dist/assets/modules/popper.js"></script>
    <script src="/!template-stisla/dist/assets/modules/bootstrap/js/bootstrap.min.js"></script>
    <script src="/!template-stisla/dist/assets/modules/nicescroll/jquery.nicescroll.min.js"></script>
    <script src="/!template-stisla/dist/assets/js/stisla.js"></script>
    <script src="/!template-stisla/dist/assets/js/scripts.js"></script>
    
    @livewireScripts
    @stack('scripts')
</body>
</html>