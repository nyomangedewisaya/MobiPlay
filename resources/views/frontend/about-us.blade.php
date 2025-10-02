@extends('layouts.app')

@section('title', 'Tentang MobiPlay')

@section('content')
    <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Hero section --}}
        <div class="text-center py-16 sm:py-24" data-aos="fade-up">
            <h1
                class="text-4xl sm:text-5xl font-extrabold">
                Mobi<span class="text-blue-500">Play</span> Indonesia
            </h1>
            <p class="mt-4 text-lg sm:text-xl max-w-3xl mx-auto text-slate-300">
                Website top-up terhebat, tercepat, dan terpercaya di Indonesia untuk semua kebutuhan game dan hiburan
                digital Anda.
            </p>
        </div>

        {{-- Grid section --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div data-aos="fade-up">
                <div
                    class="bg-slate-800 p-6 rounded-lg border border-slate-700 hover:border-blue-500 hover:-translate-y-1.5 transition-transform duration-300 h-full">
                    <div class="flex items-center gap-4">
                        <div class="bg-slate-700 p-3 rounded-full"><svg class="w-6 h-6 text-blue-400" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg></div>
                        <h3 class="text-lg font-bold text-white">Bayar dalam Detik</h3>
                    </div>
                    <p class="mt-4 text-sm text-slate-400">Hanya butuh beberapa detik untuk menyelesaikan pembayaran karena
                        semua proses terintegrasi dan mudah untuk digunakan.</p>
                </div>
            </div>

            <div data-aos="fade-up" data-aos-delay="100">
                <div
                    class="bg-slate-800 p-6 rounded-lg border border-slate-700 hover:border-blue-500 hover:-translate-y-1.5 transition-transform duration-300 h-full">
                    <div class="flex items-center gap-4">
                        <div class="bg-slate-700 p-3 rounded-full"><svg class="w-6 h-6 text-blue-400" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.59 14.37a6 6 0 01-5.84 7.38v-4.8m5.84-2.58a14.98 14.98 0 006.16-12.12A14.98 14.98 0 009.63 8.41m5.96 5.96a14.926 14.926 0 01-5.841 2.58m-.119-8.54a6 6 0 00-7.381 5.84h4.8m2.581-5.84a14.927 14.927 0 00-2.58 5.84m2.699 2.7c-.103.021-.207.041-.311.06a15.09 15.09 0 01-2.448-2.448 14.9 14.9 0 01.06-.312m-2.24 2.39a4.493 4.493 0 00-1.757 4.306 4.493 4.493 0 004.306-1.758M16.5 9a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
                            </svg></div>
                        <h3 class="text-lg font-bold text-white">Pengiriman Instan</h3>
                    </div>
                    <p class="mt-4 text-sm text-slate-400">Item atau barang yang Anda beli akan selalu dikirim ke akun Anda
                        secara instan dan cepat, tanpa tertunda.</p>
                </div>
            </div>

            <div data-aos="fade-up" data-aos-delay="200">
                <div
                    class="bg-slate-800 p-6 rounded-lg border border-slate-700 hover:border-blue-500 hover:-translate-y-1.5 transition-transform duration-300 h-full">
                    <div class="flex items-center gap-4">
                        <div class="bg-slate-700 p-3 rounded-full"><svg class="w-6 h-6 text-blue-400" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3M3.75 21h15a2.25 2.25 0 002.25-2.25V5.25A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25v13.5A2.25 2.25 0 003.75 21z" />
                            </svg></div>
                        <h3 class="text-lg font-bold text-white">Metode Pembayaran Terbaik</h3>
                    </div>
                    <p class="mt-4 text-sm text-slate-400">Kami menawarkan banyak pilihan pembayaran mulai dari pulsa,
                        e-wallet, bank transfer, dan pembayaran di mini market terdekat.</p>
                </div>
            </div>

            <div data-aos="fade-up">
                <div
                    class="bg-slate-800 p-6 rounded-lg border border-slate-700 hover:border-blue-500 hover:-translate-y-1.5 transition-transform duration-300 h-full">
                    <div class="flex items-center gap-4">
                        <div class="bg-slate-700 p-3 rounded-full"><svg class="w-6 h-6 text-blue-400" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
                            </svg></div>
                        <h3 class="text-lg font-bold text-white">Promosi Paling Menarik</h3>
                    </div>
                    <p class="mt-4 text-sm text-slate-400">Penggemar game dapat bergantung pada MobiPlay karena kami
                        memberikan penawaran menarik, diskon, dan kode item dari promosi game.</p>
                </div>
            </div>

            <div data-aos="fade-up" data-aos-delay="100">
                <div
                    class="bg-slate-800 p-6 rounded-lg border border-slate-700 hover:border-blue-500 hover:-translate-y-1.5 transition-transform duration-300 h-full">
                    <div class="flex items-center gap-4">
                        <div class="bg-slate-700 p-3 rounded-full"><svg class="w-6 h-6 text-blue-400" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 18.75a6 6 0 006-6v-1.5m-6 7.5a6 6 0 01-6-6v-1.5m6 7.5v3.75m-3.75 0h7.5M12 15.75a3 3 0 01-3-3V4.5a3 3 0 116 0v8.25a3 3 0 01-3 3z" />
                            </svg></div>
                        <h3 class="text-lg font-bold text-white">Layanan Pelanggan Cepat</h3>
                    </div>
                    <p class="mt-4 text-sm text-slate-400">Tim CS terbaik kami selalu siap membantu kapanpun, di manapun.
                        Cukup hubungi kami melalui live chat atau email.</p>
                </div>
            </div>

            <div data-aos="fade-up" data-aos-delay="200">
                <div
                    class="bg-slate-800 p-6 rounded-lg border border-slate-700 hover:border-blue-500 hover:-translate-y-1.5 transition-transform duration-300 h-full">
                    <div class="flex items-center gap-4">
                        <div class="bg-slate-700 p-3 rounded-full"><svg class="w-6 h-6 text-blue-400" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                            </svg></div>
                        <h3 class="text-lg font-bold text-white">Keamanan Terjamin</h3>
                    </div>
                    <p class="mt-4 text-sm text-slate-400">Transaksi Anda dijamin aman 100%. Kami bekerja sama dengan
                        penyedia pembayaran terpercaya di seluruh dunia.</p>
                </div>
            </div>
        </div>

        {{-- Call to ction --}}
        <div class="text-center mt-16 sm:mt-24 py-12 border-t border-slate-800" data-aos="fade-up">
            <h2 class="text-3xl font-bold text-white">Siap untuk Memulai?</h2>
            <p class="text-slate-400 mt-2">Jelajahi banyak game dan produk digital sekarang juga.</p>
            <a href="{{ route('home') }}"
                class="mt-6 inline-block blue-gradient-wh text-white rounded-lg px-8 py-3 font-semibold transition-transform hover:scale-102">
                Mulai Belanja
            </a>
        </div>
    </div>
@endsection
