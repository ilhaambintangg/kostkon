<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\OTPMail;

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
            return back()->withErrors(['email' => 'Akun belum diverifikasi. Silakan cek email Anda.'])->withInput();
        }

        if ($user->role === 'penyewa' && !$user->is_approved) {
            return back()->withErrors([
                'email' => 'Akun Anda sedang menunggu persetujuan admin. Anda akan dihubungi setelah disetujui.'
            ])->withInput();
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

    // Proses registrasi (KIRIM OTP KE EMAIL)
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        // Generate OTP 6 digit
        $otpCode = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'penyewa',
            'otp_code' => $otpCode,
            'otp_expires_at' => now()->addMinutes(10), // Expired 10 menit
            'is_verified' => false,
        ]);

        // Kirim OTP via email
        try {
            Mail::to($user->email)->send(new OTPMail($otpCode, $user->name));
            
            // Simpan user_id di session
            session(['verification_user_id' => $user->id]);

            return redirect()->route('verify.show')->with('success', 'Registrasi berhasil! Kode OTP telah dikirim ke email Anda. Silakan cek inbox/spam.');
        } catch (\Exception $e) {
            // Jika gagal kirim email, hapus user dan tampilkan error
            $user->delete();
            return back()->withErrors(['email' => 'Gagal mengirim email. Pastikan email valid.'])->withInput();
        }
    }

    // Tampilkan form verifikasi OTP
    public function showVerify()
    {
        if (!session('verification_user_id')) {
            return redirect()->route('register')->withErrors(['error' => 'Silakan registrasi terlebih dahulu']);
        }

        return view('auth.verify');
    }

    // Proses verifikasi OTP
    public function verify(Request $request)
    {
        $request->validate([
            'otp_code' => 'required|size:6',
        ]);

        $userId = session('verification_user_id');
        $user = User::find($userId);

        if (!$user) {
            return back()->withErrors(['error' => 'User tidak ditemukan']);
        }

        // Cek OTP expired
        if ($user->isOtpExpired()) {
            return back()->withErrors(['otp_code' => 'Kode OTP sudah kadaluarsa. Silakan registrasi ulang.'])->withInput();
        }

        // Cek OTP match
        if ($user->otp_code === $request->otp_code) {
            $user->update([
                'is_verified' => true,
                'otp_code' => null,
                'otp_expires_at' => null,
            ]);

            session()->forget('verification_user_id');

            return redirect()->route('login')->with('success', 'Verifikasi berhasil! Silakan login. Akun Anda akan segera di-review oleh admin.');
        }

        return back()->withErrors(['otp_code' => 'Kode OTP salah'])->withInput();
    }

    // Resend OTP
    public function resendOtp()
    {
        $userId = session('verification_user_id');
        
        if (!$userId) {
            return redirect()->route('register')->withErrors(['error' => 'Session expired. Silakan registrasi ulang.']);
        }

        $user = User::find($userId);

        if (!$user) {
            return redirect()->route('register')->withErrors(['error' => 'User tidak ditemukan']);
        }

        // Generate OTP baru
        $otpCode = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

        $user->update([
            'otp_code' => $otpCode,
            'otp_expires_at' => now()->addMinutes(10),
        ]);

        // Kirim ulang via email
        try {
            Mail::to($user->email)->send(new OTPMail($otpCode, $user->name));
            return back()->with('success', 'Kode OTP baru telah dikirim ke email Anda!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal mengirim email. Coba lagi.']);
        }
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