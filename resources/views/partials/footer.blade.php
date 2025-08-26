<footer class="bg-dark text-light py-5">
    <div class="container">
        <div class="row">
            <!-- Company Info -->
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="footer-brand mb-4">
                    @if(isset($settings['company_logo']))
                        <img src="{{ $settings['company_logo'] }}" alt="{{ $settings['company_name'] ?? 'Revira Industrial' }}" class="footer-logo mb-3">
                    @endif
                    <h5 class="fw-bold mb-3">{{ $settings['company_name'] ?? 'Revira Industrial' }}</h5>
                </div>
                <p class="text-muted mb-4">{{ $settings['company_description'] ?? 'Leading provider of industrial machinery and equipment solutions.' }}</p>
                
                <!-- Contact Info -->
                <div class="contact-info">
                    @if(isset($settings['company_address']))
                        <div class="contact-item mb-3">
                            <i class="fas fa-map-marker-alt me-3 text-primary"></i>
                            <span>{{ $settings['company_address'] }}</span>
                        </div>
                    @endif
                    
                    @if(isset($settings['company_phone']))
                        <div class="contact-item mb-3">
                            <i class="fas fa-phone me-3 text-primary"></i>
                            <a href="tel:{{ $settings['company_phone'] }}" class="text-decoration-none">
                                {{ $settings['company_phone'] }}
                            </a>
                        </div>
                    @endif
                    
                    @if(isset($settings['company_email']))
                        <div class="contact-item mb-3">
                            <i class="fas fa-envelope me-3 text-primary"></i>
                            <a href="mailto:{{ $settings['company_email'] }}" class="text-decoration-none">
                                {{ $settings['company_email'] }}
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Quick Links -->
            <div class="col-lg-2 col-md-6 mb-4">
                <h5 class="fw-bold mb-4">{{ __('quick_links') }}</h5>
                <ul class="list-unstyled footer-links">
                    <li class="mb-3">
                        <a href="{{ route('home') }}" class="footer-link">
                            <i class="fas fa-home me-2"></i>
                            {{ __('home') }}
                        </a>
                    </li>
                    <li class="mb-3">
                        <a href="{{ \App\Helpers\LanguageHelper::getLocalizedUrl('products') }}" class="footer-link">
                            <i class="fas fa-cogs me-2"></i>
                            {{ __('products') }}
                        </a>
                    </li>
                    <li class="mb-3">
                        <a href="{{ \App\Helpers\LanguageHelper::getLocalizedUrl('news') }}" class="footer-link">
                            <i class="fas fa-newspaper me-2"></i>
                            {{ __('news') }}
                        </a>
                    </li>
                    <li class="mb-3">
                        <a href="{{ \App\Helpers\LanguageHelper::getLocalizedUrl('agents') }}" class="footer-link">
                            <i class="fas fa-users me-2"></i>
                            {{ __('agents') }}
                        </a>
                    </li>
                    <li class="mb-3">
                        <a href="{{ \App\Helpers\LanguageHelper::getLocalizedUrl('about') }}" class="footer-link">
                            <i class="fas fa-info-circle me-2"></i>
                            {{ __('about_us') }}
                        </a>
                    </li>
                    <li class="mb-3">
                        <a href="{{ \App\Helpers\LanguageHelper::getLocalizedUrl('contact') }}" class="footer-link">
                            <i class="fas fa-envelope me-2"></i>
                            {{ __('contact_us') }}
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Categories -->
            <div class="col-lg-3 col-md-6 mb-4">
                <h5 class="fw-bold mb-4">{{ __('categories') }}</h5>
                <ul class="list-unstyled footer-links">
                    @foreach($mainCategories->take(6) as $category)
                        <li class="mb-3">
                            <a href="{{ \App\Helpers\LanguageHelper::getLocalizedUrl('products', ['category' => $category->slug]) }}" class="footer-link">
                                <i class="fas fa-tag me-2"></i>
                                {{ $category->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Social Media -->
            <div class="col-lg-3 col-md-6 mb-4">
                <h6 class="fw-bold mb-3">{{ __('follow_us') }}</h6>
                <div class="d-flex gap-3">
                    @if(isset($settings['social_facebook']) && $settings['social_facebook'])
                        <a href="{{ $settings['social_facebook'] }}" target="_blank" class="social-link">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                    @endif
                    
                    @if(isset($settings['social_twitter']) && $settings['social_twitter'])
                        <a href="{{ $settings['social_twitter'] }}" target="_blank" class="social-link">
                            <i class="fab fa-twitter"></i>
                        </a>
                    @endif
                    
                    @if(isset($settings['social_linkedin']) && $settings['social_linkedin'])
                        <a href="{{ $settings['social_linkedin'] }}" target="_blank" class="social-link">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    @endif
                    
                    @if(isset($settings['social_instagram']) && $settings['social_instagram'])
                        <a href="{{ $settings['social_instagram'] }}" target="_blank" class="social-link">
                            <i class="fab fa-instagram"></i>
                        </a>
                    @endif
                    
                    @if(isset($settings['social_youtube']) && $settings['social_youtube'])
                        <a href="{{ $settings['social_youtube'] }}" target="_blank" class="social-link">
                            <i class="fab fa-youtube"></i>
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Bottom Footer -->
        <div class="footer-bottom">
            <div class="container">
                <div class="row align-items-center py-4">
                    <div class="col-md-6">
                        <p class="mb-0">
                            &copy; {{ date('Y') }} {{ $settings['company_name'] ?? 'Revira Tech' }}. {{ __('All rights reserved.') }}
                        </p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <div class="footer-bottom-links">
                            <span>{{ __('Developed and Designed by Abedalrahman Shalabi') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>