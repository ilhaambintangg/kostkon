@extends('layouts.app')

@section('title', 'Kelola Booking')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h2><i class="bi bi-calendar-check me-2"></i>Kelola Booking</h2>
    </div>

    <div class="card">
        <div class="card-body">
            @if($bookings->isEmpty())
                <div class="text-center py-5">
                    <i class="bi bi-inbox text-muted" style="font-size: 4rem;"></i>
                    <p class="text-muted mt-3">Belum ada booking masuk.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">No</th>
                                <th width="15%">Penyewa</th>
                                <th width="15%">Properti</th>
                                <th width="15%">Kamar</th>
                                <th width="15%">Tanggal Sewa</th>
                                <th width="10%">Status</th>
                                <th width="10%">Bukti Bayar</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bookings as $index => $booking)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <strong>{{ $booking->user->name }}</strong><br>
                                        <small class="text-muted">{{ $booking->user->email }}</small>
                                    </td>
                                    <td>{{ $booking->room->property->name }}</td>
                                    <td>{{ $booking->room->room_name }}</td>
                                    <td>
                                        <small>
                                            <i class="bi bi-calendar-event"></i> {{ $booking->start_date->format('d M Y') }}<br>
                                            <i class="bi bi-calendar-x"></i> {{ $booking->end_date->format('d M Y') }}
                                        </small>
                                    </td>
                                    <td>
                                        @if($booking->status === 'Pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @elseif($booking->status === 'Confirmed')
                                            <span class="badge bg-success">Confirmed</span>
                                        @else
                                            <span class="badge bg-danger">Rejected</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($booking->payment_image)
                                            <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#modal{{ $booking->id }}">
                                                <i class="bi bi-image"></i> Lihat
                                            </button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="modal{{ $booking->id }}" tabindex="-1">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Bukti Pembayaran</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body text-center">
                                                            <img src="{{ asset('storage/' . $booking->payment_image) }}" class="img-fluid">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <small class="text-muted">Belum upload</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($booking->status === 'Pending')
                                            <form action="{{ route('admin.bookings.updateStatus', $booking) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="Confirmed">
                                                <button type="submit" class="btn btn-sm btn-success mb-1" 
                                                        onclick="return confirm('Konfirmasi booking ini?')">
                                                    <i class="bi bi-check-circle"></i> Terima
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.bookings.updateStatus', $booking) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="Rejected">
                                                <button type="submit" class="btn btn-sm btn-danger" 
                                                        onclick="return confirm('Tolak booking ini?')">
                                                    <i class="bi bi-x-circle"></i> Tolak
                                                </button>
                                            </form>
                                        @else
                                            <span class="badge bg-secondary">Sudah diproses</span>
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
@endsection