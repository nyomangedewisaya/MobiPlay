@extends('frontend.profiles.profile')
@section('title', 'Edit Profil')
@section('profile-content')
    <div class="bg-slate-800 rounded-lg shadow-xl p-8" data-aos="fade-up">
        <h3 class="text-lg font-bold text-gray-200 border-b border-slate-600/50 pb-4 mb-6">Informasi Profil</h3>
        <form action="{{ route('profile.update') }}" method="POST">
            @csrf
            @method('PATCH')
            <div class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-200 mb-1">Nama</label>
                    <input type="text" name="name" id="name" value="{{ old('name', auth()->user()->name) }}" class="w-full bg-slate-600/50 border border-gray-600 text-gray-200 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-200 mb-1">Alamat Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', auth()->user()->email) }}" class="w-full bg-slate-600/50 border border-gray-600 text-gray-200 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
            <div class="flex justify-end mt-6 pt-4 border-t border-slate-600/50">
                <button type="submit" class="blue-gradient-wh text-white rounded-lg px-4 py-2 font-semibold">Simpan Perubahan</button>
            </div>
        </form>
    </div>
@endsection
