@extends('layouts.app')

@section('title', 'Dashboard Penyewa')

@push('styles')
<style>
    /* Global Background */
    body {
        background: #eef1f7 !important;
        font-family: "Inter", sans-serif;
    }

    /* Welcome Banner (Premium Gradient) */
    .welcome-banner {
        background: linear-gradient(135deg, #8a74ff 0%, #6fb1fc 100%);
        border-radius: 22px;
        padding: 35px;
        color: white;
        box-shadow: 0 12px 32px rgba(80, 70, 180, 0.25);
        margin-bottom: 30px;
    }

    /* Statistic Cards */
    .stat-card {
        background: #ffffff;
        border-radius: 20px;
        padding: 28px;
        border: 1px solid rgba(0, 0, 0, 0.05);
        color: #2b2b2b;
        box-shadow: 0 6px 20px rgba(0,0,0,0.06);
        transition: 0.28s ease;
    }
    .stat-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 14px 32px rgba(0,0,0,0.1);
    }

    /* Icons Soft Style */
    .stat-icon {
        font-size: 3.2rem;
        opacity: 0.18;
    }

    /* Pending Card (Peach Gradient) */
    .pending-card {
        background: linear-gradient(135deg, #ffb199 0%, #ff6a88 100%);
        color: white;
        box-shadow: 0 10px 28px rgba(255, 120, 120, 0.25);
    }

    /* Confirmed Card (Blue Gradient) */
    .confirmed-card {
        background: linear-gradient(135deg, #6fd6ff 0%, #3a8bfd 100%);
        color: white;
        box-shadow: 0 10px 28px rgba(70, 150, 255, 0.25);
    }

    /* Booking Card */
    .booking-card {
        border-radius: 20px;
        border: none;
        overflow: hidden;
        background: white;
        box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        transition: 0.3s ease;
        border: 1px solid rgba(0,0,0,0.04);
    }
    .booking-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 18px 35px rgba(0,0,0,0.12);
    }

    .booking-card img {
        border-bottom: 1px solid rgba(0,0,0,0.05);
    }

    /* WhatsApp Floating Button */
    .whatsapp-float {
        position: fixed;
        width: 62px;
        height: 62px;
        bottom: 28px;
        right: 28px;
        background: linear-gradient(145deg, #25d366, #1db954);
        color: #FFF;
        border-radius: 50%;
        text-align: center;
        font-size: 30px;
        box-shadow: 0 8px 22px rgba(0,0,0,0.2);
        z-index: 999;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: 0.35s ease;
    }
    .whatsapp-float:hover {
        transform: scale(1.12) translateY(-3px);
        background: #17a75c;
    }

    /* Modal Soft Modern */
    .modal-content {
        border-radius: 20px !important;
        box-shadow: 0 12px 40px rgba(0,0,0,0.25);
        background: #ffffff;
        border: none;
    }

    @media (max-width: 768px) {
        .stat-card {
            margin-bottom: 15px;
        }
        .welcome-banner {
            padding: 25px;
        }
        .whatsapp-float {
            width: 55px;
            height: 55px;
            right: 20px;
            bottom: 20px;
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
                <a href="{{ route('penyewa.rooms.index') }}" class="btn btn-light btn-lg shadow-sm">
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
                        <h6 class="mb-0 text-secondary">Total Booking</h6>
                        <h2 class="mt-2">{{ $myBookings->count() }}</h2>
                    </div>
                    <i class="bi bi-calendar-check stat-icon"></i>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stat-card pending-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0 opacity-75">Pending</h6>
                        <h2 class="mt-2">{{ $myBookings->where('status', 'Pending')->count() }}</h2>
                    </div>
                    <i class="bi bi-hourglass-split stat-icon"></i>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stat-card confirmed-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0 opacity-75">Confirmed</h6>
                        <h2 class="mt-2">{{ $myBookings->where('status', 'Confirmed')->count() }}</h2>
                    </div>
                    <i class="bi bi-check-circle stat-icon"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- My Bookings -->
    <div class="card border-0 shadow-sm" style="border-radius: 20px;">
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
                                         style="height: 180px; object-fit: cover;">
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
                                            <p class="text-muted small mb-0">
                                                <i class="bi bi-building me-1"></i>{{ $booking->room->property->name }}
                                            </p>
                                        </div>

                                        @php
                                            $statusColors = [
                                                'Pending' => 'warning',
                                                'Confirmed' => 'success',
                                                'Completed' => 'info',
                                                'Rejected' => 'danger'
                                            ];
                                        @endphp

                                        <span class="badge bg-{{ $statusColors[$booking->status] ?? 'secondary' }}">
                                            {{ $booking->status }}
                                        </span>
                                    </div>

                                    <div class="mb-3">
                                        <small class="text-muted d-block">
                                            <i class="bi bi-calendar-event"></i>
                                            Check-in: {{ $booking->start_date->format('d M Y') }}
                                        </small>
                                        <small class="text-muted d-block">
                                            <i class="bi bi-calendar-x"></i>
                                            Check-out: {{ $booking->end_date->format('d M Y') }}
                                        </small>
                                    </div>

                                    @if($booking->payment_amount)
                                        <p class="fw-bold text-success">
                                            Rp {{ number_format($booking->payment_amount, 0, ',', '.') }}
                                        </p>
                                    @endif

                                    @if($booking->rejection_reason)
                                        <div class="alert alert-danger small">
                                            <strong>Ditolak:</strong> {{ $booking->rejection_reason }}
                                        </div>
                                    @endif

                                    @if($booking->refund_proof)
                                        <div class="alert alert-info small">
                                            <i class="bi bi-info-circle"></i>
                                            Bukti refund tersedia —
                                            <a href="{{ asset('storage/' . $booking->refund_proof) }}" target="_blank">Lihat</a>
                                        </div>
                                    @endif

                                    <!-- Buttons -->
                                    <div class="d-grid gap-2">

                                        @if(!$booking->payment_image && $booking->status === 'Pending')
                                            <button type="button" class="btn btn-primary btn-sm"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#uploadModal{{ $booking->id }}">
                                                <i class="bi bi-upload me-1"></i>Upload Bukti Pembayaran
                                            </button>

                                        @elseif($booking->payment_image)
                                            <button type="button" class="btn btn-outline-success btn-sm"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#viewPaymentModal{{ $booking->id }}">
                                                <i class="bi bi-eye me-1"></i>Lihat Bukti Bayar
                                            </button>
                                        @endif

                                        @if($booking->canBeDeleted())
                                            <form action="{{ route('penyewa.bookings.destroy', $booking) }}" method="POST"
                                                  onsubmit="return confirm('Yakin ingin menghapus booking ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm">
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
                                        <button class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <form action="{{ route('penyewa.bookings.uploadPayment', $booking) }}"
                                          method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-body">

                                            <label class="form-label">Pilih Gambar</label>
                                            <input type="file" name="payment_image" class="form-control" required>

                                            <div class="alert alert-info mt-3">
                                                <i class="bi bi-info-circle"></i> Upload bukti pembayaran Anda.
                                            </div>

                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button class="btn btn-primary">Upload</button>
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
                                        <button class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body text-center">
                                        <img src="{{ asset('storage/' . $booking->payment_image) }}"
                                             class="img-fluid rounded shadow-sm">
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

<!-- WhatsApp Button -->
<a href="https://wa.me/6289510675368?text=Halo%20Admin,%20saya%20butuh%20bantuan"
   class="whatsapp-float"
   target="_blank">
    <i class="bi bi-whatsapp"></i>
</a>

@endsection
