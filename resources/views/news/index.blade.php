@extends('layouts.app')

@section('title', __('news') . ' - ' . ($settings['site_name'] ?? 'Revira Industrial'))
@section('description', __('news_description'))

@section('content')
    <!-- Page Header -->
    <section class="text-white py-5" style="background: var(--gradient-primary);">
        <div class="container section-top-padding">
            <div class="row">
                <div class="col-12">
                    <h1 class="display-4 fw-bold">{{ __('news') }}</h1>
<p class="lead">{{ __('news_intro') }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- News Grid -->
    <section class="py-5">
        <div class="container">
            @if($news->count() > 0)
                <div class="row">
                    @foreach($news as $article)
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card h-100 shadow-sm">
                                @if($article->image)
                                    <img src="{{ $article->image }}" class="card-img-top" 
                                         alt="{{ $article->title }}" class="news-index-img">
                                @endif
                                <div class="card-body">
                                    <h5 class="card-title">{{ $article->title }}</h5>
                                    <p class="card-text">{{ $article->excerpt }}</p>
                                    
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <small class="text-muted">
                                            <i class="fas fa-calendar me-1"></i>
                                            {{ $article->published_at->format('Y-m-d') }}
                                        </small>
                                        @if($article->author)
                                            <small class="text-muted">
                                                <i class="fas fa-user me-1"></i>
                                                {{ $article->author }}
                                            </small>
                                        @endif
                                    </div>
                                    
                                    @if($article->tags)
                                        <div class="mb-3">
                                            @foreach($article->tags as $tag)
                                                <span class="badge bg-secondary me-1">{{ $tag }}</span>
                                            @endforeach
                                        </div>
                                    @endif
                                    
                                    <a href="{{ \App\Helpers\LanguageHelper::getLocalizedUrl('news.show', ['slug' => $article->slug]) }}" class="btn btn-primary">
                                        {{ __('read_more') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $news->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                    <h3 class="text-muted">{{ __('no_news_found') }}</h3>
<p class="text-muted">{{ __('news_coming_soon') }}</p>
                </div>
            @endif
        </div>
    </section>
@endsection