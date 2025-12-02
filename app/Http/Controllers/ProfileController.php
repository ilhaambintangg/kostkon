<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    // Tampilkan halaman edit profile
    public function edit()
    {
        $user = auth()->user();
        return view('penyewa.profile.edit', compact('user'));
    }

    // Update profile (FIX BUG: Tidak logout setelah update)
    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'bank_name' => 'nullable|string|max:100',
            'account_number' => 'nullable|string|max:50',
            'account_holder_name' => 'nullable|string|max:255',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:6|confirmed',
        ]);

        $data = $request->only(['name', 'email', 'phone', 'bank_name', 'account_number', 'account_holder_name']);

        // Upload foto profil
        if ($request->hasFile('profile_photo')) {
            // Hapus foto lama
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }
            $data['profile_photo'] = $request->file('profile_photo')->store('profiles', 'public');
        }

        // Update password jika diisi
        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Password lama salah'])->withInput();
            }
            $data['password'] = Hash::make($request->new_password);
        }

        // ← FIX BUG: Update tanpa logout
        $user->update($data);

        // ← PENTING: Refresh user data di session tanpa logout
        Auth::setUser($user->fresh());

        return back()->with('success', 'Profile berhasil diperbarui!');
    }

    // Hapus foto profil
    public function deletePhoto()
    {
        $user = auth()->user();

        if ($user->profile_photo) {
            Storage::disk('public')->delete($user->profile_photo);
            $user->update(['profile_photo' => null]);
            
            // Refresh session
            Auth::setUser($user->fresh());
        }

        return back()->with('success', 'Foto profil berhasil dihapus!');
    }
}