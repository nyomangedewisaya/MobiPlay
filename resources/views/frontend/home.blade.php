@extends('layouts.app')
@section('content')
    <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 mt-8" x-data="{
        articleDetailModal: false,
        articleToShow: {}
    }">
        {{-- Carousel of ads --}}
        @if (!$isSearchActive && $advertisements->isNotEmpty())
            <div data-aos="zoom-in">
                <div class="max-w-4xl mx-auto">
                    <div
                        class="swiper advertisement-slider relative rounded-xl overflow-hidden shadow-lg aspect-video sm:aspect-[2.5/1]">
                        <div class="swiper-wrapper">
                            @foreach ($advertisements as $ad)
                                <div class="swiper-slide">
                                    <a href="{{ $ad->target_url }}" target="_blank" rel="noopener noreferrer">
                                        <img src="{{ asset($ad->banner_url) }}" alt="{{ $ad->title }}"
                                            onerror="this.onerror=null;this.src='https://placehold.co/1200x480/1e293b/94a3b8?text={{ urlencode($ad->title) }}';"
                                            class="w-full h-full object-cover">
                                    </a>
                                </div>
                            @endforeach
                        </div>
                        <div class="swiper-button-prev text-white drop-shadow-lg"></div>
                        <div class="swiper-button-next text-white drop-shadow-lg"></div>
                    </div>
                    <div class="advertisement-pagination mt-4 text-center space-x-2"></div>
                </div>
            </div>
        @endif

        {{-- List cards of products --}}
        @if ($isSearchActive)
            <div data-aos="fade-up">
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 sm:gap-5">
                    @forelse ($searchResults as $product)
                        <a href="{{ route('transaction.show', $product) }}"
                            class="bg-slate-800 rounded-lg shadow-md overflow-hidden group hover:-translate-y-1.5 transition-all duration-300"">
                            <img src="{{ asset($product->thumbnail_url) }}" ...>
                            <div class="p-3">
                                <h3 class="font-semibold text-white truncate">{{ $product->name }}</h3>
                            </div>
                        </a>
                    @empty
                        <div class="col-span-full text-center py-10 bg-slate-800 rounded-lg">
                            <p class="text-lg text-slate-300">Oops! Produk tidak ditemukan.</p>
                            <p class="text-sm text-slate-400 mt-2">Coba gunakan kata kunci lain.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        @else
            <div class="space-y-12 mt-6">
                @foreach ($categories as $category)
                    @if ($category->products->isNotEmpty())
                        <div x-data="{ expanded: false }">
                            <h2 class="text-2xl font-bold text-white mb-4" data-aos="fade-right">{{ $category->name }}</h2>
                            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 sm:gap-5">
                                @foreach ($category->products as $product)
                                    <div x-show="expanded || {{ $loop->index }} < 10" x-transition data-aos="fade-up"
                                        data-aos-delay="{{ ($loop->index % 5) * 50 }}">
                                        <a href="{{ route('transaction.show', $product) }}"
                                            class="block bg-slate-800 rounded-lg shadow-md overflow-hidden group hover:-translate-y-0.5 transition-transform duration-300">
                                            <img src="{{ asset($product->thumbnail_url) }}" alt="{{ $product->name }}"
                                                class="w-full h-40 sm:h-48 object-cover group-hover:scale-103 transition-transform duration-300">
                                            <div class="p-3">
                                                <h3 class="font-semibold text-white truncate">{{ $product->name }}</h3>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                            @if (count($category->products) > 10)
                                <div class="text-center mt-6" data-aos="fade-up">
                                    <button @click="expanded = !expanded" class="text-white font-semibold hover:underline">
                                        <span x-show="!expanded">Tampilkan Semua</span>
                                        <span x-show="expanded" x-cloak>Sembunyikan</span>
                                    </button>
                                </div>
                            @endif
                        </div>
                    @endif
                @endforeach
            </div>
        @endif

        {{-- List cards of articles --}}
        @if (!$isSearchActive && $articles->isNotEmpty())
            <div class="mt-12">
                <h2 class="text-2xl font-bold text-white mb-4" data-aos="fade-right">News and Update</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($articles as $article)
                        <div @click="articleDetailModal = true; articleToShow = {{ json_encode($article) }}" data-aos="fade-up"
                            data-aos-delay="{{ ($loop->index % 3) * 100 }}" class="cursor-pointer">
                            <div
                                class="bg-slate-800 rounded-lg shadow-md overflow-hidden group hover:-translate-y-1.5 transition-transform duration-300">
                                <div class="aspect-video">
                                    <img src="{{ asset($article->banner_url) }}" alt="{{ $article->title }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                </div>
                                <div class="p-4">
                                    <h3
                                        class="font-bold text-lg text-white truncate group-hover:text-blue-400 transition-colors">
                                        {{ $article->title }}</h3>
                                    <p class="text-xs text-slate-400 mt-1">{{ $article->created_at->format('d F Y') }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Modal detail articles --}}
        <div x-show="articleDetailModal" x-cloak x-transition.opacity
            class="fixed inset-0 bg-black/40 backdrop-blur-sm z-50">
        </div>
        <div x-show="articleDetailModal" x-cloak x-transition
            class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div @click.outside="articleDetailModal = false"
                class="bg-slate-800 rounded-lg shadow-xl w-full max-w-2xl max-h-[90vh] flex flex-col">
                <div class="p-4 border-b border-slate-700 flex justify-between items-center flex-shrink-0">
                    <h3 class="text-xl font-bold text-white" x-text="articleToShow.title"></h3>
                    <button @click="articleDetailModal = false" class="text-slate-400 hover:text-white">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="p-6 space-y-4 overflow-y-auto">
                    <img :src="articleToShow.banner_url" :alt="articleToShow.title"
                        class="w-full rounded-lg aspect-video object-cover bg-slate-700">
                    <p class="text-slate-300 whitespace-pre-wrap leading-relaxed"
                        x-text="articleToShow.content"></p>
                </div>
                <div class="p-4 border-t border-slate-700 text-right flex-shrink-0">
                    <button type="button" @click="articleDetailModal = false"
                        class="px-4 py-2 rounded-lg hover:bg-slate-600 bg-slate-700 text-white">Tutup</button>
                </div>
            </div>
        </div>
    </div>


    {{-- Script initial of Swiper.js --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const swiper = new Swiper('.advertisement-slider', {
                loop: true,
                effect: 'fade',
                fadeEffect: {
                    crossFade: true
                },
                autoplay: {
                    delay: 4000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: '.advertisement-pagination',
                    clickable: true,
                    renderBullet: function(index, className) {
                        return '<span class="' + className +
                            ' bg-white/50 w-2.5 h-2.5 rounded-full inline-block cursor-pointer transition-all duration-300 mx-1"></span>';
                    },
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
            });
        });
    </script>
    {{-- Style for pagination --}}
    <style>
        .advertisement-pagination .swiper-pagination-bullet-active {
            background-color: white;
            transform: scale(1.2);
        }
    </style>
@endsection
