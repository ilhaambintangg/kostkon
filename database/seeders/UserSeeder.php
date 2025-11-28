<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin KostKon',
            'email' => 'admin@kostkon.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'is_verified' => true,
        ]);

        // Penyewa
        User::create([
            'name' => 'Budi Penyewa',
            'email' => 'budi@gmail.com',
            'password' => Hash::make('budi123'),
            'role' => 'penyewa',
            'is_verified' => true,
        ]);

        User::create([
            'name' => 'Siti Penyewa',
            'email' => 'siti@gmail.com',
            'password' => Hash::make('siti123'),
            'role' => 'penyewa',
            'is_verified' => true,
        ]);
    }
}