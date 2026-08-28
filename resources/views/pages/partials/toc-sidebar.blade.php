                    @if($showToc)
                        <div class="hidden lg:block lg:w-1/4 relative">
                            <div class="sticky top-32 bg-gray-100/80 backdrop-blur-sm rounded-2xl p-6 border border-gray-200 shadow-sm lg:-mt-2">
                                <h4 class="text-sm font-bold text-navy-dark uppercase tracking-wide mb-4">Daftar Isi</h4>
                                <ul class="space-y-3 text-sm">
                                    @foreach($headings as $heading)
                                        <li>
                                            <a href="#{{ $heading['id'] }}"
                                               class="block transition-colors duration-200 hover:text-gold"
                                               :class="activeSection === '{{ $heading['id'] }}' ? 'text-gold font-bold translate-x-1' : 'text-text-muted'">
                                                {{ $heading['text'] }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
