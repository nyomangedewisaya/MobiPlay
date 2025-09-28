@extends('layouts.master')
@section('title', 'Artikel')
@section('content')
    @include('partials.alert')
    <div class="bg-white dark:bg-slate-700/50 rounded-l-xl dark:border-l dark:border-slate-700 shadow-xl px-6 py-4 flex flex-col h-[calc(100vh)]"
        x-data="{
            searchQuery: '{{ request('search', '') }}',
            articleModal: false,
            articleToShow: {},
        
            openArticleModal(product) {
                this.articleToShow = product;
                this.articleModal = true
            }
        }">
        <div
            class="border-b border-gray-200 dark:border-slate-600/50 flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4 mb-4 pb-4" data-aos="fade-up">
            <div>
                <h2 class="text-2xl font-bold text-gray-700 dark:text-white">Kelola Artikel</h2>
                <p class="text-sm text-gray-500 dark:text-slate-400">Kelola konten berita, tips, atau promosi.</p>
            </div>
            <div class="flex items-center gap-2 w-full sm:w-auto">
                <form action="{{ route('articles.index') }}" method="GET" class="relative w-full sm:w-auto">
                    <input type="text" name="search" x-model="searchQuery"
                        class="w-full bg-gray-200 dark:bg-slate-600/50 border border-gray-300 dark:border-gray-600 text-gray-800 dark:text-gray-200 rounded-full pl-4 pr-10 py-3 focus:outline-none"
                        placeholder="Cari nama artikel...">

                    <button type="button" x-show="searchQuery"
                        @click="searchQuery = ''; window.location.href = '{{ route('articles.index') }}'" x-cloak
                        class="absolute inset-y-0 right-0 flex items-center pr-5 text-gray-400 hover:text-gray-500 dark:text-gray-200 dark:hover:text-gray-400 transcolor">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                            <path
                                d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
                        </svg>
                    </button>

                    <button type="submit" x-show="!searchQuery"
                        class="absolute inset-y-0 right-0 flex items-center pr-5 text-gray-400 hover:text-gray-500 dark:text-gray-200 dark:hover:text-gray-400 transcolor">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                    </button>
                </form>
                <a href="{{ route('articles.create') }}"
                    class="blue-gradient-wh rounded-lg px-6 py-3 text-md text-white font-medium flex items-center justify-end gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    Tambah
                </a>
            </div>
        </div>

        <div class="flex-grow flex flex-col overflow-hidden" data-aos="fade-up">
            {{-- Active articles --}}
            <div class="flex-shrink-0">
                <h3 class="text-lg font-semibold text-gray-700 dark:text-slate-200">Dipublish (<span
                        class="text-green-500">{{ count($activeArticles) }}</span>)</h3>
                <hr class="dark:border-slate-600 my-2">
            </div>
            <div class="overflow-x-auto pb-4 -ml-4 sm:-ml-6 pl-4 sm:pl-6">
                <div class="grid grid-flow-col grid-rows-2 auto-cols-[15rem] sm:auto-cols-[16rem] gap-4 lg:flex lg:gap-4">
                    @forelse ($activeArticles as $article)
                        <div @click="openArticleModal({{ json_encode($article) }})"
                            class="lg:w-70 bg-gray-50 dark:bg-slate-800 rounded-lg shadow-md cursor-pointer hover:scale-101 hover:shadow-lg transition-all duration-300">
                            <img src="{{ $article->banner_url }}" alt="{{ $article->title }}"
                                class="w-full h-32 object-cover rounded-t-lg">
                            <div class="p-3">
                                <h4 class="font-bold text-gray-800 dark:text-white truncate">{{ $article->title }}</h4>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500 dark:text-slate-400">Tidak ada artikel yang di-publish.</p>
                    @endforelse
                </div>
            </div>

            {{-- Inactive articles (drafts) --}}
            <div class="flex-shrink-0 mt-4">
                <h3 class="text-lg font-semibold text-gray-700 dark:text-slate-200">Draf (<span
                        class="text-yellow-500">{{ count($inactiveArticles) }}</span>)</h3>
                <hr class="dark:border-slate-600 my-2">
            </div>
            <div class="overflow-x-auto pb-4 -ml-4 sm:-ml-6 pl-4 sm:pl-6">
                <div class="grid grid-flow-col grid-rows-2 auto-cols-[15rem] sm:auto-cols-[16rem] gap-4 lg:flex lg:gap-4">
                    @forelse ($inactiveArticles as $article)
                        <div @click="openArticleModal({{ json_encode($article) }})"
                            class="lg:w-70 bg-gray-50 dark:bg-slate-800 rounded-lg shadow-md cursor-pointer hover:scale-101 hover:shadow-lg transition-all duration-300">
                            <img src="{{ $article->banner_url }}" alt="{{ $article->title }}"
                                class="w-full h-32 object-cover rounded-t-lg opacity-70">
                            <div class="p-3">
                                <h4 class="font-bold text-gray-800 dark:text-white truncate">{{ $article->title }}</h4>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500 dark:text-slate-400">Tidak ada draf artikel.</p>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Modal detail article --}}
        <div x-show="articleModal" x-cloak x-transition.opacity class="fixed inset-0 bg-black/40 backdrop-blur-sm z-50">
        </div>
        <div x-show="articleModal" x-cloak x-transition class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div x-cloak x-transition.opacity
                class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
                <div @click.outside="articleModal = false"
                    class="bg-white dark:bg-slate-800 rounded-lg shadow-xl w-full max-w-2xl max-h-[90vh] flex flex-col">
                    <div class="p-4 border-b dark:border-slate-700 flex justify-between items-center">
                        <h3 class="text-xl font-bold text-gray-800 dark:text-white" x-text="articleToShow.title"></h3>
                        <button @click="articleModal = false"
                            class="text-gray-500 hover:text-gray-800 dark:hover:text-white"><svg
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg></button>
                    </div>
                    <div class="p-6 space-y-4 overflow-y-auto">
                        <img :src="articleToShow.banner_url" :alt="articleToShow.title"
                            class="w-full rounded-lg aspect-video object-cover bg-gray-200 dark:bg-slate-700">
                        <p class="text-gray-600 dark:text-slate-300 whitespace-pre-wrap" x-text="articleToShow.content"></p>
                    </div>
                    <div class="p-4 border-t dark:border-slate-700 flex flex-wrap justify-end gap-4">
                        <form :action="`/articles/${articleToShow.slug}`" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="px-4 py-2 rounded-lg red-gradient-wh text-white font-medium">Hapus</button>
                        </form>
                        <a :href="`/articles/${articleToShow.slug}/edit`"
                            class="px-4 py-2 rounded-lg blue-gradient-wh text-white font-medium">Edit</a>
                        <form :action="`/articles/${articleToShow.slug}/status`" method="POST">
                            @csrf
                            @method('PATCH')
                            <template x-if="articleToShow.status === 'active'">
                                <button type="submit"
                                    class="px-4 py-2 rounded-lg yellow-gradient-wh text-white font-medium">Jadikan
                                    Private</button>
                            </template>
                            <template x-if="articleToShow.status === 'inactive'">
                                <button type="submit"
                                    class="px-4 py-2 rounded-lg green-gradient-wh text-white font-medium">Publish
                                    Artikel</button>
                            </template>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
