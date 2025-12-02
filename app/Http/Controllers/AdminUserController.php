<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

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

    // Reject user (hapus dari sistem)
    public function reject(User $user)
    {
        if ($user->role !== 'penyewa') {
            return back()->withErrors(['error' => 'Invalid action']);
        }

        // Hapus foto profil jika ada
        if ($user->profile_photo) {
            Storage::disk('public')->delete($user->profile_photo);
        }

        $user->delete();

        return back()->with('success', 'User berhasil ditolak dan dihapus dari sistem.');
    }

    // ← BARU: Delete user (untuk user yang sudah approved)
    public function destroy(User $user)
    {
        // Cek tidak bisa hapus admin atau diri sendiri
        if ($user->role === 'admin') {
            return back()->withErrors(['error' => 'Tidak bisa menghapus akun admin!']);
        }

        if ($user->id === auth()->id()) {
            return back()->withErrors(['error' => 'Tidak bisa menghapus akun sendiri!']);
        }

        // Hapus foto profil jika ada
        if ($user->profile_photo) {
            Storage::disk('public')->delete($user->profile_photo);
        }

        // Hapus semua booking terkait (cascade)
        $user->bookings()->each(function($booking) {
            if ($booking->payment_image) {
                Storage::disk('public')->delete($booking->payment_image);
            }
            if ($booking->refund_proof) {
                Storage::disk('public')->delete($booking->refund_proof);
            }
            $booking->delete();
        });

        $userName = $user->name;
        $user->delete();

        return back()->with('success', "User {$userName} berhasil dihapus dari sistem!");
    }

    // Admin profile
    public function editProfile()
    {
        $admin = auth()->user();
        return view('admin.profile.edit', compact('admin'));
    }

    // Update admin profile (FIX BUG SAMA)
    public function updateProfile(Request $request)
    {
        $admin = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $admin->id,
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
            if ($admin->profile_photo) {
                Storage::disk('public')->delete($admin->profile_photo);
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

        // Update tanpa logout
        $admin->update($data);
        
        // Refresh session
        Auth::setUser($admin->fresh());

        return back()->with('success', 'Profile berhasil diperbarui!');
    }
}