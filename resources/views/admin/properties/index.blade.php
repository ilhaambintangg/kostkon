@extends('layouts.app')

@section('title', 'Kelola Properti')

@push('styles')
<style>
    .property-img {
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
        .property-img {
            height: 50px;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
        <div>
            <h2><i class="bi bi-building me-2"></i>Kelola Properti</h2>
            <p class="text-muted mb-0 d-none d-md-block">Daftar semua properti kos/kontrakan</p>
        </div>
        <a href="{{ route('properties.create') }}" class="btn btn-primary mt-3 mt-md-0">
            <i class="bi bi-plus-circle me-2"></i>Tambah Properti
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            @if($properties->isEmpty())
                <div class="text-center py-5">
                    <i class="bi bi-inbox text-muted" style="font-size: 4rem;"></i>
                    <p class="text-muted mt-3">Belum ada properti. Tambahkan properti pertama Anda!</p>
                    <a href="{{ route('properties.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-2"></i>Tambah Properti
                    </a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">No</th>
                                <th width="15%" class="d-none d-md-table-cell">Gambar</th>
                                <th width="25%">Nama Properti</th>
                                <th width="30%" class="d-none d-lg-table-cell">Alamat</th>
                                <th width="10%">Kamar</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($properties as $index => $property)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td class="d-none d-md-table-cell">
                                        @if($property->image)
                                            <img src="{{ asset('storage/' . $property->image) }}" 
                                                 class="property-img" 
                                                 alt="{{ $property->name }}">
                                        @else
                                            <div class="bg-secondary text-white d-flex align-items-center justify-content-center property-img">
                                                <i class="bi bi-image"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ $property->name }}</strong>
                                        <div class="d-md-none small text-muted mt-1">
                                            {{ Str::limit($property->address, 30) }}
                                        </div>
                                    </td>
                                    <td class="d-none d-lg-table-cell">
                                        <small>{{ Str::limit($property->address, 50) }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $property->rooms_count }}</span>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('properties.edit', $property) }}" 
                                               class="btn btn-warning"
                                               title="Edit">
                                                <i class="bi bi-pencil"></i>
                                                <span class="d-none d-lg-inline ms-1">Edit</span>
                                            </a>
                                            <button type="button" 
                                                    class="btn btn-danger" 
                                                    onclick="deleteProperty({{ $property->id }})"
                                                    title="Hapus">
                                                <i class="bi bi-trash"></i>
                                                <span class="d-none d-lg-inline ms-1">Hapus</span>
                                            </button>
                                        </div>
                                        <form id="delete-form-{{ $property->id }}" 
                                              action="{{ route('properties.destroy', $property) }}" 
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
    function deleteProperty(id) {
        if (confirm('Yakin ingin menghapus properti ini? Semua kamar terkait juga akan terhapus!')) {
            document.getElementById('delete-form-' + id).submit();
        }
    }
</script>
@endpush