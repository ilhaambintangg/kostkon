@extends('layouts.app')

@section('title', 'Kelola Properti')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-building me-2"></i>Kelola Properti</h2>
        <a href="{{ route('properties.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Tambah Properti
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            @if($properties->isEmpty())
                <div class="text-center py-5">
                    <i class="bi bi-inbox text-muted" style="font-size: 4rem;"></i>
                    <p class="text-muted mt-3">Belum ada properti. Tambahkan properti pertama Anda!</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">No</th>
                                <th width="15%">Gambar</th>
                                <th width="20%">Nama Properti</th>
                                <th width="25%">Alamat</th>
                                <th width="15%">Jumlah Kamar</th>
                                <th width="20%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($properties as $index => $property)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        @if($property->image)
                                            <img src="{{ asset('storage/' . $property->image) }}" 
                                                 class="img-thumbnail" style="height: 60px; width: 80px; object-fit: cover;">
                                        @else
                                            <div class="bg-secondary text-white d-flex align-items-center justify-content-center" 
                                                 style="height: 60px; width: 80px;">
                                                <i class="bi bi-image"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td><strong>{{ $property->name }}</strong></td>
                                    <td>{{ Str::limit($property->address, 50) }}</td>
                                    <td>
                                        <span class="badge bg-info">{{ $property->rooms_count }} kamar</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('properties.edit', $property) }}" class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('properties.destroy', $property) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" 
                                                    onclick="return confirm('Yakin ingin menghapus properti ini?')">
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