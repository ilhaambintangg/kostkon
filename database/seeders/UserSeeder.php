<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin (auto approved)
        User::create([
            'name' => 'Admin KostKon',
            'email' => 'admin@kostkon.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'is_verified' => true,
            'is_approved' => true,  // Admin auto approved
            'approved_at' => now(),
        ]);

        // Penyewa (approved untuk testing)
        User::create([
            'name' => 'Budi Penyewa',
            'email' => 'budi@gmail.com',
            'password' => Hash::make('budi123'),
            'role' => 'penyewa',
            'is_verified' => true,
            'is_approved' => true,  // Approved untuk testing
            'approved_at' => now(),
        ]);

        User::create([
            'name' => 'Siti Penyewa',
            'email' => 'siti@gmail.com',
            'password' => Hash::make('siti123'),
            'role' => 'penyewa',
            'is_verified' => true,
            'is_approved' => true,  // Approved untuk testing
            'approved_at' => now(),
        ]);

        // User baru yang belum di-approve (untuk testing approval system)
        User::create([
            'name' => 'Andi Pending',
            'email' => 'andi@gmail.com',
            'password' => Hash::make('andi123'),
            'role' => 'penyewa',
            'is_verified' => true,
            'is_approved' => false,  // Menunggu approval
        ]);
    }
}