@php
    $waNumber = '6285262146214';
    $waMessage = rawurlencode('Halo, saya ingin menanyakan informasi mengenai Bandara Kalimarau.');
@endphp
<div class="fixed bottom-6 right-6 z-50 flex flex-col items-end gap-3"
     x-data="{ open: false, showHint: false, hasUnread: !sessionStorage.getItem('kalimarau_chat_opened') }"
     x-init="if (!sessionStorage.getItem('kalimarau_hint_shown_v2')) {
         setTimeout(() => { showHint = true; sessionStorage.setItem('kalimarau_hint_shown_v2', '1') }, 2000);
         setTimeout(() => { showHint = false }, 12000);
     }">
    <!-- Popup card -->
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 translate-y-4 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-4 scale-95"
         class="bg-white rounded-3xl shadow-2xl border border-border-soft w-[calc(100vw-3rem)] max-w-[340px] overflow-hidden"
         style="display: none;">
        
        <!-- Header -->
        <div class="relative p-6 pb-7 bg-navy text-white overflow-hidden">
            <!-- Decorative circles -->
            <div class="absolute -right-6 -top-6 w-32 h-32 rounded-full bg-white/5"></div>
            <div class="absolute right-12 top-10 w-16 h-16 rounded-full bg-white/5"></div>
            
            <div class="relative flex items-start justify-between mb-2">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center backdrop-blur-sm">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 20.25c4.97 0 9-3.694 9-8.25s-4.03-8.25-9-8.25S3 7.444 3 12c0 2.104.859 4.023 2.273 5.48.432.447.74 1.04.586 1.641a4.483 4.483 0 01-.923 1.785A5.969 5.969 0 006 21c1.282 0 2.47-.402 3.445-1.087.81.22 1.668.337 2.555.337z"/></svg>
                    </div>
                    <h3 class="text-lg font-bold tracking-wide">Pusat Bantuan</h3>
                </div>
                <button @click="open = false" class="p-1.5 -mr-1.5 -mt-1 text-white/60 hover:text-white hover:bg-white/10 rounded-full transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <p class="relative text-sm text-white/80 leading-relaxed mt-4">Pilih layanan di bawah ini untuk terhubung langsung dengan tim kami.</p>
        </div>

        <!-- Actions -->
        <div class="p-2 bg-surface">
            <div class="bg-white rounded-2xl overflow-hidden border border-border-soft shadow-sm">
                <!-- Action 1 -->
                <a href="https://wa.me/{{ $waNumber }}?text={{ $waMessage }}" target="_blank" rel="noopener noreferrer" class="group flex items-center gap-4 p-4 hover:bg-surface focus-visible:bg-surface focus-visible:outline-none transition-colors duration-300 border-b border-border-soft">
                    <div class="w-10 h-10 rounded-full bg-[#25D366]/10 flex items-center justify-center shrink-0 group-hover:bg-[#25D366] transition-colors duration-300">
                        <svg viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-[#25D366] group-hover:text-white transition-colors duration-300"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.119.554 4.107 1.523 5.832L.044 23.25a.75.75 0 00.946.898l5.652-1.86A11.945 11.945 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22.5A10.45 10.45 0 016.66 20.93l-.38-.227-3.936 1.295 1.242-3.826-.247-.395A10.454 10.454 0 011.5 12C1.5 6.21 6.21 1.5 12 1.5S22.5 6.21 22.5 12 17.79 22.5 12 22.5z"/></svg>
                    </div>
                    <div class="flex-1">
                        <div class="text-sm font-bold text-navy group-hover:text-[#25D366] transition-colors duration-300">Chat WhatsApp</div>
                        <div class="text-xs text-text-muted mt-0.5">Respons cepat</div>
                    </div>
                    <svg class="w-4 h-4 text-text-muted group-hover:text-[#25D366] group-hover:translate-x-1 transition-all duration-300" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                </a>
                
                <!-- Action 2 -->
                <a href="{{ route('contact.index') }}" class="group flex items-center gap-4 p-4 hover:bg-surface focus-visible:bg-surface focus-visible:outline-none transition-colors duration-300">
                    <div class="w-10 h-10 rounded-full bg-navy/5 flex items-center justify-center shrink-0 group-hover:bg-navy transition-colors duration-300">
                        <svg class="w-5 h-5 text-navy group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                    </div>
                    <div class="flex-1">
                        <div class="text-sm font-bold text-navy transition-colors duration-300">Formulir Pengaduan</div>
                        <div class="text-xs text-text-muted mt-0.5">Sampaikan keluhan resmi</div>
                    </div>
                    <svg class="w-4 h-4 text-text-muted group-hover:text-navy group-hover:translate-x-1 transition-all duration-300" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                </a>
            </div>
        </div>

        <!-- Footer -->
        <div class="bg-surface px-6 py-3.5 flex items-center gap-2 border-t border-border-soft">
            <span class="relative flex h-2 w-2 shrink-0">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
            </span>
            <span class="text-[10px] font-bold text-navy/60 uppercase tracking-widest">Online (08.00–16.00 WITA)</span>
        </div>
    </div>

    <!-- Auto notification bubble -->
    <div x-show="showHint"
         x-transition:enter="transition ease-out duration-500"
         x-transition:enter-start="opacity-0 translate-y-4 scale-90"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-2 scale-95"
         class="flex items-center gap-3 bg-white rounded-full shadow-[0_8px_30px_rgb(0,0,0,0.12)] border border-gray-100 py-2 pl-3 pr-2 cursor-pointer hover:-translate-y-1 transition-transform duration-300"
         style="display: none;"
         @click="open = true; showHint = false; hasUnread = false; sessionStorage.setItem('kalimarau_chat_opened', '1')">
        <div class="flex items-center justify-center bg-blue-50 w-8 h-8 rounded-full shrink-0">
            <span class="text-base">👋</span>
        </div>
        <span class="text-sm font-semibold text-navy pr-2">Halo! Butuh bantuan?</span>
        <button @click.stop="showHint = false" aria-label="Tutup notifikasi" class="p-1.5 text-text-muted hover:text-navy hover:bg-surface rounded-full transition-colors ml-1">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>

    <!-- Toggle button -->
    <button @click="open = !open; showHint = false; hasUnread = false; sessionStorage.setItem('kalimarau_chat_opened', '1')" :aria-label="open ? 'Tutup kontak' : 'Hubungi kami'" class="relative w-14 h-14 rounded-full bg-navy hover:bg-navy-dark text-white shadow-[0_8px_30px_rgb(0,0,0,0.12)] hover:shadow-[0_8px_30px_rgb(0,0,0,0.2)] hover:-translate-y-1 transition-all duration-300 flex items-center justify-center">
        <!-- Notification Dot -->
        <span x-show="hasUnread && !open" class="absolute top-0 right-0 flex h-3.5 w-3.5" style="display: none;">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
            <span class="relative inline-flex rounded-full h-3.5 w-3.5 bg-red-500 border-2 border-white"></span>
        </span>
        <svg x-show="!open" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6"><path d="M12 20.25c4.97 0 9-3.694 9-8.25s-4.03-8.25-9-8.25S3 7.444 3 12c0 2.104.859 4.023 2.273 5.48.432.447.74 1.04.586 1.641a4.483 4.483 0 01-.923 1.785A5.969 5.969 0 006 21c1.282 0 2.47-.402 3.445-1.087.81.22 1.668.337 2.555.337z"/></svg>
        <svg x-show="open" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" class="w-6 h-6" style="display: none;"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
    </button>
</div>
