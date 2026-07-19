@props([
    'title' => config('app.name', 'Bandara Kalimarau'),
    'description' => 'Website resmi Bandara Kalimarau, Berau, Kalimantan Timur.',
    'canonical' => url()->current(),
    'image' => asset('images/logo-header.png'),
    'type' => 'website',
    'robots' => null,
    'withHeaderPadding' => true,
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

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo-blu.png') }}">

    <!-- Scripts and Styles (fonts + Alpine.js bundled via app.css/app.js) -->
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
