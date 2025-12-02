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
                                        <div class="d-flex align-items-center">
                                            @if($user->profile_photo)
                                                <img src="{{ asset('storage/' . $user->profile_photo) }}" 
                                                     class="rounded-circle me-2" 
                                                     style="width: 40px; height: 40px; object-fit: cover;">
                                            @else
                                                <div class="bg-secondary text-white rounded-circle me-2 d-flex align-items-center justify-content-center" 
                                                     style="width: 40px; height: 40px;">
                                                    <i class="bi bi-person"></i>
                                                </div>
                                            @endif
                                            <strong>{{ $user->name }}</strong>
                                        </div>
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
                                <th>Bank</th>
                                <th>Disetujui</th>
                                <th>Oleh</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($approvedUsers as $index => $user)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($user->profile_photo)
                                                <img src="{{ asset('storage/' . $user->profile_photo) }}" 
                                                     class="rounded-circle me-2" 
                                                     style="width: 40px; height: 40px; object-fit: cover;">
                                            @else
                                                <div class="bg-secondary text-white rounded-circle me-2 d-flex align-items-center justify-content-center" 
                                                     style="width: 40px; height: 40px;">
                                                    <i class="bi bi-person"></i>
                                                </div>
                                            @endif
                                            <strong>{{ $user->name }}</strong>
                                        </div>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->phone ?? '-' }}</td>
                                    <td>
                                        @if($user->bank_name)
                                            <small>
                                                <strong>{{ $user->bank_name }}</strong><br>
                                                {{ $user->account_number }}<br>
                                                a/n {{ $user->account_holder_name }}
                                            </small>
                                        @else
                                            <small class="text-muted">Belum diisi</small>
                                        @endif
                                    </td>
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
                                    <td>
                                        <button type="button" 
                                                class="btn btn-sm btn-info mb-1" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#detailModal{{ $user->id }}">
                                            <i class="bi bi-eye"></i> Detail
                                        </button>
                                        <form action="{{ route('admin.users.destroy', $user) }}" 
                                              method="POST" 
                                              class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-sm btn-danger" 
                                                    onclick="return confirm('Yakin ingin menghapus user ini? Semua data terkait akan terhapus!')">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Detail Modal -->
                                <div class="modal fade" id="detailModal{{ $user->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header bg-info text-white">
                                                <h5 class="modal-title">Detail User</h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="text-center mb-3">
                                                    @if($user->profile_photo)
                                                        <img src="{{ asset('storage/' . $user->profile_photo) }}" 
                                                             class="rounded-circle" 
                                                             style="width: 100px; height: 100px; object-fit: cover;">
                                                    @else
                                                        <div class="bg-secondary text-white rounded-circle mx-auto d-flex align-items-center justify-content-center" 
                                                             style="width: 100px; height: 100px;">
                                                            <i class="bi bi-person" style="font-size: 3rem;"></i>
                                                        </div>
                                                    @endif
                                                </div>

                                                <table class="table table-sm">
                                                    <tr>
                                                        <th width="40%">Nama</th>
                                                        <td>{{ $user->name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Email</th>
                                                        <td>{{ $user->email }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Telepon</th>
                                                        <td>{{ $user->phone ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Bank</th>
                                                        <td>{{ $user->bank_name ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>No. Rekening</th>
                                                        <td>{{ $user->account_number ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Atas Nama</th>
                                                        <td>{{ $user->account_holder_name ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Total Booking</th>
                                                        <td>{{ $user->bookings->count() }} booking</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Terdaftar</th>
                                                        <td>{{ $user->created_at->format('d M Y H:i') }}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection