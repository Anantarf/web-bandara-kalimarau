@props([
    'value',
    'label',
])

<div class="py-4 md:py-0 flex flex-col items-center">
    <div class="mb-5 flex justify-center">
        {{ $slot }}
    </div>
    <div class="text-4xl font-bold text-navy mb-2 tabular-nums stat-counter" data-target="{{ $value }}">0</div>
    <div class="text-text-muted font-medium uppercase tracking-wide text-sm">{{ $label }}</div>
</div>