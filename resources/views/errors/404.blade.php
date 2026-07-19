<x-layouts.public>
    <div class="py-20 bg-gray-50 min-h-[70vh] flex items-center">
        <div class="container mx-auto px-4 text-center max-w-2xl">
            <h1 class="text-9xl font-bold text-gray-200 mb-4">404</h1>
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Halaman Tidak Ditemukan</h2>
            <p class="text-lg text-gray-600 mb-8">Maaf, halaman yang Anda cari mungkin telah dihapus, namanya diubah, atau tidak tersedia untuk saat ini.</p>
            
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('home') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-md transition-colors inline-flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    Kembali ke Beranda
                </a>
                <a href="{{ route('contact.index') }}" class="bg-white hover:bg-gray-50 text-gray-800 border border-gray-300 font-semibold py-3 px-6 rounded-md transition-colors inline-flex items-center justify-center">
                    Hubungi Kami
                </a>
            </div>
        </div>
    </div>
</x-layouts.public>
