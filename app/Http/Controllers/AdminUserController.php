<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

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

        if ($user->profile_photo) {
            Storage::disk('public')->delete($user->profile_photo);
        }

        $user->delete();

        return back()->with('success', 'User berhasil ditolak dan dihapus.');
    }

    // Delete user approve
    public function destroy(User $user)
    {
        if ($user->role === 'admin') {
            return back()->withErrors(['error' => 'Tidak bisa menghapus akun admin!']);
        }

        if ($user->id === auth()->id()) {
            return back()->withErrors(['error' => 'Tidak bisa menghapus akun sendiri!']);
        }

        if ($user->profile_photo) {
            Storage::disk('public')->delete($user->profile_photo);
        }

        // Hapus booking + bukti
        $user->bookings()->each(function($booking) {
            if ($booking->payment_image) {
                Storage::disk('public')->delete($booking->payment_image);
            }
            if ($booking->refund_proof) {
                Storage::disk('public')->delete($booking->refund_proof);
            }
            $booking->delete();
        });

        $name = $user->name;
        $user->delete();

        return back()->with('success', "User {$name} berhasil dihapus!");
    }

    // Halaman edit profile admin
    public function editProfile()
    {
        $admin = auth()->user();
        return view('admin.profile.edit', compact('admin'));
    }

    // Update profile admin
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

            // Password
            'current_password' => 'nullable',
            'new_password' => 'nullable|min:6|confirmed',
        ]);

        $data = $request->only([
            'name', 'email', 'phone',
            'bank_name', 'account_number', 'account_holder_name'
        ]);

        // Upload foto profil
        if ($request->hasFile('profile_photo')) {
            if ($admin->profile_photo) {
                Storage::disk('public')->delete($admin->profile_photo);
            }

            $data['profile_photo'] = $request->file('profile_photo')->store('profiles', 'public');
        }

        // Update password jika diisi
        if ($request->filled('new_password')) {

            // Pastikan current password benar
            if (!Hash::check($request->current_password, $admin->password)) {
                return back()->withErrors(['current_password' => 'Password lama salah'])->withInput();
            }

            // Hash password baru
            $data['password'] = Hash::make($request->new_password);
        }

        // Update ke database
        $admin->update($data);

        // Refresh session agar tidak logout setelah ubah password
        Auth::setUser($admin->fresh());

        return back()->with('success', 'Profile berhasil diperbarui!');
    }
}
