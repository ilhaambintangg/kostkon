@extends('layouts.app')

@section('title', 'Edit Profil Admin')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h2><i class="bi bi-person-circle me-2"></i>Edit Profil Admin</h2>
    </div>

    <div class="row g-4">
        <div class="col-lg-4">
            <!-- Profile Photo Card -->
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title mb-4">Foto Profil</h5>
                    
                    @if($admin->profile_photo)
                        <img src="{{ asset('storage/' . $admin->profile_photo) }}" 
                             class="rounded-circle mb-3" 
                             style="width: 150px; height: 150px; object-fit: cover;" 
                             alt="Profile Photo">
                        
                        <form action="{{ route('admin.profile.update') }}" method="POST" class="mt-2">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="delete_photo" value="1">
                            <button type="submit" class="btn btn-outline-danger btn-sm" 
                                    onclick="return confirm('Yakin ingin menghapus foto profil?')">
                                <i class="bi bi-trash"></i> Hapus Foto
                            </button>
                        </form>
                    @else
                        <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
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
                    <p class="mb-2"><strong>Role:</strong> <span class="badge bg-danger">Administrator</span></p>
                    <p class="mb-2"><strong>Status:</strong> <span class="badge bg-success">Active</span></p>
                    <p class="mb-0"><strong>Bergabung:</strong> {{ $admin->created_at->format('d M Y') }}</p>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <!-- Edit Profile Form -->
            <div class="card shadow-sm">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0"><i class="bi bi-pencil me-2"></i>Edit Informasi Admin</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <h6 class="mb-3"><i class="bi bi-person-badge me-2"></i>Data Pribadi</h6>

                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" 
                                   name="name" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name', $admin->name) }}" 
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
                                   value="{{ old('email', $admin->email) }}" 
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
                                   value="{{ old('phone', $admin->phone) }}" 
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

                        <h6 class="mb-3"><i class="bi bi-bank me-2"></i>Informasi Rekening</h6>
                        <p class="text-muted small">Untuk keperluan transfer dana atau pengembalian</p>

                        <div class="mb-3">
                            <label class="form-label">Nama Bank</label>
                            <select name="bank_name" class="form-select @error('bank_name') is-invalid @enderror">
                                <option value="">-- Pilih Bank --</option>
                                <option value="BCA" {{ old('bank_name', $admin->bank_name) == 'BCA' ? 'selected' : '' }}>BCA</option>
                                <option value="Mandiri" {{ old('bank_name', $admin->bank_name) == 'Mandiri' ? 'selected' : '' }}>Mandiri</option>
                                <option value="BNI" {{ old('bank_name', $admin->bank_name) == 'BNI' ? 'selected' : '' }}>BNI</option>
                                <option value="BRI" {{ old('bank_name', $admin->bank_name) == 'BRI' ? 'selected' : '' }}>BRI</option>
                                <option value="CIMB Niaga" {{ old('bank_name', $admin->bank_name) == 'CIMB Niaga' ? 'selected' : '' }}>CIMB Niaga</option>
                                <option value="Danamon" {{ old('bank_name', $admin->bank_name) == 'Danamon' ? 'selected' : '' }}>Danamon</option>
                                <option value="Permata" {{ old('bank_name', $admin->bank_name) == 'Permata' ? 'selected' : '' }}>Permata</option>
                                <option value="BSI" {{ old('bank_name', $admin->bank_name) == 'BSI' ? 'selected' : '' }}>BSI (Bank Syariah Indonesia)</option>
                                <option value="Lainnya" {{ old('bank_name', $admin->bank_name) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
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
                                   value="{{ old('account_number', $admin->account_number) }}" 
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
                                   value="{{ old('account_holder_name', $admin->account_holder_name) }}" 
                                   placeholder="Sesuai nama di buku rekening">
                            @error('account_holder_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr>

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

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-danger">
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