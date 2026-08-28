@props([
    'breadcrumbs' => [],
    'title',
    'description' => null,
    'containerClass' => 'max-w-7xl mx-auto px-4 lg:px-6',
    'align' => 'left',
    'headerClass' => 'pt-12 pb-12 bg-white',
    'border' => false,
    'loadedDelay' => 100,
])

@php
    $isCentered = $align === 'center';
@endphp

@if($breadcrumbs)
    <div class="bg-gray-50 py-4 sm:py-6 border-b border-gray-200">
        <div class="{{ $containerClass }}">
            <x-breadcrumb :items="$breadcrumbs" />
        </div>
    </div>
@endif

<section class="{{ $headerClass }} {{ $border ? 'border-b border-gray-100' : '' }}" x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, {{ $loadedDelay }})">
    <div class="{{ $containerClass }} {{ $isCentered ? 'text-center' : 'text-center md:text-left' }}">
        <h1 x-show="loaded"
            x-transition:enter="transition-all ease-out duration-500 delay-100"
            x-transition:enter-start="opacity-0 translate-y-8"
            x-transition:enter-end="opacity-100 translate-y-0"
            style="display: none;"
            class="font-sans text-3xl md:text-5xl font-extrabold text-navy-dark leading-tight mb-6 {{ $isCentered ? 'mx-auto' : '' }}">{{ $title }}</h1>

        <div x-show="loaded"
             x-transition:enter="transition-all ease-out duration-500 delay-200"
             x-transition:enter-start="opacity-0 scale-0"
             x-transition:enter-end="opacity-100 scale-100"
             style="display: none;"
             class="h-1.5 w-20 bg-gold-light rounded-full mb-6 {{ $isCentered ? 'mx-auto' : 'mx-auto md:mx-0 origin-left' }}"></div>

        @if($description)
            <p x-show="loaded"
               x-transition:enter="transition-all ease-out duration-500 delay-200"
               x-transition:enter-start="opacity-0 translate-y-4"
               x-transition:enter-end="opacity-100 translate-y-0"
               style="display: none;"
               class="text-lg text-text-muted text-pretty max-w-3xl {{ $isCentered ? 'mx-auto' : 'mx-auto md:mx-0' }}">{{ $description }}</p>
        @endif

        {{ $slot }}
    </div>
</section>