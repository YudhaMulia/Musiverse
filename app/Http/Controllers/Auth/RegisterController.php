<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class RegisterController extends Controller
{
    public function showRegister(Request $request): View
    {
        $kembali = $request->query('kembali');
        if (is_string($kembali) && str_starts_with($kembali, '/') && ! str_starts_with($kembali, '//')) {
            session(['url.intended' => url($kembali)]);
        }

        return view('auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:60'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        // Password otomatis di-hash oleh casts() di model User
        $user = User::create($data + ['avatar' => random_int(1, 10)]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->intended(route('games.index'));
    }
}
