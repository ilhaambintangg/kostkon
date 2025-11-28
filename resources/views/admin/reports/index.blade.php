@extends('layouts.app')

@section('title', 'Laporan')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h2><i class="bi bi-graph-up me-2"></i>Laporan Sistem</h2>
    </div>

    <!-- Statistics Overview -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-primary">
                <div class="card-body text-center">
                    <i class="bi bi-building text-primary" style="font-size: 2.5rem;"></i>
                    <h3 class="mt-2">{{ $totalProperties }}</h3>
                    <p class="text-muted mb-0">Total Properti</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-success">
                <div class="card-body text-center">
                    <i class="bi bi-door-open text-success" style="font-size: 2.5rem;"></i>
                    <h3 class="mt-2">{{ $totalRooms }}</h3>
                    <p class="text-muted mb-0">Total Kamar</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-info">
                <div class="card-body text-center">
                    <i class="bi bi-door-open-fill text-info" style="font-size: 2.5rem;"></i>
                    <h3 class="mt-2">{{ $availableRooms }}</h3>
                    <p class="text-muted mb-0">Kamar Tersedia</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-warning">
                <div class="card-body text-center">
                    <i class="bi bi-people text-warning" style="font-size: 2.5rem;"></i>
                    <h3 class="mt-2">{{ $totalPenyewa }}</h3>
                    <p class="text-muted mb-0">Total Penyewa</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Booking Statistics -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h6>Total Booking</h6>
                    <h2>{{ $totalBookings }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h6>Pending</h6>
                    <h2>{{ $pendingBookings }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h6>Confirmed</h6>
                    <h2>{{ $confirmedBookings }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <h6>Rejected</h6>
                    <h2>{{ $rejectedBookings }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <!-- Recent Bookings -->
        <div class="col-md-7">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="bi bi-clock-history me-2"></i>Booking Terbaru</h5>
                </div>
                <div class="card-body">
                    @if($recentBookings->isEmpty())
                        <p class="text-muted text-center">Belum ada booking</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Penyewa</th>
                                        <th>Kamar</th>
                                        <th>Tanggal</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentBookings as $booking)
                                        <tr>
                                            <td>{{ $booking->user->name }}</td>
                                            <td>{{ $booking->room->room_name }}</td>
                                            <td><small>{{ $booking->created_at->format('d M Y') }}</small></td>
                                            <td>
                                                @if($booking->status === 'Pending')
                                                    <span class="badge bg-warning">Pending</span>
                                                @elseif($booking->status === 'Confirmed')
                                                    <span class="badge bg-success">Confirmed</span>
                                                @else
                                                    <span class="badge bg-danger">Rejected</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Popular Rooms -->
        <div class="col-md-5">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="bi bi-star-fill text-warning me-2"></i>Kamar Terpopuler</h5>
                </div>
                <div class="card-body">
                    @if($popularRooms->isEmpty())
                        <p class="text-muted text-center">Belum ada data</p>
                    @else
                        <ul class="list-group list-group-flush">
                            @foreach($popularRooms as $room)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ $room->room_name }}</strong><br>
                                        <small class="text-muted">{{ $room->property->name }}</small>
                                    </div>
                                    <span class="badge bg-primary rounded-pill">{{ $room->bookings_count }} booking</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection