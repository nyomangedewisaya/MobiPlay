<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function loginAction(Request $request)
    {
        $validate = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|min:8',
        ], [
            'email.required' => 'Email tidak boleh kosong!',
            'password.required' => 'Password tidak boleh kosong!',
        ]);

        $data = [
            'email' => $validate['email'],
            'password' => $validate['password'],
        ];

        if (Auth::attempt($data)) {
            $request->session()->regenerate();

            if (Auth::user()->role === 'admin') {
                return redirect()->intended(route('dashboard'));
            }
            return redirect()->intended(route('home'));
        }

        return back()
            ->withErrors(['Email atau password salah'])
            ->onlyInput('email');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function registerAction(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|string|email|max:50',
            'password' => 'required|string|min:8',
        ], [
            'name.required' => 'Nama lengkap tidak boleh kosong!',
            'email.required' => 'Email tidak boleh kosong!',
            'password.required' => 'Password tidak boleh kosong!',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);
        // Auth::login($user);
        // $request->session()->regenerate();

        // return redirect()->route('home');
    }
}
