@extends('layouts.app')

@section('title', __('products') . ' - ' . ($settings['site_name'] ?? 'Revira Industrial'))
@section('description', __('products_description'))

@section('content')
    <!-- Page Header -->
    <section class="text-white py-5" style="background: var(--gradient-primary);">
        <div class="container section-top-padding">
            <div class="row">
                <div class="col-12">
                    <h1 class="display-4 fw-bold">{{ __('products') }}</h1>
<p class="lead">{{ __('products_intro') }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Filters and Search -->
    <section class="py-4 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-4 mb-3 pe-4">
                    <div class="sidebar-filters sticky-top shadow-sm border rounded p-3 bg-white">
                    <form action="{{ route('products') }}" method="GET" id="filterForm">
                        <!-- Search -->
                        <div class="mb-3">
                            <label for="search" class="form-label">{{ __('search') }}</label>
                            <input type="text" class="form-control" id="search" name="search" 
                                   value="{{ request('search') }}" placeholder="{{ __('search_products_placeholder') }}">
                        </div>

                        <!-- Category Filter -->
                        <div class="mb-3">
                            <label for="category" class="form-label">{{ __('category') }}</label>
                            <select class="form-select" id="category" name="category">
                                <option value="">{{ __('all_categories') }}</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->slug }}" {{ request('category') == $category->slug ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                    @foreach($category->children as $subCategory)
                                        <option value="{{ $subCategory->slug }}" {{ request('category') == $subCategory->slug ? 'selected' : '' }}>
                                            -- {{ $subCategory->name }}
                                        </option>
                                    @endforeach
                                @endforeach
                            </select>
                        </div>

                        <!-- Price Range -->
                        <div class="mb-3">
                            <label class="form-label">{{ __('price_range') }}</label>
                            <div class="row">
                                <div class="col-6">
                                    <input type="number" class="form-control" name="min_price" 
                                           placeholder="{{ __('from') }}" value="{{ request('min_price') }}">
                                </div>
                                <div class="col-6">
                                    <input type="number" class="form-control" name="max_price" 
                                           placeholder="{{ __('to') }}" value="{{ request('max_price') }}">
                                </div>
                            </div>
                        </div>

                        <!-- Sort -->
                        <div class="mb-3">
                            <label for="sort" class="form-label">{{ __('sort') }}</label>
                            <select class="form-select" id="sort" name="sort">
                                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>{{ __('newest') }}</option>
<option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>{{ __('price_low') }}</option>
<option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>{{ __('price_high') }}</option>
<option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>{{ __('name') }}</option>
<option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>{{ __('most_popular') }}</option>
                            </select>
                        </div>



                        <button type="submit" class="btn btn-primary w-100 mb-2">
                            <i class="fas fa-filter me-2"></i>{{ __('apply_filter') }}
                        </button>
                        
                        <a href="{{ route('products') }}" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-times me-2"></i>{{ __('reset') }}
                        </a>
                    </form>
                    </div>
                </div>

                <!-- Products Grid -->
                <div class="col-lg-9 col-md-8">
                    @if($products->count() > 0)
                        <!-- Results Info -->
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <p class="mb-0">
                                {{ __('showing') }} {{ $products->firstItem() }} {{ __('to') }} {{ $products->lastItem() }}
{{ __('of') }} {{ $products->total() }} {{ __('results') }}
                            </p>
                        </div>

                        <!-- Products -->
                        <div class="row">
                            @foreach($products as $product)
                                <div class="col-lg-4 col-md-6 mb-4">
                                    <div class="card product-card h-100">
                                        @if($product->image)
                                            <img src="{{ $product->image }}" 
                                            
                                                 class="card-img-top" alt="{{ $product->name }}" loading="lazy">
                                        @else
                                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center product-card-placeholder">
                                                <i class="fas fa-image fa-3x text-muted"></i>
                                            </div>
                                        @endif
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $product->name }}</h5>
                                            <p class="card-text">{{ $product->short_description }}</p>
                                            
                                            @if($product->price)
                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <span class="h5 mb-0">{{ number_format($product->final_price) }} {{ currency_symbol() }}</span>
                                                    @if($product->is_on_sale)
                                                        <span class="badge bg-danger">{{ $product->discount_percentage }}% خصم</span>
                                                    @endif
                                                </div>
                                            @endif
                                            
                                            <div class="d-flex gap-2">
                                                <a href="{{ \App\Helpers\LanguageHelper::getLocalizedUrl('product.show', ['slug' => $product->slug]) }}" 
                                                   class="btn btn-primary flex-fill">
                                                    {{ __('view_details') }}
                                                </a>
                                                <button class="btn btn-outline-primary" 
                                                        onclick="requestQuote('{{ $product->id }}')">
                                                    <i class="fas fa-quote-right"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center">
                            {{ $products->appends(request()->query())->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                            <h3 class="text-muted">{{ __('no_products_found') }}</h3>
<p class="text-muted">{{ __('try_different_filters') }}</p>
                            <a href="{{ route('products') }}" class="btn btn-primary">
                                {{ __('view_all_products') }}
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
<script>
    // Auto-submit form when filters change
    document.querySelectorAll('#filterForm select, #filterForm input[type="radio"]').forEach(function(element) {
        element.addEventListener('change', function() {
            document.getElementById('filterForm').submit();
        });
    });

    // Request quote function
    function requestQuote(productId) {
        // Redirect to contact page with product info
        window.location.href = '{{ route("contact") }}?product=' + productId;
    }
</script>
@endsection