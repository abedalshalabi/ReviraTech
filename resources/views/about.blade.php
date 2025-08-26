@extends('layouts.app')

@section('title', __('about_us') . ' - ' . ($settings['site_name'] ?? 'Revira Industrial'))
@section('description', __('about_us_description'))

@section('content')
    <!-- Page Header -->
    <section class="text-white py-5" style="background: var(--gradient-primary);">
        <div class="container section-top-padding">
            <div class="row">
                <div class="col-12 text-center">
                    <h1 class="display-4 fw-bold">{{ __('about_us') }}</h1>
            <p class="lead">{{ __('about_us_subtitle') }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Content -->
    <section class="py-5">
        <div class="container">
            <div class="row align-items-center mb-5">
                <div class="col-lg-6">
                    <h2 class="mb-4">{{ __('our_story') }}</h2>
                    <p class="lead mb-4">
                        {{ __('about_company_intro') }}
                    </p>
                    <p class="mb-4">
                        {{ __('about_company_foundation') }}
                    </p>
                    <p class="mb-4">
                        {{ __('about_company_partnerships') }}
                    </p>
                </div>
                <div class="col-lg-6">
                    <div class="bg-light p-4 rounded">
                        <img src="{{ asset('images/about-us.jpg') }}" alt="{{ __('about_us') }}" 
                             class="img-fluid rounded" onerror="this.style.display='none'">
                    </div>
                </div>
            </div>

            <!-- Mission & Vision -->
            <div class="row mb-5">
                <div class="col-lg-6 mb-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <i class="fas fa-bullseye fa-3x text-primary mb-3"></i>
                            <h4 class="mb-3">{{ __('our_vision') }}</h4>
                            <p class="mb-0">
                                {{ __('company_vision') }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <i class="fas fa-flag fa-3x text-primary mb-3"></i>
                            <h4 class="mb-3">{{ __('our_mission') }}</h4>
                            <p class="mb-0">
                                {{ __('company_mission') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Values -->
            <div class="row mb-5">
                <div class="col-12 text-center mb-4">
                    <h3>{{ __('our_values') }}</h3>
                    <p class="lead">{{ __('company_values_title') }}</p>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="text-center">
                        <i class="fas fa-award fa-2x text-primary mb-3"></i>
                        <h5>{{ __('quality') }}</h5>
                        <p class="text-muted">{{ __('value_quality') }}</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="text-center">
                        <i class="fas fa-lightbulb fa-2x text-primary mb-3"></i>
                        <h5>{{ __('innovation') }}</h5>
                        <p class="text-muted">{{ __('value_innovation') }}</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="text-center">
                        <i class="fas fa-handshake fa-2x text-primary mb-3"></i>
                        <h5>{{ __('reliability') }}</h5>
                        <p class="text-muted">{{ __('value_relationships') }}</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="text-center">
                        <i class="fas fa-users fa-2x text-primary mb-3"></i>
                        <h5>{{ __('collaboration') }}</h5>
                        <p class="text-muted">{{ __('value_teamwork') }}</p>
                    </div>
                </div>
            </div>

            <!-- Statistics -->
            <div class="row mb-5">
                <div class="col-12">
                    <div class="bg-primary text-white p-5 rounded">
                        <div class="row text-center">
                            <div class="col-lg-3 col-md-6 mb-4">
                                <div class="counter">
                                    <h2 class="display-4 fw-bold">10+</h2>
                                    <p class="mb-0">{{ __('years_of_experience') }}</p>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-4">
                                <div class="counter">
                                    <h2 class="display-4 fw-bold">500+</h2>
                                    <p class="mb-0">{{ __('satisfied_clients') }}</p>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-4">
                                <div class="counter">
                                    <h2 class="display-4 fw-bold">1000+</h2>
                                    <p class="mb-0">{{ __('completed_projects') }}</p>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-4">
                                <div class="counter">
                                    <h2 class="display-4 fw-bold">24/7</h2>
                                    <p class="mb-0">{{ __('technical_support') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Team -->
            <div class="row mb-5">
                <div class="col-12 text-center mb-4">
                    <h3>{{ __('our_team') }}</h3>
                    <p class="lead">{{ __('team_title') }}</p>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card text-center border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="bg-light rounded-circle mx-auto mb-3 feature-icon">
                                <i class="fas fa-user fa-2x text-primary"></i>
                            </div>
                            <h5>{{ __('sales_team') }}</h5>
                            <p class="text-muted">{{ __('team_sales') }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card text-center border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="bg-light rounded-circle mx-auto mb-3 feature-icon">
                                <i class="fas fa-cogs fa-2x text-primary"></i>
                            </div>
                            <h5>{{ __('technical_team') }}</h5>
                            <p class="text-muted">{{ __('team_technical') }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card text-center border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="bg-light rounded-circle mx-auto mb-3 feature-icon">
                                <i class="fas fa-headset fa-2x text-primary"></i>
                            </div>
                            <h5>{{ __('customer_service') }}</h5>
                            <p class="text-muted">{{ __('team_support') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Certifications -->
            <div class="row">
                <div class="col-12 text-center mb-4">
                    <h3>{{ __('certificates_and_accreditations') }}</h3>
                    <p class="lead">{{ __('certifications_title') }}</p>
                </div>
                <div class="col-12">
                    <div class="row text-center">
                        <div class="col-lg-2 col-md-4 col-6 mb-4">
                            <div class="bg-light p-3 rounded">
                                <i class="fas fa-certificate fa-2x text-primary mb-2"></i>
                                <h6>{{ __('ISO 9001') }}</h6>
                                <small class="text-muted">{{ __('quality_management') }}</small>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-4 col-6 mb-4">
                            <div class="bg-light p-3 rounded">
                                <i class="fas fa-shield-alt fa-2x text-primary mb-2"></i>
                                <h6>{{ __('ISO 14001') }}</h6>
                                <small class="text-muted">{{ __('environmental_management') }}</small>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-4 col-6 mb-4">
                            <div class="bg-light p-3 rounded">
                                <i class="fas fa-user-shield fa-2x text-primary mb-2"></i>
                                <h6>{{ __('OHSAS 18001') }}</h6>
                                <small class="text-muted">{{ __('health_safety') }}</small>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-4 col-6 mb-4">
                            <div class="bg-light p-3 rounded">
                                <i class="fas fa-award fa-2x text-primary mb-2"></i>
                                <h6>{{ __('CE Mark') }}</h6>
                                <small class="text-muted">{{ __('ce_certification') }}</small>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-4 col-6 mb-4">
                            <div class="bg-light p-3 rounded">
                                <i class="fas fa-star fa-2x text-primary mb-2"></i>
                                <h6>{{ __('SASO') }}</h6>
                                <small class="text-muted">{{ __('saso_certification') }}</small>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-4 col-6 mb-4">
                            <div class="bg-light p-3 rounded">
                                <i class="fas fa-check-circle fa-2x text-primary mb-2"></i>
                                <h6>{{ __('UL Listed') }}</h6>
                                <small class="text-muted">{{ __('ul_certification') }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-5 bg-primary text-white">
        <div class="container">
            <div class="row text-center">
                <div class="col-12">
                    <h3 class="mb-4">{{ __('want_to_know_more') }}</h3>
                    <p class="lead mb-4">{{ __('contact_cta') }}</p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{ route('contact') }}" class="btn btn-light btn-lg">
                            <i class="fas fa-phone me-2"></i>{{ __('contact_us') }}
                        </a>
                        <a href="{{ route('products') }}" class="btn btn-outline-light btn-lg">
                            <i class="fas fa-box me-2"></i>{{ __('browse_products') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection