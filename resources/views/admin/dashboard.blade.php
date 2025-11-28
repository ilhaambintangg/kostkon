@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-speedometer2 me-2"></i>Dashboard Admin</h2>
        <div class="text-muted">
            <i class="bi bi-calendar3"></i> {{ now()->format('d F Y') }}
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Total Properti</h6>
                            <h2 class="mb-0 mt-2">{{ $totalProperties }}</h2>
                        </div>
                        <i class="bi bi-building" style="font-size: 3rem; opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Kamar Tersedia</h6>
                            <h2 class="mb-0 mt-2">{{ $totalRooms }}</h2>
                        </div>
                        <i class="bi bi-door-open" style="font-size: 3rem; opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Total Booking</h6>
                            <h2 class="mb-0 mt-2">{{ $totalBookings }}</h2>
                        </div>
                        <i class="bi bi-calendar-check" style="font-size: 3rem; opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Pending</h6>
                            <h2 class="mb-0 mt-2">{{ $pendingBookings }}</h2>
                        </div>
                        <i class="bi bi-hourglass-split" style="font-size: 3rem; opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row g-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="bi bi-lightning-fill text-warning me-2"></i>Aksi Cepat</h5>
                </div>
                <div class="card-body">
                    <div class="row g-2">
                        <div class="col-md-3">
                            <a href="{{ route('properties.create') }}" class="btn btn-outline-primary w-100">
                                <i class="bi bi-plus-circle me-2"></i>Tambah Properti
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('rooms.create') }}" class="btn btn-outline-success w-100">
                                <i class="bi bi-plus-circle me-2"></i>Tambah Kamar
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-info w-100">
                                <i class="bi bi-list-check me-2"></i>Kelola Booking
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('admin.reports') }}" class="btn btn-outline-dark w-100">
                                <i class="bi bi-graph-up me-2"></i>Lihat Laporan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection