@extends('layouts.master')
@section('title', 'Dashboard')
@section('content')
    <div
        class="bg-white dark:bg-slate-700/50 rounded-l-xl dark:border-l dark:border-slate-700 shadow-xl px-6 py-4 flex flex-col">
        <div class="flex items-center justify-between">
            <h1 class="text-3xl font-extrabold text-gray-700 dark:text-white">Selamat datang di Dashboard MobiPlay</h1>
            <div class="hidden lg:flex items-center gap-3">
                <p class="text-gray-700 dark:text-white font-medium">{{ Auth::user()->name }}</p>
                <img src="" alt="{{ Auth::user()->name }}" class="w-12 h-12 rounded-full border border-slate-700">
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
