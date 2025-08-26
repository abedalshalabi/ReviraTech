@extends('layouts.app')

@section('title', __('server_error') . ' - ' . ($settings['site_name'] ?? 'Revira Industrial'))

@section('content')
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 text-center">
                    <div class="error-page">
                        <h1 class="display-1 text-muted">500</h1>
                        <h2 class="mb-4">{{ __('server_error_title') }}</h2>
<p class="lead mb-4">{{ __('server_error_message') }}</p>
                        
                        <div class="d-flex justify-content-center gap-3 mb-4">
                            <a href="{{ route('home') }}" class="btn btn-primary">
                                <i class="fas fa-home me-2"></i>{{ __('back_to_home') }}
                            </a>
                            <a href="{{ route('contact') }}" class="btn btn-outline-primary">
                                <i class="fas fa-phone me-2"></i>{{ __('contact_us') }}
                            </a>
                        </div>
                        
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            {{ __('support_team_message') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('styles')
<style>
    .error-page {
        padding: 3rem 0;
    }
    
    .error-page .display-1 {
        font-size: 8rem;
        font-weight: 300;
        color: #e9ecef;
    }
</style>
@endsection