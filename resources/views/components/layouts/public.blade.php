@props([
    'title' => config('app.name', 'Bandara Kalimarau'),
    'description' => 'Website resmi Bandara Kalimarau, Berau, Kalimantan Timur.',
    'canonical' => url()->current(),
    'image' => asset('images/logo-header.png'),
    'type' => 'website',
    'robots' => null,
    'withHeaderPadding' => true,
    'preloadImage' => null,
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="overflow-x-hidden scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title }}</title>
    <meta name="description" content="{{ $description }}">
    <link rel="canonical" href="{{ $canonical }}">
    @if($preloadImage)
        <link rel="preload" as="image" href="{{ $preloadImage }}" fetchpriority="high">
    @endif

    <meta property="og:type" content="{{ $type }}">
    <meta property="og:title" content="{{ $title }}">
    <meta property="og:description" content="{{ $description }}">
    <meta property="og:url" content="{{ $canonical }}">
    <meta property="og:image" content="{{ $image }}">
    <meta property="og:site_name" content="{{ config('app.name', 'Bandara Kalimarau') }}">
    <meta name="twitter:card" content="summary_large_image">
    @if($robots)
        <meta name="robots" content="{{ $robots }}">
    @endif

    <!-- Local SEO Geo Meta Tags -->
    <meta name="geo.region" content="ID-KI">
    <meta name="geo.placename" content="Kabupaten Berau">
    <meta name="geo.position" content="2.155556;117.433889">
    <meta name="ICBM" content="2.155556, 117.433889">

    <!-- Schema.org Airport Structured Data (Google Knowledge Panel & Travel) -->
    <script type="application/ld+json">{!! json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'Airport',
        'name' => 'Bandar Udara Kalimarau',
        'alternateName' => ['Bandara Kalimarau', 'Kalimarau Airport', 'UPBU Kelas I Kalimarau'],
        'iataCode' => 'BEJ',
        'icaoCode' => 'WAQT',
        'url' => url('/'),
        'logo' => asset('images/logo-blu.png'),
        'image' => asset('images/hero/hero1.jpg'),
        'geo' => [
            '@type' => 'GeoCoordinates',
            'latitude' => 2.155556,
            'longitude' => 117.433889,
        ],
        'address' => [
            '@type' => 'PostalAddress',
            'streetAddress' => 'Jl. Kalimarau, Teluk Bayur',
            'addressLocality' => 'Teluk Bayur',
            'addressRegion' => 'Kabupaten Berau, Kalimantan Timur',
            'postalCode' => '77315',
            'addressCountry' => 'ID',
        ],
        'openingHours' => 'Mo-Su 06:00-18:00',
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>

    <!-- Schema.org GovernmentOrganization Structured Data -->
    <script type="application/ld+json">{!! json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'GovernmentOrganization',
        'name' => 'UPBU Kelas I Kalimarau',
        'alternateName' => 'Kantor UPBU Kelas I Kalimarau Berau',
        'url' => url('/'),
        'logo' => asset('images/logo-blu.png'),
        'address' => [
            '@type' => 'PostalAddress',
            'addressLocality' => 'Teluk Bayur',
            'addressRegion' => 'Kabupaten Berau, Kalimantan Timur',
            'postalCode' => '77315',
            'addressCountry' => 'ID',
        ],
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>

    <!-- Favicon & PWA Manifest -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo-blu.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo-blu.png') }}">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#0c2d6b">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="Kalimarau">

    <!-- Fonts: preconnect + non-blocking stylesheet -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap">

    <!-- Scripts and Styles (Alpine.js bundled via app.css/app.js) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-text-main bg-surface flex flex-col min-h-screen overflow-x-hidden">

    <x-public.header :transparent="! $withHeaderPadding" />

    <main class="flex-grow {{ $withHeaderPadding ? 'pt-20 md:pt-24' : '' }}">
        {{ $slot }}
    </main>

    <x-public.footer />

    <x-public.floating-contact />

</body>
</html>
