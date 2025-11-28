<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Property;

class PropertySeeder extends Seeder
{
    public function run(): void
    {
        Property::create([
            'name' => 'Kos Mawar Residence',
            'address' => 'Jl. Mawar No. 123, Bandar Lampung',
            'description' => 'Kos nyaman dekat kampus Unila, fasilitas lengkap',
        ]);

        Property::create([
            'name' => 'Kontrakan Melati Asri',
            'address' => 'Jl. Melati No. 45, Way Halim',
            'description' => 'Kontrakan keluarga, lingkungan aman dan tenang',
        ]);

        Property::create([
            'name' => 'Kos Anggrek Putih',
            'address' => 'Jl. Anggrek No. 78, Rajabasa',
            'description' => 'Kos putra/putri, dekat minimarket dan rumah makan',
        ]);
    }
}