<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Room;

class BookingController extends Controller
{
    // List kamar tersedia (untuk penyewa)
    public function index()
    {
        $rooms = Room::where('status', 'Tersedia')->with('property')->get();
        return view('penyewa.rooms.index', compact('rooms'));
    }

    // Detail kamar
    public function show(Room $room)
    {
        return view('penyewa.rooms.show', compact('room'));
    }

    // Form booking
    public function create(Room $room)
    {
        if ($room->status !== 'Tersedia') {
            return redirect()->route('penyewa.rooms.index')->withErrors(['error' => 'Kamar tidak tersedia']);
        }

        return view('penyewa.bookings.create', compact('room'));
    }

    // Simpan booking
    public function store(Request $request, Room $room)
    {
        $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'notes' => 'nullable|string',
        ]);

        Booking::create([
            'room_id' => $room->id,
            'user_id' => auth()->id(),
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => 'Pending',
            'notes' => $request->notes,
        ]);

        return redirect()->route('dashboard')->with('success', 'Booking berhasil! Menunggu konfirmasi admin.');
    }

    // Upload bukti pembayaran
    public function uploadPayment(Request $request, Booking $booking)
    {
        // Cek ownership    
        if ($booking->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'payment_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Hapus bukti lama jika ada
        if ($booking->payment_image) {
            \Storage::disk('public')->delete($booking->payment_image);
        }

        $path = $request->file('payment_image')->store('payments', 'public');

        $booking->update([
            'payment_image' => $path,
        ]);

        return back()->with('success', 'Bukti pembayaran berhasil diupload!');
    }

    // Admin: List semua booking
    public function adminIndex()
    {
        $bookings = Booking::with(['user', 'room.property'])->latest()->get();
        return view('admin.bookings.index', compact('bookings'));
    }

    // Admin: Update status booking
    public function updateStatus(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => 'required|in:Pending,Confirmed,Rejected',
        ]);

        $booking->update([
            'status' => $request->status,
        ]);

        // Jika confirmed, ubah status room jadi tidak tersedia
        if ($request->status === 'Confirmed') {
            $booking->room->update(['status' => 'Tidak Tersedia']);
        }

        return back()->with('success', 'Status booking berhasil diupdate!');
    }
}