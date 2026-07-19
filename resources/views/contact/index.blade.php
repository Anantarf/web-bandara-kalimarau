<x-layouts.public
    title="Pengaduan dan Kontak - Bandara Kalimarau"
    description="Hubungi Bandara Kalimarau untuk informasi, saran, dan pengaduan layanan."
    :canonical="route('contact.index')"
>
    <!-- Header -->
    <div class="bg-navy-dark text-white py-8 border-b-4 border-gold">
        <div class="container mx-auto px-4 max-w-7xl">
            <!-- Breadcrumb -->
            <nav class="text-sm mb-6 text-blue-200" aria-label="Breadcrumb">
                <ol class="list-none p-0 inline-flex flex-wrap">
                    <li class="flex items-center">
                        <a href="{{ route('home') }}" class="hover:text-white">Beranda</a>
                        <svg class="fill-current w-3 h-3 mx-2 opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"/></svg>
                    </li>
                    <li>
                        <span class="font-medium text-white" aria-current="page">Pengaduan & Kontak</span>
                    </li>
                </ol>
            </nav>

            <h1 class="font-sans text-2xl md:text-4xl font-bold mb-3">Pengaduan & Kontak</h1>
            <p class="text-base text-white/70 max-w-3xl">Hubungi kami atau sampaikan pengaduan layanan secara online melalui formulir di bawah ini.</p>
        </div>
    </div>

    <div class="py-8 bg-gray-50">
        <div class="container mx-auto px-4 max-w-7xl">
            
            @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-800 rounded-lg p-6 mb-8 flex items-start">
                <svg class="w-6 h-6 mr-3 text-green-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div>
                    <h3 class="font-bold text-lg mb-1">Pesan Berhasil Terkirim</h3>
                    <p>{{ session('success') }}</p>
                </div>
            </div>
            @endif

            <div class="flex flex-col lg:flex-row gap-8 lg:gap-12">
                <!-- Kontak Info -->
                <div class="w-full lg:w-1/3 space-y-6">
                    <div class="bg-white p-6 md:p-8 rounded-xl shadow-sm border border-gray-200">
                        <h2 class="text-xl font-bold text-gray-900 mb-6">Informasi Kontak</h2>
                        
                        <div class="flex items-start mb-6">
                            <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center flex-shrink-0 mr-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900">Alamat</h3>
                                <p class="text-gray-600 mt-1">Jl. Kalimarau, Teluk Bayur, Kabupaten Berau, Kalimantan Timur 77315</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start mb-6">
                            <div class="w-10 h-10 bg-green-50 text-green-600 rounded-full flex items-center justify-center flex-shrink-0 mr-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900">WhatsApp Resmi</h3>
                                <p class="text-gray-600 mt-1">0852 6214 6214</p>
                                <a href="https://wa.me/6285262146214" target="_blank" class="text-green-600 hover:text-green-700 font-medium text-sm mt-1 inline-block">Hubungi via WhatsApp</a>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center flex-shrink-0 mr-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900">Email</h3>
                                <p class="text-gray-600 mt-1">info@kalimarau-airport.com</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Formulir Kontak -->
                <div class="w-full lg:w-2/3">
                    <div class="bg-white p-6 md:p-8 rounded-xl shadow-sm border border-gray-200">
                        <h2 class="text-xl font-bold text-gray-900 mb-6">Kirim Pesan atau Pengaduan</h2>
                        
                        <form action="{{ route('contact.store') }}" method="POST">
                            @csrf
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                                    <input type="text" id="name" name="name" value="{{ old('name') }}" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-md focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-colors @error('name') border-red-500 @enderror" required>
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Alamat Email <span class="text-red-500">*</span></label>
                                    <input type="email" id="email" name="email" value="{{ old('email') }}" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-md focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-colors @error('email') border-red-500 @enderror" required>
                                    @error('email')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Nomor HP/Telepon <span class="text-red-500">*</span></label>
                                    <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-md focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-colors @error('phone') border-red-500 @enderror" required>
                                    @error('phone')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Subjek Pesan <span class="text-red-500">*</span></label>
                                    <input type="text" id="subject" name="subject" value="{{ old('subject') }}" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-md focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-colors @error('subject') border-red-500 @enderror" required>
                                    @error('subject')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="mb-6">
                                <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Isi Pesan/Pengaduan <span class="text-red-500">*</span></label>
                                <textarea id="message" name="message" rows="6" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-md focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-colors @error('message') border-red-500 @enderror" required>{{ old('message') }}</textarea>
                                @error('message')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="flex justify-end">
                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-8 rounded-md transition-colors shadow-sm inline-flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                                    Kirim Pesan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Maps Section -->
            <div class="mt-12 bg-gray-300 rounded-xl overflow-hidden h-[400px] relative border border-gray-200">
                <iframe src="https://maps.google.com/maps?q=Bandar%20Udara%20Kalimarau,%20Berau,%20Kaltim&t=&z=15&ie=UTF8&iwloc=B&output=embed" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>

        </div>
    </div>
</x-layouts.public>
