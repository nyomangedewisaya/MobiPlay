<!DOCTYPE html>
<html lang="en" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'MobiPlay - Top Up Aman dan Terpercaya')</title>

    <script>
        document.documentElement.classList.add('dark');
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/style.css'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type=number] {
            -moz-appearance: none;
        }

        [x-cloak] {
            display: none !important;
        }

        /* Style for pagination Swiper */
        .advertisement-pagination .swiper-pagination-bullet-active {
            background-color: white;
            transform: scale(1.2);
        }
    </style>
</head>

<body class="bg-slate-900 text-slate-300 font-inter" x-data="{ sidebarOpen: false, logoutModal: false }">
    {{-- Sidebar --}}
    <aside x-show="sidebarOpen" @click.outside="sidebarOpen = false"
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="-translate-x-full"
        x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full"
        class="fixed top-0 left-0 w-full max-w-xs sm:w-72 h-full bg-slate-800 shadow-lg z-50 flex flex-col" x-cloak>

        {{-- Header --}}
        <div class="p-4 flex items-center justify-between border-b border-slate-700 flex-shrink-0">
            <h2 class="font-bold text-xl text-white">Menu</h2>
            <button @click="sidebarOpen = false" class="text-slate-400 hover:text-white">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        {{-- Content --}}
        <div class="flex-grow overflow-y-auto">
            @guest
                {{-- if user not login --}}
                <div class="p-6">
                    <h3 class="text-xl font-bold text-white">Daftar MobiPlay sekarang!</h3>
                    <ul class="space-y-3 mt-6 text-slate-300">
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-blue-400 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Jadilah yang pertama mengetahui promo & penawaran eksklusif!</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-blue-400 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 010 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 010-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375z" />
                            </svg>
                            <span>Akses riwayat pesanan Anda dengan mudah.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-blue-400 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 9v3.75m0-10.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.75c0 5.592 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.57-.598-3.75h-.152c-3.196 0-6.1-1.249-8.25-3.286zm0 13.036h.008v.008H12v-.008z" />
                            </svg>
                            <span>Pembayaran lebih cepat dan aman.</span>
                        </li>
                    </ul>
                </div>
            @endauth

            {{-- user login --}}
            @auth
                <div class="p-4 flex items-center gap-4 border-b border-slate-700">
                    <img src="{{ Auth::user()->avatar ?? 'https://placehold.co/48x48/475569/E2E8F0?text=M' }}"
                        alt="{{ Auth::user()->name }}" class="w-12 h-12 rounded-full border-2 border-slate-600">
                    <div class="min-w-0">
                        <p class="font-bold text-white truncate">{{ Auth::user()->name }}</p>
                        <p class="text-sm text-slate-400 truncate">{{ Auth::user()->email }}</p>
                    </div>
                </div>
                <nav class="p-4 space-y-2">
                    <a href="{{ route('home') }}"
                        class="px-4 py-2 rounded-md flex items-center gap-4 {{ Request::is('/') ? 'blue-gradient font-semibold text-white' : 'hover:bg-slate-700' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                        </svg>
                        Beranda
                    </a>
                    <a href="{{ route('history') }}"
                        class="px-4 py-2 rounded-md flex items-center gap-4 {{ Request::is('history') ? 'blue-gradient font-semibold text-white' : 'hover:bg-slate-700' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>

                        Histori Transaksi
                    </a>
                    <a href="{{ route('about-us') }}"
                        class="px-4 py-2 rounded-md flex items-center gap-4 {{ Request::is('about-us') ? 'blue-gradient font-semibold text-white' : 'hover:bg-slate-700' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                        </svg>
                        Tentang Kami
                    </a>
                </nav>
            @endauth
        </div>

        {{-- footer sidebar --}}
        <div class="mt-auto p-4 border-t border-slate-700 flex-shrink-0">
            @guest
                <div class="space-y-3">
                    <a href="{{ route('register') }}"
                        class="block w-full text-center blue-gradient-wh text-white font-semibold py-2.5 px-4 rounded-lg">Daftar</a>
                    <a href="{{ route('login') }}"
                        class="block w-full text-center bg-slate-700 hover:bg-slate-600 text-white font-semibold py-2.5 px-4 rounded-lg">Masuk</a>
                </div>
            @endguest
            @auth
                <button type="button" @click="logoutModal = true; sidebarOpen = false"
                    class="w-full text-left px-3 py-2 text-sm font-semibold text-red-500 hover:bg-slate-700 rounded-md flex items-center gap-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" />
                    </svg>
                    Keluar
                </button>
            @endauth
        </div>
    </aside>
    {{-- Overlay --}}
    <div x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 bg-black/50 z-40" x-cloak></div>

    {{-- Header --}}
    <header class="bg-slate-800 shadow-md z-30">
        <div class=" px-4 sm:px-6 lg:px-8 py-3 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <button @click="sidebarOpen = true" class="text-slate-300 hover:text-white">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>
                <a href="{{ route('home') }}" class="text-2xl font-bold text-white">Mobi<span
                        class="text-blue-500">Play</span></a>
                <p class="hidden md:block text-slate-200 border-l border-slate-600 pl-4 ml-2">Mobiplay hadir untuk
                    bikin
                    pengalaman mainmu lebih seru, praktis, dan terpercaya.</p>
            </div>
            <div class="flex items-center gap-4">
                <div x-data="{
                    searchQuery: '{{ request('search', '') }}',
                    suggestions: [],
                    showSuggestions: false,
                    fetchSuggestions() {
                        if (this.searchQuery.length < 2) {
                            this.suggestions = [];
                            this.showSuggestions = false;
                            return;
                        }
                        fetch(`{{ route('api.search-products') }}?q=${this.searchQuery}`)
                            .then(response => response.json())
                            .then(data => {
                                this.suggestions = data;
                                this.showSuggestions = this.suggestions.length > 0;
                            });
                    },
                    selectSuggestion(productName) {
                        this.searchQuery = productName;
                        this.showSuggestions = false;
                        this.$nextTick(() => {
                            this.$refs.searchForm.submit();
                        });
                    }
                }" class="relative">
                    @if (Request::is('/'))
                        <form action="{{ route('home') }}" method="GET" x-ref="searchForm">
                            <input type="text" name="search" placeholder="Cari produk disini..."
                                x-model="searchQuery" @input.debounce.300ms="fetchSuggestions()"
                                @focus="showSuggestions = suggestions.length > 0"
                                class="w-full bg-gray-200 dark:bg-slate-600/50 border border-gray-300 dark:border-gray-600 text-gray-800 dark:text-gray-200 rounded-full pl-4 pr-10 py-3 focus:outline-none">

                            <button type="button" x-show="searchQuery"
                                @click="searchQuery = ''; window.location.href = '{{ route('home') }}'" x-cloak
                                class="absolute inset-y-0 right-0 flex items-center pr-5 text-gray-400 hover:text-gray-500 dark:text-gray-200 dark:hover:text-gray-400 transcolor">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    class="size-5">
                                    <path
                                        d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
                                </svg>
                            </button>

                            <button type="submit" x-show="!searchQuery"
                                class="absolute inset-y-0 right-0 flex items-center pr-5 text-gray-400 hover:text-gray-500 dark:text-gray-200 dark:hover:text-gray-400 transcolor">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                </svg>
                            </button>
                        </form>
                        {{-- Dropdown Autocomplete --}}
                        <div x-show="showSuggestions" @click.outside="showSuggestions = false" x-transition x-cloak
                            class="absolute top-full mt-2 w-full bg-slate-700 rounded-lg shadow-lg border border-slate-600 max-h-60 overflow-y-auto z-50">
                            <ul class="divide-y divide-slate-600">
                                <template x-for="product in suggestions" :key="product.slug">
                                    <li>
                                        <a href="#" @click.prevent="selectSuggestion(product.name)"
                                            class="flex items-center gap-3 p-3 hover:bg-slate-600/50">
                                            <img :src="product.thumbnail_url"
                                                class="w-10 h-10 object-cover rounded-md flex-shrink-0">
                                            <span x-text="product.name" class="font-semibold text-white"></span>
                                        </a>
                                    </li>
                                </template>
                            </ul>
                        </div>
                    @endif
                </div>
                @guest
                    <a href="{{ route('login') }}"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg text-sm transition-colors">Masuk</a>
                @endguest
                @auth
                    <a href="{{ route('profile.edit') }}"
                        class="w-9 h-9 rounded-full bg-slate-700 flex items-center justify-center">
                        <img src="{{ Auth::user()->avatar ?? 'https://placehold.co/36x36/475569/E2E8F0?text=M' }}"
                            alt="Avatar" class="rounded-full">
                    </a>
                @endauth
            </div>
        </div>
    </header>

    {{-- Main Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-slate-800 text-slate-400 mt-12">
        <div class="px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h4 class="font-bold text-white mb-4">Untuk Penerbit</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white">Daftarkan Game Anda</a></li>
                        <li><a href="#" class="hover:text-white">Pelajari Lebih Lanjut</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-white mb-4">Hubungi Kami</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white">Dukungan Pelanggan</a></li>
                        <li><a href="#" class="hover:text-white">Pemasaran & Kemitraan</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-white mb-4">Sosial Media</h4>
                    <div class="flex space-x-4">
                        <a href="#">
                            <img src="https://img.icons8.com/color/48/instagram-new.png" />
                        </a>
                        <a href="#">
                            <img src="https://img.icons8.com/color/48/facebook-new.png" />
                        </a>
                        <a href="#">
                            <img src="https://img.icons8.com/color/48/youtube-play.png" />
                        </a>
                        <a href="#">
                            <img src="https://img.icons8.com/color/48/tiktok.png" />
                        </a>
                    </div>
                </div>
                <div>
                    <h4 class="font-bold text-white mb-4">Metode Pembayaran</h4>
                    <div class="flex flex-wrap gap-2 items-center">
                        <div
                            class="h-8 px-3 rounded-md bg-blue-500 text-white font-bold text-sm flex items-center justify-center">
                            DANA
                        </div>
                        <div
                            class="h-8 px-3 rounded-md bg-blue-400 text-white font-bold text-sm flex items-center justify-center">
                            Gopay
                        </div>
                        <div
                            class="h-8 px-3 rounded-md bg-purple-600 text-white font-bold text-sm flex items-center justify-center">
                            OVO
                        </div>
                        <div
                            class="h-8 px-3 rounded-md bg-orange-500 text-white font-bold text-sm flex items-center justify-center">
                            ShopeePay
                        </div>
                        <div
                            class="h-8 px-3 rounded-md bg-sky-500 text-white font-bold text-sm flex items-center justify-center">
                            BCA
                        </div>
                    </div>
                </div>
            </div>
            <div
                class="border-t border-slate-700 mt-8 pt-6 flex flex-col sm:flex-row justify-between items-center text-xs">
                <p>&copy; {{ date('Y') }} MobiPlay. Seluruh hak cipta dilindungi.</p>
                <div class="flex space-x-4 mt-4 sm:mt-0">
                    <a href="#" class="hover:text-white">Syarat & Ketentuan</a>
                    <a href="#" class="hover:text-white">Kebijakan Privasi</a>
                    <a href="#" class="hover:text-white">Menjadi Distributor</a>
                </div>
            </div>
        </div>
    </footer>

    {{-- Logout modal --}}
    <div x-show="logoutModal" x-cloak x-transition.opacity class="fixed inset-0 bg-black/40 backdrop-blur-sm z-50">
    </div>
    <div x-show="logoutModal" x-cloak x-transition class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div x-cloak x-transition.opacity
            class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
            <div @click.outside="logoutModal = false"
                class="bg-white dark:bg-slate-800 rounded-lg shadow-xl w-full max-w-sm p-6 text-center">
                <svg class="mx-auto h-12 w-12 text-red-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                </svg>
                <h3 class="mt-4 text-xl font-bold text-gray-800 dark:text-white">Konfirmasi Logout</h3>
                <p class="text-gray-600 dark:text-slate-300 mt-2">
                    Apakah Anda yakin ingin keluar dari sesi Anda?
                </p>
                <div class="flex justify-center gap-4 mt-6">
                    <button type="button" @click="logoutModal = false"
                        class="w-full px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 dark:bg-slate-600 dark:text-white dark:hover:bg-slate-500 transition-colors duration-300">
                        Batal
                    </button>
                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <button type="submit"
                            class="w-full px-4 py-2 red-gradient-wh text-white rounded-lg font-semibold">
                            Ya, Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Swipe JS --}}
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    {{-- AOS JS --}}
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800
        });
    </script>
</body>

</html>
