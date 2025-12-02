@extends('layouts.app')

@section('title', 'Kelola User')

@push('styles')
<style>
    @media (max-width: 768px) {
        .table-responsive {
            font-size: 0.85rem;
        }
        .btn-sm {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h2><i class="bi bi-people me-2"></i>Kelola User</h2>
        <p class="text-muted">Approve atau tolak pendaftaran user baru</p>
    </div>

    <!-- Pending Approval -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-warning text-dark">
            <h5 class="mb-0">
                <i class="bi bi-hourglass-split me-2"></i>Menunggu Persetujuan
                <span class="badge bg-dark">{{ $pendingUsers->count() }}</span>
            </h5>
        </div>
        <div class="card-body">
            @if($pendingUsers->isEmpty())
                <p class="text-muted text-center py-3 mb-0">Tidak ada user yang menunggu persetujuan</p>
            @else
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Telepon</th>
                                <th>Terdaftar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendingUsers as $index => $user)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <strong>{{ $user->name }}</strong>
                                        @if($user->profile_photo)
                                            <br><small class="text-muted"><i class="bi bi-image"></i> Ada foto</small>
                                        @endif
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->phone ?? '-' }}</td>
                                    <td><small>{{ $user->created_at->diffForHumans() }}</small></td>
                                    <td>
                                        <form action="{{ route('admin.users.approve', $user) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-success mb-1" 
                                                    onclick="return confirm('Setujui user ini?')">
                                                <i class="bi bi-check-circle"></i> Setujui
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.users.reject', $user) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" 
                                                    onclick="return confirm('Tolak dan hapus user ini?')">
                                                <i class="bi bi-x-circle"></i> Tolak
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

    <!-- Approved Users -->
    <div class="card shadow-sm">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">
                <i class="bi bi-check-circle me-2"></i>User Disetujui
                <span class="badge bg-light text-dark">{{ $approvedUsers->count() }}</span>
            </h5>
        </div>
        <div class="card-body">
            @if($approvedUsers->isEmpty())
                <p class="text-muted text-center py-3 mb-0">Belum ada user yang disetujui</p>
            @else
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Telepon</th>
                                <th>Disetujui</th>
                                <th>Oleh</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($approvedUsers as $index => $user)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td><strong>{{ $user->name }}</strong></td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->phone ?? '-' }}</td>
                                    <td>
                                        <small>
                                            @if($user->approved_at)
                                                {{ \Carbon\Carbon::parse($user->approved_at)->format('d M Y') }}
                                            @else
                                                -
                                            @endif
                                        </small>
                                    </td>
                                    <td>
                                        <small>
                                            @if($user->approver)
                                                {{ $user->approver->name }}
                                            @else
                                                System
                                            @endif
                                        </small>
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