@extends('layouts.app')

@section('title', 'Cari Kamar')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h2><i class="bi bi-search me-2"></i>Cari Kamar Kos/Kontrakan</h2>
        <p class="text-muted">Temukan kamar yang sesuai dengan kebutuhan Anda</p>
    </div>

    @if($rooms->isEmpty())
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="bi bi-inbox text-muted" style="font-size: 4rem;"></i>
                <p class="text-muted mt-3">Belum ada kamar tersedia saat ini.</p>
            </div>
        </div>
    @else
        <div class="row g-4">
            @foreach($rooms as $room)
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm hover-card">
                        @if($room->image)
                            <img src="{{ asset('storage/' . $room->image) }}" class="card-img-top" 
                                 style="height: 200px; object-fit: cover;" alt="{{ $room->room_name }}">
                        @else
                            <div class="bg-secondary d-flex align-items-center justify-content-center" 
                                 style="height: 200px;">
                                <i class="bi bi-image text-white" style="font-size: 3rem;"></i>
                            </div>
                        @endif
                        
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="card-title mb-0">{{ $room->room_name }}</h5>
                                <span class="badge bg-success">Tersedia</span>
                            </div>
                            
                            <p class="text-muted mb-2">
                                <i class="bi bi-building"></i> {{ $room->property->name }}
                            </p>
                            
                            <p class="text-muted small mb-3">
                                <i class="bi bi-geo-alt"></i> {{ Str::limit($room->property->address, 50) }}
                            </p>
                            
                            @if($room->description)
                                <p class="card-text small text-muted">
                                    {{ Str::limit($room->description, 80) }}
                                </p>
                            @endif
                            
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div>
                                    <h4 class="text-success mb-0">Rp {{ number_format($room->price, 0, ',', '.') }}</h4>
                                    <small class="text-muted">per bulan</small>
                                </div>
                                <a href="{{ route('penyewa.rooms.show', $room) }}" class="btn btn-primary">
                                    <i class="bi bi-eye"></i> Detail
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

@push('styles')
<style>
    .hover-card {
        transition: transform 0.3s, box-shadow 0.3s;
    }
    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.2) !important;
    }
</style>
@endpush
@endsection