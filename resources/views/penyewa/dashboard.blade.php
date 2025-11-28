@extends('layouts.app')

@section('title', 'Dashboard Penyewa')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h2><i class="bi bi-house-heart me-2"></i>Selamat Datang, {{ auth()->user()->name }}!</h2>
        <p class="text-muted">Kelola booking kamar Anda di sini</p>
    </div>

    <!-- Quick Action -->
    <div class="row g-3 mb-4">
        <div class="col-md-12">
            <div class="card bg-gradient" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="card-body text-white text-center py-4">
                    <h4>Cari Kamar Impian Anda!</h4>
                    <p class="mb-3">Temukan kos dan kontrakan dengan harga terbaik</p>
                    <a href="{{ route('penyewa.rooms.index') }}" class="btn btn-light btn-lg">
                        <i class="bi bi-search me-2"></i>Cari Kamar Sekarang
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- My Bookings -->
    <div class="card">
        <div class="card-header bg-white">
            <h5 class="mb-0"><i class="bi bi-list-check me-2"></i>Booking Saya</h5>
        </div>

        <div class="card-body">
            @if($myBookings->isEmpty())
                <div class="text-center py-5">
                    <i class="bi bi-inbox text-muted" style="font-size: 4rem;"></i>
                    <p class="text-muted mt-3">Anda belum memiliki booking.</p>
                    <a href="{{ route('penyewa.rooms.index') }}" class="btn btn-primary">
                        <i class="bi bi-search me-2"></i>Cari Kamar
                    </a>
                </div>
            @else
                <div class="row g-3">
                    @foreach($myBookings as $booking)
                        <div class="col-md-6">
                            <div class="card border">
                                <div class="card-body">

                                    <!-- Header -->
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div>
                                            <h5 class="mb-1">{{ $booking->room->room_name }}</h5>
                                            <p class="text-muted mb-0">
                                                <i class="bi bi-building me-1"></i>{{ $booking->room->property->name }}
                                            </p>
                                        </div>

                                        @if($booking->status === 'Pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @elseif($booking->status === 'Confirmed')
                                            <span class="badge bg-success">Confirmed</span>
                                        @else
                                            <span class="badge bg-danger">Rejected</span>
                                        @endif
                                    </div>

                                    <!-- Dates -->
                                    <div class="mb-3">
                                        <small class="text-muted">
                                            <i class="bi bi-calendar-event"></i> 
                                            Check-in: {{ $booking->start_date->format('d M Y') }}<br>
                                            <i class="bi bi-calendar-x"></i> 
                                            Check-out: {{ $booking->end_date->format('d M Y') }}
                                        </small>
                                    </div>

                                    <!-- Price -->
                                    <div class="mb-3">
                                        <strong class="text-success">Rp {{ number_format($booking->room->price, 0, ',', '.') }}/bulan</strong>
                                    </div>

                                    <!-- Payment -->
                                    @if(!$booking->payment_image && $booking->status === 'Pending')
                                        <button type="button" class="btn btn-sm btn-primary w-100"
                                                data-bs-toggle="modal" data-bs-target="#uploadModal{{ $booking->id }}">
                                            <i class="bi bi-upload me-2"></i>Upload Bukti Pembayaran
                                        </button>

                                        <!-- Upload Modal -->
                                        <div class="modal fade" id="uploadModal{{ $booking->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Upload Bukti Pembayaran</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <form action="{{ route('penyewa.bookings.uploadPayment', $booking) }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label class="form-label">Pilih Gambar</label>
                                                                <input type="file" name="payment_image" class="form-control" accept="image/*" required>
                                                            </div>
                                                            <div class="alert alert-info">
                                                                <small>
                                                                    <i class="bi bi-info-circle"></i> Upload foto bukti transfer/pembayaran Anda
                                                                </small>
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-primary">Upload</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                    @elseif($booking->payment_image)
                                        <div class="alert alert-success mb-0">
                                            <i class="bi bi-check-circle"></i> Bukti pembayaran sudah diupload
                                        </div>
                                    @endif

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
