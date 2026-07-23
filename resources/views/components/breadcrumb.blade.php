@props(['items'])

@php
    $jsonLd = [
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => collect($items)->values()->map(fn ($item, $index) => [
            '@type' => 'ListItem',
            'position' => $index + 1,
            'name' => $item['label'],
            'item' => $item['url'] ?? url()->current(),
        ])->all(),
    ];
@endphp

<script type="application/ld+json">{!! json_encode($jsonLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>

<nav class="text-sm" aria-label="Breadcrumb">
    <ol class="list-none p-0 inline-flex flex-wrap">
        @foreach($items as $item)
            <li class="flex items-center">
                @if($loop->last)
                    <span class="text-gray-800 font-medium {{ $item['class'] ?? '' }}" aria-current="page">{{ $item['label'] }}</span>
                @elseif(!empty($item['url']))
                    <a href="{{ $item['url'] }}" class="text-gray-600 hover:text-navy transition-colors">{{ $item['label'] }}</a>
                @else
                    <span class="text-gray-800 font-medium">{{ $item['label'] }}</span>
                @endif
                @unless($loop->last)
                    <svg class="fill-current w-3 h-3 mx-2 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"/></svg>
                @endunless
            </li>
        @endforeach
    </ol>
</nav>
