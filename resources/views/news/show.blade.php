@extends('layouts.app')

@section('title', $news->title . ' - ' . ($settings['site_name'] ?? 'Revira Industrial'))
@section('description', $news->excerpt)
@section('keywords', $news->meta_keywords)

@section('content')
    <!-- Article Header -->
    <section class="py-5">
        <div class="container">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ \App\Helpers\LanguageHelper::getLocalizedUrl('home') }}">{{ __('home') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ \App\Helpers\LanguageHelper::getLocalizedUrl('news') }}">{{ __('news') }}</a></li>
                    <li class="breadcrumb-item active">{{ $news->title }}</li>
                </ol>
            </nav>

            <div class="row">
                <div class="col-lg-8 pe-lg-4">
                    <!-- Article Image -->
                    @if($news->image)
                        <img src="{{ $news->image }}" class="img-fluid rounded mb-4" 
                             alt="{{ $news->title }}" class="news-detail-img">
                    @endif

                    <!-- Article Content -->
                    <article>
                        <h1 class="mb-3">{{ $news->title }}</h1>
                        
                        <!-- Article Meta -->
                        <div class="d-flex flex-wrap gap-3 mb-4 text-muted">
                            <small>
                                <i class="fas fa-calendar me-1"></i>
                                {{ $news->published_at->format('Y-m-d') }}
                            </small>
                            @if($news->author)
                                <small>
                                    <i class="fas fa-user me-1"></i>
                                    {{ $news->author }}
                                </small>
                            @endif
                            @if($news->source)
                                <small>
                                    <i class="fas fa-link me-1"></i>
                                    @if($news->source_url)
                                        <a href="{{ $news->source_url }}" target="_blank" class="text-decoration-none">
                                            {{ $news->source }}
                                        </a>
                                    @else
                                        {{ $news->source }}
                                    @endif
                                </small>
                            @endif
                            <small>
                                <i class="fas fa-eye me-1"></i>
                                {{ $news->views_count }} {{ __('views') }}
                            </small>
                        </div>

                        <!-- Tags -->
                        @if($news->tags)
                            <div class="mb-4">
                                @foreach($news->tags as $tag)
                                    <span class="badge bg-secondary me-1">{{ $tag }}</span>
                                @endforeach
                            </div>
                        @endif

                        <!-- Article Body -->
                        <div class="article-content">
                            {!! $news->content !!}
                        </div>

                        <!-- Share Buttons -->
                        <div class="mt-5 pt-4 border-top">
                            <h6 class="mb-3">{{ __('share_article') }}:</h6>
                            <div class="d-flex gap-2">
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" 
                                   target="_blank" class="btn btn-outline-primary">
                                    <i class="fab fa-facebook me-2"></i>Facebook
                                </a>
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($news->title) }}" 
                                   target="_blank" class="btn btn-outline-info">
                                    <i class="fab fa-twitter me-2"></i>Twitter
                                </a>
                                <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}" 
                                   target="_blank" class="btn btn-outline-primary">
                                    <i class="fab fa-linkedin me-2"></i>LinkedIn
                                </a>
                                <a href="mailto:?subject={{ urlencode($news->title) }}&body={{ urlencode(url()->current()) }}" 
                                   class="btn btn-outline-secondary">
                                    <i class="fas fa-envelope me-2"></i>Email
                                </a>
                            </div>
                        </div>
                    </article>
                </div>

                <!-- Enhanced Sidebar -->
                <div class="col-lg-4 ps-lg-4">
                    <!-- Article Quick Info -->
                    {{-- <div class="card mb-4 border-0 shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>{{ __('article_info') }}</h6>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-6">
                                    <div class="border-end">
                                        <h5 class="text-primary mb-1">{{ $news->views_count }}</h5>
                                        <small class="text-muted">{{ __('views') }}</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <h5 class="text-success mb-1">{{ $news->published_at->diffForHumans() }}</h5>
                                    <small class="text-muted">{{ __('published') }}</small>
                                </div>
                            </div>
                            @if($news->author)
                                <hr class="my-3">
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                        <i class="fas fa-user text-white"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">{{ $news->author }}</h6>
                                        <small class="text-muted">{{ __('author') }}</small>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div> --}}

                    {{-- <!-- Quick Share -->
                    <div class="card mb-4 border-0 shadow-sm">
                        <div class="card-header bg-success text-white">
                            <h6 class="mb-0"><i class="fas fa-share-alt me-2"></i>{{ __('quick_share') }}</h6>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" 
                                   target="_blank" class="btn btn-outline-primary btn-sm">
                                    <i class="fab fa-facebook me-2"></i>Facebook
                                </a>
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($news->title) }}" 
                                   target="_blank" class="btn btn-outline-info btn-sm">
                                    <i class="fab fa-twitter me-2"></i>Twitter
                                </a>
                                <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}" 
                                   target="_blank" class="btn btn-outline-primary btn-sm">
                                    <i class="fab fa-linkedin me-2"></i>LinkedIn
                                </a>
                                <button class="btn btn-outline-secondary btn-sm" onclick="copyToClipboard('{{ url()->current() }}')">
                                    <i class="fas fa-copy me-2"></i>{{ __('copy_link') }}
                                </button>
                            </div>
                        </div>
                    </div> --}}

                    <!-- Related News -->
                    @if($relatedNews->count() > 0)
                        <div class="card mb-4 border-0 shadow-sm">
                            <div class="card-header bg-warning text-dark">
                                <h6 class="mb-0"><i class="fas fa-newspaper me-2"></i>{{ __('related_news') }}</h6>
                            </div>
                            <div class="card-body p-0">
                                @foreach($relatedNews as $index => $relatedArticle)
                                    <div class="p-3 {{ $index < count($relatedNews) - 1 ? 'border-bottom' : '' }} hover-bg-light transition-all">
                                        <div class="d-flex">
                                            @if($relatedArticle->image)
                                                <div class="position-relative me-3">
                                                    <img src="{{ $relatedArticle->image }}" 
                                                         class="rounded news-thumb-enhanced shadow-sm">
                                                    <div class="position-absolute top-0 start-0 bg-primary text-white px-2 py-1 rounded-bottom-end" style="font-size: 0.7rem;">
                                                        {{ $loop->iteration }}
                                                    </div>
                                                </div>
                                            @else
                                                <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center news-thumb-enhanced">
                                                    <i class="fas fa-image text-muted"></i>
                                                </div>
                                            @endif
                                            <div class="flex-grow-1">
                                                <h6 class="mb-2 line-clamp-2">
                                                    <a href="{{ \App\Helpers\LanguageHelper::getLocalizedUrl('news.show', ['slug' => $relatedArticle->slug]) }}" 
                                                   class="text-decoration-none text-dark hover-text-primary">
                                                        {{ $relatedArticle->title }}
                                                    </a>
                                                </h6>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <small class="text-muted">
                                                        <i class="fas fa-calendar-alt me-1"></i>
                                                        {{ $relatedArticle->published_at->format('M d, Y') }}
                                                    </small>
                                                    <small class="text-primary">
                                                        <i class="fas fa-eye me-1"></i>{{ $relatedArticle->views_count ?? 0 }}
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Latest News -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-info text-white">
                            <h6 class="mb-0"><i class="fas fa-clock me-2"></i>{{ __('latest_news') }}</h6>
                        </div>
                        <div class="card-body p-0">
                            @php
                                $latestNews = \App\Models\News::active()->published()
                                    ->where('id', '!=', $news->id)
                                    ->orderBy('published_at', 'desc')
                                    ->limit(5)
                                    ->get();
                            @endphp
                            
                            @foreach($latestNews as $index => $latestArticle)
                                <div class="p-3 {{ $index < count($latestNews) - 1 ? 'border-bottom' : '' }} hover-bg-light transition-all">
                                    <div class="d-flex">
                                        @if($latestArticle->image)
                                            <div class="position-relative me-3">
                                                <img src="{{ $latestArticle->image }}" 
                                                     class="rounded news-thumb-enhanced shadow-sm">
                                                <div class="position-absolute top-0 end-0 bg-success text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 20px; height: 20px; font-size: 0.7rem;">
                                                    <i class="fas fa-star"></i>
                                                </div>
                                            </div>
                                        @else
                                            <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center news-thumb-enhanced">
                                                <i class="fas fa-image text-muted"></i>
                                            </div>
                                        @endif
                                        <div class="flex-grow-1">
                                            <h6 class="mb-2 line-clamp-2">
                                                <a href="{{ \App\Helpers\LanguageHelper::getLocalizedUrl('news.show', ['slug' => $latestArticle->slug]) }}" 
                                               class="text-decoration-none text-dark hover-text-primary">
                                                    {{ $latestArticle->title }}
                                                </a>
                                            </h6>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <small class="text-muted">
                                                    <i class="fas fa-calendar-alt me-1"></i>
                                                    {{ $latestArticle->published_at->format('M d, Y') }}
                                                </small>
                                                <span class="badge bg-light text-dark">
                                                    {{ $latestArticle->published_at->diffForHumans() }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            
                            <div class="p-3 text-center border-top bg-light">
                                <a href="{{ \App\Helpers\LanguageHelper::getLocalizedUrl('news') }}" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-arrow-right me-2"></i>{{ __('view_all_news') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('styles')
<style>
    .article-content {
        line-height: 1.8;
        font-size: 1.1rem;
    }
    
    .article-content h2, .article-content h3, .article-content h4 {
        margin-top: 2rem;
        margin-bottom: 1rem;
    }
    
    .article-content p {
        margin-bottom: 1.5rem;
    }
    
    .article-content img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin: 1rem 0;
    }
    
    .article-content blockquote {
        border-left: 4px solid #007bff;
        padding-left: 1rem;
        margin: 1.5rem 0;
        font-style: italic;
        color: #666;
    }
</style>
@endsection

@section('scripts')
<script>
function copyToClipboard(text) {
    if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(text).then(function() {
            showCopySuccess();
        }, function(err) {
            fallbackCopyTextToClipboard(text);
        });
    } else {
        fallbackCopyTextToClipboard(text);
    }
}

function fallbackCopyTextToClipboard(text) {
    var textArea = document.createElement("textarea");
    textArea.value = text;
    textArea.style.top = "0";
    textArea.style.left = "0";
    textArea.style.position = "fixed";
    document.body.appendChild(textArea);
    textArea.focus();
    textArea.select();
    
    try {
        var successful = document.execCommand('copy');
        if (successful) {
            showCopySuccess();
        } else {
            showCopyError();
        }
    } catch (err) {
        showCopyError();
    }
    
    document.body.removeChild(textArea);
}

function showCopySuccess() {
    // Create a temporary toast notification
    var toast = document.createElement('div');
    toast.className = 'alert alert-success position-fixed';
    toast.style.top = '20px';
    toast.style.right = '20px';
    toast.style.zIndex = '9999';
    toast.style.minWidth = '250px';
    toast.innerHTML = '<i class="fas fa-check me-2"></i>{{ __('copy_link') }} {{ __('success') }}!';
    
    document.body.appendChild(toast);
    
    setTimeout(function() {
        toast.remove();
    }, 3000);
}

function showCopyError() {
    var toast = document.createElement('div');
    toast.className = 'alert alert-danger position-fixed';
    toast.style.top = '20px';
    toast.style.right = '20px';
    toast.style.zIndex = '9999';
    toast.style.minWidth = '250px';
    toast.innerHTML = '<i class="fas fa-times me-2"></i>{{ __('copy_failed') }}';
    
    document.body.appendChild(toast);
    
    setTimeout(function() {
        toast.remove();
    }, 3000);
}
</script>
@endsection