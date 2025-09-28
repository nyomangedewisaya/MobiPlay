@extends('layouts.master')
@section('title', 'Edit Input Field')
@section('content')
    <div
        class="bg-white dark:bg-slate-700/50 rounded-l-xl dark:border-l dark:border-slate-700 shadow-xl px-6 py-4 flex flex-col h-[calc(100vh)]">
        {{-- Header --}}
        <div class="border-b border-gray-200 dark:border-slate-600/50 mb-6 pb-4" data-aos="fade-up">
            <a href="{{ route('managements.input-fields.index', $product) }}"
                class="text-sm text-blue-500 hover:underline mb-2 flex items-center gap-2"><svg
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                </svg>
                Kembali ke Daftar Fields</a>
            <h2 class="text-2xl font-bold text-gray-700 dark:text-white">Edit Input Field:
                {{ $productInputField->field_label }}</h2>
        </div>

        {{-- Form input update for input fields --}}
        <form action="{{ route('managements.input-fields.update', $productInputField) }}" method="POST"
            class="flex flex-col flex-grow" data-aos="fade-up">
            @csrf
            @method('PUT')
            <div class="flex-grow overflow-y-auto pr-4 space-y-6" x-data="{ fieldType: '{{ old('field_type', $productInputField->field_type) }}' }">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="field_label"
                            class="block text-sm font-medium text-gray-700 dark:text-slate-200 mb-1">Label Field</label>
                        <input type="text" name="field_label" id="field_label"
                            value="{{ old('field_label', $productInputField->field_label) }}"
                            class="w-full bg-gray-100 dark:bg-slate-700 border border-gray-300 dark:border-slate-600 text-gray-800 dark:text-gray-200 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                        @error('field_label')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="field_name"
                            class="block text-sm font-medium text-gray-700 dark:text-slate-200 mb-1">Field Name</label>
                        <input type="text" name="field_name" id="field_name"
                            value="{{ old('field_name', $productInputField->field_name) }}"
                            class="w-full bg-gray-100 dark:bg-slate-700 border border-gray-300 dark:border-slate-600 text-gray-800 dark:text-gray-200 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                        @error('field_name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label for="field_desc"
                            class="block text-sm font-medium text-gray-700 dark:text-slate-200 mb-1">Deskripsi
                            Singkat</label>
                        <input type="text" name="field_desc" id="field_desc"
                            value="{{ old('field_desc', $productInputField->field_desc) }}"
                            class="w-full bg-gray-100 dark:bg-slate-700 border border-gray-300 dark:border-slate-600 text-gray-800 dark:text-gray-200 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                        @error('field_desc')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="placeholder"
                            class="block text-sm font-medium text-gray-700 dark:text-slate-200 mb-1">Placeholder(Opsional)</label>
                        <input type="text" name="placeholder" id="placeholder"
                            value="{{ old('placeholder', $productInputField->placeholder) }}"
                            class="w-full bg-gray-100 dark:bg-slate-700 border border-gray-300 dark:border-slate-600 text-gray-800 dark:text-gray-200 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('placeholder')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="validation_rules"
                            class="block text-sm font-medium text-gray-700 dark:text-slate-200 mb-1">Aturan Validasi</label>
                        <input type="text" name="validation_rules" id="validation_rules"
                            value="{{ old('validation_rules', $productInputField->validation_rules) }}"
                            class="w-full bg-gray-100 dark:bg-slate-700 border border-gray-300 dark:border-slate-600 text-gray-800 dark:text-gray-200 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                        @error('validation_rules')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="field_type"
                            class="block text-sm font-medium text-gray-700 dark:text-slate-200 mb-1">Tipe Field</label>
                        <select name="field_type" id="field_type" x-model="fieldType"
                            class="w-full bg-gray-100 dark:bg-slate-700 border border-gray-300 dark:border-slate-600 text-gray-800 dark:text-gray-200 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                            <option value="text"
                                {{ old('field_type', $productInputField->field_type) == 'text' ? 'selected' : '' }}>Text
                            </option>
                            <option value="number"
                                {{ old('field_type', $productInputField->field_type) == 'number' ? 'selected' : '' }}>
                                Number</option>
                            <option value="select"
                                {{ old('field_type', $productInputField->field_type) == 'select' ? 'selected' : '' }}>
                                Select</option>
                        </select>
                        @error('field_type')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div x-show="fieldType === 'select'" x-transition class="md:col-span-2">
                        <label for="field_options"
                            class="block text-sm font-medium text-gray-700 dark:text-slate-200 mb-1">Opsi Pilihan (pisahkan
                            dengan koma)</label>
                        <textarea name="field_options" id="field_options" rows="3"
                            class="w-full bg-gray-100 dark:bg-slate-700 border border-gray-300 dark:border-slate-600 text-gray-800 dark:text-gray-200 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('field_options', implode(', ', $productInputField->field_options ?? [])) }}</textarea>
                        @error('field_options')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="flex items-center justify-end gap-4 mt-6">
                    <a href="{{ route('managements.input-fields.index', $productInputField->product) }}"
                        class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 dark:bg-slate-600 dark:text-white dark:hover:bg-slate-500 transition-colors duration-300">Batal</a>
                    <button type="submit" class="blue-gradient-wh text-white rounded-lg px-4 py-2 font-semibold">Simpan
                        Perubahan</button>
                </div>
            </div>
        </form>
    </div>
@endsection
