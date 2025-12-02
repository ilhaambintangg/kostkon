@extends('layouts.app')

@section('title', 'Edit Profil')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h2><i class="bi bi-person-circle me-2"></i>Edit Profil Saya</h2>
    </div>

    <div class="row g-4">
        <!-- Left Side -->
        <div class="col-lg-4">
            
            <!-- Profile Photo Card -->
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title mb-4">Foto Profil</h5>

                    @if($user->profile_photo)
                        <img src="{{ asset('storage/' . $user->profile_photo) }}"
                             class="rounded-circle mb-3"
                             style="width: 150px; height: 150px; object-fit: cover;"
                             alt="Profile Photo">

                        <form action="{{ route('penyewa.profile.deletePhoto') }}" method="POST" class="mt-2">
                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="btn btn-outline-danger btn-sm"
                                    onclick="return confirm('Yakin ingin menghapus foto profil?')">
                                <i class="bi bi-trash"></i> Hapus Foto
                            </button>
                        </form>
                    @else
                        <div class="bg-secondary text-white rounded-circle d-inline-flex 
                                    align-items-center justify-content-center mb-3"
                             style="width: 150px; height: 150px;">
                            <i class="bi bi-person-circle" style="font-size: 5rem;"></i>
                        </div>

                        <p class="text-muted">Belum ada foto profil</p>
                    @endif
                </div>
            </div>

            <!-- Account Info -->
            <div class="card shadow-sm mt-3">
                <div class="card-body">
                    <h6 class="card-title">Informasi Akun</h6>
                    <hr>

                    <p class="mb-2"><strong>Role:</strong> {{ ucfirst($user->role) }}</p>

                    <p class="mb-2">
                        <strong>Status:</strong>
                        @if($user->is_verified)
                            <span class="badge bg-success">Terverifikasi</span>
                        @else
                            <span class="badge bg-warning">Belum Verifikasi</span>
                        @endif
                    </p>

                    <p class="mb-2">
                        <strong>Approval:</strong>
                        @if($user->is_approved)
                            <span class="badge bg-success">Disetujui</span>
                        @else
                            <span class="badge bg-warning">Menunggu</span>
                        @endif
                    </p>

                    <p class="mb-0">
                        <strong>Bergabung:</strong> {{ $user->created_at->format('d M Y') }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Right Side -->
        <div class="col-lg-8">
            <div class="card shadow-sm">
                
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-pencil me-2"></i>Edit Informasi Profil
                    </h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('penyewa.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Data Pribadi -->
                        <h6 class="mb-3"><i class="bi bi-person-badge me-2"></i>Data Pribadi</h6>

                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text"
                                   name="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', $user->name) }}"
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email"
                                   name="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email', $user->email) }}"
                                   required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nomor Telepon</label>
                            <input type="text"
                                   name="phone"
                                   class="form-control @error('phone') is-invalid @enderror"
                                   value="{{ old('phone', $user->phone) }}"
                                   placeholder="08xxxxxxxxxx">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Upload Foto Profil Baru</label>
                            <input type="file"
                                   name="profile_photo"
                                   class="form-control @error('profile_photo') is-invalid @enderror"
                                   accept="image/*">
                            @error('profile_photo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Format: JPG, PNG. Max: 2MB</small>
                        </div>

                        <hr>

                        <!-- Bank Info -->
                        <h6 class="mb-3"><i class="bi bi-bank me-2"></i>Informasi Rekening (Opsional)</h6>
                        <p class="text-muted small">Isi untuk mempermudah proses refund jika diperlukan</p>

                        <div class="mb-3">
                            <label class="form-label">Nama Bank</label>
                            <select name="bank_name" 
                                    class="form-select @error('bank_name') is-invalid @enderror">
                                
                                <option value="">-- Pilih Bank --</option>

                                @foreach(['BCA','Mandiri','BNI','BRI','CIMB Niaga','Danamon','Permata','BSI','Lainnya'] as $bank)
                                    <option value="{{ $bank }}" 
                                            {{ old('bank_name', $user->bank_name) == $bank ? 'selected' : '' }}>
                                        {{ $bank }}
                                    </option>
                                @endforeach

                            </select>
                            @error('bank_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nomor Rekening</label>
                            <input type="text"
                                   name="account_number"
                                   class="form-control @error('account_number') is-invalid @enderror"
                                   value="{{ old('account_number', $user->account_number) }}"
                                   placeholder="1234567890">
                            @error('account_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Nama Pemilik Rekening</label>
                            <input type="text"
                                   name="account_holder_name"
                                   class="form-control @error('account_holder_name') is-invalid @enderror"
                                   value="{{ old('account_holder_name', $user->account_holder_name) }}"
                                   placeholder="Sesuai nama di buku rekening">
                            @error('account_holder_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr>

                        <!-- Password Section -->
                        <h6 class="mb-3"><i class="bi bi-shield-lock me-2"></i>Ubah Password (Opsional)</h6>

                        <div class="mb-3">
                            <label class="form-label">Password Lama</label>
                            <input type="password"
                                   name="current_password"
                                   class="form-control @error('current_password') is-invalid @enderror">
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Isi jika ingin mengubah password</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password Baru</label>
                            <input type="password"
                                   name="new_password"
                                   class="form-control @error('new_password') is-invalid @enderror">
                            @error('new_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Minimal 6 karakter</small>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Konfirmasi Password Baru</label>
                            <input type="password"
                                   name="new_password_confirmation"
                                   class="form-control">
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-2"></i>Simpan Perubahan
                            </button>
                            <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-2"></i>Kembali
                            </a>
                        </div>

                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection