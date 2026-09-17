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
                $bgClass = match($announcement->type) {
                    'warning' => 'bg-amber-500 text-slate-950 border-b border-amber-600',
                    'danger' => 'bg-red-600 text-white border-b border-red-700',
                    default => 'bg-navy-dark text-white border-b border-gold/40',
                };

                $badgeClass = match($announcement->type) {
                    'warning' => 'bg-black/15 text-slate-900',
                    'danger' => 'bg-white/20 text-white',
                    default => 'bg-gold/20 text-gold-light border border-gold/30',
                };

                $btnClass = match($announcement->type) {
                    'warning' => 'bg-slate-900 text-white hover:bg-slate-800',
                    'danger' => 'bg-white text-red-700 hover:bg-red-50',
                    default => 'bg-gold text-navy-dark hover:bg-gold-light font-semibold',
                };
            @endphp

            <!-- Top Notification Bar -->
            <div x-data="{
                    dismissed: sessionStorage.getItem('announcement_dismissed_{{ $announcement->id }}') === 'true',
                    dismiss() {
                        this.dismissed = true;
                        sessionStorage.setItem('announcement_dismissed_{{ $announcement->id }}', 'true');
                    }
                 }"
                 x-show="!dismissed"
                 x-cloak
                 x-transition:leave="transition ease-in duration-300"
                 x-transition:leave-start="opacity-100 max-h-40"
                 x-transition:leave-end="opacity-0 max-h-0 py-0"
                 class="{{ $bgClass }} px-4 py-2.5 shadow-sm text-sm relative">

                <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-3 text-center sm:text-left">
                    <div class="flex items-center gap-3 flex-1 min-w-0">
                        <!-- Icon -->
                        <span class="flex-shrink-0 inline-flex items-center justify-center p-1 rounded-full {{ $badgeClass }}">
                            @if($announcement->type === 'danger')
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            @elseif($announcement->type === 'warning')
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            @else
                                <svg class="w-4 h-4 text-gold-light" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                            @endif
                        </span>

                        <!-- Message Content -->
                        <div class="leading-snug text-xs sm:text-sm">
                            <strong class="font-bold mr-1">{{ $announcement->title }}:</strong>
                            <span>{{ $announcement->message }}</span>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center gap-2 flex-shrink-0">
                        @if($announcement->action_label && $announcement->action_url)
                            <a href="{{ $announcement->action_url }}"
                               class="px-3 py-1 text-xs rounded-lg transition-all duration-200 shadow-sm {{ $btnClass }}">
                                {{ $announcement->action_label }}
                            </a>
                        @endif

                        <button @click="dismiss()"
                                type="button"
                                class="p-1 rounded-md opacity-75 hover:opacity-100 transition-opacity"
                                title="Tutup pemberitahuan"
                                aria-label="Tutup pemberitahuan">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Optional Modal Pop-up Mode -->
            @if($announcement->is_popup)
                <div x-data="{
                        popupDismissed: sessionStorage.getItem('announcement_popup_dismissed_{{ $announcement->id }}') === 'true',
                        dismissPopup() {
                            this.popupDismissed = true;
                            sessionStorage.setItem('announcement_popup_dismissed_{{ $announcement->id }}', 'true');
                        }
                     }"
                     x-show="!popupDismissed"
                     x-cloak
                     class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-navy-dark/60 backdrop-blur-sm"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0">

                    <div @click.away="dismissPopup()"
                         class="bg-white rounded-2xl shadow-2xl max-w-lg w-full overflow-hidden border border-gray-100 transform transition-all"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="scale-95 opacity-0"
                         x-transition:enter-end="scale-100 opacity-100">

                        <!-- Modal Header -->
                        <div class="{{ $announcement->type === 'danger' ? 'bg-red-600 text-white' : ($announcement->type === 'warning' ? 'bg-amber-500 text-slate-900' : 'bg-navy-dark text-white') }} px-6 py-4 flex items-center justify-between">
                            <div class="flex items-center gap-2.5">
                                <span class="p-1.5 rounded-full {{ $announcement->type === 'danger' ? 'bg-white/20' : ($announcement->type === 'warning' ? 'bg-black/15' : 'bg-gold/20 text-gold-light') }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                                </span>
                                <h3 class="font-bold text-base md:text-lg">{{ $announcement->title }}</h3>
                            </div>
                            <button @click="dismissPopup()" class="opacity-70 hover:opacity-100 transition p-1">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>

                        <!-- Modal Body -->
                        <div class="p-6">
                            <div class="text-gray-600 text-sm md:text-base leading-relaxed mb-6 whitespace-pre-line">
                                {{ $announcement->message }}
                            </div>

                            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                                <button @click="dismissPopup()"
                                        type="button"
                                        class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-800 bg-gray-100 hover:bg-gray-200 rounded-xl transition">
                                    Tutup
                                </button>
                                @if($announcement->action_label && $announcement->action_url)
                                    <a href="{{ $announcement->action_url }}"
                                       class="px-5 py-2 text-sm font-semibold rounded-xl transition shadow-md {{ $btnClass }}">
                                        {{ $announcement->action_label }}
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
