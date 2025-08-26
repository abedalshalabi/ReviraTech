@extends('layouts.app')

@section('title', __('agents') . ' - ' . ($settings['site_name'] ?? 'Revira Industrial'))
@section('description', __('agents_description'))

@section('content')
    <!-- Page Header -->
    <section class="text-white py-5" style="background: var(--gradient-primary);">
        <div class="container section-top-padding">
            <div class="row">
                <div class="col-12 text-center">
                    <h1 class="display-4 fw-bold">{{ __('our_agents') }}</h1>
<p class="lead">{{ __('agents_intro') }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Agents Grid -->
    <section class="py-5">
        <div class="container">
            @if($agents->count() > 0)
                <div class="row">
                    @foreach($agents as $agent)
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card h-100 shadow-sm">
                                @if($agent->logo)
                                    <div class="card-body text-center">
                                        <img src="{{ $agent->logo }}" alt="{{ $agent->company_name }}" 
                                             class="img-fluid mb-3 agent-index-logo">
                                    </div>
                                @endif
                                <div class="card-body">
                                    <h5 class="card-title text-center">{{ $agent->company_name }}</h5>
                                    @if($agent->description)
                                        <p class="card-text text-center">{{ $agent->description }}</p>
                                    @endif
                                    
                                    <div class="text-center">
                                        @if($agent->phone)
                                            <p class="mb-2">
                                                <i class="fas fa-phone me-2 text-primary"></i>
                                                <a href="tel:{{ $agent->phone }}" class="text-decoration-none">
                                                    {{ $agent->phone }}
                                                </a>
                                            </p>
                                        @endif
                                        
                                        @if($agent->email)
                                            <p class="mb-2">
                                                <i class="fas fa-envelope me-2 text-primary"></i>
                                                <a href="mailto:{{ $agent->email }}" class="text-decoration-none">
                                                    {{ $agent->email }}
                                                </a>
                                            </p>
                                        @endif
                                        
                                        @if($agent->website)
                                            <p class="mb-3">
                                                <i class="fas fa-globe me-2 text-primary"></i>
                                                <a href="{{ $agent->website }}" target="_blank" class="text-decoration-none">
                                                    {{ __('website') }}
                                                </a>
                                            </p>
                                        @endif
                                        
                                        @if($agent->full_address)
                                            <p class="mb-3">
                                                <i class="fas fa-map-marker-alt me-2 text-primary"></i>
                                                <small class="text-muted">{{ $agent->full_address }}</small>
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="row">
                    <div class="col-12 text-center">
                        <div class="py-5">
                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                            <h3 class="text-muted">{{ __('no_agents_found') }}</h3>
<p class="text-muted">{{ __('agents_coming_soon') }}</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>

    <!-- Contact CTA -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h3 class="mb-4">{{ __('become_agent_title') }}</h3>
<p class="lead mb-4">{{ __('become_agent_description') }}</p>
                    <a href="{{ route('contact') }}" class="btn btn-primary btn-lg">
                        {{ __('contact_us') }}
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection