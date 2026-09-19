                            <div class="prose prose-lg max-w-none text-text-main
                                        prose-p:leading-relaxed prose-a:text-navy hover:prose-a:text-gold-ink font-medium prose-a:no-underline hover:prose-a:underline
                                        prose-headings:text-navy-dark prose-headings:font-bold
                                        prose-li:marker:text-gold prose-ul:space-y-1">
                                {!! $contentWithIds !!}

                                @if($page->slug === 'profil-bandara-kalimarau')
                                    <div class="mt-8 not-prose">
                                        <x-lightbox-image
                                            src="{{ asset('images/profil-bandara-kalimarau-page-1.jpg') }}"
                                            alt="Profil Bandar Udara Kalimarau"
                                            figure-class="max-w-2xl mx-auto text-center" />
                                    </div>
                                @elseif($page->slug === 'struktur-organisasi')
                                    <x-page-structure-image type="airport" />
                                @elseif($page->slug === 'struktur-organisasi-ppid-pelaksana-upt')
                                    <x-page-structure-image type="ppid" />
                                @endif
                            </div>
