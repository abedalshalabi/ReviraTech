@extends('layouts.app')

@section('title', __('contact_us') . ' - ' . ($settings['site_name'] ?? 'Revira Industrial'))
@section('description', __('contact_us_description'))

@section('content')
    <!-- Page Header -->
    <section class="text-white py-5" style="background: var(--gradient-primary);">
        <div class="container section-top-padding">
            <div class="row">
                <div class="col-12 text-center">
                    <h1 class="display-4 fw-bold">{{ __('contact_us') }}</h1>
                    <p class="lead">{{ __('contact_us_help_text') }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Information -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <!-- Contact Form -->
                <div class="col-lg-8 mb-5">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0">{{ __('message_us') }}</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('contact') }}" method="POST" id="contactForm">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">{{ __('name') }} *</label>
                                        <input type="text" class="form-control" id="name" name="name" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label">{{ __('email') }} *</label>
                                        <input type="email" class="form-control" id="email" name="email" required>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="phone" class="form-label">{{ __('phone') }}</label>
                                        <input type="tel" class="form-control" id="phone" name="phone">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="company" class="form-label">{{ __('company') }}</label>
                                        <input type="text" class="form-control" id="company" name="company">
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="subject" class="form-label">{{ __('subject') }} *</label>
                                    <select class="form-select" id="subject" name="subject" required>
                                        <option value="">{{ __('select_subject') }}</option>
                                        <option value="quote">{{ __('request_quote') }}</option>
                                        <option value="inquiry">{{ __('general_inquiry') }}</option>
                                        <option value="support">{{ __('technical_support') }}</option>
                                        <option value="partnership">{{ __('business_partnership') }}</option>
                                        <option value="other">{{ __('other') }}</option>
                                    </select>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="message" class="form-label">{{ __('message') }} *</label>
                                    <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                                </div>
                                
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="newsletter" name="newsletter">
                                        <label class="form-check-label" for="newsletter">
                                            {{ __('subscribe_newsletter') }}
                                        </label>
                                    </div>
                                </div>
                                
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-paper-plane me-2"></i>{{ __('send_message') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Contact Info -->
                <div class="col-lg-4">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">{{ __('contact_information') }}</h5>
                        </div>
                        <div class="card-body">
                            @if(isset($settings['contact_address']) && $settings['contact_address'])
                                <div class="d-flex mb-3">
                                    <i class="fas fa-map-marker-alt text-primary me-3 mt-1"></i>
                                    <div>
                                        <h6 class="mb-1">{{ __('address') }}</h6>
                                        <p class="mb-0">{{ $settings['contact_address'] }}</p>
                                    </div>
                                </div>
                            @endif
                            
                            @if(isset($settings['contact_phone']) && $settings['contact_phone'])
                                <div class="d-flex mb-3">
                                    <i class="fas fa-phone text-primary me-3 mt-1"></i>
                                    <div>
                                        <h6 class="mb-1">{{ __('phone') }}</h6>
                                        <p class="mb-0">
                                            <a href="tel:{{ $settings['contact_phone'] }}" class="text-decoration-none">
                                                {{ $settings['contact_phone'] }}
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            @endif
                            
                            @if(isset($settings['contact_email']) && $settings['contact_email'])
                                <div class="d-flex mb-3">
                                    <i class="fas fa-envelope text-primary me-3 mt-1"></i>
                                    <div>
                                        <h6 class="mb-1">{{ __('email') }}</h6>
                                        <p class="mb-0">
                                            <a href="mailto:{{ $settings['contact_email'] }}" class="text-decoration-none">
                                                {{ $settings['contact_email'] }}
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            @endif
                            
                            @if(isset($settings['contact_working_hours']) && $settings['contact_working_hours'])
                                <div class="d-flex mb-3">
                                    <i class="fas fa-clock text-primary me-3 mt-1"></i>
                                    <div>
                                        <h6 class="mb-1">{{ __('working_hours') }}</h6>
                                        <p class="mb-0">{{ $settings['contact_working_hours'] }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Social Media -->
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">{{ __('follow_us') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex gap-2">
                                @if(isset($settings['social_facebook']) && $settings['social_facebook'])
                                    <a href="{{ $settings['social_facebook'] }}" class="btn btn-outline-primary" target="_blank">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                @endif
                                
                                @if(isset($settings['social_twitter']) && $settings['social_twitter'])
                                    <a href="{{ $settings['social_twitter'] }}" class="btn btn-outline-info" target="_blank">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                @endif
                                
                                @if(isset($settings['social_linkedin']) && $settings['social_linkedin'])
                                    <a href="{{ $settings['social_linkedin'] }}" class="btn btn-outline-primary" target="_blank">
                                        <i class="fab fa-linkedin-in"></i>
                                    </a>
                                @endif
                                
                                @if(isset($settings['social_instagram']) && $settings['social_instagram'])
                                    <a href="{{ $settings['social_instagram'] }}" class="btn btn-outline-danger" target="_blank">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                @endif
                                
                                @if(isset($settings['social_youtube']) && $settings['social_youtube'])
                                    <a href="{{ $settings['social_youtube'] }}" class="btn btn-outline-danger" target="_blank">
                                        <i class="fab fa-youtube"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    @if(isset($settings['google_maps_api_key']) && $settings['google_maps_api_key'])
        <section class="py-5 bg-light">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h3 class="text-center mb-4">{{ __('our_location') }}</h3>
                        <div id="map" class="map-container"></div>
                    </div>
                </div>
            </div>
        </section>
    @endif
@endsection

@section('scripts')
@if(isset($settings['google_maps_api_key']) && $settings['google_maps_api_key'])
<script src="{{ asset('js/google-maps.js') }}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key={{ $settings['google_maps_api_key'] }}&callback=initMap" async defer></script>
@endif

<script>
// Form validation and submission
document.getElementById('contactForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Basic validation
    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const subject = document.getElementById('subject').value;
    const message = document.getElementById('message').value;
    
    if (!name || !email || !subject || !message) {
        alert('{{ __('please_fill_all_required_fields') }}');
        return;
    }
    
    // Email validation
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        alert('{{ __('please_enter_valid_email') }}');
        return;
    }
    
    // Submit form
    this.submit();
});
</script>
@endsection