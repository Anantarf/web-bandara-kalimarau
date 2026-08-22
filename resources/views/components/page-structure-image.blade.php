@props([
    'type',
    'showHeading' => true,
])

@php
    $items = [
        'airport' => [
            'heading' => 'Struktur Organisasi Bandara Kalimarau',
            'id' => 'struktur-organisasi-bandara-kalimarau',
            'description' => null,
            'src' => asset('images/struktur-organisasi.jpg'),
            'alt' => 'Struktur Organisasi Bandara Kalimarau',
            'headingClass' => 'mt-10 mb-6 border-b border-gray-100',
        ],
        'ppid' => [
            'heading' => 'Struktur Organisasi PPID',
            'id' => 'struktur-ppid',
            'description' => 'Berikut adalah bagan susunan Struktur Organisasi Pejabat Pengelola Informasi dan Dokumentasi (PPID) pada Badan Layanan Umum (BLU) Kantor Unit Penyelenggara Bandar Udara Kelas I Kalimarau.',
            'src' => asset('images/ppid/struktur-ppid.jpeg'),
            'alt' => 'Struktur Organisasi PPID BLU Bandara Kalimarau',
            'headingClass' => 'mt-12 mb-4 border-b-2 border-gray-100',
        ],
    ];

    $item = $items[$type] ?? null;
@endphp

@if($item)
    @if($showHeading)
        <h2 id="{{ $item['id'] }}" class="text-2xl font-extrabold leading-tight text-navy-dark not-prose scroll-mt-32 pb-2 {{ $item['headingClass'] }}">
            {{ $item['heading'] }}
        </h2>
    @endif

    @if($item['description'])
        <p class="not-prose text-base md:text-lg leading-relaxed text-gray-700 mt-4 mb-6">
            {{ $item['description'] }}
        </p>
    @endif

    <x-lightbox-image
        :src="$item['src']"
        :alt="$item['alt']"
        figure-class="not-prose" />
@endif
