<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Room;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        // Rooms untuk Property 1
        Room::create([
            'property_id' => 1,
            'room_name' => 'Kamar A1',
            'price' => 800000,
            'status' => 'Tersedia',
            'description' => 'Kamar standar dengan kasur single, lemari, meja belajar',
        ]);

        Room::create([
            'property_id' => 1,
            'room_name' => 'Kamar A2',
            'price' => 1000000,
            'status' => 'Tersedia',
            'description' => 'Kamar deluxe dengan AC, kasur queen size, kamar mandi dalam',
        ]);

        // Rooms untuk Property 2
        Room::create([
            'property_id' => 2,
            'room_name' => 'Rumah Tipe 36',
            'price' => 2500000,
            'status' => 'Tersedia',
            'description' => '2 kamar tidur, 1 kamar mandi, dapur, ruang tamu',
        ]);

        Room::create([
            'property_id' => 2,
            'room_name' => 'Rumah Tipe 45',
            'price' => 3000000,
            'status' => 'Tidak Tersedia',
            'description' => '3 kamar tidur, 2 kamar mandi, carport',
        ]);

        // Rooms untuk Property 3
        Room::create([
            'property_id' => 3,
            'room_name' => 'Kamar B1',
            'price' => 750000,
            'status' => 'Tersedia',
            'description' => 'Kamar ekonomis, kasur single, lemari',
        ]);

        Room::create([
            'property_id' => 3,
            'room_name' => 'Kamar B2',
            'price' => 900000,
            'status' => 'Tersedia',
            'description' => 'Kamar dengan AC, kasur single, meja belajar',
        ]);
    }
}