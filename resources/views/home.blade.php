@extends('layouts.app')

@section('title', $settings['site_name'] ?? 'Revira Industrial')
@section('description', $settings['site_description'] ?? '')

@section('content')
    <!-- Hero Slider -->
    @if($sliders->count() > 0)
        <section class="hero-slider position-relative">
            <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    @foreach($sliders as $index => $slider)
                        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="{{ $index }}" 
                                class="{{ $index === 0 ? 'active' : '' }}"></button>
                    @endforeach
                </div>
                
                <div class="carousel-inner">
                    @foreach($sliders as $index => $slider)
                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }} parallax" style="background-image: url('{{ $slider->image }}');">
                            <div class="carousel-caption">
                                <div class="hero-content">
                                    <h1 class="display-2 fw-bold mb-4 lh-1 text-white">{{ $slider->title }}</h1>
                                    <p class="fs-4 mb-5 text-white opacity-90 lead">{{ $slider->description }}</p>
                                    <div class="hero-buttons d-flex flex-column flex-md-row justify-content-center align-items-center gap-3">
                                        @if($slider->button_text && $slider->button_url)
                                            <a href="{{ $slider->button_url }}" class="btn btn-primary btn-lg px-5 py-3 rounded-pill shadow-lg">
                                                <i class="fas fa-rocket me-2"></i>
                                                {{ $slider->button_text }}
                                                <i class="fas fa-arrow-right ms-2"></i>
                                            </a>
                                        @endif
                                        @if($slider->video_url)
                                            <a href="{{ $slider->video_url }}" class="btn btn-outline-light btn-lg px-5 py-3 rounded-pill shadow-lg" target="_blank">
                                                <i class="fas fa-play me-2"></i>
                                                {{ __('watch_video') }}
                                                <i class="fas fa-external-link-alt ms-2"></i>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
            </div>
        </section>
    @endif

    <!-- Our Mission -->
    <section class="section bg-light">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-5">
                    <h2 class="section-title">{{ __('our_mission') }}</h2>
                    <p class="section-subtitle">{{ __('mission_title') }}</p>
                </div>
            </div>
            <div class="row align-items-center mb-5">
                <div class="col-lg-6">
                    <div class="mission-content">
                        <h3 class="h4 fw-bold mb-4">{{ __('mission_title') }}</h3>
                        <p class="lead mb-4">{{ __('mission_description') }}</p>
                        <div class="d-flex align-items-center">
                            <div class="bg-primary rounded-circle p-3 me-3">
                                <i class="fas fa-bullseye text-white fa-2x"></i>
                            </div>
                            <div>
                                <h5 class="mb-1">{{ __('mission_vision_title') }}</h5>
                                <p class="text-muted mb-0">{{ __('mission_vision_text') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mission-image text-center">
                        <div class="rounded-3 overflow-hidden shadow-lg">
                            <img src="{{ asset('images/mission-industrial.svg') }}" alt="{{ __('our_mission') }}" class="img-fluid w-100" style="max-height: 400px; object-fit: cover;">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-success rounded-circle p-2 me-3">
                                    <i class="fas fa-heart text-white"></i>
                                </div>
                                <h5 class="card-title mb-0">{{ __('mission_values_title') }}</h5>
                            </div>
                            <p class="card-text text-muted">{{ __('mission_values_text') }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-warning rounded-circle p-2 me-3">
                                    <i class="fas fa-handshake text-white"></i>
                                </div>
                                <h5 class="card-title mb-0">{{ __('mission_commitment_title') }}</h5>
                            </div>
                            <p class="card-text text-muted">{{ __('mission_commitment_text') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Products -->
    @if($featuredProducts->count() > 0)
        <section class="section">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h2 class="section-title">{{ __('featured_products') }}</h2>
                        <p class="section-subtitle">{{ __('featured_products_subtitle') }}</p>
                    </div>
                </div>
                <div class="row g-4">
                    @foreach($featuredProducts as $product)
                        <div class="col-lg-3 col-md-6">
                            <div class="card product-card h-100 border-0 shadow-sm">
                                <div class="position-relative overflow-hidden">
                                    @if($product->image)
                                        <img src="{{ $product->image }}" class="card-img-top product-img" alt="{{ $product->name }}" loading="lazy">
                                    @else
                                        <div class="card-img-top bg-gradient d-flex align-items-center justify-content-center product-placeholder">
                                            <i class="fas fa-cogs fa-3x text-muted"></i>
                                        </div>
                                    @endif
                                    @if($product->is_on_sale)
                                        <div class="position-absolute top-0 start-0 m-3">
                                            <span class="badge bg-danger rounded-pill">{{ $product->discount_percentage }}% {{ __('off') }}</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="card-body p-4">
                                    <h5 class="card-title fw-bold mb-2">{{ $product->name }}</h5>
                                    <p class="card-text text-muted small mb-3">{{ $product->short_description }}</p>
                                    @if($product->price)
                                        <div class="mb-3">
                                            <div class="d-flex align-items-center gap-2">
                                                <span class="h5 mb-0 text-primary fw-bold">{{ number_format($product->final_price) }} {{ currency_symbol() }}</span>
                                                @if($product->is_on_sale && $product->price != $product->final_price)
                                                    <span class="text-muted text-decoration-line-through small">{{ number_format($product->price) }} {{ currency_symbol() }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                    <a href="{{ \App\Helpers\LanguageHelper::getLocalizedUrl('product.show', ['slug' => $product->slug]) }}" class="btn btn-outline-primary w-100 rounded-pill">
                                        {{ __('view_details') }}
                                        <i class="fas fa-arrow-right ms-2"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="row mt-5">
                    <div class="col-12 text-center">
                        <a href="{{ \App\Helpers\LanguageHelper::getLocalizedUrl('products') }}" class="btn btn-primary btn-lg rounded-pill px-5">
                            {{ __('view_all_products') }}
                            <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- Latest Products -->
    @if($newProducts->count() > 0)
        <section class="section bg-light">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h2 class="section-title">{{ __('latest_products') }}</h2>
                        <p class="section-subtitle">{{ __('latest_products_subtitle') }}</p>
                    </div>
                </div>
                <div class="row g-4">
                    @foreach($newProducts as $product)
                        <div class="col-lg-3 col-md-6">
                            <div class="card product-card h-100 border-0 shadow-sm">
                                <div class="position-relative overflow-hidden">
                                    @if($product->image)
                                        <img src="{{ $product->image }}" class="card-img-top product-img" alt="{{ $product->name }}" loading="lazy">
                                    @else
                                        <div class="card-img-top bg-gradient d-flex align-items-center justify-content-center product-placeholder">
                                            <i class="fas fa-cogs fa-3x text-muted"></i>
                                        </div>
                                    @endif
                                    @if($product->is_on_sale)
                                        <div class="position-absolute top-0 start-0 m-3">
                                            <span class="badge bg-danger rounded-pill">{{ $product->discount_percentage }}% {{ __('off') }}</span>
                                        </div>
                                    @endif
                                    <div class="position-absolute top-0 end-0 m-3">
                                        <span class="badge bg-success rounded-pill">{{ __('new') }}</span>
                                    </div>
                                </div>
                                <div class="card-body p-4">
                                    <h5 class="card-title fw-bold mb-2">{{ $product->name }}</h5>
                                    <p class="card-text text-muted small mb-3">{{ $product->short_description }}</p>
                                    @if($product->price)
                                        <div class="mb-3">
                                            <div class="d-flex align-items-center gap-2">
                                                <span class="h5 mb-0 text-primary fw-bold">{{ number_format($product->final_price) }} {{ currency_symbol() }}</span>
                                                @if($product->is_on_sale && $product->price != $product->final_price)
                                                    <span class="text-muted text-decoration-line-through small">{{ number_format($product->price) }} {{ currency_symbol() }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                    <a href="{{ route('product.show', $product->slug) }}" class="btn btn-outline-primary w-100 rounded-pill">
                                        {{ __('view_details') }}
                                        <i class="fas fa-arrow-right ms-2"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Latest News -->
    @if($latestNews->count() > 0)
        <section class="section">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h2 class="section-title">{{ __('latest_news') }}</h2>
                        <p class="section-subtitle">{{ __('news_section_subtitle') }}</p>
                    </div>
                </div>
                <div class="row g-4">
                    @foreach($latestNews as $news)
                        <div class="col-lg-4 col-md-6">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="position-relative overflow-hidden">
                                    @if($news->image)
                                        <img src="{{ $news->image }}" class="card-img-top news-img" alt="{{ $news->title }}">
                                    @else
                                        <div class="card-img-top bg-gradient d-flex align-items-center justify-content-center news-placeholder">
                                            <i class="fas fa-newspaper fa-3x text-muted"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="card-body p-4">
                                    <h5 class="card-title fw-bold mb-3">{{ $news->title }}</h5>
                                    <p class="card-text text-muted mb-4">{{ $news->excerpt }}</p>
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <small class="text-muted">
                                            <i class="fas fa-calendar-alt me-1"></i>
                                            {{ $news->published_at->format('M d, Y') }}
                                        </small>
                                    </div>
                                    <a href="{{ \App\Helpers\LanguageHelper::getLocalizedUrl('news.show', ['slug' => $news->slug]) }}" class="btn btn-outline-primary w-100 rounded-pill">
                                        {{ __('read_more') }}
                                        <i class="fas fa-arrow-right ms-2"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="row mt-5">
                    <div class="col-12 text-center">
                        <a href="{{ \App\Helpers\LanguageHelper::getLocalizedUrl('news') }}" class="btn btn-primary btn-lg rounded-pill px-5">
                            {{ __('view_all_news') }}
                            <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- Agents Section -->
    @if($agents->count() > 0)
        <section class="section bg-light">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h2 class="section-title">{{ __('our_agents') }}</h2>
                        <p class="section-subtitle">{{ __('agents_section_subtitle') }}</p>
                    </div>
                </div>
                <div class="row g-4">
                    @foreach($agents->take(6) as $agent)
                        <div class="col-lg-4 col-md-6">
                            <div class="card text-center h-100 border-0 shadow-sm">
                                <div class="card-body p-4">
                                    @if($agent->logo)
                                        <img src="{{ $agent->logo }}" alt="{{ $agent->company_name }}" class="img-fluid mb-3 agent-logo">
                                        <h5 class="card-title fw-bold mb-3">{{ $agent->company_name }}</h5>
                                        <p class="card-text text-muted mb-4">{{ $agent->description }}</p>
                                        <div class="contact-info">
                                            @if($agent->phone)
                                                <p class="mb-2">
                                                    <i class="fas fa-phone me-2 text-primary"></i>
                                                    <a href="tel:{{ $agent->phone }}" class="text-decoration-none">{{ $agent->phone }}</a>
                                                </p>
                                            @endif
                                            @if($agent->email)
                                                <p class="mb-2">
                                                    <i class="fas fa-envelope me-2 text-primary"></i>
                                                    <a href="mailto:{{ $agent->email }}" class="text-decoration-none">{{ $agent->email }}</a>
                                                </p>
                                            @endif
                                            @if($agent->website)
                                                <p class="mb-3">
                                                    <i class="fas fa-globe me-2 text-primary"></i>
                                                    <a href="{{ $agent->website }}" target="_blank" class="text-decoration-none">{{ __('website') }}</a>
                                                </p>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="row mt-5">
                    <div class="col-12 text-center">
                        <a href="{{ \App\Helpers\LanguageHelper::getLocalizedUrl('agents') }}" class="btn btn-primary btn-lg rounded-pill px-5">
                            {{ __('view_all_agents') }}
                            <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    @endif
@endsection

@section('scripts')
<script>
    // Enhanced carousel initialization
    $(document).ready(function() {
        const carousel = $('#heroCarousel');
        let userInteracted = false;
        let isTransitioning = false;
        
        // Initialize carousel with formal presentation settings
        carousel.carousel({
            interval: 8000,
            wrap: true,
            keyboard: true,
            pause: 'hover'
        });
        
        // Smooth transition handling
        carousel.on('slide.bs.carousel', function() {
            isTransitioning = true;
            $('.carousel-item').css('transition', 'all 0.6s cubic-bezier(0.4, 0, 0.2, 1)');
        });
        
        carousel.on('slid.bs.carousel', function() {
            isTransitioning = false;
            // Reset any transforms after transition
            $('.carousel-item:not(.active)').css({
                'background-position': 'center center',
                'transform': 'none'
            });
        });
        
        // No content animations - instant changes only
          carousel.on('slide.bs.carousel', function (e) {
              // Remove any existing animations
              $('.hero-content').stop(true, true).css('opacity', '1').show();
          });
        
        // Auto-pause on user interaction
        carousel.on('slid.bs.carousel', function() {
            if (!userInteracted && !isTransitioning) {
                setTimeout(() => {
                    if (!isTransitioning) {
                        carousel.carousel('next');
                    }
                }, 8000);
            }
        });
        
        // Pause on manual navigation
        $('.carousel-control-prev, .carousel-control-next, .carousel-indicators button').on('click', function() {
            userInteracted = true;
            setTimeout(() => {
                userInteracted = false;
            }, 10000); // Resume auto-play after 10 seconds
        });
        
        // Touch/swipe support for mobile
        let startX = 0;
        let endX = 0;
        
        carousel.on('touchstart', function(e) {
            startX = e.originalEvent.touches[0].clientX;
        });
        
        carousel.on('touchend', function(e) {
            endX = e.originalEvent.changedTouches[0].clientX;
            handleSwipe();
        });
        
        function handleSwipe() {
            const threshold = 50;
            const diff = startX - endX;
            
            if (Math.abs(diff) > threshold) {
                if (diff > 0) {
                    carousel.carousel('next');
                } else {
                    carousel.carousel('prev');
                }
                userInteracted = true;
                setTimeout(() => {
                    userInteracted = false;
                }, 10000);
            }
        }
        
        // Keyboard navigation enhancement
        $(document).on('keydown', function(e) {
            if (e.key === 'ArrowLeft') {
                carousel.carousel('prev');
                userInteracted = true;
            } else if (e.key === 'ArrowRight') {
                carousel.carousel('next');
                userInteracted = true;
            }
        });
        
        // Enhanced scroll handling with throttling
        let scrollTimeout;
        $(window).on('scroll', function() {
            if (scrollTimeout) {
                clearTimeout(scrollTimeout);
            }
            
            scrollTimeout = setTimeout(function() {
                const scrolled = $(this).scrollTop();
                const windowHeight = $(window).height();
                const sliderHeight = $('.hero-slider').outerHeight();
                
                // Only apply effects when slider is visible and not transitioning
                if (scrolled < sliderHeight && !isTransitioning) {
                    const activeSlide = $('.carousel-item.active');
                    const speed = 0.2;
                    
                    // Subtle parallax effect on background position
                    const bgPos = 50 + (scrolled * speed / 20);
                    activeSlide.css({
                        'background-position': `center ${Math.min(60, Math.max(40, bgPos))}%`
                    });
                    
                    // Smooth fade effect
                    const opacity = Math.max(0.3, 1 - (scrolled / (sliderHeight * 0.9)));
                    $('.hero-slider').css('opacity', opacity);
                } else if (scrolled >= sliderHeight) {
                    // Reset when scrolled past slider
                    $('.hero-slider').css('opacity', 0.3);
                    $('.carousel-item.active').css('background-position', 'center center');
                }
            }.bind(this), 16); // ~60fps throttling
        });
        
        // Preload next slide images for smoother transitions
        const preloadImages = () => {
            carousel.find('.carousel-item').each(function() {
                const bgImage = $(this).css('background-image');
                if (bgImage && bgImage !== 'none') {
                    const img = new Image();
                    img.src = bgImage.replace(/url\(["']?([^"']*)["']?\)/i, '$1');
                }
            });
        };
        
        preloadImages();
        
        // Add loading animation
        carousel.addClass('carousel-loaded');
    });
</script>
@endsection