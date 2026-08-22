@props([
    'faq',
    'index',
])

<div class="group relative overflow-hidden border border-gray-200/60 rounded-2xl bg-white shadow-sm hover:shadow-md transition-all duration-300"
     :class="{ 'ring-1 ring-gold-light/50 shadow-md': active === {{ $index }} }">
    <div class="absolute left-0 top-0 bottom-0 w-1 bg-gold-light transition-transform duration-300 origin-top"
         :class="active === {{ $index }} ? 'scale-y-100' : 'scale-y-0'"></div>

    <button @click="active !== {{ $index }} ? active = {{ $index }} : active = null" class="w-full flex justify-between items-center p-5 md:p-6 text-left focus:outline-none focus-visible:ring-2 focus-visible:ring-gold rounded-2xl">
        <span class="font-sans font-bold text-navy-dark text-base md:text-lg pr-6 transition-colors duration-300"
              :class="active === {{ $index }} ? 'text-navy-dark' : 'group-hover:text-gold'">
            {{ $faq['q'] }}
        </span>
        <span class="relative shrink-0 w-6 h-6 flex items-center justify-center transition-transform duration-500 ease-[cubic-bezier(0.87,0,0.13,1)]"
              :class="active === {{ $index }} ? 'rotate-180 text-gold' : 'text-gray-400 group-hover:text-gold'">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
        </span>
    </button>

    <div x-show="active === {{ $index }}"
         x-transition:enter="transition-all ease-out duration-300"
         x-transition:enter-start="opacity-0 max-h-0"
         x-transition:enter-end="opacity-100 max-h-[500px]"
         x-transition:leave="transition-all ease-in duration-200"
         x-transition:leave-start="opacity-100 max-h-[500px]"
         x-transition:leave-end="opacity-0 max-h-0"
         class="overflow-hidden"
         style="display: none;">
        <div class="px-5 md:px-6 pb-5 md:pb-6 text-text-muted text-sm md:text-base leading-relaxed">
            <div class="w-full h-px bg-gray-100 mb-4 md:mb-5"></div>
            {{ $faq['a'] }}
        </div>
    </div>
</div>