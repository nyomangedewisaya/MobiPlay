@extends('frontend.profiles.profile')

@section('title', 'Ganti Password')

@section('profile-content')
    <div class="bg-slate-800 rounded-lg shadow-xl p-8" data-aos="fade-up">
        <h3 class="text-lg font-bold text-gray-200 border-b border-slate-600/50 pb-4 mb-6">Ganti Password</h3>
        <form action="{{ route('profile.password.update') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="space-y-4">
                <div>
                    <label for="current_password" class="block text-sm font-medium text-gray-200 mb-1">Password Saat Ini</label>
                    <input type="password" name="current_password" id="current_password" class="w-full bg-slate-600/50 border border-gray-600 text-gray-200 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    @error('current_password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-200 mb-1">Password Baru</label>
                    <input type="password" name="password" id="password" class="w-full bg-slate-600/50 border border-gray-600 text-gray-200 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-200 mb-1">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="w-full bg-slate-600/50 border border-gray-600 text-gray-200 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
            </div>
            <div class="flex justify-end mt-6 pt-4 border-t border-slate-600/50">
                <button type="submit" class="blue-gradient-wh text-white rounded-lg px-4 py-2 font-semibold">Ganti Password</button>
            </div>
        </form>
    </div>
@endsection
