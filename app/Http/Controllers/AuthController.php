<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Tampilkan form login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email tidak ditemukan'])->withInput();
        }

        if (!$user->is_verified) {
            return back()->withErrors(['email' => 'Akun belum diverifikasi'])->withInput();
        }

        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Password salah'])->withInput();
        }

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->intended('/dashboard')->with('success', 'Login berhasil!');
    }

    // Tampilkan form registrasi
    public function showRegister()
    {
        return view('auth.register');
    }

    // Proses registrasi
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        // Generate kode verifikasi 6 digit
        $verificationCode = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'penyewa',
            'verification_code' => $verificationCode,
            'is_verified' => false,
        ]);

        // Simpan user_id di session untuk verifikasi
        session(['verification_user_id' => $user->id]);

        return redirect()->route('verify.show')->with('success', "Registrasi berhasil! Kode verifikasi Anda: $verificationCode (Simpan kode ini)");
    }

    // Tampilkan form verifikasi
    public function showVerify()
    {
        if (!session('verification_user_id')) {
            return redirect()->route('register')->withErrors(['error' => 'Silakan registrasi terlebih dahulu']);
        }

        return view('auth.verify');
    }

    // Proses verifikasi
    public function verify(Request $request)
    {
        $request->validate([
            'verification_code' => 'required|size:6',
        ]);

        $userId = session('verification_user_id');
        $user = User::find($userId);

        if (!$user) {
            return back()->withErrors(['error' => 'User tidak ditemukan']);
        }

        if ($user->verification_code === $request->verification_code) {
            $user->update([
                'is_verified' => true,
                'verification_code' => null,
            ]);

            session()->forget('verification_user_id');

            return redirect()->route('login')->with('success', 'Verifikasi berhasil! Silakan login.');
        }

        return back()->withErrors(['verification_code' => 'Kode verifikasi salah'])->withInput();
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Logout berhasil!');
    }
}