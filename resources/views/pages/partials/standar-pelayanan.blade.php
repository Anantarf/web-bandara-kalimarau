@php
    $documentUrl = asset('storage/media/legacy/2024/09/Standar-Pelayanan-2023.pdf');
@endphp

<div class="w-full max-w-5xl mx-auto">
    <div class="bg-white rounded-xl p-4 md:p-5 border border-border-soft/70 shadow-sm relative">
        <x-pdf-document-viewer :url="$documentUrl" />
    </div>
</div>