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
        'is_verified',
        'is_approved',
        'approved_at',
        'approved_by',
        'profile_photo',
        'phone',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // ← PERBAIKI BAGIAN INI
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'approved_at' => 'datetime',        // ← PENTING: Cast ke datetime
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
}