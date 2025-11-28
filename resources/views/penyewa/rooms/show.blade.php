@extends('layouts.app')

@section('title', 'Detail Kamar')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <a href="{{ route('penyewa.rooms.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="row g-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <!-- Image -->
                    @if($room->image)
                        <img src="{{ asset('storage/' . $room->image) }}" class="img-fluid rounded mb-4" 
                             style="width: 100%; height: 400px; object-fit: cover;" alt="{{ $room->room_name }}">
                    @else
                        <div class="bg-secondary d-flex align-items-center justify-content-center rounded mb-4" 
                             style="width: 100%; height: 400px;">
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
                            <span class="badge bg-success fs-6">Tersedia</span>
                        @else
                            <span class="badge bg-danger fs-6">Tidak Tersedia</span>
                        @endif
                    </div>

                    <hr>

                    <!-- Price -->
                    <div class="mb-4">
                        <h3 class="text-success">Rp {{ number_format($room->price, 0, ',', '.') }}</h3>
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

        <div class="col-md-4">
            <!-- Booking Card -->
            <div class="card sticky-top" style="top: 20px;">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-calendar-check me-2"></i>Booking Kamar</h5>
                </div>
                <div class="card-body">
                    @if($room->status === 'Tersedia')
                        <div class="text-center mb-3">
                            <h3 class="text-success">Rp {{ number_format($room->price, 0, ',', '.') }}</h3>
                            <p class="text-muted mb-0">per bulan</p>
                        </div>

                        <a href="{{ route('penyewa.bookings.create', $room) }}" class="btn btn-primary w-100 btn-lg">
                            <i class="bi bi-check-circle me-2"></i>Booking Sekarang
                        </a>

                        <div class="alert alert-info mt-3 mb-0">
                            <small>
                                <i class="bi bi-info-circle"></i> 
                                Lakukan booking dan upload bukti pembayaran untuk konfirmasi
                            </small>
                        </div>
                    @else
                        <div class="alert alert-danger mb-0">
                            <i class="bi bi-x-circle"></i> Kamar ini sedang tidak tersedia
                        </div>
                    @endif
                </div>
            </div>

            <!-- Contact Info -->
            <div class="card mt-3">
                <div class="card-body">
                    <h6><i class="bi bi-telephone me-2"></i>Butuh Bantuan?</h6>
                    <p class="small text-muted mb-0">Hubungi admin untuk informasi lebih lanjut</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection