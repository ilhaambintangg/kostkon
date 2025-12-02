@extends('layouts.app')

@section('title', 'Kelola Kamar')

@push('styles')
<style>
    .room-img {
        width: 100%;
        height: 60px;
        object-fit: cover;
        border-radius: 5px;
    }
    @media (max-width: 768px) {
        .table-responsive {
            font-size: 0.85rem;
        }
        .btn-sm {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
        }
        .room-img {
            height: 50px;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
        <div>
            <h2><i class="bi bi-door-open me-2"></i>Kelola Kamar</h2>
            <p class="text-muted mb-0 d-none d-md-block">Daftar semua kamar per properti</p>
        </div>
        <a href="{{ route('rooms.create') }}" class="btn btn-primary mt-3 mt-md-0">
            <i class="bi bi-plus-circle me-2"></i>Tambah Kamar
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            @if($rooms->isEmpty())
                <div class="text-center py-5">
                    <i class="bi bi-inbox text-muted" style="font-size: 4rem;"></i>
                    <p class="text-muted mt-3">Belum ada kamar. Tambahkan kamar pertama Anda!</p>
                    <a href="{{ route('rooms.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-2"></i>Tambah Kamar
                    </a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">No</th>
                                <th width="12%" class="d-none d-md-table-cell">Gambar</th>
                                <th width="20%">Nama Kamar</th>
                                <th width="20%" class="d-none d-lg-table-cell">Properti</th>
                                <th width="15%">Harga/Bulan</th>
                                <th width="10%">Status</th>
                                <th width="18%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rooms as $index => $room)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td class="d-none d-md-table-cell">
                                        @if($room->image)
                                            <img src="{{ asset('storage/' . $room->image) }}" 
                                                 class="room-img" 
                                                 alt="{{ $room->room_name }}">
                                        @else
                                            <div class="bg-secondary text-white d-flex align-items-center justify-content-center room-img">
                                                <i class="bi bi-image"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ $room->room_name }}</strong>
                                        <div class="d-lg-none small text-muted mt-1">
                                            {{ $room->property->name }}
                                        </div>
                                    </td>
                                    <td class="d-none d-lg-table-cell">
                                        <small>{{ $room->property->name }}</small>
                                    </td>
                                    <td>
                                        <strong class="text-success">Rp {{ number_format($room->price, 0, ',', '.') }}</strong>
                                    </td>
                                    <td>
                                        @if($room->status === 'Tersedia')
                                            <span class="badge bg-success">Tersedia</span>
                                        @else
                                            <span class="badge bg-danger">Penuh</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('rooms.edit', $room) }}" 
                                               class="btn btn-warning"
                                               title="Edit">
                                                <i class="bi bi-pencil"></i>
                                                <span class="d-none d-lg-inline ms-1">Edit</span>
                                            </a>
                                            <button type="button" 
                                                    class="btn btn-danger" 
                                                    onclick="deleteRoom({{ $room->id }})"
                                                    title="Hapus">
                                                <i class="bi bi-trash"></i>
                                                <span class="d-none d-lg-inline ms-1">Hapus</span>
                                            </button>
                                        </div>
                                        <form id="delete-room-{{ $room->id }}" 
                                              action="{{ route('rooms.destroy', $room) }}" 
                                              method="POST" 
                                              class="d-none">
                                            @csrf
                                            @method('DELETE')
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

@push('scripts')
<script>
    function deleteRoom(id) {
        if (confirm('Yakin ingin menghapus kamar ini?')) {
            document.getElementById('delete-room-' + id).submit();
        }
    }
</script>
@endpush