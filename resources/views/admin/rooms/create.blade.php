@extends('layouts.app')

@section('title', 'Tambah Kamar')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h2><i class="bi bi-plus-circle me-2"></i>Tambah Kamar Baru</h2>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('rooms.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label">Pilih Properti <span class="text-danger">*</span></label>
                            <select name="property_id" class="form-select @error('property_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Properti --</option>
                                @foreach($properties as $property)
                                    <option value="{{ $property->id }}" {{ old('property_id') == $property->id ? 'selected' : '' }}>
                                        {{ $property->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('property_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nama Kamar <span class="text-danger">*</span></label>
                            <input type="text" name="room_name" class="form-control @error('room_name') is-invalid @enderror" 
                                   value="{{ old('room_name') }}" placeholder="Contoh: Kamar A1" required>
                            @error('room_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Harga per Bulan (Rp) <span class="text-danger">*</span></label>
                            <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" 
                                   value="{{ old('price') }}" placeholder="800000" min="0" required>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="Tersedia" {{ old('status') == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                                <option value="Tidak Tersedia" {{ old('status') == 'Tidak Tersedia' ? 'selected' : '' }}>Tidak Tersedia</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Deskripsi Kamar</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                                      rows="4" placeholder="Fasilitas: kasur, lemari, meja belajar, AC, dll.">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Gambar Kamar</label>
                            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" 
                                   accept="image/*">
                            <small class="text-muted">Format: JPG, PNG. Max: 2MB</small>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-2"></i>Simpan Kamar
                            </button>
                            <a href="{{ route('rooms.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-2"></i>Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <i class="bi bi-info-circle me-2"></i>Informasi
                </div>
                <div class="card-body">
                    <p><strong>Tips Tambah Kamar:</strong></p>
                    <ul class="small">
                        <li>Pastikan properti sudah dibuat terlebih dahulu</li>
                        <li>Gunakan nama kamar yang unik (A1, B2, dll)</li>
                        <li>Harga dalam Rupiah tanpa titik</li>
                        <li>Deskripsi detail meningkatkan minat penyewa</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection