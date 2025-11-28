<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;

class PropertyController extends Controller
{
    // List semua properti
    public function index()
    {
        $properties = Property::withCount('rooms')->get();
        return view('admin.properties.index', compact('properties'));
    }

    // Form tambah properti
    public function create()
    {
        return view('admin.properties.create');
    }

    // Simpan properti baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->only(['name', 'address', 'description']);

        // Upload image jika ada
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('properties', 'public');
        }

        Property::create($data);

        return redirect()->route('properties.index')->with('success', 'Properti berhasil ditambahkan!');
    }

    // Form edit properti
    public function edit(Property $property)
    {
        return view('admin.properties.edit', compact('property'));
    }

    // Update properti
    public function update(Request $request, Property $property)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->only(['name', 'address', 'description']);

        // Upload image baru jika ada
        if ($request->hasFile('image')) {
            // Hapus image lama jika ada
            if ($property->image) {
                \Storage::disk('public')->delete($property->image);
            }
            $data['image'] = $request->file('image')->store('properties', 'public');
        }

        $property->update($data);

        return redirect()->route('properties.index')->with('success', 'Properti berhasil diupdate!');
    }

    // Hapus properti
    public function destroy(Property $property)
    {
        // Hapus image jika ada
        if ($property->image) {
            \Storage::disk('public')->delete($property->image);
        }

        $property->delete();

        return redirect()->route('properties.index')->with('success', 'Properti berhasil dihapus!');
    }
}