<!-- Top Bar -->
<div class="top-bar">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="d-flex align-items-center">
                    @if(isset($settings['contact_email']) && $settings['contact_email'])
                        <span class="me-3">
                            <i class="fas fa-envelope me-1"></i>
                            <a href="mailto:{{ $settings['contact_email'] }}" class="text-white text-decoration-none">
                                {{ $settings['contact_email'] }}
                            </a>
                        </span>
                    @endif
                    @if(isset($settings['contact_phone']) && $settings['contact_phone'])
                        <span>
                            <i class="fas fa-phone me-1"></i>
                            <a href="tel:{{ $settings['contact_phone'] }}" class="text-white text-decoration-none">
                                {{ $settings['contact_phone'] }}
                            </a>
                        </span>
                    @endif
                </div>
            </div>
            <div class="col-md-6 text-end">
                <div class="d-flex align-items-center justify-content-end">
                    <!-- Social Media Icons -->
                    <div class="social-icons">
                        <a href="#" class="text-white me-2" title="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="text-white me-2" title="Twitter">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="text-white me-2" title="LinkedIn">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="#" class="text-white me-2" title="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                    
                    <!-- Language Switcher -->
                    <div class="dropdown language-switcher">
                        <button class="btn btn-outline-light btn-sm dropdown-toggle border-0 rounded-pill px-3" type="button" data-bs-toggle="dropdown">
                            <span class="me-2">{{ $languages['current']->flag ?? '🌐' }}</span>
                            <span class="fw-medium">{{ $languages['current']->name ?? 'العربية' }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            @foreach($languages['languages'] as $language)
                                <li>
                                    <a class="dropdown-item rounded" href="{{ \App\Helpers\LanguageHelper::getLanguageSwitchUrl($language->code) }}">
                                        <span class="me-2">{{ $language->flag ?? '🌐' }}</span>
                                        <span>{{ $language->name }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<header class="sticky-top">
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <!-- Logo -->
            <a class="navbar-brand d-flex align-items-center" href="{{ \App\Helpers\LanguageHelper::getLocalizedUrl('home') }}">
                @if(isset($settings['site_logo']) && $settings['site_logo'])
                    <img src="{{ $settings['site_logo'] }}" alt="{{ $settings['site_name'] ?? 'Revira Tech' }}" height="68" class="me-2">
               
                    {{-- <span class="fs-4">{{ $settings['site_name'] ?? '' }}</span> --}}
                @endif
            </a>

            <!-- Mobile Toggle -->
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <i class="fas fa-bars"></i>
            </button>

            <!-- Navigation Menu -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home*') ? 'active' : '' }}" href="{{ \App\Helpers\LanguageHelper::getLocalizedUrl('home') }}">
                            <i class="fas fa-home"></i> {{ __('home') }}
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('products*') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-cogs"></i> {{ __('products') }}
                        </a>
                        <ul class="dropdown-menu shadow border-0 rounded-lg">
                            @foreach($mainCategories as $category)
                                <li>
                                    <a class="dropdown-item py-2" href="{{ \App\Helpers\LanguageHelper::getLocalizedUrl('products', ['category' => $category->slug]) }}">
                                        {{ $category->name }}
                                    </a>
                                </li>
                            @endforeach
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item py-2 fw-medium" href="{{ \App\Helpers\LanguageHelper::getLocalizedUrl('products') }}">
                                    <i class="fas fa-th-large me-1"></i> {{ __('view_all') }}
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('news*') ? 'active' : '' }}" href="{{ \App\Helpers\LanguageHelper::getLocalizedUrl('news') }}">
                            <i class="fas fa-newspaper"></i> {{ __('news') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('agents*') ? 'active' : '' }}" href="{{ \App\Helpers\LanguageHelper::getLocalizedUrl('agents') }}">
                            <i class="fas fa-handshake"></i> {{ __('agents') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('about*') ? 'active' : '' }}" href="{{ \App\Helpers\LanguageHelper::getLocalizedUrl('about') }}">
                            <i class="fas fa-info-circle"></i> {{ __('about_us') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('contact*') ? 'active' : '' }}" href="{{ \App\Helpers\LanguageHelper::getLocalizedUrl('contact') }}">
                            <i class="fas fa-envelope"></i> {{ __('contact_us') }}
                        </a>
                    </li>
                </ul>

                <!-- Search Form -->
                <form class="d-flex me-4" action="{{ \App\Helpers\LanguageHelper::getLocalizedUrl('products') }}" method="GET">
                    <div class="input-group modern-search">
                        <input class="form-control border-0 bg-light search-input" type="search" name="search" placeholder="{{ __('search') }}" value="{{ request('search') }}">
                        <button class="btn btn-primary border-0 search-btn" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>


            </div>
        </div>
    </nav>
</header>