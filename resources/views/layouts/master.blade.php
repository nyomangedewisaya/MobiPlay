<!DOCTYPE html>
<html lang="en">

<head>
    {{-- Meta and title --}}
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>

    {{-- Settings for dark mode (avoid glitch) --}}
    <script>
        (function() {
            if (localStorage.getItem('darkMode') === 'true' ||
                (!('darkMode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>

    {{-- Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/style.css'])
    {{-- Font Inter --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet">
    {{-- CDN with Alpine.js --}}
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/persist@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    {{-- CDN with Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0"></script>
    {{-- CDN with Tom Select --}}
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">
    {{-- Adding style css --}}
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
    </style>
</head>

<body class="bg-gray-100 dark:bg-slate-900 font-inter" x-data="{
    sidebar: false,
    logoutModal: false,
    darkMode: localStorage.getItem('darkMode') === 'true',

    toggleDarkMode() {
        this.darkMode = !this.darkMode;
        localStorage.setItem('darkMode', this.darkMode);
        if (this.darkMode) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    }
}">
    {{-- Sidebar Admin --}}
    <aside
        class="sidebar bg-white dark:bg-slate-600/50 dark:border-r dark:border-slate-700 lg:rounded-r-xl shadow-xl fixed top-0 bottom-0 left-0 w-64 z-30 flex flex-col transform transition-transform ease-in-out duration-300 -translate-x-full lg:translate-x-0"
        :class="{ 'translate-x-0': sidebar }">
        <div
            class="p-4 font-bold text-2xl text-blue-400 border-b border-gray-200 dark:border-gray-500 flex items-center justify-between">
            <div class="flex items-center">
                <span class="text-gray-800 dark:text-white">Mobi</span>Play
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6 ml-2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15.59 14.37a6 6 0 0 1-5.84 7.38v-4.8m5.84-2.58a14.98 14.98 0 0 0 6.16-12.12A14.98 14.98 0 0 0 9.631 8.41m5.96 5.96a14.926 14.926 0 0 1-5.841 2.58m-.119-8.54a6 6 0 0 0-7.381 5.84h4.8m2.581-5.84a14.927 14.927 0 0 0-2.58 5.84m2.699 2.7c-.103.021-.207.041-.311.06a15.09 15.09 0 0 1-2.448-2.448 14.9 14.9 0 0 1 .06-.312m-2.24 2.39a4.493 4.493 0 0 0-1.757 4.306 4.493 4.493 0 0 0 4.306-1.758M16.5 9a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z" />
                </svg>
            </div>
            <button @click="sidebar = false"
                class="lg:hidden text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <nav class="flex-1 overflow-y-auto">
            <ul class="space-y-3 font-medium p-4">
                <li>
                    <a href="{{ route('dashboard') }}"
                        class="block px-4 py-2 rounded-lg transition-colors duration-300 {{ Request::is('dashboard') ? 'text-white blue-gradient' : 'text-gray-600 dark:text-gray-500 hover:bg-gray-200 dark:hover:bg-slate-600' }}">
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 7.125C2.25 6.504 2.754 6 3.375 6h6c.621 0 1.125.504 1.125 1.125v3.75c0 .621-.504 1.125-1.125 1.125h-6a1.125 1.125 0 0 1-1.125-1.125v-3.75ZM14.25 8.625c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125v8.25c0 .621-.504 1.125-1.125 1.125h-5.25a1.125 1.125 0 0 1-1.125-1.125v-8.25ZM3.75 16.125c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125v2.25c0 .621-.504 1.125-1.125 1.125h-5.25a1.125 1.125 0 0 1-1.125-1.125v-2.25Z" />
                            </svg>
                            Dashboard
                        </div>
                    </a>
                </li>
                <li x-data="{ open: $persist(false).as('masterDataOpen') }">
                    <div @click="open = !open"
                        class="flex items-center justify-between px-4 py-2 rounded-lg transition-colors duration-300 cursor-pointer {{ Request::is('managements/categories*') || Request::is('managements/products*') || Request::is('managements/items*') || Request::is('managements/input_fields*') ? 'text-white blue-gradient' : 'text-gray-600 dark:text-gray-500 hover:bg-gray-200 dark:hover:bg-slate-600' }}">
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16.5 8.25V6a2.25 2.25 0 0 0-2.25-2.25H6A2.25 2.25 0 0 0 3.75 6v8.25A2.25 2.25 0 0 0 6 16.5h2.25m8.25-8.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-7.5A2.25 2.25 0 0 1 8.25 18v-1.5m8.25-8.25h-6a2.25 2.25 0 0 0-2.25 2.25v6" />
                            </svg>
                            Master Data
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-5 transition-transform duration-300"
                            :class="{ 'rotate-90': open }">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                        </svg>
                    </div>
                    <ul x-show="open" x-transition class="mt-2 space-y-2 ml-5">
                        <li>
                            <a href="{{ route('managements.categories.index') }}"
                                class="block px-4 py-2 rounded-lg transition-colors duration-300 {{ Request::is('managements/categories*') ? 'text-white blue-gradient' : 'text-gray-600 dark:text-gray-500 hover:bg-gray-200 dark:hover:bg-slate-600' }}">
                                <div class="flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z" />
                                    </svg>
                                    Kategori
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#"
                                class="block px-4 py-2 rounded-lg transition-colors duration-300 {{ Request::is('managements/products*') ? 'text-white blue-gradient' : 'text-gray-600 dark:text-gray-500 hover:bg-gray-200 dark:hover:bg-slate-600' }}">
                                <div class="flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m21 7.5-9-5.25L3 7.5m18 0-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" />
                                    </svg>
                                    Produk
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#"
                                class="block px-4 py-2 rounded-lg transition-colors duration-300 {{ Request::is('managements/items*') ? 'text-white blue-gradient' : 'text-gray-600 dark:text-gray-500 hover:bg-gray-200 dark:hover:bg-slate-600' }}">
                                <div class="flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.25 13.5h3.86a2.25 2.25 0 0 1 2.012 1.244l.256.512a2.25 2.25 0 0 0 2.013 1.244h3.218a2.25 2.25 0 0 0 2.013-1.244l.256-.512a2.25 2.25 0 0 1 2.013-1.244h3.859m-19.5.338V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18v-4.162c0-.224-.034-.447-.1-.661L19.24 5.338a2.25 2.25 0 0 0-2.15-1.588H6.911a2.25 2.25 0 0 0-2.15 1.588L2.35 13.177a2.25 2.25 0 0 0-.1.661Z" />
                                    </svg>
                                    Item
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#"
                                class="block px-4 py-2 rounded-lg transition-colors duration-300 {{ Request::is('managements/input_fields*') ? 'text-white blue-gradient' : 'text-gray-600 dark:text-gray-500 hover:bg-gray-200 dark:hover:bg-slate-600' }}">
                                <div class="flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M7.5 7.5h-.75A2.25 2.25 0 0 0 4.5 9.75v7.5a2.25 2.25 0 0 0 2.25 2.25h7.5a2.25 2.25 0 0 0 2.25-2.25v-7.5a2.25 2.25 0 0 0-2.25-2.25h-.75m-6 3.75 3 3m0 0 3-3m-3 3V1.5m6 9h.75a2.25 2.25 0 0 1 2.25 2.25v7.5a2.25 2.25 0 0 1-2.25 2.25h-7.5a2.25 2.25 0 0 1-2.25-2.25v-.75" />
                                    </svg>
                                    Input User
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#"
                        class="block px-4 py-2 rounded-lg transition-colors duration-300 {{ Request::is('transactions') ? 'text-white blue-gradient' : 'text-gray-600 dark:text-gray-500 hover:bg-gray-200 dark:hover:bg-slate-600' }}">
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" />
                            </svg>
                            Transaksi
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#"
                        class="block px-4 py-2 rounded-lg transition-colors duration-300 {{ Request::is('advertisements*') ? 'text-white blue-gradient' : 'text-gray-600 dark:text-gray-500 hover:bg-gray-200 dark:hover:bg-slate-600' }}">
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3.75 3v11.25A2.25 2.25 0 0 0 6 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0 1 18 16.5h-2.25m-7.5 0h7.5m-7.5 0-1 3m8.5-3 1 3m0 0 .5 1.5m-.5-1.5h-9.5m0 0-.5 1.5m.75-9 3-3 2.148 2.148A12.061 12.061 0 0 1 16.5 7.605" />
                            </svg>
                            Iklan
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#"
                        class="block px-4 py-2 rounded-lg transition-colors duration-300 {{ Request::is('articles*') ? 'text-white blue-gradient' : 'text-gray-600 dark:text-gray-500 hover:bg-gray-200 dark:hover:bg-slate-600' }}">
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 0 1-2.25 2.25M16.5 7.5V18a2.25 2.25 0 0 0 2.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 0 0 2.25 2.25h13.5M6 7.5h3v3H6v-3Z" />
                            </svg>
                            Artikel
                        </div>
                    </a>
                </li>
            </ul>
        </nav>
        {{-- Toggle button for change dark/light mode --}}
        <div class="mt-auto p-4 border-t border-gray-200 dark:border-slate-600/50">
            <button @click="toggleDarkMode()"
                class="w-full flex items-center justify-center gap-2 p-2 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                <span x-show="!darkMode">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
                    </svg>
                </span>
                <span x-show="darkMode" x-cloak>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" />
                    </svg>
                </span>
                <span x-text="darkMode ? 'Light Mode' : 'Dark Mode'"></span>
            </button>
        </div>
    </aside>
    {{-- Overloay for mobile --}}
    <div x-show="sidebar" @click="sidebar = false" x-cloak class="fixed inset-0 bg-black/50 z-20 lg:hidden"></div>
    {{-- Main content --}}
    <main class="lg:ml-64 lg:pl-2">
        <div
            class="lg:hidden p-4 bg-gray-50 dark:bg-slate-700 shadow-md flex items-center justify-between sticky top-0 z-10">
            <button @click.stop="sidebar = !sidebar" class="text-gray-700 dark:text-white">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </button>
            <div class="flex lg:hidden items-center gap-3">
                <p class="text-gray-700 dark:text-white font-medium">{{ Auth::user()->name }}</p>
                <img src="" alt="{{ Auth::user()->name }}"
                    class="w-10 h-10 rounded-full border border-slate-700">
            </div>
        </div>
        @yield('content')
    </main>
</body>

</html>
