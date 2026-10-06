@php
    $activeAnnouncements = \App\Models\Announcement::active()
        ->orderBy('sort_order')
        ->orderByDesc('id')
        ->get();
@endphp

@if($activeAnnouncements->isNotEmpty())
    <div class="relative z-50">
        @foreach($activeAnnouncements as $announcement)
            @php
                $topBarConfig = match($announcement->type) {
                    'danger' => [
                        'bg' => 'bg-red-700 text-white border-b border-red-800 shadow-sm',
                        'pill' => 'bg-white/15 text-white border-white/20',
                        'dot' => 'bg-white',
                        'label' => 'Darurat',
                        'btn' => 'bg-white text-red-700 hover:bg-red-50 font-bold',
                    ],
                    'warning' => [
                        'bg' => 'bg-gradient-to-r from-amber-600 via-amber-500 to-amber-600 text-slate-950 border-b border-amber-600/80 shadow-sm',
                        'pill' => 'bg-black/15 text-slate-950 font-semibold border-black/10',
                        'dot' => 'bg-slate-950',
                        'label' => 'Peringatan',
                        'btn' => 'bg-slate-900 text-white hover:bg-slate-800 font-bold',
                    ],
                    default => [
                        'bg' => 'bg-gradient-to-r from-navy-dark via-navy to-navy-dark text-white border-b border-gold/30 shadow-sm',
                        'pill' => 'bg-gold/15 text-gold-light border-gold/30',
                        'dot' => 'bg-gold-light',
                        'label' => 'Pengumuman Resmi',
                        'btn' => 'bg-gold hover:bg-gold-light text-navy-dark font-bold shadow-sm',
                    ],
                };
            @endphp

            <!-- Top Notification Bar -->
            <div x-data="{
                    dismissed: false,
                    dismiss() {
                        this.dismissed = true;
                    }
                 }"
                 x-show="!dismissed"
                 x-cloak
                 x-transition:enter="transition ease-out duration-400"
                 x-transition:enter-start="opacity-0 -translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-300"
                 x-transition:leave-start="opacity-100 max-h-40"
                 x-transition:leave-end="opacity-0 max-h-0 py-0"
                 class="{{ $topBarConfig['bg'] }} px-4 py-2.5 text-sm relative z-40">

                <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-3 text-center sm:text-left">
                    <div class="flex items-center gap-2.5 sm:gap-3 flex-1 min-w-0">
                        <!-- Subtle Pill Badge -->
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-bold uppercase tracking-wider border shrink-0 {{ $topBarConfig['pill'] }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $topBarConfig['dot'] }}"></span>
                            {{ $topBarConfig['label'] }}
                        </span>

                        <!-- Message Content -->
                        <div class="leading-snug text-xs sm:text-sm">
                            <span class="font-bold mr-1">{{ $announcement->title }}:</span>
                            <span class="opacity-95">{{ $announcement->message }}</span>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center gap-2.5 shrink-0">
                        @if($announcement->action_label && $announcement->action_url)
                            <a href="{{ $announcement->action_url }}"
                               class="px-3.5 py-1 text-xs rounded-full transition-all duration-200 shadow-sm hover:scale-[1.02] {{ $topBarConfig['btn'] }}">
                                {{ $announcement->action_label }}
                            </a>
                        @endif

                        <button @click="dismiss()"
                                type="button"
                                class="p-1 rounded-full opacity-70 hover:opacity-100 hover:bg-white/10 transition-all"
                                title="Tutup pemberitahuan"
                                aria-label="Tutup pemberitahuan">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Optional Modal Pop-up Mode (Ditampilkan di Beranda & Muncul Lagi saat Refresh) -->
            @if($announcement->is_popup && request()->routeIs('home'))
                @php
                    $modalTypeConfig = match($announcement->type) {
                        'danger' => [
                            'label' => 'Pemberitahuan Darurat',
                            'badge' => 'bg-red-50 text-red-800 border-red-200/80',
                            'dot' => 'bg-red-600',
                            'line' => 'bg-red-500',
                            'topBar' => 'bg-red-500',
                            'primaryBtn' => 'bg-red-600 hover:bg-red-700 text-white shadow-sm',
                        ],
                        'warning' => [
                            'label' => 'Peringatan Operasional',
                            'badge' => 'bg-amber-50 text-amber-900 border-amber-200/80',
                            'dot' => 'bg-amber-600',
                            'line' => 'bg-gold-dark',
                            'topBar' => 'bg-amber-500',
                            'primaryBtn' => 'bg-amber-600 hover:bg-amber-700 text-white shadow-sm',
                        ],
                        default => [
                            'label' => 'Informasi Resmi',
                            'badge' => 'bg-navy/5 text-navy-dark border-navy/15',
                            'dot' => 'bg-gold',
                            'line' => 'bg-gold-light',
                            'topBar' => 'bg-gradient-to-r from-navy via-navy-light to-gold',
                            'primaryBtn' => 'bg-navy hover:bg-navy-dark text-white shadow-sm',
                        ],
                    };
                @endphp

                <div x-data="{
                        showModal: false,
                        init() {
                            // Jeda 700ms agar halaman utama ter-render stabil terlebih dahulu
                            setTimeout(() => {
                                this.showModal = true;
                            }, 700);

                            this.$watch('showModal', value => {
                                if (value) {
                                    document.body.classList.add('overflow-hidden');
                                } else {
                                    document.body.classList.remove('overflow-hidden');
                                }
                            });
                        },
                        dismissPopup() {
                            this.showModal = false;
                            document.body.classList.remove('overflow-hidden');
                        }
                     }"
                     x-show="showModal"
                     @keydown.escape.window="dismissPopup()"
                     x-cloak
                     class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6 bg-navy-dark/45 backdrop-blur-sm"
                     x-transition:enter="transition ease-out duration-400"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0">

                    <div @click.away="dismissPopup()"
                         class="bg-white rounded-2xl md:rounded-3xl shadow-2xl max-w-lg w-full overflow-hidden border border-slate-100 transform transition-all relative"
                         x-transition:enter="transition ease-out duration-400 delay-100"
                         x-transition:enter-start="scale-[0.95] translate-y-3 opacity-0"
                         x-transition:enter-end="scale-100 translate-y-0 opacity-100"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="scale-100 opacity-100"
                         x-transition:leave-end="scale-[0.96] opacity-0">

                        <!-- Top Subtle Accent Bar -->
                        <div class="h-1.5 w-full {{ $modalTypeConfig['topBar'] }}"></div>

                        <div class="p-6 sm:p-7">
                            <!-- Header Row: Category Badge + Dismiss Button -->
                            <div class="flex items-center justify-between gap-3 mb-4">
                                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold border {{ $modalTypeConfig['badge'] }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $modalTypeConfig['dot'] }}"></span>
                                    <span>{{ $modalTypeConfig['label'] }}</span>
                                    <span class="text-slate-300 font-normal">|</span>
                                    <span class="text-slate-500 font-medium">Bandara Kalimarau</span>
                                </div>

                                <button @click="dismissPopup()"
                                        type="button"
                                        class="w-8 h-8 rounded-full flex items-center justify-center text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition-colors"
                                        title="Tutup pengumuman"
                                        aria-label="Tutup pengumuman">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </div>

                            <!-- Title & Golden Line Accent -->
                            <div class="mb-4">
                                <h3 class="font-sans text-lg sm:text-xl font-extrabold text-navy-dark leading-snug tracking-tight mb-2.5">
                                    {{ $announcement->title }}
                                </h3>
                                <div class="h-1 w-12 {{ $modalTypeConfig['line'] }} rounded-full"></div>
                            </div>

                            <!-- Body Message Content -->
                            <div class="bg-slate-50/80 rounded-xl p-4 sm:p-5 border border-slate-100 mb-6">
                                <p class="text-slate-700 text-sm sm:text-[15px] leading-relaxed whitespace-pre-line">
                                    {{ $announcement->message }}
                                </p>
                            </div>

                            <!-- Footer Action Buttons -->
                            <div class="flex items-center justify-end gap-3 pt-1">
                                <button @click="dismissPopup()"
                                        type="button"
                                        class="px-4 py-2.5 text-xs sm:text-sm font-semibold text-slate-600 hover:text-slate-900 hover:bg-slate-100 rounded-xl transition duration-150">
                                    Tutup
                                </button>

                                @if($announcement->action_label && $announcement->action_url)
                                    <a href="{{ $announcement->action_url }}"
                                       class="inline-flex items-center gap-1.5 px-5 py-2.5 text-xs sm:text-sm font-bold rounded-xl transition-all duration-200 {{ $modalTypeConfig['primaryBtn'] }}">
                                        <span>{{ $announcement->action_label }}</span>
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
@endif
