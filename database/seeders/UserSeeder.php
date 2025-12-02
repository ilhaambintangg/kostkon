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
            'is_approved' => true,
            'approved_at' => now(),
            'phone' => '081234567890',
            'bank_name' => 'BCA',
            'account_number' => '1234567890',
            'account_holder_name' => 'Admin KostKon',
        ]);

        // Penyewa 1 (approved untuk testing)
        User::create([
            'name' => 'Budi Penyewa',
            'email' => 'budi@gmail.com',
            'password' => Hash::make('budi123'),
            'role' => 'penyewa',
            'is_verified' => true,
            'is_approved' => true,
            'approved_at' => now(),
            'phone' => '082345678901',
            'bank_name' => 'Mandiri',
            'account_number' => '9876543210',
            'account_holder_name' => 'Budi Santoso',
        ]);

        // Penyewa 2 (approved untuk testing)
        User::create([
            'name' => 'Siti Penyewa',
            'email' => 'siti@gmail.com',
            'password' => Hash::make('siti123'),
            'role' => 'penyewa',
            'is_verified' => true,
            'is_approved' => true,
            'approved_at' => now(),
            'phone' => '083456789012',
            'bank_name' => 'BNI',
            'account_number' => '5555666677',
            'account_holder_name' => 'Siti Nurhaliza',
        ]);

        // User baru yang belum di-approve (untuk testing approval system)
        User::create([
            'name' => 'Andi Pending',
            'email' => 'andi@gmail.com',
            'password' => Hash::make('andi123'),
            'role' => 'penyewa',
            'is_verified' => true,
            'is_approved' => false,
            'phone' => '084567890123',
        ]);
    }
}