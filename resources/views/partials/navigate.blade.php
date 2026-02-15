<div class="header-container d-flex flex-column align-items-start">
    <nav id="navmenu" class="navmenu">
        <ul>
            @php
                $currentLocale = app()->getLocale();
                $currentRoute = Route::currentRouteName();
                $routeParams = Route::current() ? Route::current()->parameters() : [];
            @endphp

            <li>
                <a href="{{ route('home', ['locale' => $currentLocale]) }}" @class(['active' => request()->routeIs('home')])>
                    <i class="bi bi-house navicon"></i> {{ app()->getLocale() == 'id' ? 'Beranda' : 'Home' }}
                </a>
            </li>
            <li>
                <a href="{{ route('about', ['locale' => $currentLocale]) }}" @class(['active' => request()->routeIs('about')])>
                    <i class="bi bi-person navicon"></i> {{ app()->getLocale() == 'id' ? 'Tentang' : 'About' }}
                </a>
            </li>
            <li>
                <a href="{{ route('resume', ['locale' => $currentLocale]) }}" @class(['active' => request()->routeIs('resume')])>
                    <i class="bi bi-file-earmark-text navicon"></i> Resume
                </a>
            </li>
            <li>
                <a href="{{ route('portofolio', ['locale' => $currentLocale]) }}" @class(['active' => request()->routeIs('portofolio') || request()->routeIs('portofolio-detail')])>
                    <i class="bi bi-images navicon"></i> Portofolio
                </a>
            </li>
            <li>
                <a href="{{ route('contact', ['locale' => $currentLocale]) }}" @class(['active' => request()->routeIs('contact')])>
                    <i class="bi bi-envelope navicon"></i> {{ app()->getLocale() == 'id' ? 'Kontak' : 'Contact' }}
                </a>
            </li>

            {{-- Switcher Bahasa --}}
            <div class="d-flex justify-content-center align-items-center mt-3 gap-2">
                {{-- Tombol Indonesia --}}
                <a href="{{ $currentRoute ? route($currentRoute, array_merge($routeParams, ['locale' => 'id'])) : url('/lang/id') }}"
                    class="{{ app()->getLocale() == 'id' ? 'text-primary' : '' }}">
                    <img src="{{ asset('snapfolio/assets/img/flag-id.png') }}" width="18" class="me-1"> 
                    {{ app()->getLocale() == 'id' ? 'Indonesia' : 'Indonesian' }}
                </a>
                <span class="text-muted">|</span>
                {{-- Tombol English --}}
                <a href="{{ $currentRoute ? route($currentRoute, array_merge($routeParams, ['locale' => 'en'])) : url('/lang/en') }}"
                    class="{{ app()->getLocale() == 'en' ? 'text-primary' : '' }}">
                    <img src="{{ asset('snapfolio/assets/img/flag-gb.png') }}" width="18" class="me-1"> 
                    {{ app()->getLocale() == 'id' ? 'Inggris' : 'English' }}
                </a>
            </div>
        </ul>
    </nav>
    <div class="social-links text-center">
        <a href="https://linkedin.com/in/{{ $sosialMedia->linkedin ?? '' }}" target="_blank" class="linkedin"><i class="bi bi-linkedin"></i></a>
        <a href="https://discord.com/users/{{ $sosialMedia->discord ?? '' }}" target="_blank" class="discord"><i class="bi bi-discord"></i></a>
        <a href="https://tiktok.com/{{ $sosialMedia->tiktok ?? '' }}" target="_blank" class="tiktok"><i class="bi bi-tiktok"></i></a>
        <a href="https://github.com/{{ $sosialMedia->github ?? '' }}" target="_blank" class="github"><i class="bi bi-github"></i></a>
        <a href="https://instagram.com/{{ $sosialMedia->instagram ?? '' }}" target="_blank" class="instagram"><i class="bi bi-instagram"></i></a>
    </div>
</div>