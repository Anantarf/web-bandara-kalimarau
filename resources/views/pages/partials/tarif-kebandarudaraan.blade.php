                            <div x-data="{ activeTab: 'aero' }" class="w-full">
                                <p class="text-text-muted mb-8 text-lg leading-relaxed max-w-3xl">
                                    Informasi resmi mengenai rincian tarif pelayanan jasa kebandarudaraan, baik untuk layanan penerbangan (Aeronautika) maupun layanan penunjang non-penerbangan (Non Aeronautika) di UPBU Kelas I Kalimarau.
                                </p>
                                <div class="flex flex-col sm:flex-row p-1.5 bg-gray-100/80 backdrop-blur-sm rounded-2xl mb-8 border border-gray-200">
                                    <button @click="activeTab = 'aero'"
                                            :class="activeTab === 'aero' ? 'bg-white text-navy-dark shadow-sm font-bold border-b-2 border-gold' : 'text-text-muted hover:text-navy hover:bg-gray-200/50 border-b-2 border-transparent'"
                                            class="flex-1 py-3 px-6 rounded-xl text-sm md:text-base font-medium transition-all duration-200 flex items-center justify-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Tarif Aero
                                    </button>
                                    <button @click="activeTab = 'nonaero'"
                                            :class="activeTab === 'nonaero' ? 'bg-white text-navy-dark shadow-sm font-bold border-b-2 border-gold' : 'text-text-muted hover:text-navy hover:bg-gray-200/50 border-b-2 border-transparent'"
                                            class="flex-1 py-3 px-6 rounded-xl text-sm md:text-base font-medium transition-all duration-200 flex items-center justify-center gap-2 mt-1 sm:mt-0 sm:ml-1">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                        Tarif Non Aero
                                    </button>
                                </div>

                                <div class="bg-white rounded-2xl p-6 md:p-8 border border-gray-100 shadow-md shadow-navy-dark/5 relative">
                                    <div x-show="activeTab === 'aero'"
                                         x-transition:enter="transition ease-out duration-500 delay-100"
                                         x-transition:enter-start="opacity-0 translate-y-4"
                                         x-transition:enter-end="opacity-100 translate-y-0"
                                         class="w-full">
                                        <div x-data="{ loaded: false }" class="aspect-[4/3] md:aspect-[16/10] w-full rounded-lg overflow-hidden bg-gray-50 border border-gray-100 shadow-inner relative">
                                            <div x-show="!loaded" class="absolute inset-0 flex items-center justify-center">
                                                <div class="inline-block animate-spin rounded-full h-8 w-8 border-4 border-gold border-t-transparent"></div>
                                            </div>
                                            <iframe src="https://drive.google.com/file/d/1XsuTFf4z0TyGMer01QT4mX6K5LVmr7S5/preview" @load="loaded = true" class="absolute inset-0 w-full h-full border-0 relative z-10" allow="autoplay" allowfullscreen></iframe>
                                        </div>
                                        <a href="https://drive.google.com/file/d/1XsuTFf4z0TyGMer01QT4mX6K5LVmr7S5/view" target="_blank" rel="noopener" class="inline-flex items-center gap-1 mt-3 text-sm text-navy hover:text-gold-dark font-medium">
                                            Dokumen tidak tampil? Buka di tab baru
                                        </a>
                                    </div>

                                    <div x-show="activeTab === 'nonaero'"
                                         style="display: none;"
                                         x-transition:enter="transition ease-out duration-500 delay-100"
                                         x-transition:enter-start="opacity-0 translate-y-4"
                                         x-transition:enter-end="opacity-100 translate-y-0"
                                         class="w-full">
                                        <div x-data="{ loaded: false }" class="aspect-[4/3] md:aspect-[16/10] w-full rounded-lg overflow-hidden bg-gray-50 border border-gray-100 shadow-inner relative">
                                            <div x-show="!loaded" class="absolute inset-0 flex items-center justify-center">
                                                <div class="inline-block animate-spin rounded-full h-8 w-8 border-4 border-gold border-t-transparent"></div>
                                            </div>
                                            <iframe src="https://drive.google.com/file/d/12UDBEDfbWAxBzbsabMvO7wyUjg5luItb/preview" @load="loaded = true" class="absolute inset-0 w-full h-full border-0 relative z-10" allow="autoplay" allowfullscreen></iframe>
                                        </div>
                                        <a href="https://drive.google.com/file/d/12UDBEDfbWAxBzbsabMvO7wyUjg5luItb/view" target="_blank" rel="noopener" class="inline-flex items-center gap-1 mt-3 text-sm text-navy hover:text-gold-dark font-medium">
                                            Dokumen tidak tampil? Buka di tab baru
                                        </a>
                                    </div>
                                </div>
                            </div>
