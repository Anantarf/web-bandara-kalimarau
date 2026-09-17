@props([
    'breadcrumbs' => [],
    'title',
    'description' => null,
    'containerClass' => 'max-w-7xl mx-auto px-4 lg:px-6',
    'align' => 'left',
    'headerClass' => 'py-6 md:py-8 bg-white',
    'border' => false,
    'loadedDelay' => 100,
])

@php
    $isCentered = $align === 'center';
@endphp

@if($breadcrumbs)
    <div class="bg-surface py-4 sm:py-6 border-b border-border-soft">
        <div class="{{ $containerClass }}">
            <x-breadcrumb :items="$breadcrumbs" />
        </div>
    </div>
@endif

<section class="{{ $headerClass }} {{ $border ? 'border-b border-border-soft/70' : '' }}" x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, {{ $loadedDelay }})">
    <div class="{{ $containerClass }} {{ $isCentered ? 'text-center' : 'text-center md:text-left' }}">
        <h1 x-show="loaded"
            x-transition:enter="transition ease-out duration-500 delay-100"
            x-transition:enter-start="opacity-0 translate-y-8"
            x-transition:enter-end="opacity-100 translate-y-0"

            class="font-sans text-2xl md:text-3xl font-extrabold text-navy-dark leading-snug mb-3 {{ $isCentered ? 'mx-auto' : '' }}">{{ $title }}</h1>

        <div x-show="loaded"
             x-transition:enter="transition ease-out duration-500 delay-200"
             x-transition:enter-start="opacity-0 scale-0"
             x-transition:enter-end="opacity-100 scale-100"

             class="h-1.5 w-20 bg-gold-light rounded-full mb-6 {{ $isCentered ? 'mx-auto' : 'mx-auto md:mx-0 origin-left' }}"></div>

        @if($description)
            <p x-show="loaded"
               x-transition:enter="transition ease-out duration-500 delay-200"
               x-transition:enter-start="opacity-0 translate-y-4"
               x-transition:enter-end="opacity-100 translate-y-0"

               class="text-base md:text-lg text-text-muted text-pretty max-w-2xl {{ $isCentered ? 'mx-auto' : 'mx-auto md:mx-0' }}">{{ $description }}</p>
        @endif

        {{ $slot }}
    </div>
</section>