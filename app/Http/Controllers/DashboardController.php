<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\Room;
use App\Models\Booking;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            // Dashboard Admin
            $totalProperties = Property::count();
            $totalRooms = Room::where('status', 'Tersedia')->count();
            $totalBookings = Booking::count();
            $pendingBookings = Booking::where('status', 'Pending')->count();

            return view('admin.dashboard', compact(
                'totalProperties',
                'totalRooms',
                'totalBookings',
                'pendingBookings'
            ));
        } else {
            // Dashboard Penyewa
            $myBookings = Booking::where('user_id', $user->id)
                ->with(['room.property'])
                ->latest()
                ->get();

            return view('penyewa.dashboard', compact('myBookings'));
        }
    }
}