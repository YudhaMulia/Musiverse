<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('profile.edit', ['user' => $request->user()]);
    }

    // Ubah nama dan email
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        $data = $request->validate([
            'name'  => ['required', 'string', 'max:60'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
        ]);

        $user->update($data);

        return back()->with('status_profil', 'Profil berhasil diperbarui.');
    }

    // Ganti avatar (pilih 1 dari 10 karakter)
    public function updateAvatar(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'avatar' => ['required', 'integer', 'between:1,10'],
        ]);

        $request->user()->update(['avatar' => $data['avatar']]);

        return back()->with('status_avatar', 'Avatar berhasil diganti.');
    }

    // Ubah kata sandi
    public function updatePassword(Request $request): RedirectResponse
    {
        $user = $request->user();

        $aturan = [
            'password' => ['required', 'confirmed', Password::min(8)],
        ];

        if (! is_null($user->password)) {
            $aturan['current_password'] = ['required', 'current_password'];
        }

        // Error disimpan di "bag" bernama password supaya tidak tercampur dengan form lain
        $request->validateWithBag('password', $aturan);

        $user->update(['password' => $request->password]);   // di-hash otomatis oleh model User

        return back()->with('status_password', 'Kata sandi berhasil diubah.');
    }
}