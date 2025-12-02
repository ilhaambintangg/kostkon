@extends('layouts.app')

@section('title', 'Laporan')

@push('styles')
<style>
    .stat-box {
        border-radius: 10px;
        padding: 20px;
        text-align: center;
        transition: all 0.3s;
    }
    .stat-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }
    @media (max-width: 768px) {
        .stat-box {
            padding: 15px;
            margin-bottom: 15px;
        }
        .stat-box h2 {
            font-size: 1.5rem;
        }
        .table-responsive {
            font-size: 0.85rem;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h2><i class="bi bi-graph-up me-2"></i>Laporan Sistem</h2>
        <p class="text-muted d-none d-md-block">Overview lengkap sistem KostKon</p>
    </div>

    <!-- Statistics Overview -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="stat-box border-primary card">
                <i class="bi bi-building text-primary" style="font-size: 2.5rem;"></i>
                <h2 class="mt-2 mb-0">{{ $totalProperties }}</h2>
                <p class="text-muted mb-0 small">Total Properti</p>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="stat-box border-success card">
                <i class="bi bi-door-open text-success" style="font-size: 2.5rem;"></i>
                <h2 class="mt-2 mb-0">{{ $totalRooms }}</h2>
                <p class="text-muted mb-0 small">Total Kamar</p>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="stat-box border-info card">
                <i class="bi bi-door-open-fill text-info" style="font-size: 2.5rem;"></i>
                <h2 class="mt-2 mb-0">{{ $availableRooms }}</h2>
                <p class="text-muted mb-0 small">Kamar Tersedia</p>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="stat-box border-warning card">
                <i class="bi bi-people text-warning" style="font-size: 2.5rem;"></i>
                <h2 class="mt-2 mb-0">{{ $totalPenyewa }}</h2>
                <p class="text-muted mb-0 small">Total Penyewa</p>
            </div>
        </div>
    </div>

    <!-- Booking Statistics -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body text-center">
                    <h6 class="small mb-2">Total Booking</h6>
                    <h2 class="mb-0">{{ $totalBookings }}</h2>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body text-center">
                    <h6 class="small mb-2">Pending</h6>
                    <h2 class="mb-0">{{ $pendingBookings }}</h2>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body text-center">
                    <h6 class="small mb-2">Confirmed</h6>
                    <h2 class="mb-0">{{ $confirmedBookings }}</h2>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card bg-danger text-white">
                <div class="card-body text-center">
                    <h6 class="small mb-2">Rejected</h6>
                    <h2 class="mb-0">{{ $rejectedBookings }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <!-- Recent Bookings -->
        <div class="col-12 col-lg-7">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0"><i class="bi bi-clock-history me-2"></i>Booking Terbaru</h5>
                </div>
                <div class="card-body">
                    @if($recentBookings->isEmpty())
                        <p class="text-muted text-center py-3 mb-0">Belum ada booking</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th>Penyewa</th>
                                        <th class="d-none d-md-table-cell">Kamar</th>
                                        <th>Tanggal</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentBookings as $booking)
                                        <tr>
                                            <td>
                                                <strong>{{ $booking->user->name }}</strong>
                                                <div class="d-md-none small text-muted">
                                                    {{ $booking->room->room_name }}
                                                </div>
                                            </td>
                                            <td class="d-none d-md-table-cell">
                                                <small>{{ $booking->room->room_name }}</small>
                                            </td>
                                            <td><small>{{ $booking->created_at->format('d M Y') }}</small></td>
                                            <td>
                                                @if($booking->status === 'Pending')
                                                    <span class="badge bg-warning">Pending</span>
                                                @elseif($booking->status === 'Confirmed')
                                                    <span class="badge bg-success">Confirmed</span>
                                                @elseif($booking->status === 'Completed')
                                                    <span class="badge bg-info">Completed</span>
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
        <div class="col-12 col-lg-5">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0"><i class="bi bi-star-fill text-warning me-2"></i>Kamar Terpopuler</h5>
                </div>
                <div class="card-body">
                    @if($popularRooms->isEmpty())
                        <p class="text-muted text-center py-3 mb-0">Belum ada data</p>
                    @else
                        <ul class="list-group list-group-flush">
                            @foreach($popularRooms as $room)
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <div>
                                        <strong>{{ $room->room_name }}</strong>
                                        <br>
                                        <small class="text-muted d-none d-md-inline">{{ $room->property->name }}</small>
                                    </div>
                                    <span class="badge bg-primary rounded-pill">
                                        {{ $room->bookings_count }} <span class="d-none d-md-inline">booking</span>
                                    </span>
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