@extends('layouts.app')

@section('title', 'Dashboard Penyewa')

@push('styles')
<style>
    .stat-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 15px;
        padding: 25px;
        color: white;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        transition: transform 0.3s;
    }
    .stat-card:hover {
        transform: translateY(-5px);
    }
    .booking-card {
        border-radius: 15px;
        border: none;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        transition: all 0.3s;
    }
    .booking-card:hover {
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }
    .whatsapp-float {
        position: fixed;
        width: 60px;
        height: 60px;
        bottom: 30px;
        right: 30px;
        background-color: #25d366;
        color: #FFF;
        border-radius: 50px;
        text-align: center;
        font-size: 30px;
        box-shadow: 2px 2px 15px rgba(0,0,0,0.3);
        z-index: 100;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s;
        text-decoration: none;
    }
    .whatsapp-float:hover {
        background-color: #128c7e;
        transform: scale(1.1);
        color: white;
    }
    .welcome-banner {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 15px;
        padding: 30px;
        color: white;
        margin-bottom: 30px;
    }
    @media (max-width: 768px) {
        .stat-card {
            margin-bottom: 15px;
        }
        .whatsapp-float {
            width: 50px;
            height: 50px;
            font-size: 25px;
            bottom: 20px;
            right: 20px;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Welcome Banner -->
    <div class="welcome-banner">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h2 class="mb-2">
                    <i class="bi bi-hand-wave-fill"></i> {{ auth()->user()->name }}
                </h2>
                <p class="mb-0 opacity-75">Kelola booking dan temukan kamar impian Anda</p>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <a href="{{ route('penyewa.rooms.index') }}" class="btn btn-light btn-lg">
                    <i class="bi bi-search me-2"></i>Cari Kamar
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0 opacity-75">Total Booking</h6>
                        <h2 class="mb-0 mt-2">{{ $myBookings->count() }}</h2>
                    </div>
                    <i class="bi bi-calendar-check" style="font-size: 3rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stat-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0 opacity-75">Pending</h6>
                        <h2 class="mb-0 mt-2">{{ $myBookings->where('status', 'Pending')->count() }}</h2>
                    </div>
                    <i class="bi bi-hourglass-split" style="font-size: 3rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stat-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0 opacity-75">Confirmed</h6>
                        <h2 class="mb-0 mt-2">{{ $myBookings->where('status', 'Confirmed')->count() }}</h2>
                    </div>
                    <i class="bi bi-check-circle" style="font-size: 3rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- My Bookings -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 py-3">
            <h5 class="mb-0"><i class="bi bi-list-check me-2"></i>Riwayat Booking Saya</h5>
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
                        <div class="col-md-6 col-lg-4">
                            <div class="booking-card card h-100">
                                @if($booking->room->image)
                                    <img src="{{ asset('storage/' . $booking->room->image) }}" 
                                         class="card-img-top" 
                                         style="height: 180px; object-fit: cover;" 
                                         alt="{{ $booking->room->room_name }}">
                                @else
                                    <div class="bg-secondary d-flex align-items-center justify-content-center" 
                                         style="height: 180px;">
                                        <i class="bi bi-image text-white" style="font-size: 3rem;"></i>
                                    </div>
                                @endif
                                
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div>
                                            <h5 class="mb-1">{{ $booking->room->room_name }}</h5>
                                            <p class="text-muted mb-0 small">
                                                <i class="bi bi-building me-1"></i>{{ $booking->room->property->name }}
                                            </p>
                                        </div>
                                        @if($booking->status === 'Pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @elseif($booking->status === 'Confirmed')
                                            <span class="badge bg-success">Confirmed</span>
                                        @elseif($booking->status === 'Completed')
                                            <span class="badge bg-info">Completed</span>
                                        @else
                                            <span class="badge bg-danger">Rejected</span>
                                        @endif
                                    </div>

                                    <div class="mb-3">
                                        <small class="text-muted d-block">
                                            <i class="bi bi-calendar-event"></i> Check-in: {{ $booking->start_date->format('d M Y') }}
                                        </small>
                                        <small class="text-muted d-block">
                                            <i class="bi bi-calendar-x"></i> Check-out: {{ $booking->end_date->format('d M Y') }}
                                        </small>
                                    </div>

                                    @if($booking->payment_amount)
                                        <div class="mb-3">
                                            <strong class="text-success">Rp {{ number_format($booking->payment_amount, 0, ',', '.') }}</strong>
                                        </div>
                                    @endif

                                    @if($booking->status === 'Rejected' && $booking->rejection_reason)
                                        <div class="alert alert-danger small mb-3">
                                            <strong>Ditolak:</strong> {{ $booking->rejection_reason }}
                                        </div>
                                    @endif

                                    @if($booking->refund_proof)
                                        <div class="alert alert-info small mb-3">
                                            <i class="bi bi-info-circle"></i> Bukti pengembalian dana tersedia
                                            <a href="{{ asset('storage/' . $booking->refund_proof) }}" target="_blank" class="alert-link">Lihat</a>
                                        </div>
                                    @endif

                                    <!-- Action Buttons -->
                                    <div class="d-grid gap-2">
                                        @if(!$booking->payment_image && $booking->status === 'Pending')
                                            <button type="button" class="btn btn-primary btn-sm" 
                                                    data-bs-toggle="modal" data-bs-target="#uploadModal{{ $booking->id }}">
                                                <i class="bi bi-upload me-1"></i>Upload Bukti Pembayaran
                                            </button>
                                        @elseif($booking->payment_image)
                                            <button type="button" class="btn btn-outline-success btn-sm" 
                                                    data-bs-toggle="modal" data-bs-target="#viewPaymentModal{{ $booking->id }}">
                                                <i class="bi bi-eye me-1"></i>Lihat Bukti Bayar
                                            </button>
                                        @endif

                                        @if($booking->canBeDeleted())
                                            <form action="{{ route('penyewa.bookings.destroy', $booking) }}" method="POST" 
                                                  onsubmit="return confirm('Yakin ingin menghapus riwayat booking ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                                                    <i class="bi bi-trash me-1"></i>Hapus Riwayat
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Upload Payment Modal -->
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
                                                    <i class="bi bi-info-circle"></i> Upload foto bukti transfer pembayaran Anda
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

                        <!-- View Payment Modal -->
                        @if($booking->payment_image)
                            <div class="modal fade" id="viewPaymentModal{{ $booking->id }}" tabindex="-1">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Bukti Pembayaran</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body text-center">
                                            <img src="{{ asset('storage/' . $booking->payment_image) }}" class="img-fluid rounded" alt="Bukti Pembayaran">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

<!-- WhatsApp Floating Button (Sticky) -->
<a href="https://wa.me/6289510675368?text=Halo%20Admin%20KostKon,%20saya%20butuh%20bantuan" 
   class="whatsapp-float" 
   target="_blank"
   title="Hubungi Admin via WhatsApp">
    <i class="bi bi-whatsapp"></i>
</a>
@endsection