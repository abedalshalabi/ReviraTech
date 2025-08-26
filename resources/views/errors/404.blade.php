@extends('layouts.app')

@section('title', __('page_not_found') . ' - ' . ($settings['site_name'] ?? 'Revira Industrial'))

@section('content')
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 text-center">
                    <div class="error-page">
                        <h1 class="display-1 text-muted">404</h1>
                        <h2 class="mb-4">{{ __('page_not_found_title') }}</h2>
<p class="lead mb-4">{{ __('page_not_found_message') }}</p>
                        
                        <div class="d-flex justify-content-center gap-3 mb-4">
                            <a href="{{ route('home') }}" class="btn btn-primary">
                                <i class="fas fa-home me-2"></i>{{ __('back_to_home') }}
                            </a>
                            <a href="{{ route('products') }}" class="btn btn-outline-primary">
                                <i class="fas fa-box me-2"></i>{{ __('browse_products') }}
                            </a>
                        </div>
                        
                        <div class="search-box">
                            <h5 class="mb-3">{{ __('search_our_site') }}</h5>
                            <form action="{{ route('products') }}" method="GET" class="d-flex">
                                <input type="text" name="search" class="form-control me-2" 
                                       placeholder="{{ __('search_products_placeholder') }}">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i>
                                </button>
                            </form>
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
    
    .search-box {
        max-width: 400px;
        margin: 0 auto;
    }
</style>
@endsection