<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = auth()->user();
        return view('penyewa.profile.edit', compact('user'));
    }

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
            'current_password' => 'nullable',
            'new_password' => 'nullable|min:6|confirmed',
        ]);

        $data = $request->only([
            'name', 'email', 'phone', 'bank_name',
            'account_number', 'account_holder_name'
        ]);

        // Upload foto profil
        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }
            $data['profile_photo'] = $request->file('profile_photo')->store('profiles', 'public');
        }

        // ================================================
        // PERBAIKAN LOGIKA PASSWORD (ONLY THIS PART CHANGED)
        // ================================================
        
        // Password opsional: hanya proses jika new_password diisi
        if ($request->filled('new_password')) {
            // Jika new_password diisi, current_password wajib diisi
            $request->validate([
                'current_password' => 'required',
            ]);
            
            // Cek password lama
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Password lama salah'])->withInput();
            }
            
            // Simpan password baru
            $data['password'] = Hash::make($request->new_password);
        }
        // Jika new_password kosong, abaikan saja - tidak perlu validasi current_password
        // ================================================

        $user->update($data);

        // Refresh tanpa logout
        Auth::setUser($user->fresh());

        return back()->with('success', 'Profile berhasil diperbarui!');
    }

    public function deletePhoto()
    {
        $user = auth()->user();

        if ($user->profile_photo) {
            Storage::disk('public')->delete($user->profile_photo);
            $user->update(['profile_photo' => null]);

            Auth::setUser($user->fresh());
        }

        return back()->with('success', 'Foto profil berhasil dihapus!');
    }
}