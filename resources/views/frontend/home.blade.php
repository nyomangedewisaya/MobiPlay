@extends('layouts.app')
@section('content')
    <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
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
                        <a href="#"
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
                                        <a href="#"
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
                                    <button @click="expanded = !expanded"
                                        class="text-white font-semibold hover:underline">
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
