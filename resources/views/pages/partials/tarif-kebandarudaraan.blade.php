<div x-data="{ activeTab: 'aero' }" class="w-full max-w-5xl mx-auto">
    <p class="text-text-muted mb-8 text-lg leading-relaxed max-w-3xl">
        Informasi resmi mengenai rincian tarif pelayanan jasa kebandarudaraan, baik untuk layanan penerbangan (Aeronautika) maupun layanan penunjang non-penerbangan (Non Aeronautika) di UPBU Kelas I Kalimarau.
    </p>

    <div class="flex flex-col sm:flex-row p-1.5 bg-surface/80 backdrop-blur-sm rounded-2xl mb-8 border border-border-soft">
        <button @click="activeTab = 'aero'"
                :class="activeTab === 'aero' ? 'bg-white text-navy-dark shadow-sm font-bold border-b-2 border-gold' : 'text-text-muted hover:text-navy hover:bg-border-soft/50 border-b-2 border-transparent'"
                class="flex-1 py-3 px-6 rounded-xl text-sm md:text-base font-medium transition duration-200 flex items-center justify-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            Tarif Aero
        </button>
        <button @click="activeTab = 'nonaero'"
                :class="activeTab === 'nonaero' ? 'bg-white text-navy-dark shadow-sm font-bold border-b-2 border-gold' : 'text-text-muted hover:text-navy hover:bg-border-soft/50 border-b-2 border-transparent'"
                class="flex-1 py-3 px-6 rounded-xl text-sm md:text-base font-medium transition duration-200 flex items-center justify-center gap-2 mt-1 sm:mt-0 sm:ml-1">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a1 1 0 00-1-1H6a1 1 0 00-1 1v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
            Tarif Non Aero
        </button>
    </div>

    <div class="bg-white rounded-xl p-4 md:p-5 border border-border-soft/70 shadow-sm relative">
        <template x-if="activeTab === 'aero'">
            <x-pdf-document-viewer :url="asset('documents/tarif/tarif-aeronautika.pdf')" />
        </template>

        <template x-if="activeTab === 'nonaero'">
            <x-pdf-document-viewer :url="asset('documents/tarif/tarif-non-aeronautika.pdf')" />
        </template>
    </div>
</div>