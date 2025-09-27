@extends('layouts.master')
@section('title', 'Dashboard')
@section('content')
    <div
        class="bg-white dark:bg-slate-700/50 rounded-l-xl dark:border-l dark:border-slate-700 shadow-xl px-6 py-4 flex flex-col" >
        <div class="flex items-center justify-between">
            <h1 class="text-3xl font-extrabold text-gray-700 dark:text-white">Selamat datang di Dashboard MobiPlay</h1>
            <div class="hidden lg:flex items-center gap-3">
                <p class="text-gray-700 dark:text-white font-medium">{{ Auth::user()->name }}</p>
                <div
                    class="w-10 h-10 rounded-full bg-gradient-to-br from-violet-400 to-blue-400 flex items-center justify-center shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-6 h-6 text-white drop-shadow-lg"
                        viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M12 2a7 7 0 0 1 7 7c0 3.866-3.134 7-7 7s-7-3.134-7-7a7 7 0 0 1 7-7Zm-9 18a9 9 0 0 1 18 0H3Z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
        </div>
        <div class="border-t border-gray-200 dark:border-slate-600/50 flex items-center justify-between mt-4 pt-4">
            <h2 class="text-2xl font-bold text-gray-700 dark:text-white">Dashboard</h2>
            {{-- <form action="{{ route('dashboard') }}" method="GET">
                <select name="year" class="blue-gradient rounded-lg px-3 py-2 text-white cursor-pointer focus:outline-none" onchange="this.form.submit()">
                    @foreach ($availableYears as $year)
                        <option value="{{ $year }}" {{ $year == $selectedYear ? 'selected' : '' }}>
                            {{ $year }}
                        </option>
                    @endforeach
                </select>
            </form> --}}
        </div>
    </div>
@endsection
