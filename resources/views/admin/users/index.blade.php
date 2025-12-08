@extends('layouts.app')

@section('title', 'Kelola User')

@push('styles')
<style>
    .user-avatar {
        width: 40px;
        height: 40px;
        object-fit: cover;
    }
    
    .table th {
        font-weight: 600;
        white-space: nowrap;
    }
    
    .table td {
        vertical-align: middle;
    }
    
    .bank-info-cell {
        max-width: 180px;
        min-width: 150px;
    }
    
    .action-cell {
        width: 120px;
        white-space: nowrap;
    }
    
    @media (max-width: 768px) {
        .table-responsive {
            font-size: 0.85rem;
        }
        .user-avatar {
            width: 32px;
            height: 32px;
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
                                                     class="rounded-circle user-avatar me-2">
                                            @else
                                                <div class="bg-secondary text-white rounded-circle user-avatar me-2 d-flex align-items-center justify-content-center">
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
                    <table class="table table-hover table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">No</th>
                                <th width="25%">User</th>
                                <th width="15%">Kontak</th>
                                <th width="20%">Informasi Bank</th>
                                <th width="15%">Status & Waktu</th>
                                <th width="20%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($approvedUsers as $index => $user)
                                <tr>
                                    <td class="text-center fw-bold">{{ $index + 1 }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($user->profile_photo)
                                                <img src="{{ asset('storage/' . $user->profile_photo) }}" 
                                                     class="rounded-circle user-avatar me-2 border">
                                            @else
                                                <div class="bg-secondary text-white rounded-circle user-avatar me-2 d-flex align-items-center justify-content-center">
                                                    <i class="bi bi-person"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <div class="fw-bold">{{ $user->name }}</div>
                                                <div class="text-muted small">{{ $user->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="small">
                                            <div class="mb-1">
                                                <i class="bi bi-telephone me-1"></i>
                                                {{ $user->phone ?: 'Belum diisi' }}
                                            </div>
                                            <div class="text-muted">
                                                <i class="bi bi-calendar me-1"></i>
                                                {{ $user->created_at->format('d M Y') }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="bank-info-cell">
                                        @if($user->bank_name && $user->account_number)
                                            <div class="small">
                                                <div class="fw-semibold">{{ $user->bank_name }}</div>
                                                <div class="text-muted mb-1">{{ $user->account_number }}</div>
                                                <div class="text-muted">
                                                    <i class="bi bi-person-badge me-1"></i>
                                                    {{ $user->account_holder_name }}
                                                </div>
                                            </div>
                                        @else
                                            <span class="badge bg-secondary">Belum diisi</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="small">
                                            <span class="badge bg-success mb-1">Disetujui</span>
                                            <div class="text-muted">
                                                {{ $user->approved_at ? \Carbon\Carbon::parse($user->approved_at)->format('d M Y') : '-' }}
                                            </div>
                                            <div class="text-muted">
                                                oleh {{ $user->approver ? $user->approver->name : 'System' }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="action-cell">
                                        <div class="d-flex flex-column gap-1">
                                            <button type="button" 
                                                    class="btn btn-sm btn-outline-info w-100" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#detailModal{{ $user->id }}">
                                                <i class="bi bi-eye me-1"></i> Detail
                                            </button>
                                            <form action="{{ route('admin.users.destroy', $user) }}" 
                                                  method="POST" 
                                                  class="w-100">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-sm btn-outline-danger w-100"
                                                        onclick="return confirm('Yakin ingin menghapus user ini? Semua data terkait akan terhapus!')">
                                                    <i class="bi bi-trash me-1"></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Modals for each user -->
                @foreach($approvedUsers as $user)
                <div class="modal fade" id="detailModal{{ $user->id }}" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-info text-white">
                                <h5 class="modal-title">
                                    <i class="bi bi-person-badge me-2"></i>Detail User
                                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-4 text-center">
                                        @if($user->profile_photo)
                                            <img src="{{ asset('storage/' . $user->profile_photo) }}" 
                                                 class="rounded-circle border mb-3" 
                                                 style="width: 150px; height: 150px; object-fit: cover;">
                                        @else
                                            <div class="bg-secondary text-white rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" 
                                                 style="width: 150px; height: 150px;">
                                                <i class="bi bi-person" style="font-size: 4rem;"></i>
                                            </div>
                                        @endif
                                        <h5>{{ $user->name }}</h5>
                                        <p class="text-muted">{{ $user->email }}</p>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <h6 class="border-bottom pb-2">
                                                    <i class="bi bi-info-circle me-1"></i>Informasi Pribadi
                                                </h6>
                                                <div class="small">
                                                    <div class="mb-2">
                                                        <strong>Telepon:</strong><br>
                                                        {{ $user->phone ?: '-' }}
                                                    </div>
                                                    <div class="mb-2">
                                                        <strong>Terdaftar:</strong><br>
                                                        {{ $user->created_at->format('d M Y H:i') }}
                                                    </div>
                                                    <div>
                                                        <strong>Total Booking:</strong><br>
                                                        {{ $user->bookings->count() }} booking
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <h6 class="border-bottom pb-2">
                                                    <i class="bi bi-bank me-1"></i>Informasi Bank
                                                </h6>
                                                @if($user->bank_name)
                                                <div class="small">
                                                    <div class="mb-2">
                                                        <strong>Bank:</strong><br>
                                                        {{ $user->bank_name }}
                                                    </div>
                                                    <div class="mb-2">
                                                        <strong>No. Rekening:</strong><br>
                                                        {{ $user->account_number }}
                                                    </div>
                                                    <div>
                                                        <strong>Atas Nama:</strong><br>
                                                        {{ $user->account_holder_name }}
                                                    </div>
                                                </div>
                                                @else
                                                <p class="text-muted text-center">
                                                    <i class="bi bi-exclamation-circle me-1"></i>
                                                    Belum mengisi informasi bank
                                                </p>
                                                @endif
                                            </div>
                                            <div class="col-12">
                                                <h6 class="border-bottom pb-2">
                                                    <i class="bi bi-journal-check me-1"></i>Status
                                                </h6>
                                                <div class="small">
                                                    <div class="mb-2">
                                                        <strong>Status:</strong>
                                                        <span class="badge bg-success ms-2">Disetujui</span>
                                                    </div>
                                                    <div class="mb-2">
                                                        <strong>Disetujui pada:</strong><br>
                                                        {{ $user->approved_at ? \Carbon\Carbon::parse($user->approved_at)->format('d M Y H:i') : '-' }}
                                                    </div>
                                                    <div>
                                                        <strong>Disetujui oleh:</strong><br>
                                                        {{ $user->approver ? $user->approver->name : 'System' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
@endsection