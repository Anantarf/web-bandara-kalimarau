                            @php
                                preg_match('/href=["\']([^"\']+\.pdf[^"\']*)["\']/i', $page->content, $pdfMatch);
                                $standardBiayaUrl = $pdfMatch[1] ?? asset('storage/media/legacy/2024/09/Standar-Pelayanan-2023.pdf');
                            @endphp

                            <!-- Section 1: Maklumat Pelayanan -->
                            <div class="mb-12">
                                <h3 id="maklumat-pelayanan" class="text-2xl font-extrabold leading-tight text-navy-dark border-b border-gray-100 pb-2 mb-6 scroll-mt-32">Maklumat Pelayanan</h3>
                                <x-lightbox-image
                                    src="{{ asset('images/ppid/maklumat-ppid-page-1.jpg') }}"
                                    alt="Maklumat Pelayanan PPID Bandar Udara Kalimarau"
                                    figure-class="not-prose max-w-2xl mx-auto" />
                            </div>

                            <!-- Section 2: Standar Biaya -->
                            <div class="mt-16">
                                <h3 id="standar-biaya" class="text-2xl font-extrabold leading-tight text-navy-dark border-b border-gray-100 pb-2 mb-6 scroll-mt-32">Standar Biaya</h3>
                                <x-lightbox-image
                                    src="{{ asset('images/ppid/standar-biaya-page-1.jpg') }}"
                                    alt="Standar Biaya Layanan Informasi PPID Bandar Udara Kalimarau"
                                    figure-class="not-prose max-w-2xl mx-auto" />
                            </div>
