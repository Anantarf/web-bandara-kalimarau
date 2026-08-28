                            <div class="prose prose-lg prose-blue text-gray-800
                                        prose-p:leading-relaxed prose-a:text-sky prose-a:no-underline hover:prose-a:underline
                                        prose-headings:text-navy-dark prose-headings:font-bold
                                        prose-li:marker:text-gold prose-ul:space-y-1">
                                {!! $contentWithIds !!}

                                @if($page->slug === 'struktur-organisasi')
                                    <x-page-structure-image type="airport" />
                                @elseif($page->slug === 'struktur-organisasi-ppid-pelaksana-upt')
                                    <x-page-structure-image type="ppid" />
                                @endif
                            </div>
