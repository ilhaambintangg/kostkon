<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'verification_code',
        'otp_code',              // ← BARU
        'otp_expires_at',        // ← BARU
        'is_verified',
        'is_approved',
        'approved_at',
        'approved_by',
        'profile_photo',
        'phone',
        'bank_name',             // ← BARU
        'account_number',        // ← BARU
        'account_holder_name',   // ← BARU
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'otp_code',              // ← BARU: Hide dari API
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'approved_at' => 'datetime',
            'otp_expires_at' => 'datetime',   // ← BARU
            'password' => 'hashed',
            'is_verified' => 'boolean',
            'is_approved' => 'boolean',
        ];
    }

    // Relasi
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // ← BARU: Helper method untuk cek OTP expired
    public function isOtpExpired()
    {
        return $this->otp_expires_at && now()->isAfter($this->otp_expires_at);
    }
}