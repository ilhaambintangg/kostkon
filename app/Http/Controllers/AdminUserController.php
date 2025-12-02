<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminUserController extends Controller
{
    // List semua user pending approval
    public function index()
    {
        $pendingUsers = User::where('role', 'penyewa')
            ->where('is_verified', true)
            ->where('is_approved', false)
            ->latest()
            ->get();

        $approvedUsers = User::where('role', 'penyewa')
            ->where('is_approved', true)
            ->latest()
            ->get();

        return view('admin.users.index', compact('pendingUsers', 'approvedUsers'));
    }

    // Approve user
    public function approve(User $user)
    {
        if ($user->role !== 'penyewa') {
            return back()->withErrors(['error' => 'Hanya penyewa yang bisa diapprove']);
        }

        $user->update([
            'is_approved' => true,
            'approved_at' => now(),
            'approved_by' => auth()->id(),
        ]);

        return back()->with('success', "User {$user->name} berhasil disetujui!");
    }

    // Reject user
    public function reject(User $user)
    {
        if ($user->role !== 'penyewa') {
            return back()->withErrors(['error' => 'Invalid action']);
        }

        // Hapus user yang ditolak
        $user->delete();

        return back()->with('success', 'User berhasil ditolak dan dihapus dari sistem.');
    }

    // Admin profile
    public function editProfile()
    {
        $admin = auth()->user();
        return view('admin.profile.edit', compact('admin'));
    }

    // Update admin profile
    public function updateProfile(Request $request)
    {
        $admin = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $admin->id,
            'phone' => 'nullable|string|max:20',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:6|confirmed',
        ]);

        $data = $request->only(['name', 'email', 'phone']);

        // Upload foto profil
        if ($request->hasFile('profile_photo')) {
            if ($admin->profile_photo) {
                \Storage::disk('public')->delete($admin->profile_photo);
            }
            $data['profile_photo'] = $request->file('profile_photo')->store('profiles', 'public');
        }

        // Update password jika diisi
        if ($request->filled('current_password')) {
            if (!\Hash::check($request->current_password, $admin->password)) {
                return back()->withErrors(['current_password' => 'Password lama salah'])->withInput();
            }
            $data['password'] = \Hash::make($request->new_password);
        }

        $admin->update($data);

        return back()->with('success', 'Profile berhasil diperbarui!');
    }
}