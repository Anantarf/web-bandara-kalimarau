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
                        'bg' => 'bg-slate-950 text-slate-100 border-b border-red-500/25 shadow-sm',
                        'pill' => 'bg-red-500/10 text-red-300 border-red-500/25',
                        'label' => 'Darurat',
                        'icon' => 'danger',
                        'link' => 'text-red-300 hover:text-white underline underline-offset-2 decoration-red-400/60 hover:decoration-white',
                    ],
                    'warning' => [
                        'bg' => 'bg-slate-950 text-slate-100 border-b border-amber-500/25 shadow-sm',
                        'pill' => 'bg-amber-500/10 text-amber-300 border-amber-500/25',
                        'label' => 'Peringatan',
                        'icon' => 'warning',
                        'link' => 'text-amber-300 hover:text-white underline underline-offset-2 decoration-amber-400/60 hover:decoration-white',
                    ],
                    default => [
                        'bg' => 'bg-navy-dark text-white border-b border-gold/25 shadow-sm',
                        'pill' => 'bg-gold/10 text-gold-light border-gold/25',
                        'label' => 'Informasi',
                        'icon' => 'info',
                        'link' => 'text-gold-light hover:text-white underline underline-offset-2 decoration-gold/60 hover:decoration-white',
                    ],
                };
            @endphp

            <!-- Top Notification Micro-Strip (Slim, Non-Dominant & Auto-Dismiss) -->
            <div x-data="{
                    dismissed: false,
                    paused: false,
                    duration: 12000,
                    remaining: 12000,
                    timer: null,
                    init() {
                        const interval = 100;
                        this.timer = setInterval(() => {
                            if (!this.paused && !this.dismissed) {
                                this.remaining -= interval;
                                if (this.remaining <= 0) {
                                    this.dismiss();
                                }
                            }
                        }, interval);
                    },
                    dismiss() {
                        this.dismissed = true;
                        if (this.timer) clearInterval(this.timer);
                    }
                 }"
                 x-show="!dismissed"
                 x-cloak
                 @mouseenter="paused = true"
                 @mouseleave="paused = false"
                 x-transition:enter="transition ease-out duration-400"
                 x-transition:enter-start="opacity-0 -translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition-all ease-in-out duration-500 overflow-hidden"
                 x-transition:leave-start="opacity-100 max-h-16 py-1.5"
                 x-transition:leave-end="opacity-0 max-h-0 py-0"
                 class="{{ $topBarConfig['bg'] }} px-3 sm:px-4 py-1 sm:py-1.5 text-xs relative z-40">

                <div class="max-w-7xl mx-auto flex items-center justify-between gap-2.5 sm:gap-3 text-left">
                    <div class="flex items-center gap-2 sm:gap-2.5 flex-1 min-w-0">
                        <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded text-[10px] font-bold tracking-wider border shrink-0 {{ $topBarConfig['pill'] }}" title="{{ $topBarConfig['label'] }}">
                            @if($topBarConfig['icon'] === 'danger')
                                <svg class="w-3 h-3 text-red-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            @elseif($topBarConfig['icon'] === 'warning')
                                <svg class="w-3 h-3 text-amber-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            @else
                                <svg class="w-3 h-3 text-gold-light shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                            @endif
                            <span class="hidden sm:inline uppercase">{{ $topBarConfig['label'] }}</span>
                        </span>

                        <div class="leading-tight text-[11px] sm:text-xs truncate-mobile min-w-0 flex-1">
                            <span class="font-bold mr-1">{{ $announcement->title }}:</span>
                            <span class="opacity-90">{{ $announcement->message }}</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 sm:gap-2.5 shrink-0">
                        @if($announcement->action_label && $announcement->action_url)
                            <a href="{{ $announcement->action_url }}"
                               class="inline-flex items-center gap-1 font-semibold text-[11px] sm:text-xs transition-colors shrink-0 {{ $topBarConfig['link'] }}">
                                <span>{{ $announcement->action_label }}</span>
                                <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        @endif

                        <button @click="dismiss()"
                                type="button"
                                class="p-0.5 rounded text-slate-400 hover:text-white hover:bg-white/10 transition-colors"
                                title="Tutup pemberitahuan"
                                aria-label="Tutup pemberitahuan">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Floating Notification Card / Toast Mode (Option 1: Ramping, Elegan, Auto-Dismiss 8s) -->
            @if($announcement->is_popup && request()->routeIs('home'))
                @php
                    $toastConfig = match($announcement->type) {
                        'danger' => [
                            'border' => 'border-l-4 border-l-red-500',
                            'iconBg' => 'bg-red-50 text-red-600',
                            'bar' => 'bg-red-500',
                            'label' => 'Darurat',
                            'link' => 'text-red-600 hover:text-red-700',
                        ],
                        'warning' => [
                            'border' => 'border-l-4 border-l-amber-500',
                            'iconBg' => 'bg-amber-50 text-amber-700',
                            'bar' => 'bg-amber-500',
                            'label' => 'Perhatian',
                            'link' => 'text-amber-700 hover:text-amber-800',
                        ],
                        default => [
                            'border' => 'border-l-4 border-l-navy',
                            'iconBg' => 'bg-navy/5 text-navy',
                            'bar' => 'bg-navy',
                            'label' => 'Pengumuman',
                            'link' => 'text-navy hover:text-navy-light',
                        ],
                    };
                @endphp

                <div x-data="{
                        showToast: false,
                        paused: false,
                        duration: 8000,
                        remaining: 8000,
                        progress: 100,
                        timer: null,
                        init() {
                            // Muncul perlahan setelah 1.2 detik
                            setTimeout(() => {
                                this.showToast = true;
                                this.startTimer();
                            }, 1200);
                        },
                        startTimer() {
                            const interval = 50;
                            this.timer = setInterval(() => {
                                if (!this.paused && this.showToast) {
                                    this.remaining -= interval;
                                    this.progress = Math.max(0, (this.remaining / this.duration) * 100);
                                    if (this.remaining <= 0) {
                                        this.dismiss();
                                    }
                                }
                            }, interval);
                        },
                        dismiss() {
                            this.showToast = false;
                            clearInterval(this.timer);
                        }
                     }"
                     x-show="showToast"
                     x-cloak
                     @mouseenter="paused = true"
                     @mouseleave="paused = false"
                     @keydown.escape.window="dismiss()"
                     class="fixed top-20 sm:top-24 right-4 sm:right-6 z-40 max-w-sm sm:max-w-md w-[calc(100vw-2rem)] sm:w-auto"
                     x-transition:enter="transition ease-out duration-400"
                     x-transition:enter-start="opacity-0 translate-y-2 sm:translate-y-0 sm:translate-x-8 scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:translate-x-0 scale-100"
                     x-transition:leave="transition ease-in duration-300"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 translate-y-2 sm:translate-y-0 sm:translate-x-8 scale-95">

                    <div class="bg-white/95 backdrop-blur-md rounded-2xl shadow-xl shadow-slate-900/10 border border-slate-200/80 overflow-hidden {{ $toastConfig['border'] }} relative">
                        <div class="p-4 sm:p-4.5">
                            <div class="flex items-start gap-3">
                                <!-- Status Icon -->
                                <div class="w-8 h-8 rounded-xl flex items-center justify-center shrink-0 {{ $toastConfig['iconBg'] }}">
                                    @if($announcement->type === 'danger')
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                    @elseif($announcement->type === 'warning')
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    @else
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                                    @endif
                                </div>

                                <!-- Text Content -->
                                <div class="flex-1 min-w-0 pr-1">
                                    <h4 class="text-xs sm:text-sm font-bold text-navy-dark leading-snug">
                                        {{ $announcement->title }}
                                    </h4>
                                    <p class="text-[11px] sm:text-xs text-slate-600 leading-relaxed mt-1 line-clamp-3 whitespace-pre-line">
                                        {{ $announcement->message }}
                                    </p>

                                    @if($announcement->action_label && $announcement->action_url)
                                        <div class="mt-2.5">
                                            <a href="{{ $announcement->action_url }}"
                                               class="inline-flex items-center gap-1 text-xs font-bold {{ $toastConfig['link'] }} group">
                                                <span>{{ $announcement->action_label }}</span>
                                                <svg class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                            </a>
                                        </div>
                                    @endif
                                </div>

                                <!-- Close Button -->
                                <button @click="dismiss()"
                                        type="button"
                                        class="p-1 rounded-lg text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition-colors shrink-0 -mr-1 -mt-1"
                                        title="Tutup notifikasi"
                                        aria-label="Tutup notifikasi">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </div>
                        </div>

                        <!-- Thin Countdown Progress Indicator -->
                        <div class="h-0.5 w-full bg-slate-100 overflow-hidden">
                            <div class="h-full {{ $toastConfig['bar'] }} transition-all duration-75 ease-linear"
                                 :style="`width: ${progress}%`"></div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
@endif
