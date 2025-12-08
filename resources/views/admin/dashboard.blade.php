@extends('layouts.app')

@section('title', 'Admin Dashboard')

@push('styles')
<style>
    /* Glassmorphism Cards */
    .card-stat {
        border-radius: 18px;
        backdrop-filter: blur(14px);
        border: 1px solid rgba(255, 255, 255, 0.25);
        transition: transform .2s ease, box-shadow .2s ease;
    }
    .card-stat:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    }

    .icon-soft {
        font-size: 3rem;
        opacity: 0.3;
    }

    .quick-card {
        border-radius: 18px;
        box-shadow: 0 6px 20px rgba(0,0,0,0.08);
    }

    .btn-modern {
        border-radius: 12px;
        padding: 12px 14px;
        font-weight: 500;
        transition: .2s ease;
    }

    .btn-modern:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 14px rgba(0,0,0,0.1);
    }

    /* Title */
    .page-title {
        font-weight: 700;
        font-size: 1.9rem;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="page-title"><i class="bi bi-speedometer2 me-2"></i>Dashboard Admin</h2>
        <div class="text-muted">
            <i class="bi bi-calendar3"></i> {{ now()->format('d F Y') }}
        </div>
    </div>

    <!-- ======== STAT CARDS ======== -->
    <div class="row g-4 mb-4">

        <div class="col-md-3">
            <div class="card card-stat bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Total Properti</h6>
                            <h2 class="mt-2">{{ $totalProperties }}</h2>
                        </div>
                        <i class="bi bi-building icon-soft"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card card-stat bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Kamar Tersedia</h6>
                            <h2 class="mt-2">{{ $totalRooms }}</h2>
                        </div>
                        <i class="bi bi-door-open icon-soft"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card card-stat bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Total Booking</h6>
                            <h2 class="mt-2">{{ $totalBookings }}</h2>
                        </div>
                        <i class="bi bi-calendar-check icon-soft"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card card-stat bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Pending</h6>
                            <h2 class="mt-2">{{ $pendingBookings }}</h2>
                        </div>
                        <i class="bi bi-hourglass-split icon-soft"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- ======== QUICK ACTION ======== -->
    <div class="card quick-card">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0"><i class="bi bi-lightning-fill text-warning me-2"></i>Aksi Cepat</h5>
        </div>

        <div class="card-body">
            <div class="row g-3">

                <div class="col-md-3">
                    <a href="{{ route('properties.create') }}" class="btn btn-outline-primary w-100 btn-modern">
                        <i class="bi bi-plus-circle me-2"></i>Tambah Properti
                    </a>
                </div>

                <div class="col-md-3">
                    <a href="{{ route('rooms.create') }}" class="btn btn-outline-success w-100 btn-modern">
                        <i class="bi bi-plus-circle me-2"></i>Tambah Kamar
                    </a>
                </div>

                <div class="col-md-3">
                    <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-info w-100 btn-modern">
                        <i class="bi bi-list-check me-2"></i>Kelola Booking
                    </a>
                </div>

                <div class="col-md-3">
                    <a href="{{ route('admin.reports') }}" class="btn btn-outline-dark w-100 btn-modern">
                        <i class="bi bi-graph-up me-2"></i>Lihat Laporan
                    </a>
                </div>

            </div>
        </div>
    </div>

</div>
@endsection
