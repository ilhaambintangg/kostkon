@extends('layouts.app')

@section('title', 'Kelola Kamar')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-door-open me-2"></i>Kelola Kamar</h2>
        <a href="{{ route('rooms.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Tambah Kamar
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            @if($rooms->isEmpty())
                <div class="text-center py-5">
                    <i class="bi bi-inbox text-muted" style="font-size: 4rem;"></i>
                    <p class="text-muted mt-3">Belum ada kamar. Tambahkan kamar pertama Anda!</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">No</th>
                                <th width="12%">Gambar</th>
                                <th width="20%">Nama Kamar</th>
                                <th width="20%">Properti</th>
                                <th width="15%">Harga/Bulan</th>
                                <th width="10%">Status</th>
                                <th width="18%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rooms as $index => $room)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        @if($room->image)
                                            <img src="{{ asset('storage/' . $room->image) }}" 
                                                 class="img-thumbnail" style="height: 60px; width: 80px; object-fit: cover;">
                                        @else
                                            <div class="bg-secondary text-white d-flex align-items-center justify-content-center" 
                                                 style="height: 60px; width: 80px;">
                                                <i class="bi bi-image"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td><strong>{{ $room->room_name }}</strong></td>
                                    <td>{{ $room->property->name }}</td>
                                    <td><strong class="text-success">Rp {{ number_format($room->price, 0, ',', '.') }}</strong></td>
                                    <td>
                                        @if($room->status === 'Tersedia')
                                            <span class="badge bg-success">Tersedia</span>
                                        @else
                                            <span class="badge bg-danger">Tidak Tersedia</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('rooms.edit', $room) }}" class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('rooms.destroy', $room) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" 
                                                    onclick="return confirm('Yakin ingin menghapus kamar ini?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
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