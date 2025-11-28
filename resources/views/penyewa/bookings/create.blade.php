@extends('layouts.app')

@section('title', 'Booking Kamar')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h2><i class="bi bi-calendar-check me-2"></i>Form Booking Kamar</h2>
    </div>

    <div class="row g-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('penyewa.bookings.store', $room) }}" method="POST">
                        @csrf

                        <!-- Room Info -->
                        <div class="alert alert-info">
                            <h5 class="mb-2">{{ $room->room_name }}</h5>
                            <p class="mb-1"><i class="bi bi-building"></i> {{ $room->property->name }}</p>
                            <p class="mb-0"><strong class="text-success">Rp {{ number_format($room->price, 0, ',', '.') }}/bulan</strong></p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tanggal Mulai Sewa <span class="text-danger">*</span></label>
                            <input type="date" name="start_date" class="form-control @error('start_date') is-invalid @enderror" 
                                   value="{{ old('start_date') }}" min="{{ date('Y-m-d') }}" required>
                            @error('start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Pilih tanggal check-in Anda</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tanggal Akhir Sewa <span class="text-danger">*</span></label>
                            <input type="date" name="end_date" class="form-control @error('end_date') is-invalid @enderror" 
                                   value="{{ old('end_date') }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                            @error('end_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Pilih tanggal check-out Anda</small>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Catatan Tambahan (Opsional)</label>
                            <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" 
                                      rows="4" placeholder="Tambahkan catatan atau permintaan khusus...">{{ old('notes') }}</textarea>
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

        <div class="col-md-4">
            <!-- Summary Card -->
            <div class="card sticky-top" style="top: 20px;">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="bi bi-receipt me-2"></i>Ringkasan Booking</h5>
                </div>
                <div class="card-body">
                    <p class="mb-2"><strong>Kamar:</strong> {{ $room->room_name }}</p>
                    <p class="mb-2"><strong>Properti:</strong> {{ $room->property->name }}</p>
                    <hr>
                    <p class="mb-2"><strong>Harga per Bulan:</strong></p>
                    <h4 class="text-success">Rp {{ number_format($room->price, 0, ',', '.') }}</h4>
                </div>
            </div>

            <!-- Instructions Card -->
            <div class="card mt-3">
                <div class="card-header bg-info text-white">
                    <i class="bi bi-info-circle me-2"></i>Instruksi
                </div>
                <div class="card-body">
                    <ol class="small mb-0 ps-3">
                        <li>Isi tanggal mulai dan akhir sewa</li>
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