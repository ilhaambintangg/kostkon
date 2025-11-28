<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\Room;
use App\Models\Booking;
use App\Models\User;

class ReportController extends Controller
{
    public function index()
    {
        // Statistik
        $totalProperties = Property::count();
        $totalRooms = Room::count();
        $availableRooms = Room::where('status', 'Tersedia')->count();
        $totalBookings = Booking::count();
        $pendingBookings = Booking::where('status', 'Pending')->count();
        $confirmedBookings = Booking::where('status', 'Confirmed')->count();
        $rejectedBookings = Booking::where('status', 'Rejected')->count();
        $totalPenyewa = User::where('role', 'penyewa')->count();

        // Booking terbaru
        $recentBookings = Booking::with(['user', 'room.property'])
            ->latest()
            ->limit(10)
            ->get();

        // Room paling banyak dibooking
        $popularRooms = Room::withCount('bookings')
            ->orderBy('bookings_count', 'desc')
            ->limit(5)
            ->get();

        return view('admin.reports.index', compact(
            'totalProperties',
            'totalRooms',
            'availableRooms',
            'totalBookings',
            'pendingBookings',
            'confirmedBookings',
            'rejectedBookings',
            'totalPenyewa',
            'recentBookings',
            'popularRooms'
        ));
    }
}