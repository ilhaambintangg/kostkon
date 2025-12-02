@extends('layouts.app')

@section('title', 'Kelola Booking')

@push('styles')
<style>
    .booking-card {
        border-radius: 10px;
        border: 1px solid #dee2e6;
        transition: all 0.3s;
    }
    .booking-card:hover {
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    @media (max-width: 768px) {
        .table-responsive {
            font-size: 0.8rem;
        }
        .btn-sm {
            font-size: 0.7rem;
            padding: 0.2rem 0.4rem;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h2><i class="bi bi-calendar-check me-2"></i>Kelola Booking</h2>
        <p class="text-muted d-none d-md-block">Manage semua booking dari penyewa</p>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            @if($bookings->isEmpty())
                <div class="text-center py-5">
                    <i class="bi bi-inbox text-muted" style="font-size: 4rem;"></i>
                    <p class="text-muted mt-3">Belum ada booking masuk.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Penyewa</th>
                                <th class="d-none d-lg-table-cell">Properti</th>
                                <th>Kamar</th>
                                <th class="d-none d-md-table-cell">Tanggal</th>
                                <th>Bayar</th>
                                <th>Status</th>
                                <th>Bukti</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bookings as $index => $booking)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <strong>{{ $booking->user->name }}</strong>
                                        <br><small class="text-muted d-none d-md-inline">{{ $booking->user->email }}</small>
                                    </td>
                                    <td class="d-none d-lg-table-cell">
                                        <small>{{ $booking->room->property->name }}</small>
                                    </td>
                                    <td><strong>{{ $booking->room->room_name }}</strong></td>
                                    <td class="d-none d-md-table-cell">
                                        <small>
                                            {{ $booking->start_date->format('d/m/Y') }}<br>
                                            {{ $booking->end_date->format('d/m/Y') }}
                                        </small>
                                    </td>
                                    <td>
                                        @if($booking->payment_amount)
                                            <strong class="text-success">Rp {{ number_format($booking->payment_amount, 0, ',', '.') }}</strong>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
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
                                    <td>
                                        @if($booking->payment_image)
                                            <button type="button" class="btn btn-sm btn-info" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#paymentModal{{ $booking->id }}">
                                                <i class="bi bi-image"></i> Lihat
                                            </button>
                                        @else
                                            <small class="text-muted">Belum</small>
                                        @endif
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary mb-1" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#statusModal{{ $booking->id }}">
                                            <i class="bi bi-pencil"></i> Status
                                        </button>
                                        
                                        @if($booking->status === 'Rejected' && $booking->payment_image)
                                            <button type="button" class="btn btn-sm btn-warning" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#refundModal{{ $booking->id }}">
                                                <i class="bi bi-upload"></i> Refund
                                            </button>
                                        @endif
                                    </td>
                                </tr>

                                <!-- Payment Image Modal -->
                                @if($booking->payment_image)
                                    <div class="modal fade" id="paymentModal{{ $booking->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Bukti Pembayaran</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body text-center">
                                                    <img src="{{ asset('storage/' . $booking->payment_image) }}" 
                                                         class="img-fluid rounded" 
                                                         alt="Bukti Bayar">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <!-- Status Update Modal -->
                                <div class="modal fade" id="statusModal{{ $booking->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Update Status Booking</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form action="{{ route('admin.bookings.updateStatus', $booking) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label">Status Baru</label>
                                                        <select name="status" class="form-select" id="status{{ $booking->id }}" required>
                                                            <option value="Pending" {{ $booking->status === 'Pending' ? 'selected' : '' }}>Pending</option>
                                                            <option value="Confirmed" {{ $booking->status === 'Confirmed' ? 'selected' : '' }}>Confirmed</option>
                                                            <option value="Completed" {{ $booking->status === 'Completed' ? 'selected' : '' }}>Completed</option>
                                                            <option value="Rejected" {{ $booking->status === 'Rejected' ? 'selected' : '' }}>Rejected</option>
                                                        </select>
                                                    </div>

                                                    <div class="mb-3" id="rejectionReasonDiv{{ $booking->id }}" 
                                                         style="display: {{ $booking->status === 'Rejected' ? 'block' : 'none' }}">
                                                        <label class="form-label">Alasan Penolakan <span class="text-danger">*</span></label>
                                                        <textarea name="rejection_reason" 
                                                                  class="form-control" 
                                                                  rows="3" 
                                                                  placeholder="Jelaskan alasan penolakan...">{{ $booking->rejection_reason }}</textarea>
                                                        <small class="text-muted">Wajib diisi jika status Rejected</small>
                                                    </div>

                                                    @if($booking->rejection_reason)
                                                        <div class="alert alert-danger">
                                                            <strong>Alasan Penolakan Sebelumnya:</strong><br>
                                                            {{ $booking->rejection_reason }}
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary">Update Status</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Upload Refund Modal -->
                                @if($booking->status === 'Rejected' && $booking->payment_image)
                                    <div class="modal fade" id="refundModal{{ $booking->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header bg-warning">
                                                    <h5 class="modal-title">Upload Bukti Pengembalian Dana</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <form action="{{ route('admin.bookings.uploadRefund', $booking) }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="modal-body">
                                                        @if($booking->refund_proof)
                                                            <div class="alert alert-success">
                                                                <i class="bi bi-check-circle"></i> Bukti refund sudah diupload
                                                                <a href="{{ asset('storage/' . $booking->refund_proof) }}" target="_blank" class="alert-link">Lihat</a>
                                                            </div>
                                                        @endif

                                                        <div class="mb-3">
                                                            <label class="form-label">Upload Bukti Transfer Kembali</label>
                                                            <input type="file" name="refund_proof" class="form-control" accept="image/*" required>
                                                            <small class="text-muted">Screenshot bukti transfer pengembalian dana ke penyewa</small>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-warning">Upload</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <script>
                                    // Show/hide rejection reason field
                                    document.getElementById('status{{ $booking->id }}').addEventListener('change', function() {
                                        const rejectionDiv = document.getElementById('rejectionReasonDiv{{ $booking->id }}');
                                        if (this.value === 'Rejected') {
                                            rejectionDiv.style.display = 'block';
                                        } else {
                                            rejectionDiv.style.display = 'none';
                                        }
                                    });
                                </script>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection