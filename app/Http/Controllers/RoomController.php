<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Property;

class RoomController extends Controller
{
    // List semua kamar
    public function index()
    {
        $rooms = Room::with('property')->get();
        return view('admin.rooms.index', compact('rooms'));
    }

    // Form tambah kamar
    public function create()
    {
        $properties = Property::all();
        return view('admin.rooms.create', compact('properties'));
    }

    // Simpan kamar baru
    public function store(Request $request)
    {
        $request->validate([
            'property_id' => 'required|exists:properties,id',
            'room_name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:Tersedia,Tidak Tersedia',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->only(['property_id', 'room_name', 'price', 'status', 'description']);

        // Upload image jika ada
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('rooms', 'public');
        }

        Room::create($data);

        return redirect()->route('rooms.index')->with('success', 'Kamar berhasil ditambahkan!');
    }

    // Form edit kamar
    public function edit(Room $room)
    {
        $properties = Property::all();
        return view('admin.rooms.edit', compact('room', 'properties'));
    }

    // Update kamar
    public function update(Request $request, Room $room)
    {
        $request->validate([
            'property_id' => 'required|exists:properties,id',
            'room_name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:Tersedia,Tidak Tersedia',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->only(['property_id', 'room_name', 'price', 'status', 'description']);

        // Upload image baru jika ada
        if ($request->hasFile('image')) {
            if ($room->image) {
                \Storage::disk('public')->delete($room->image);
            }
            $data['image'] = $request->file('image')->store('rooms', 'public');
        }

        $room->update($data);

        return redirect()->route('rooms.index')->with('success', 'Kamar berhasil diupdate!');
    }

    // Hapus kamar
    public function destroy(Room $room)
    {
        if ($room->image) {
            \Storage::disk('public')->delete($room->image);
        }

        $room->delete();

        return redirect()->route('rooms.index')->with('success', 'Kamar berhasil dihapus!');
    }
}