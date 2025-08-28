<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ $directions }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', $settings['site_name'] ?? 'Revira Industrial')</title>
    <meta name="description" content="@yield('description', $settings['site_description'] ?? '')">
    <meta name="keywords" content="@yield('keywords', '')">
    
    <!-- Open Graph -->
    <meta property="og:title" content="@yield('og_title', $settings['site_name'] ?? 'Revira Industrial')">
    <meta property="og:description" content="@yield('og_description', $settings['site_description'] ?? '')">
    <meta property="og:image" content="@yield('og_image', $settings['site_logo'] ?? '')">
    <meta property="og:url" content="{{ url()->current() }}">
    
    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('twitter_title', $settings['site_name'] ?? 'Revira Industrial')">
    <meta name="twitter:description" content="@yield('twitter_description', $settings['site_description'] ?? '')">
    <meta name="twitter:image" content="@yield('twitter_image', $settings['site_logo'] ?? '')">
    
    <!-- Favicon -->
    @if(isset($settings['site_favicon']) && $settings['site_favicon'])
        <link rel="icon" type="image/x-icon" href="{{ $settings['site_favicon'] }}">
    @endif
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Styles -->
    @if($directions === 'rtl')
        <link href="{{ asset('css/bootstrap.rtl.min.css') }}" rel="stylesheet">
    @else
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    @endif
    <link href="{{ asset('css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('css/google-fonts.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    

    
    @yield('styles')
</head>
<body>
    <!-- Header -->
    @include('partials.header')
    
    <!-- Main Content -->
    <main>
        @yield('content')
    </main>
    
    <!-- Footer -->
    @include('partials.footer')
    
    <!-- Scripts -->
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/jquery-3.7.0.min.js') }}"></script>
    
    <!-- Google Analytics -->
    @if(isset($settings['seo_google_analytics']) && $settings['seo_google_analytics'])
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $settings['seo_google_analytics'] }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '{{ $settings["seo_google_analytics"] }}');
        </script>
    @endif
    
    <!-- Facebook Pixel -->
    @if(isset($settings['seo_facebook_pixel']) && $settings['seo_facebook_pixel'])
        <script>
            !function(f,b,e,v,n,t,s)
            {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};
            if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
            n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t,s)}(window, document,'script',
            'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '{{ $settings["seo_facebook_pixel"] }}');
            fbq('track', 'PageView');
        </script>
    @endif
    
    @yield('scripts')
</body>
</html>