@extends('layouts.app')

@section('title', 'Booking Kamar')

@push('styles')
<style>
    .summary-card {
        position: sticky;
        top: 20px;
    }
    @media (max-width: 768px) {
        .summary-card {
            position: relative;
            top: 0;
            margin-top: 20px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // Auto calculate payment amount berdasarkan harga kamar
    document.addEventListener('DOMContentLoaded', function() {
        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');
        const paymentAmountInput = document.getElementById('payment_amount');
        const pricePerMonth = {{ $room->price }};

        function calculatePayment() {
            const startDate = new Date(startDateInput.value);
            const endDate = new Date(endDateInput.value);

            if (startDate && endDate && endDate > startDate) {
                // Hitung jumlah bulan
                const months = (endDate.getFullYear() - startDate.getFullYear()) * 12 + 
                               (endDate.getMonth() - startDate.getMonth());
                
                // Total pembayaran (minimal 1 bulan)
                const totalMonths = Math.max(months, 1);
                const totalPayment = pricePerMonth * totalMonths;
                
                paymentAmountInput.value = totalPayment;
                
                // Update display
                document.getElementById('displayPayment').textContent = 
                    'Rp ' + totalPayment.toLocaleString('id-ID');
                document.getElementById('displayMonths').textContent = totalMonths + ' bulan';
            }
        }

        startDateInput.addEventListener('change', calculatePayment);
        endDateInput.addEventListener('change', calculatePayment);
    });
</script>
@endpush

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h2><i class="bi bi-calendar-check me-2"></i>Form Booking Kamar</h2>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="{{ route('penyewa.bookings.store', $room) }}" method="POST" id="bookingForm">
                        @csrf

                        <!-- Room Info -->
                        <div class="alert alert-info">
                            <div class="d-flex align-items-center">
                                @if($room->image)
                                    <img src="{{ asset('storage/' . $room->image) }}" 
                                         style="width: 80px; height: 80px; object-fit: cover; border-radius: 10px;" 
                                         class="me-3">
                                @endif
                                <div>
                                    <h5 class="mb-1">{{ $room->room_name }}</h5>
                                    <p class="mb-1"><i class="bi bi-building"></i> {{ $room->property->name }}</p>
                                    <strong class="text-success">Rp {{ number_format($room->price, 0, ',', '.') }}/bulan</strong>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tanggal Mulai Sewa <span class="text-danger">*</span></label>
                                <input type="date" 
                                       id="start_date"
                                       name="start_date" 
                                       class="form-control @error('start_date') is-invalid @enderror" 
                                       value="{{ old('start_date') }}" 
                                       min="{{ date('Y-m-d') }}" 
                                       required>
                                @error('start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Pilih tanggal check-in Anda</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tanggal Akhir Sewa <span class="text-danger">*</span></label>
                                <input type="date" 
                                       id="end_date"
                                       name="end_date" 
                                       class="form-control @error('end_date') is-invalid @enderror" 
                                       value="{{ old('end_date') }}" 
                                       min="{{ date('Y-m-d', strtotime('+1 day')) }}" 
                                       required>
                                @error('end_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Pilih tanggal check-out Anda</small>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Jumlah Pembayaran (Rp) <span class="text-danger">*</span></label>
                            <input type="number" 
                                   id="payment_amount"
                                   name="payment_amount" 
                                   class="form-control @error('payment_amount') is-invalid @enderror" 
                                   value="{{ old('payment_amount') }}" 
                                   min="0" 
                                   readonly
                                   required>
                            @error('payment_amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Dihitung otomatis berdasarkan durasi sewa</small>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Catatan Tambahan (Opsional)</label>
                            <textarea name="notes" 
                                      class="form-control @error('notes') is-invalid @enderror" 
                                      rows="4" 
                                      placeholder="Tambahkan catatan atau permintaan khusus...">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-check-circle me-2"></i>Konfirmasi Booking
                            </button>
                            <a href="{{ route('penyewa.rooms.show', $room) }}" class="btn btn-secondary btn-lg">
                                <i class="bi bi-arrow-left me-2"></i>Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Summary Card -->
            <div class="card shadow-sm summary-card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="bi bi-receipt me-2"></i>Ringkasan Booking</h5>
                </div>
                <div class="card-body">
                    <p class="mb-2"><strong>Kamar:</strong> {{ $room->room_name }}</p>
                    <p class="mb-2"><strong>Properti:</strong> {{ $room->property->name }}</p>
                    <hr>
                    <p class="mb-2"><strong>Harga per Bulan:</strong></p>
                    <h5 class="text-success mb-3">Rp {{ number_format($room->price, 0, ',', '.') }}</h5>
                    
                    <p class="mb-2"><strong>Durasi Sewa:</strong></p>
                    <h5 class="text-primary mb-3" id="displayMonths">-</h5>
                    
                    <p class="mb-2"><strong>Total Pembayaran:</strong></p>
                    <h4 class="text-success" id="displayPayment">Rp 0</h4>
                </div>
            </div>

            <!-- Instructions Card -->
            <div class="card shadow-sm mt-3">
                <div class="card-header bg-info text-white">
                    <i class="bi bi-info-circle me-2"></i>Instruksi
                </div>
                <div class="card-body">
                    <ol class="small mb-0 ps-3">
                        <li>Pilih tanggal mulai dan akhir sewa</li>
                        <li>Jumlah pembayaran dihitung otomatis</li>
                        <li>Klik "Konfirmasi Booking"</li>
                        <li>Upload bukti pembayaran di dashboard</li>
                        <li>Tunggu konfirmasi dari admin</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection