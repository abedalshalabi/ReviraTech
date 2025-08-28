@extends('layouts.app')

@section('title', $product->name . ' - ' . ($settings['site_name'] ?? 'Revira Industrial'))
@section('description', $product->short_description)
@section('keywords', is_array($product->getTranslation('meta_keywords', app()->getLocale())) ? implode(', ', $product->getTranslation('meta_keywords', app()->getLocale())) : $product->getTranslation('meta_keywords', app()->getLocale()))

@section('content')
    <!-- Product Details -->
    <section class="py-5">
        <div class="container">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ \App\Helpers\LanguageHelper::getLocalizedUrl('home') }}">{{ __('home') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ \App\Helpers\LanguageHelper::getLocalizedUrl('products') }}">{{ __('products') }}</a></li>
                    @if($product->category)
                        <li class="breadcrumb-item">
                            <a href="{{ \App\Helpers\LanguageHelper::getLocalizedUrl('products', ['category' => $product->category->slug]) }}">
                                {{ $product->category->name }}
                            </a>
                        </li>
                    @endif
                    <li class="breadcrumb-item active">{{ $product->name }}</li>
                </ol>
            </nav>

            <div class="row">
                <!-- Product Images -->
                <div class="col-lg-6 mb-4">
                    <div class="product-gallery">
                        @if(count($product->images) > 0)
                            <!-- Main Image Display -->
                            <div class="main-image-container mb-3 position-relative d-flex align-items-center justify-content-center" style="height: 400px; background: #f8f9fa; border-radius: 8px;">
                                <img id="mainProductImage" 
                                     src="{{ $product->images[0]['url'] }}" 
                                     class="img-fluid rounded shadow-sm main-product-image" 
                                     alt="{{ $product->images[0]['alt'] }}"
                                     style="max-height: 100%; max-width: 100%; object-fit: contain; cursor: zoom-in;">
                                
                                <!-- Zoom Lens -->
                                <div id="zoomLens" class="zoom-lens" style="display: none;"></div>
                                
                                <!-- Zoom Result -->
                                <div id="zoomResult" class="zoom-result" style="display: none;"></div>
                            </div>
                            
                            <!-- Thumbnail Gallery -->
                            @if(count($product->images) > 1)
                                <div class="thumbnail-gallery">
                                    <div class="row g-0">
                                        @foreach($product->images as $index => $image)
                                            <div class="col-2">
                                                <img src="{{ $image['thumb'] }}" 
                                                     class="img-fluid thumbnail-image rounded {{ $index === 0 ? 'active' : '' }}" 
                                                     alt="{{ $image['alt'] }}"
                                                     data-main-src="{{ $image['url'] }}"
                                                     style="height: 80px; object-fit: cover; cursor: pointer; border: 2px solid {{ $index === 0 ? 'var(--bs-primary)' : 'transparent' }};">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center product-detail-placeholder rounded" style="height: 400px;">
                                <i class="fas fa-image fa-3x text-muted"></i>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Product Info -->
                <div class="col-lg-6">
                    <h1 class="mb-3">{{ $product->name }}</h1>
                    
                    @if($product->short_description)
                        <p class="lead mb-4">{{ $product->short_description }}</p>
                    @endif

                    <!-- Price -->
                    @if($product->price)
                        <div class="mb-4">
                            @if($product->is_on_sale)
                                <div class="d-flex align-items-center gap-3">
                                    <span class="h3 text-danger mb-0">{{ number_format($product->sale_price) }} {{ currency_symbol() }}</span>
                            <span class="h5 text-muted text-decoration-line-through">{{ number_format($product->price) }} {{ currency_symbol() }}</span>
                                    <span class="badge bg-danger fs-6">{{ $product->discount_percentage }}% خصم</span>
                                </div>
                            @else
                                <span class="h3 text-primary mb-0">{{ number_format($product->price) }} {{ currency_symbol() }}</span>
                            @endif
                        </div>
                    @endif

                    <!-- Product Meta -->
                    <div class="row mb-4">
                        @if($product->sku)
                            <div class="col-6">
                                <strong>{{ __('product_code') }}:</strong> {{ $product->sku }}
                            </div>
                        @endif
                        @if($product->model)
                            <div class="col-6">
                                <strong>{{ __('model') }}:</strong> {{ $product->model }}
                            </div>
                        @endif
                        @if($product->brand)
                            <div class="col-6">
                                <strong>{{ __('brand') }}:</strong> {{ $product->brand }}
                            </div>
                        @endif
                        @if($product->country_of_origin)
                            <div class="col-6">
                                <strong>{{ __('country_of_origin') }}:</strong> {{ $product->country_of_origin }}
                            </div>
                        @endif
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex gap-3 mb-4">
                        <a href="{{ \App\Helpers\LanguageHelper::getLocalizedUrl('contact') }}?product={{ $product->id }}" class="btn btn-primary btn-lg flex-fill">
                            <i class="fas fa-quote-right me-2"></i>{{ __('request_quote') }}
                        </a>
                        @if($product->catalog_url)
                            <a href="{{ $product->catalog_url }}" class="btn btn-outline-primary" target="_blank">
                                <i class="fas fa-download me-2"></i>{{ __('download_catalog') }}
                            </a>
                        @endif
                    </div>

                    <!-- Share -->
                    <div class="d-flex gap-2">
                        <span class="text-muted">{{ __('share_product') }}:</span>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" 
                           target="_blank" class="text-decoration-none">
                            <i class="fab fa-facebook fa-lg text-primary"></i>
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($product->name) }}" 
                           target="_blank" class="text-decoration-none">
                            <i class="fab fa-twitter fa-lg text-info"></i>
                        </a>
                        <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}" 
                           target="_blank" class="text-decoration-none">
                            <i class="fab fa-linkedin fa-lg text-primary"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Product Tabs -->
            <div class="row mt-5">
                <div class="col-12">
                    <ul class="nav nav-tabs" id="productTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="description-tab" data-bs-toggle="tab" 
                                    data-bs-target="#description" type="button" role="tab">
                                {{ __('description') }}
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="specifications-tab" data-bs-toggle="tab" 
                                    data-bs-target="#specifications" type="button" role="tab">
                                {{ __('specifications') }}
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="features-tab" data-bs-toggle="tab" 
                                    data-bs-target="#features" type="button" role="tab">
                                {{ __('features') }}
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="applications-tab" data-bs-toggle="tab" 
                                    data-bs-target="#applications" type="button" role="tab">
                                {{ __('applications') }}
                            </button>
                        </li>
                        @if($product->video_url)
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="video-tab" data-bs-toggle="tab" 
                                        data-bs-target="#video" type="button" role="tab">
                                    {{ __('video') }}
                                </button>
                            </li>
                        @endif
                        @if($product->warranty)
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="warranty-tab" data-bs-toggle="tab" 
                                        data-bs-target="#warranty" type="button" role="tab">
                                    {{ __('warranty') }}
                                </button>
                            </li>
                        @endif
                    </ul>

                    <div class="tab-content" id="productTabsContent">
                        <!-- Description -->
                        <div class="tab-pane fade show active" id="description" role="tabpanel">
                            <div class="p-4">
                                {!! $product->description !!}
                            </div>
                        </div>

                        <!-- Specifications -->
                        <div class="tab-pane fade" id="specifications" role="tabpanel">
                            <div class="p-4">
                                @php
                                    $specifications = $product->getTranslation('technical_specifications', app()->getLocale());
                                    if (is_string($specifications)) {
                                        // Handle comma-separated key:value pairs
                                        $specs = [];
                                        if (!empty($specifications)) {
                                            $pairs = array_filter(array_map('trim', explode(',', $specifications)));
                                            foreach ($pairs as $pair) {
                                                if (strpos($pair, ':') !== false) {
                                                    list($key, $value) = array_map('trim', explode(':', $pair, 2));
                                                    $specs[$key] = $value;
                                                }
                                            }
                                        }
                                        $specifications = $specs;
                                    }
                                @endphp
                                @if($specifications && count($specifications) > 0)
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <tbody>
                                                @foreach($specifications as $key => $value)
                                                    <tr>
                                                        <th>{{ $key }}</th>
                                                        <td>{{ $value }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <p class="text-muted">{{ __('no_specifications_available') }}</p>
                                @endif
                            </div>
                        </div>

                        <!-- Features -->
                        <div class="tab-pane fade" id="features" role="tabpanel">
                            <div class="p-4">
                                @php
                                    $features = $product->getTranslation('features', app()->getLocale());
                                    if (is_string($features)) {
                                        $features = array_filter(array_map('trim', explode(',', $features)));
                                    }
                                @endphp
                                @if($features && count($features) > 0)
                                    <ul class="list-unstyled">
                                        @foreach($features as $feature)
                                            <li class="mb-2">
                                                <i class="fas fa-check text-success me-2"></i>{{ $feature }}
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="text-muted">{{ __('no_features_available') }}</p>
                                @endif
                            </div>
                        </div>

                        <!-- Applications -->
                        <div class="tab-pane fade" id="applications" role="tabpanel">
                            <div class="p-4">
                                @php
                                    $applications = $product->getTranslation('applications', app()->getLocale());
                                    if (is_string($applications)) {
                                        $applications = array_filter(array_map('trim', explode(',', $applications)));
                                    }
                                @endphp
                                @if($applications && count($applications) > 0)
                                    <ul class="list-unstyled">
                                        @foreach($applications as $application)
                                            <li class="mb-2">
                                                <i class="fas fa-industry text-primary me-2"></i>{{ $application }}
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="text-muted">{{ __('no_applications_available') }}</p>
                                @endif
                            </div>
                        </div>

                        <!-- Video -->
                        @if($product->video_url)
                            <div class="tab-pane fade" id="video" role="tabpanel">
                                <div class="p-4">
                                    <div class="ratio ratio-16x9">
                                        <iframe src="{{ $product->video_url }}" 
                                                title="{{ $product->name }}" 
                                                frameborder="0" 
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                                allowfullscreen></iframe>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Warranty -->
                        @if($product->warranty)
                            <div class="tab-pane fade" id="warranty" role="tabpanel">
                                <div class="p-4">
                                    <div class="alert alert-info">
                                        <i class="fas fa-shield-alt me-2"></i>
                                        {{ $product->warranty }}
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
        <section class="py-5 bg-light">
            <div class="container">
                <h3 class="mb-4">{{ __('similar_products') }}</h3>
                <div class="row">
                    @foreach($relatedProducts as $relatedProduct)
                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="card product-card h-100">
                                @if($relatedProduct->getFirstMediaUrl('images'))
                                    <img src="{{ $relatedProduct->getFirstMediaUrl('images') }}" 
                                         class="card-img-top" alt="{{ $relatedProduct->name }}" loading="lazy">
                                @endif
                                <div class="card-body">
                                    <h5 class="card-title">{{ $relatedProduct->name }}</h5>
                                    <p class="card-text">{{ $relatedProduct->short_description }}</p>
                                    @if($relatedProduct->price)
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <span class="h6 mb-0">{{ number_format($relatedProduct->final_price) }} {{ currency_symbol() }}</span>
                                            @if($relatedProduct->is_on_sale)
                                                <span class="badge bg-danger">{{ $relatedProduct->discount_percentage }}% خصم</span>
                                            @endif
                                        </div>
                                    @endif
                                    <a href="{{ \App\Helpers\LanguageHelper::getLocalizedUrl('product.show', ['slug' => $relatedProduct->slug]) }}" class="btn btn-primary w-100">
                                        {{ __('view_details') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection

@section('styles')
<style>
    .main-image-container {
        border: 1px solid #e9ecef;
    }
    
    .zoom-lens {
        position: absolute;
        border: 2px solid #007bff;
        border-radius: 50%;
        width: 80px;
        height: 80px;
        pointer-events: none;
        background: rgba(0, 123, 255, 0.1);
        backdrop-filter: blur(1px);
    }
    
    .zoom-result {
        position: absolute;
        top: 0;
        right: -320px;
        width: 300px;
        height: 400px;
        border: 1px solid #ddd;
        border-radius: 8px;
        background: white;
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        overflow: hidden;
        z-index: 1000;
    }
    
    .thumbnail-image {
        transition: all 0.3s ease;
        border-radius: 6px;
    }
    
    .thumbnail-image:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    
    .thumbnail-image.active {
        border-color: var(--bs-primary) !important;
        box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.25);
        transform: scale(1.02);
    }
    
    .main-product-image {
        transition: transform 0.3s ease;
    }
    
    .main-product-image:hover {
        transform: scale(1.02);
    }
    
    @media (max-width: 768px) {
        .zoom-result {
            display: none !important;
        }
        
        .main-image-container {
            height: 300px !important;
        }
    }
</style>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        let zoomActive = false;
        
        // Thumbnail gallery functionality
        $('.thumbnail-image').on('click', function() {
            const mainSrc = $(this).data('main-src');
            const alt = $(this).attr('alt');
            
            // Update main image
            $('#mainProductImage').attr('src', mainSrc).attr('alt', alt);
            
            // Update active thumbnail
            $('.thumbnail-image').removeClass('active').css('border-color', 'transparent');
            $(this).addClass('active').css('border-color', 'var(--bs-primary)');
        });
        
        // Zoom lens functionality
        const mainImage = $('#mainProductImage');
        const zoomLens = $('#zoomLens');
        const zoomResult = $('#zoomResult');
        
        mainImage.on('mouseenter', function() {
            if (window.innerWidth > 768) {
                zoomActive = true;
                zoomLens.show();
                zoomResult.show();
                initializeZoom();
            }
        });
        
        mainImage.on('mouseleave', function() {
            zoomActive = false;
            zoomLens.hide();
            zoomResult.hide();
        });
        
        mainImage.on('mousemove', function(e) {
            if (zoomActive && window.innerWidth > 768) {
                updateZoom(e);
            }
        });
        
        function initializeZoom() {
            const imgSrc = mainImage.attr('src');
            const container = mainImage.parent();
            const imgElement = mainImage[0];
            
            // Calculate actual image dimensions within the container
            const containerWidth = container.width();
            const containerHeight = container.height();
            const imgNaturalWidth = imgElement.naturalWidth;
            const imgNaturalHeight = imgElement.naturalHeight;
            
            // Calculate the displayed image size (object-fit: contain)
            const containerRatio = containerWidth / containerHeight;
            const imageRatio = imgNaturalWidth / imgNaturalHeight;
            
            let displayWidth, displayHeight;
            if (imageRatio > containerRatio) {
                displayWidth = containerWidth;
                displayHeight = containerWidth / imageRatio;
            } else {
                displayHeight = containerHeight;
                displayWidth = containerHeight * imageRatio;
            }
            
            zoomResult.css({
                'background-image': 'url(' + imgSrc + ')',
                'background-size': (displayWidth * 2.5) + 'px ' + (displayHeight * 2.5) + 'px',
                'background-repeat': 'no-repeat'
            });
        }
        
        function updateZoom(e) {
            const container = mainImage.parent();
            const containerRect = container[0].getBoundingClientRect();
            const imgElement = mainImage[0];
            
            // Calculate actual image dimensions within the container
            const containerWidth = container.width();
            const containerHeight = container.height();
            const imgNaturalWidth = imgElement.naturalWidth;
            const imgNaturalHeight = imgElement.naturalHeight;
            
            // Calculate the displayed image size and position
            const containerRatio = containerWidth / containerHeight;
            const imageRatio = imgNaturalWidth / imgNaturalHeight;
            
            let displayWidth, displayHeight, offsetX, offsetY;
            if (imageRatio > containerRatio) {
                displayWidth = containerWidth;
                displayHeight = containerWidth / imageRatio;
                offsetX = 0;
                offsetY = (containerHeight - displayHeight) / 2;
            } else {
                displayHeight = containerHeight;
                displayWidth = containerHeight * imageRatio;
                offsetX = (containerWidth - displayWidth) / 2;
                offsetY = 0;
            }
            
            const x = e.clientX - containerRect.left - offsetX;
            const y = e.clientY - containerRect.top - offsetY;
            
            // Only show zoom if cursor is over the actual image
            if (x >= 0 && x <= displayWidth && y >= 0 && y <= displayHeight) {
                zoomLens.show();
                zoomResult.show();
                
                // Position the lens
                const lensX = x - zoomLens.width() / 2 + offsetX;
                const lensY = y - zoomLens.height() / 2 + offsetY;
                
                // Keep lens within container boundaries
                const maxX = containerWidth - zoomLens.width();
                const maxY = containerHeight - zoomLens.height();
                
                const boundedX = Math.max(0, Math.min(lensX, maxX));
                const boundedY = Math.max(0, Math.min(lensY, maxY));
                
                zoomLens.css({
                    left: boundedX + 'px',
                    top: boundedY + 'px'
                });
                
                // Calculate the correct background position for zoom result
                // Convert mouse position to percentage of displayed image
                const xPercent = x / displayWidth;
                const yPercent = y / displayHeight;
                
                // Calculate background position based on the zoomed image size
                const zoomFactor = 2.5;
                const bgX = -(xPercent * displayWidth * zoomFactor - zoomResult.width() / 2);
                const bgY = -(yPercent * displayHeight * zoomFactor - zoomResult.height() / 2);
                
                zoomResult.css({
                    'background-position': bgX + 'px ' + bgY + 'px'
                });
            } else {
                zoomLens.hide();
                zoomResult.hide();
            }
        }
        
        // Modal zoom for mobile and click
        mainImage.on('click', function() {
            const modal = $('<div class="modal fade" tabindex="-1">' +
                '<div class="modal-dialog modal-lg modal-dialog-centered">' +
                '<div class="modal-content">' +
                '<div class="modal-header">' +
                '<h5 class="modal-title">' + $(this).attr('alt') + '</h5>' +
                '<button type="button" class="btn-close" data-bs-dismiss="modal"></button>' +
                '</div>' +
                '<div class="modal-body p-0">' +
                '<img src="' + $(this).attr('src') + '" class="img-fluid w-100">' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</div>');
            
            $('body').append(modal);
            modal.modal('show');
            
            modal.on('hidden.bs.modal', function() {
                modal.remove();
            });
        });
    });
</script>
@endsection