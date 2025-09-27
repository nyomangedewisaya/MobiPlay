@extends('layouts.master')
@section('title', 'Kategori')
@section('content')
    @include('partials.alert')
    <div class="bg-white dark:bg-slate-700/50 rounded-l-xl dark:border-l dark:border-slate-700 shadow-xl px-6 py-4 flex flex-col h-[calc(100vh)]"
        x-data="{
            deleteModal: false,
            searchQuery: '{{ request('search', '') }}',
            categoryToDelete: {},
            openDeleteModal(category) {
                this.categoryToDelete = category;
                this.deleteModal = true
            }
        }">
        <div class="border-b border-gray-200 dark:border-slate-600/50 flex flex-col gap-y-2 md:flex-row md:items-center md:justify-between mb-4 pb-4 gap-0" data-aos="fade-up">
            <h2 class="text-2xl font-bold text-gray-700 dark:text-white">Kategori</h2>
            <div class="flex items-stretch gap-4 w-full md:w-auto">
                <form action="{{ route('managements.categories.index') }}" method="GET" class="relative w-full sm:w-auto">
                    <input type="text" name="search" x-model="searchQuery"
                        class="w-full bg-gray-200 dark:bg-slate-600/50 border border-gray-300 dark:border-gray-600 text-gray-800 dark:text-gray-200 rounded-full pl-4 pr-10 py-3 focus:outline-none"
                        placeholder="Cari nama kategori...">

                    <button type="button" x-show="searchQuery"
                        @click="searchQuery = ''; window.location.href = '{{ route('managements.categories.index') }}'"
                        x-cloak
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
                <a href="{{ route('managements.categories.create') }}"
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
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg flex-1 overflow-y-auto" data-aos="fade-up">
            <table
                class="w-full text-md text-left text-gray-500 dark:text-gray-400 divide divide-gray-200 dark:divide-slate-60/50">
                <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-slate-700 dark:text-slate-300 sticky top-0">
                    <tr>
                        <th scope="col" class="px-6 py-3 w-16">
                            No
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Nama Kategori
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Jumlah Produk
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-slate-700"">
                    @forelse ($categories as $category)
                        <tr class="bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-800/5">
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $loop->iteration }}
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $category->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($category->products_count == 0)
                                    <span
                                        class="red-gradient text-white text-xs font-medium me-2 px-2.5 py-0.5 rounded">
                                        Kosong
                                    </span>
                                @else
                                    <span
                                        class="blue-gradient text-white text-xs font-medium me-2 px-2.5 py-0.5 rounded">
                                        {{ $category->products_count }} Produk
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('managements.categories.edit', $category) }}"
                                        class="blue-gradient-wh text-white rounded-lg p-2 hover:-translate-y-0.5 transition-all duration-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                        </svg>
                                    </a>
                                    @if ($category->products_count == 0)
                                        <button @click="openDeleteModal({{ json_encode($category) }})"
                                            class="red-gradient-wh text-white rounded-lg p-2 hover:-translate-y-0.5 transition-all duration-300">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                            </svg>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-gray-500 dark:text-gray-400">
                                Tidak ada data kategori.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Modals for delete Categories --}}
        <div x-show="deleteModal" x-cloak x-transition.opacity class="fixed inset-0 bg-black/40 backdrop-blur-sm z-50">
        </div>
        <div x-show="deleteModal" x-cloak x-transition
            class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div @click.outside="deleteModal = false"
                class="bg-white dark:bg-slate-800 rounded-lg shadow-xl w-full max-w-md p-6">
                <h3 class="text-xl font-bold text-gray-800 dark:text-white">Konfirmasi Hapus</h3>
                <p class="text-gray-600 dark:text-slate-300 mt-4">
                    Apakah Anda yakin ingin menghapus kategori "<strong class="font-bold"
                        x-text="categoryToDelete.name"></strong>"?
                </p>
                <form :action="`/managements/categories/${categoryToDelete.slug}`" method="POST"
                    class="flex justify-end gap-4 mt-6">
                    @csrf
                    @method('DELETE')
                    <button type="button" @click="deleteModal = false"
                        class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">Batal</button>
                    <button type="submit" class="red-gradient-wh text-white rounded-lg px-4 py-2">Ya, Hapus</button>
                </form>
            </div>
        </div>
    </div>
@endsection
