@extends('layouts.app')

@section('title', 'Detail Kamar')

@push('styles')
<style>
    body {
        background: #f4f5f7 !important;
        font-family: "Inter", sans-serif;
    }

    .card {
        border: none;
        border-radius: 18px;
        box-shadow: 0 10px 28px rgba(0,0,0,0.06);
    }

    .card-body h2 {
        font-weight: 600;
        color: #2b2b2b;
    }

    /* Image */
    .room-image {
        border-radius: 18px;
        box-shadow: 0 12px 28px rgba(0,0,0,0.08);
    }

    /* Booking Card */
    .booking-card {
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 12px 28px rgba(0,0,0,0.08);
    }

    .booking-card .card-header {
        background: linear-gradient(135deg, #4e5bff, #7887ff);
        border-top-left-radius: 18px !important;
        border-top-right-radius: 18px !important;
        color: white;
        font-weight: 600;
        padding: 18px;
    }

    .btn-primary {
        background: linear-gradient(135deg, #4e5bff, #7887ff);
        border: none;
        padding: 12px 18px;
        font-weight: 600;
        border-radius: 12px;
        box-shadow: 0 6px 16px rgba(78, 91, 255, 0.3);
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #3d4dde, #6775ff);
    }

    .btn-secondary {
        border-radius: 12px;
        font-weight: 600;
    }

    /* Info Title */
    h5 {
        font-weight: 600;
        color: #2d2d2d;
    }

    /* Badge */
    .badge {
        font-size: 0.95rem;
        padding: 8px 14px;
        border-radius: 10px;
    }

    /* Contact Card */
    .contact-card {
        border-radius: 14px;
        box-shadow: 0 8px 22px rgba(0,0,0,0.06);
    }
</style>
@endpush

@section('content')
<div class="container-fluid">

    <!-- Back Button -->
    <div class="mb-4">
        <a href="{{ route('penyewa.rooms.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="row g-4">

        <!-- Left Section -->
        <div class="col-md-8">

            <div class="card p-3">

                <div class="card-body">

                    <!-- Image -->
                    @if($room->image)
                        <img src="{{ asset('storage/' . $room->image) }}"
                             class="img-fluid room-image mb-4"
                             style="width: 100%; height: 400px; object-fit: cover;">
                    @else
                        <div class="bg-secondary d-flex align-items-center justify-content-center rounded mb-4"
                             style="width: 100%; height: 400px; border-radius:18px;">
                            <i class="bi bi-image text-white" style="font-size: 5rem;"></i>
                        </div>
                    @endif

                    <!-- Room Info -->
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h2>{{ $room->room_name }}</h2>
                            <p class="text-muted mb-0">
                                <i class="bi bi-building me-1"></i>{{ $room->property->name }}
                            </p>
                        </div>

                        @if($room->status === 'Tersedia')
                            <span class="badge bg-success">Tersedia</span>
                        @else
                            <span class="badge bg-danger">Tidak Tersedia</span>
                        @endif
                    </div>

                    <hr>

                    <!-- Price -->
                    <div class="mb-4">
                        <h3 class="text-success fw-bold">
                            Rp {{ number_format($room->price, 0, ',', '.') }}
                        </h3>
                        <p class="text-muted">per bulan</p>
                    </div>

                    <!-- Description -->
                    <h5><i class="bi bi-info-circle me-2"></i>Deskripsi</h5>
                    <p>{{ $room->description ?? 'Tidak ada deskripsi.' }}</p>

                    <hr>

                    <!-- Property Info -->
                    <h5><i class="bi bi-building me-2"></i>Informasi Properti</h5>
                    <p class="mb-1"><strong>Nama:</strong> {{ $room->property->name }}</p>
                    <p class="mb-1"><strong>Alamat:</strong> {{ $room->property->address }}</p>
                    <p class="mb-0"><strong>Deskripsi:</strong> {{ $room->property->description ?? '-' }}</p>

                </div>
            </div>

        </div>

        <!-- Right Section -->
        <div class="col-md-4">

            <!-- Booking Card -->
            <div class="card booking-card sticky-top" style="top: 20px;">

                <div class="card-header">
                    <i class="bi bi-calendar-check me-2"></i>Booking Kamar
                </div>

                <div class="card-body">

                    @if($room->status === 'Tersedia')

                        <div class="text-center mb-3">
                            <h3 class="text-success fw-bold">
                                Rp {{ number_format($room->price, 0, ',', '.') }}
                            </h3>
                            <p class="text-muted">per bulan</p>
                        </div>

                        <a href="{{ route('penyewa.bookings.create', $room) }}"
                           class="btn btn-primary w-100 btn-lg">
                            <i class="bi bi-check-circle me-2"></i>Booking Sekarang
                        </a>

                        <div class="alert alert-info mt-3 mb-0">
                            <small>
                                <i class="bi bi-info-circle"></i>
                                Lakukan booking dan upload bukti pembayaran untuk konfirmasi.
                            </small>
                        </div>

                    @else

                        <div class="alert alert-danger mb-0">
                            <i class="bi bi-x-circle"></i> Kamar ini sedang tidak tersedia
                        </div>

                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection