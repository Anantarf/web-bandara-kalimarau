                            <p class="text-text-muted mb-8 text-lg leading-relaxed max-w-3xl">
                                Dokumen resmi mengenai pedoman operasional, tolak ukur jaminan mutu, serta prosedur standar pelayanan publik yang diselenggarakan oleh Kantor BLU UPBU Kelas I Kalimarau demi kepuasan dan kenyamanan seluruh pengguna jasa bandar udara.
                            </p>
                            <div class="bg-white rounded-2xl p-6 md:p-8 border border-gray-100 shadow-md shadow-navy-dark/5 relative w-full mb-12">
                                <div x-data="{ loaded: false }" class="aspect-[4/3] md:aspect-[16/10] w-full rounded-lg overflow-hidden bg-gray-50 border border-gray-100 shadow-inner relative">
                                    <div x-show="!loaded" class="absolute inset-0 flex items-center justify-center">
                                        <div class="inline-block animate-spin rounded-full h-8 w-8 border-4 border-gold border-t-transparent"></div>
                                    </div>
                                    <iframe src="https://docs.google.com/viewer?url={{ urlencode(asset('storage/media/legacy/2024/09/Standar-Pelayanan-2023.pdf')) }}&embedded=true" @load="loaded = true" class="absolute inset-0 w-full h-full border-0 relative z-10" allowfullscreen></iframe>
                                </div>
                                <a href="{{ asset('storage/media/legacy/2024/09/Standar-Pelayanan-2023.pdf') }}" target="_blank" rel="noopener" class="inline-flex items-center gap-1 mt-3 text-sm text-navy hover:text-gold-dark font-medium">
                                    Dokumen tidak tampil? Buka di tab baru
                                </a>
                            </div>
