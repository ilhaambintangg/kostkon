@extends('layouts.app')

@section('title', 'Edit Kamar')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h2><i class="bi bi-pencil me-2"></i>Edit Kamar</h2>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('rooms.update', $room) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label class="form-label">Pilih Properti <span class="text-danger">*</span></label>
                            <select name="property_id" class="form-select @error('property_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Properti --</option>
                                @foreach($properties as $property)
                                    <option value="{{ $property->id }}" 
                                            {{ old('property_id', $room->property_id) == $property->id ? 'selected' : '' }}>
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
                                   value="{{ old('room_name', $room->room_name) }}" required>
                            @error('room_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Harga per Bulan (Rp) <span class="text-danger">*</span></label>
                            <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" 
                                   value="{{ old('price', $room->price) }}" min="0" required>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="Tersedia" {{ old('status', $room->status) == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                                <option value="Tidak Tersedia" {{ old('status', $room->status) == 'Tidak Tersedia' ? 'selected' : '' }}>Tidak Tersedia</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Deskripsi Kamar</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                                      rows="4">{{ old('description', $room->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Gambar Kamar</label>
                            @if($room->image)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $room->image) }}" class="img-thumbnail" style="max-height: 150px;">
                                    <p class="small text-muted mt-1">Gambar saat ini</p>
                                </div>
                            @endif
                            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" 
                                   accept="image/*">
                            <small class="text-muted">Kosongkan jika tidak ingin mengubah gambar</small>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-2"></i>Update Kamar
                            </button>
                            <a href="{{ route('rooms.index') }}" class="btn btn-secondary">
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